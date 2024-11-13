<?php

namespace App\Livewire;

use App\Models\FicheClinique;
use App\Models\Profession;
use App\Models\TypeFiche;
use Carbon\Carbon;
use Livewire\Component;

class FicheCliniqueComponent extends Component
{
    public $dossierClient; //idDossier a mettre dans newFiche
    public $newFiche;


    // liste de tout les champs dans la table ficheClinique
    public $dateHeure,
        $idTypeFiche,
        $idProfession,
        #$nom,
        $analyse,
        $conseilsPrevention,
        // Anamnese et Suivi SOAPIE
        $occupation,
        $loisirs,
        $lateralite,
        $diagnostic,
        $medic,
        $contreIndication,
        $rced,
        $localIrr,
        $douleur,
        $fa,
        $fd,
        $nuit,
        $sa,
        $investigation,
        $trauma,
        $chx,
        $familiaux,
        $cardioVasculaire,
        $pulmonaire,
        $snc,
        $orl,
        $digestif,
        $gynecoAndrologie,
        $urinaire,
        $hs,
        $psychologique,
        $msk,
        $dermato,
        $autre,
        // Éval Nourrisson
        $observation,
        $commentaire,
        $nbreSemGestation,
        $apgar,
        $poid,
        $taille,
        $perCranien,
        $maladieALaNaissance,
        $medicaments,
        $nomsParent,
        $historiqueGrossesse,
        $historiqueAccouchement,
        $cesarienne,
        $forceps,
        $ventouse,
        $episiotomie,
        $alimentation,
        $digestion,
        $pleurs,
        $motricite,
        $neuro,
        $motifConsultation,
        $techniques,
        $age;


    public function mount($dossierClient)
    {
        $this->dossierClient = $dossierClient;
        $this->newFiche = new FicheClinique();

    }

    public function ajouterFiche()
    {
        switch ($this->idTypeFiche) {
            case 1: // Anamnèse
                $newFiche = FicheClinique::create([
                    'dateHeure' => Carbon::now(),
                    'idDossier' => $this->dossierClient->id,
                    'idTypeFiche' => $this->idTypeFiche,
                    'idProfession' => Profession::where('nom','Ostéopathe D.O')->value('id'),
                    #'nom' => $this->nom,
                    'analyse' => $this->analyse,
                    'conseilsPrevention' => $this->conseilsPrevention,
                    'occupation' => $this->occupation,
                    'loisirs' => $this->loisirs,
                    'lateralite' => $this->lateralite,
                    'diagnostic' => $this->diagnostic,
                    'medic' => $this->medic,
                    'contreIndication' => $this->contreIndication,
                    'rced' => $this->rced,
                    'localIrr' => $this->localIrr,
                    'douleur' => $this->douleur,
                    'fa' => $this->fa,
                    'fd' => $this->fd,
                    'nuit' => $this->nuit,
                    'sa' => $this->sa,
                    'investigation' => $this->investigation,
                    'trauma' => $this->trauma,
                    'chx' => $this->chx,
                    'familiaux' => $this->familiaux,
                    'cardioVasculaire' => $this->cardioVasculaire,
                    'pulmonaire' => $this->pulmonaire,
                    'snc' => $this->snc,
                    'orl' => $this->orl,
                    'digestif' => $this->digestif,
                    'gynecoAndrologie' => $this->gynecoAndrologie,
                    'urinaire' => $this->urinaire,
                    'hs' => $this->hs,
                    'psychologique' => $this->psychologique,
                    'msk' => $this->msk,
                    'dermato' => $this->dermato,
                    'autre' => $this->autre,
                    'observation' => $this->observation,
                    'commentaire' => $this->commentaire,
                    'conseilsPrevention' => $this->conseilsPrevention,
                ]);


                /* Pour modifier

                $newFiche->dateHeure= Carbon::now();
                $newFiche->idTypeFiche = $this->idTypeFiche;
                $newFiche->idProfession = Profession::where('nom','Ostéopathe D.O')->value('id');
                $newFiche->nom = $this->nom;
                $newFiche->analyse = $this->analyse;
                $newFiche->conseilsPrevention = $this->conseilsPrevention;
                // Anamnese field
                $newFiche->occupation = $this->occupation;
                $newFiche->loisirs = $this->loisirs;
                $newFiche->lateralite = $this->lateralite;
                $newFiche->diagnostic = $this->diagnostic;
                $newFiche->medic = $this->medic;
                $newFiche->contreIndication = $this->contreIndication;
                $newFiche->rced = $this->rced;
                $newFiche->localIrr = $this->localIrr;
                $newFiche->douleur = $this->douleur;
                $newFiche->fa = $this->fa;
                $newFiche->fd = $this->fd;
                $newFiche->nuit = $this->nuit;
                $newFiche->sa = $this->sa;
                $newFiche->investigation = $this->investigation;
                $newFiche->trauma = $this->trauma;
                $newFiche->chx = $this->chx;
                $newFiche->familiaux = $this->familiaux;
                $newFiche->cardioVasculaire = $this->cardioVasculaire;
                $newFiche->pulmonaire = $this->pulmonaire;
                $newFiche->snc = $this->snc;
                $newFiche->orl = $this->orl;
                $newFiche->digestif = $this->digestif;
                $newFiche->gynecoAndrologie = $this->gynecoAndrologie;
                $newFiche->urinaire = $this->urinaire;
                $newFiche->hs = $this->hs;
                $newFiche->psychologique = $this->psychologique;
                $newFiche->msk = $this->msk;
                $newFiche->dermato = $this->dermato;
                $newFiche->autre = $this->autre;
                dd("Anamnèse",$this, $newFiche);
                */
                dd($this, $newFiche);
                break;

            case 2: // Éval nourrisson
                dd("Éval nourrisson",$this);
                break;

            case 3: // Suivi SOAPIE
                dd("Suivi SOAPIE",$this);
                break;

            default:
                # code...
                break;
        }
    }

    public function updatedidTypeFiche($value)
    {
        #dd("updatedTypeFicheId",$this->typeFicheId);
        $this->newFiche = new FicheClinique();
        $this->newFiche->idTypeFiche = $value;

    }

    public function render()
    {
        $typeFiches = TypeFiche::all();
        return view('livewire.fiche-clinique-component',[
            'typeFiches' =>$typeFiches
        ]);
    }
}
