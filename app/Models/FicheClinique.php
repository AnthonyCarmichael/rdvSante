<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheClinique extends Model
{
    use HasFactory;

    // Ajoute 'idDossier' à la propriété fillable
    protected $fillable = [
        'dateHeure',
        'idDossier',
        'idTypeFiche',
        'idProfession',
        'nom',
        'description',
        'conseilsPrevention',
        'occupation',
        'loisirs',
        'lateralite',
        'diagnostic',
        'medic',
        'contreIndication',
        'rced',
        'localIrr',
        'douleur',
        'fa',
        'fd',
        'nuit',
        'sa',
        'investigation',
        'trauma',
        'chx',
        'familiaux',
        'cardioVasculaire',
        'pulmonaire',
        'snc',
        'orl',
        'digestif',
        'gynecoAndrologie',
        'urinaire',
        'hs',
        'psychologique',
        'msk',
        'dermato',
        'autre',
        'observation',
        'commentaire',
        'nbreSemGestation',
        'apgar',
        'poid',
        'taille',
        'perCranien',
        'maladieALaNaissance',
        'medicaments',
        'nomsParent',
        'historiqueGrossesse',
        'historiqueAccouchement',
        'cesarienne',
        'forceps',
        'ventouse',
        'episiotomie',
        'alimentation',
        'digestion',
        'pleurs',
        'motricite',
        'neuro',
        'motifConsultation',
        'techniques',
    ];

    public $timestamps = false;

    public function typeFiche()
    {
        return $this->belongsTo(TypeFiche::class, 'idTypeFiche');
    }
    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'idDossier');
    }
    public function profession()
    {
        return $this->belongsTo(Profession::class, 'idProfession');
    }

}
