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
        Schema::create('quiz_question_answers', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('quiz_question_id')
                ->constrained('quiz_questions', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedInteger('number');
            $table->text('title');
            $table->decimal('score_multiplier', 3, 2)->default(1);
            $table->boolean('is_true')->default(false);

            $table->timestamps();

            $table->unique(['quiz_question_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_question_answers');
    }
};
