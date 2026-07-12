<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_duration_ranges', function (Blueprint $table) {
            $table->id('id');
            $table->string('title');
            $table->integer('sort')->default(100);
        });

        $quizDurations = [
            [
                "title" => "До 2 минут",
                'sort' => 100,
            ],
            [
                "title" => "Более 10 минут",
                'sort' => 400,
            ],
            [
                "title" => "2 - 5 минут",
                'sort' => 200,
            ],
            [
                "title" => "5 - 10 минут",
                'sort' => 300,
            ]
        ];

        foreach ($quizDurations as $quizDuration) {
            DB::table('quiz_duration_ranges')
                ->insert($quizDuration);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_duration_ranges');
    }
};
