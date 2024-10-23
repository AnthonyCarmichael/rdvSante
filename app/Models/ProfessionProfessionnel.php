<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class ProfessionProfessionnel extends Pivot
{
    use HasFactory;

    protected $table = 'profession_professionnels';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['idProfession', 'user_id'];

}
