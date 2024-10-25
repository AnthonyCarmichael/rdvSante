<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public function disponibilites(): BelongsToMany
    {
        return $this->belongsToMany(Disponibilite::class, 'diponibilite_professionnels','id_user','idDisponibilite');
    }

    public function dossiers(): BelongsToMany
    {
        return $this->belongsToMany(Dossier::class, 'dossier_professionnels','idProfessionnel','idDossier');
    }

    public function cliniques(): BelongsToMany
    {
        return $this->belongsToMany(Clinique::class, 'clinique_professionnels','idProfessionnel','idClinique');
    }

    public function professions()
    {
        return $this->belongsToMany(Profession::class, 'profession_professionnels','user_id','idProfession');
    }

    public function indisponibilites()
    {
        return $this->hasMany(Indisponibilite::class, 'idProfessionnel');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'telephone',
        'idProfession',
        'description',
        'actif',
        'lien',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
