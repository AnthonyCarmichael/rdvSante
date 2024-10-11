<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dossier extends Model
{
    use HasFactory;

    public function professionnels(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'dossier_professionnels','idDossier','idProfessionnel');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'idClient');
    }

}
