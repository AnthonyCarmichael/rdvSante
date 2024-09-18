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
        Schema::create('profession_professionnels', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idProfessionProfessionnel');
            $table->bigInteger('idProfession')->unsigned();
            $table->bigInteger('idProfessionnel')->unsigned();
        });

        Schema::table('profession_professionnels', function (Blueprint $table) {
            $table->foreign('idProfession')->references('idProfession')->on('professions');
            $table->foreign('idProfessionnel')->references('idProfessionnel')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profession_professionnels');
    }
};
