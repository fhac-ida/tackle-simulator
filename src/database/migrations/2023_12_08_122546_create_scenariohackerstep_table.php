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
        Schema::create('scenariohackerstep', function (Blueprint $table) {
            $table->foreignId('scenario_id')->onDelete('cascade');
            $table->foreignId('hackerattackstep_id')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['scenario_id', 'hackerattackstep_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scenariohackerstep');
    }
};
