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
        Schema::create('diponibilite_professionnels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idDisponibiliteProfessionnel');
            $table->bigInteger('idDisponibilite')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
        });

        Schema::table('diponibilite_professionnels', function (Blueprint $table) {
            $table->foreign('idDisponibilite')->references('idDisponibilite')->on('disponibilites');
            $table->foreign('idProfessionnel')->references('idProfessionnel')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diponibilite_professionnels');
    }
};
