<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationProfessionnel extends Model
{
    use HasFactory;

    protected $table = 'organisation_professionnels';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['idProfession', 'idOrganisation', 'idProfessionnel', 'numMembre', 'dateExpiration'];
}
