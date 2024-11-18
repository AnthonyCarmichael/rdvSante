<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = ['nom', 'prenom', 'courriel', 'telephone', 'ddn', 'idGenre', 'nomResponsable', 'prenomResponsable', 'lienResponsable', 'rue', 'noCivique', 'codePostal', 'actif', 'idVille'];

    public $timestamps = false;

    public function dossier()
    {
        return $this->hasMany(Dossier::class, 'idClient');
    }

    public function routeNotificationForMail()
    {
        return $this->courriel;
    }

}
