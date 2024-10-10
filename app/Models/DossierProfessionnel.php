<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class DossierProfessionnel extends Pivot
{
    use HasFactory;

    protected $table = 'dossier_professionnels';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
}
