<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'prix',
        'taxable',
        'minutePause',
        'nombreHeureLimiteReservation',
        'droitPersonneACharge',
        'actif',
        'idCategorieService',
        'idProfessionnel',
    ];

    public $timestamps = false;
}
