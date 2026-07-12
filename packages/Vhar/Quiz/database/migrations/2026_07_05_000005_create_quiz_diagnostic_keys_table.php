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
        Schema::create('quiz_diagnostic_keys', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('quiz_id')
                ->constrained('quizzes', 'id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('name');
            $table->text('description');
            $table->integer('sort')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_diagnostic_keys');
    }
};
