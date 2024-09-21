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
            $table->bigIncrements('id');
            $table->bigInteger('idClinique')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
        });

        Schema::table('clinique_professionnels', function (Blueprint $table) {
            $table->foreign('idClinique')->references('id')->on('cliniques');
            $table->foreign('idProfessionnel')->references('id')->on('users');
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
