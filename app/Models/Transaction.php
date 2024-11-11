<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['montant', 'dateHeure', 'idRdv', 'idTypeTransaction', 'idMoyenPaiement', 'idTransaction'];

    public $timestamps = false;

    public function moyenPaiement()
    {
        return $this->belongsTo(MoyenPaiement::class, 'idMoyenPaiement');
    }
}
