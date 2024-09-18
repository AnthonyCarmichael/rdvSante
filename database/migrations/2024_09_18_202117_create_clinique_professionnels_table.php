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
        Schema::create('clinique_professionnels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idCliniqueProfessionnel');
            $table->bigInteger('idClinique')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
        });

        Schema::table('clinique_professionnels', function (Blueprint $table) {
            $table->foreign('idClinique')->references('idClinique')->on('cliniques');
            $table->foreign('idProfessionnel')->references('idProfessionnel')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinique_professionnels');
    }
};
