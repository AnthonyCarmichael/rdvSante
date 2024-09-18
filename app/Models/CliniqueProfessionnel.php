<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class CliniqueProfessionnel extends Pivot
{
    use HasFactory;
    protected $table = 'cliniqueProfessionnels';
    protected $primaryKey = 'idCliniqueProfessionnel';
    public $incrementing = true;
    public $timestamps = false;
}
