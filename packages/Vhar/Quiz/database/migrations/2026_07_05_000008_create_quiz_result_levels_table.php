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
        Schema::create('quiz_result_levels', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('quiz_id')
                ->constrained('quizzes', 'id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->text('description');

            $table->unsignedInteger('min_value')
                ->default(0);

            $table->unsignedInteger('max_value')
                ->default(0);

            $table->index(
                [
                    'quiz_id',
                    'min_value',
                    'max_value',
                ],
                'quiz_result_levels_range_idx'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_result_levels');
    }
};
