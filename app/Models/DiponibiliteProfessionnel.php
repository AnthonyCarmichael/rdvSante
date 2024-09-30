<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class DiponibiliteProfessionnel extends Pivot
{
    use HasFactory;
    protected $table = 'diponibilite_professionnels';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
}
