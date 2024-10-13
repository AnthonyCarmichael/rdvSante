<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdv extends Model
{
    use HasFactory;

    // Ajoute 'idDossier' à la propriété fillable
    protected $fillable = [
        'dateHeureDebut',
        'idDossier',
        'idService',
        'idClinique',
        'raison'
    ];

    public $timestamps = false;

    public function service()
    {
        return $this->belongsTo(Service::class, 'idService');
    }
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'idDossier');
    }
    public function client()
    {
        return $this->hasOneThrough(Client::class, Dossier::class, 'id', 'id', 'idDossier', 'idClient');
    }
    public function clinique()
    {
        return $this->belongsTo(Clinique::class, 'idClinique');
    }
}
