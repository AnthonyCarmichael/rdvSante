<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'profession_professionnels','idProfession','user_id');
    }
}
