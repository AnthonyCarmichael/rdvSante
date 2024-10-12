<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'idProvince'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'idProvince');
    }

    public $timestamps = false;
}
