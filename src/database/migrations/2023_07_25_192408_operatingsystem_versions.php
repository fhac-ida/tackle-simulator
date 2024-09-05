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
        Schema::create('operatingsystem_versions', function (Blueprint $table) {
            $table->id('operatingsystem_version_id');
            $table->string('version');
            $table->string('release_date');
            $table->string('end_of_service')->nullable();

            $table->foreignId('operatingsystem_id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operatingsystem_versions');
    }
};
