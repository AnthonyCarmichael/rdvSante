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
        Schema::create('organisation_professionnels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('idOrganisation')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
            $table->bigInteger('idProfession')->unsigned();
            $table->text('numMembre');
            $table->date('dateExpiration');
        });

        Schema::table('organisation_professionnels', function (Blueprint $table) {
            $table->foreign('idOrganisation')->references('id')->on('organisations');
            $table->foreign('idProfessionnel')->references('id')->on('users');
            $table->foreign('idProfession')->references('id')->on('professions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organisation_professionnels');
    }
};
