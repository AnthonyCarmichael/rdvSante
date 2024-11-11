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
        'montantPenalite',
    ];


    public function professionnel()
    {
        return $this->belongsTo(User::class, 'idProfessionnel');
    }

    public $timestamps = false;
}
