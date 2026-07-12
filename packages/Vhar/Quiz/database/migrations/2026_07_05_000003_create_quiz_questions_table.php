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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('quiz_id')
                ->constrained('quizzes', 'id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedInteger('number');
            $table->text('title');
            $table->unsignedTinyInteger('type');
            $table->integer('score')->default(0);

            $table->timestamps();

            $table->unique(['quiz_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
