<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class DossierProfessionnel extends Pivot
{
    use HasFactory;

    protected $table = 'dossierProfessionnels';
    protected $primaryKey = 'idDossierProfessionnel';
    public $incrementing = true;
    public $timestamps = false;
}
