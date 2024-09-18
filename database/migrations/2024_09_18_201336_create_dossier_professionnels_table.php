<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dossier_professionnels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idDossierProfessionnel');
            $table->boolean('principal');
            $table->bigInteger('idDossier')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
        });

        Schema::table('dossier_professionnels', function (Blueprint $table) {
            $table->foreign('idDossier')->references('idDossier')->on('dossiers');
            $table->foreign('idProfessionnel')->references('idProfessionnel')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_professionnels');
    }
};
