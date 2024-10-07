<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Disponibilite extends Model
{
    use HasFactory;

    protected $table = 'disponibilites';
    protected $primaryKey = 'id';

    protected $fillable = ['heureDebut', 'heureFin', 'idJour'];
    public $timestamps = false;

    public function professionnels(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'diponibilite_professionnels','idDisponibilite','user_id');
    }

}
