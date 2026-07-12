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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id('id');

            $table->string('slug')->unique()->index();
            $table->unsignedTinyInteger('status');
            $table->string('title');
            $table->text('description')->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->smallInteger('quiz_type');

            $table->foreignId('quiz_duration_range_id')
                ->nullable()
                ->constrained('quiz_duration_ranges', 'id')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->smallInteger('age_restriction')->default(0);
            $table->smallInteger('attempt_limit')->default(1);
            $table->integer('time_limit')->nullable();
            $table->integer('scoring_type')->nullable();
            $table->boolean('change_answer')->nullable();
            $table->json('quiz_settings')->nullable();
            $table->unsignedInteger('passed')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
