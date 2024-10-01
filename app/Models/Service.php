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
        'duree',
        'prix',
        'taxable',
        'minutePause',
        'nombreHeureLimiteReservation',
        'droitPersonneACharge',
        'actif',
        'idProfessionService',
        'idProfessionnel',
    ];

    public $timestamps = false;
}
