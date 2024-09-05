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
        Schema::create('killchains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scenario_id')->nullable()->onDelete('set null');
            $table->foreignId('hardwareobject_id')->nullable()->onDelete('set null');
            $table->foreignId('hackerattackstep_id')->nullable()->onDelete('set null');
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
        Schema::dropIfExists('killchains');
    }
};
