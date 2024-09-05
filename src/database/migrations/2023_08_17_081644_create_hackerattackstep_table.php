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
        Schema::create('hackerattacksteps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phase_id')->nullable()->onDelete('set null');
            //$table->foreign('phase_id')->references('phase_id')->on('phases');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hackerattacksteps');
    }
};
