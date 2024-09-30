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
            $table->bigIncrements('id');
            $table->bigInteger('idProfession')->unsigned();
            $table->bigInteger('user_id')->unsigned();
        });

        Schema::table('profession_professionnels', function (Blueprint $table) {
            $table->foreign('idProfession')->references('id')->on('professions')->constrained()->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onDelete('cascade');
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
