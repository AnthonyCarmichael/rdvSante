<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganisationProfession extends Model
{
    use HasFactory;

    protected $table = 'organisation_professions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['idProfession', 'idOrganisation'];
}
