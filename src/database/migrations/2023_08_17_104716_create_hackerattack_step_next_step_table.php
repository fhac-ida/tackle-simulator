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
        Schema::create('hackerattack_step_next_step', function (Blueprint $table) {
            //$table->increments('id');
            //$table->unsignedBigInteger('current_step_id');
            //$table->unsignedBigInteger('next_step_id');

            $table->foreignId('current_step_id')->nullable()->onDelete('set null');
            $table->foreignId('next_step_id')->nullable()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hackerattack_step_next_step');
    }
};
