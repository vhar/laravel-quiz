<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_diagnostic_key_levels', function (Blueprint $table) {

            $table->id();

            $table->foreignId('quiz_diagnostic_key_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->text('description');
            $table->unsignedTinyInteger('min_value');
            $table->unsignedTinyInteger('max_value');

            $table->timestamps();

            $table->index(
                [
                    'quiz_diagnostic_key_id',
                    'min_value',
                    'max_value',
                ],
                'diagnostic_key_levels_range_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_diagnostic_key_levels');
    }
};
