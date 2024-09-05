<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_question', function (Blueprint $table) {
            $table->timestamps();
            $table->foreignId('profile_id');
            $table->foreignId('question_id');
            $table->integer('answer_id');

            $table->primary(['profile_id', 'question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_question');
    }
};
