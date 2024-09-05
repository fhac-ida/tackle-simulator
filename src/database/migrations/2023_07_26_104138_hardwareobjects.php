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
        Schema::create('hardware_objects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['PLC', 'Switch', 'Router', 'Firewall', 'HMI', 'Buskoppler', 'Gateway', 'Other']); // TODO normalisieren?
            $table->string('description')->nullable();
            $table->string('vendor')->nullable(); // TODO normalisieren
            $table->year('einfuehrungsjahr')->nullable();

            $table->boolean('hasFirewall')->default(false);
            $table->boolean('hasEncryption')->default(false);
            $table->boolean('hasUserManagement')->default(false);
            $table->boolean('hasBackup')->default(false);
            $table->boolean('hasPassword')->default(false);
            $table->boolean('hasMemoryPassword')->default(false);

            $table->foreignId('operatingsystem_version_id')->nullable()->cascadeOnDelete();

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
        Schema::dropIfExists('hardware_objects');
    }
};
