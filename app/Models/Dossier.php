<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dossier extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['dateCreation', 'permissionPartage', 'idClient'];


    public function professionnels(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'dossier_professionnels','idDossier','idProfessionnel');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'idClient');
    }

    public function dossier_professionnels()
    {
        return $this->hasMany(DossierProfessionnel::class, 'idDossier', 'id');
    }

    public function fichesCliniques()
    {
        return $this->hasMany(FicheClinique::class, 'idDossier', 'id');
    }

    public function fichiers()
    {
        return $this->hasMany(Fichier::class, 'idDossier', 'id');
    }

}
