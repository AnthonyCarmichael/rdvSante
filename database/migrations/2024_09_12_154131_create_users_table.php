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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Pour pouvoir utiliser les clés étrangères et les transactions
            $table->bigIncrements('id'); // Clé primaire automatiquement créée avec "bigIncrements()".
            // "usigned()" nécessaire pour éventuellement pouvoir définir une clé étrangère sur cette colonne.
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('telephone');
            $table->string('password');
            $table->string('cleStripe')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->bigInteger('idRole')->unsigned();
            $table->text('description')->nullable();
            $table->boolean('actif')->nullable(); # A CHANGER POUR NOT NULLABLE
            $table->string('lien')->nullable();
            $table->string('numTps')->nullable();
            $table->string('numTvq')->nullable();
            $table->string('photoProfil')->nullable();
            $table->string('signature')->nullable();
            $table->longText('messagePersonnalise')->nullable();
            $table->string('invitation_token')->nullable()->unique();
            $table->timestamp('invitation_expiration')->nullable();
        });


        Schema::table('users', function (Blueprint $table) {
            $table->foreign('idRole')->references('id')->on('roles');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['invitation_token', 'invitation_expiration']);
        });
    }
};
