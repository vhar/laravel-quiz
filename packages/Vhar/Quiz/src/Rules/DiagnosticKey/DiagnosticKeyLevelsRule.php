<?php

namespace Vhar\Quiz\Rules\DiagnosticKey;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Vhar\Quiz\Models\QuizDiagnosticKeyLevel;

/**
 * Class DiagnosticKeyLevelsRule
 *
 * Validates the entire diagnostic key levels structure, enforcing database 
 * ownership consistency and a continuous, non-overlapping sequence from 0 to 100.
 *
 * @package Vhar\Quiz\Rules\DiagnosticKey
 */
final readonly class DiagnosticKeyLevelsRule implements ValidationRule
{
    /**
     * DiagnosticKeyLevelsRule constructor.
     *
     * @param int|null $keyId Target diagnostic key unique identifier for update consistency checks.
     */
    public function __construct(
        private ?int $keyId = null
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute The name of the attribute being validated.
     * @param mixed $value The value of the attribute being validated.
     * @param Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail The failure fallback callback.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value) || empty($value)) {
            return;
        }

        // 1. Ownership Consistency Check (Only enforced during update routines when keyId is provided)
        if ($this->keyId !== null) {
            /** @var array<int, int> $providedIds */
            $providedIds = collect($value)
                ->pluck('id')
                ->filter()
                ->map(fn($id) => (int) $id)
                ->toArray();

            if (!empty($providedIds)) {
                /** @var array<int, int> $validIds */
                $validIds = QuizDiagnosticKeyLevel::where('quiz_diagnostic_key_id', $this->keyId)
                    ->whereIn('id', $providedIds)
                    ->pluck('id')
                    ->toArray();

                /** @var array<int, int> $invalidIds */
                $invalidIds = array_diff($providedIds, $validIds);

                if (!empty($invalidIds)) {
                    $fail('One or more provided level IDs do not belong to this diagnostic key.');
                    return;
                }
            }
        }

        // 2. Numeric Range Boundary and Continuity Logic (0-100 Coverage)
        // Filter out incomplete items to prevent structural errors during deep analysis
        $levels = array_filter($value, function ($item) {
            return is_array($item)
                && isset($item['min_value'])
                && isset($item['max_value'])
                && is_numeric($item['min_value'])
                && is_numeric($item['max_value']);
        });

        if (count($levels) !== count($value)) {
            // Basic structure is broken; let native field validators handle specific errors
            return;
        }

        // Sort levels sequentially by their minimum bound
        usort($levels, fn($a, $b) => (int) $a['min_value'] <=> (int) $b['min_value']);

        // Requirement 1: The entire range must start exactly at 0
        if ((int) $levels[0]['min_value'] !== 0) {
            $fail('The diagnostic levels range must start exactly at 0.');
            return;
        }

        $count = count($levels);
        for ($i = 0; $i < $count; $i++) {
            $currentMax = (int) $levels[$i]['max_value'];

            if ($i < $count - 1) {
                $nextMin = (int) $levels[$i + 1]['min_value'];

                // Requirement 2: Check for overlapping or gaps
                if ($currentMax >= $nextMin) {
                    $fail("Level ranges overlap near max value {$currentMax}. It cannot exceed or equal the next minimum value ({$nextMin}).");
                    return;
                }

                if ($currentMax !== $nextMin - 1) {
                    $fail("Gaps detected in ranges. There is a missing space between max value {$currentMax} and next minimum value {$nextMin}.");
                    return;
                }
            }
        }

        // Requirement 3: The entire range must end exactly at 100
        $finalMax = (int) $levels[$count - 1]['max_value'];
        if ($finalMax !== 100) {
            $fail("The maximum scope of the final diagnostic level must reach exactly 100.");
        }
    }
}