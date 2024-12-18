<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Clinique extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'rue',
        'noCivique',
        'codePostal',
        'actif',
        'principal',
        'idVille'
    ];

    public $timestamps = false;

    public function professionnels(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'clinique_professionnels','idClinique','user_id');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'idVille');
    }
}
