<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class ProfessionProfessionnel extends Pivot
{
    use HasFactory;

    protected $table = 'professionProfessionnels';
    protected $primaryKey = 'idProfessionProfessionnel';
    public $incrementing = true;
    public $timestamps = false;
}
