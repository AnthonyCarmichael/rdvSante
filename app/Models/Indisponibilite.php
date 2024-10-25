<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indisponibilite extends Model
{
    use HasFactory;
    protected $fillable = ['note', 'dateHeureDebut', 'dateHeureFin', 'idProfessionnel'];
    public $timestamps = false;
}
