<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'organisation_professionnels','idProfession','user_id');
    }
}
