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
        Schema::create('quiz_question_answer_diagnostic_key', function (Blueprint $table) {

            $table->foreignId('quiz_question_answer_id');

            $table->foreignId('quiz_diagnostic_key_id');

            $table->unsignedInteger('value');

            $table->primary([
                'quiz_diagnostic_key_id',
                'quiz_question_answer_id',
            ]);

            $table->foreign(
                'quiz_question_answer_id',
                'qqadk_answer_fk'
            )
                ->references('id')
                ->on('quiz_question_answers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign(
                'quiz_diagnostic_key_id',
                'qqadk_key_fk'
            )
                ->references('id')
                ->on('quiz_diagnostic_keys')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_question_answer_diagnostic_key');
    }
};
