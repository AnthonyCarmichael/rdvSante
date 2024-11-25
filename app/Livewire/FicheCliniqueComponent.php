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
    public $fiche;
    public $idTypeFiche;

    public $typeForm;


    // liste de tout les champs qu'on veut reset lorsque on change de type
    public $dateHeure,
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
        $sommeil,
        $pleurs,
        $motricite,
        $neuro,
        $motifConsultation,
        $techniques,
        $age,
        $succ,
        $foulard,
        $marcheAuto,
        $grasping,
        $redressement,
        $babinski,
        $moro,
        $toniqueAsym,
        $tonusActifPassif,
        $depuisDerniereSeance;


    public function mount($dossierClient, $ficheSelected = null)
    {
        $this->fiche = $ficheSelected;
        $this->dossierClient = $dossierClient;

        if ($this->fiche) {
            $this->typeForm = "consulter";
            $this->idTypeFiche = $ficheSelected->idTypeFiche;

            $this->idProfession = $this->fiche->idProfession;
            #this->$nom,
            $this->analyse = $this->fiche->analyse;
            $this->conseilsPrevention = $this->fiche->conseilsPrevention;
            // Anamnese et Suivi SOAPIE
            $this->occupation = $this->fiche->occupation;
            $this->loisirs = $this->fiche->loisirs;
            $this->lateralite = $this->fiche->lateralite;
            $this->diagnostic = $this->fiche->diagnostic;
            $this->medic = $this->fiche->medic;
            $this->contreIndication = $this->fiche->contreIndication;
            $this->rced = $this->fiche->rced;
            $this->localIrr = $this->fiche->localIrr;
            $this->douleur = $this->fiche->douleur;
            $this->fa = $this->fiche->fa;
            $this->fd = $this->fiche->fd;
            $this->nuit = $this->fiche->nuit;
            $this->sa = $this->fiche->sa;
            $this->investigation = $this->fiche->investigation;
            $this->trauma = $this->fiche->trauma;
            $this->chx = $this->fiche->chx;
            $this->familiaux = $this->fiche->familiaux;
            $this->cardioVasculaire = $this->fiche->cardioVasculaire;
            $this->pulmonaire = $this->fiche->pulmonaire;
            $this->snc = $this->fiche->snc;
            $this->orl = $this->fiche->orl;
            $this->digestif = $this->fiche->digestif;
            $this->gynecoAndrologie = $this->fiche->gynecoAndrologie;
            $this->urinaire = $this->fiche->urinaire;
            $this->hs = $this->fiche->hs;
            $this->psychologique = $this->fiche->psychologique;
            $this->msk = $this->fiche->msk;
            $this->dermato = $this->fiche->dermato;
            $this->autre = $this->fiche->autre;
            // Éval Nourrisson
            $this->observation = $this->fiche->observation;
            $this->commentaire = $this->fiche->commentaire;
            $this->nbreSemGestation = $this->fiche->nbreSemGestation;
            $this->apgar = $this->fiche->apgar;
            $this->poid = $this->fiche->poid;
            $this->taille = $this->fiche->taille;
            $this->perCranien = $this->fiche->perCranien;
            $this->maladieALaNaissance = $this->fiche->maladieALaNaissance;
            $this->medicaments = $this->fiche->medicaments;
            $this->nomsParent = $this->fiche->nomsParent;
            $this->historiqueGrossesse = $this->fiche->historiqueGrossesse;
            $this->historiqueAccouchement = $this->fiche->historiqueAccouchement;
            $this->cesarienne = $this->fiche->cesarienne == 1;
            $this->forceps = $this->fiche->forceps == 1;
            $this->ventouse = $this->fiche->ventouse == 1;
            $this->episiotomie = $this->fiche->episiotomie == 1;
            $this->alimentation = $this->fiche->alimentation;
            $this->digestion = $this->fiche->digestion;
            $this->sommeil = $this->fiche->sommeil;
            $this->pleurs = $this->fiche->pleurs;
            $this->motricite = $this->fiche->motricite;
            $this->neuro = $this->fiche->neuro;
            $this->motifConsultation = $this->fiche->motifConsultation;
            $this->techniques = $this->fiche->techniques;
            $this->age = $this->fiche->age;
            $this->succ = $this->fiche->succ;
            $this->foulard = $this->fiche->foulard;
            $this->marcheAuto = $this->fiche->marcheAuto;
            $this->grasping = $this->fiche->grasping;
            $this->redressement = $this->fiche->redressement;
            $this->babinski = $this->fiche->babinski;
            $this->moro = $this->fiche->moro;
            $this->toniqueAsym = $this->fiche->toniqueAsym;
            $this->tonusActifPassif = $this->fiche->tonusActifPassif;
            $this->depuisDerniereSeance = $this->fiche->depuisDerniereSeance;


        } else {
            $this->typeForm = "ajouter";
            $this->fiche = new FicheClinique();
        }

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
                ]);
                break;

            case 2: // Éval nourrisson
                $newFiche = FicheClinique::create([
                    'dateHeure' => Carbon::now(),
                    'idDossier' => $this->dossierClient->id,
                    'idTypeFiche' => $this->idTypeFiche,
                    'idProfession' => Profession::where('nom','Ostéopathe D.O')->value('id'),
                    #'nom' => $this->nom,
                    'analyse' => $this->analyse,
                    'conseilsPrevention' => $this->conseilsPrevention,
                    'nbreSemGestation' => $this->nbreSemGestation,
                    'apgar' => $this->apgar,
                    'poid' => $this->poid,
                    'taille' => $this->taille,
                    'perCranien' => $this->perCranien,
                    'maladieALaNaissance' => $this->maladieALaNaissance,
                    'medicaments' => $this->medicaments,
                    'nomsParent' => $this->nomsParent,
                    'historiqueGrossesse' => $this->historiqueGrossesse,
                    'historiqueAccouchement' => $this->historiqueAccouchement,
                    'cesarienne' => $this->cesarienne,
                    'forceps' => $this->forceps,
                    'ventouse' => $this->ventouse,
                    'episiotomie' => $this->episiotomie,
                    'alimentation' => $this->alimentation,
                    'digestion' => $this->digestion,
                    'sommeil' => $this->sommeil,
                    'pleurs' => $this->pleurs,
                    'motricite' => $this->motricite,
                    'neuro' => $this->neuro,
                    'motifConsultation' => $this->motifConsultation,
                    'techniques' => $this->techniques,
                    'age' => $this->age,
                    'succ' => $this->succ,
                    'foulard' => $this->foulard,
                    'marcheAuto' => $this->marcheAuto,
                    'grasping' => $this->grasping,
                    'redressement' => $this->redressement,
                    'babinski' => $this->babinski,
                    'moro' => $this->moro,
                    'toniqueAsym' => $this->toniqueAsym,
                    'tonusActifPassif' => $this->tonusActifPassif
                ]);
                break;

            case 3: // Suivi SOAPIE
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
                    'depuisDerniereSeance' => $this->depuisDerniereSeance,
                ]);
                break;

            default:
                # code...
                break;
        }

        return redirect()->route('dossierClient',$this->dossierClient);
    }

    public function updatedidTypeFiche($value)
    {
        #dd("updatedTypeFicheId",$this->typeFicheId);
        $this->resetExcept(['dossierClient', 'idTypeFiche', 'typeForm']);
        $this->fiche = new FicheClinique();
        $this->fiche->idTypeFiche = $value;

    }

    public function alternateEditingMode() {
        if ($this->typeForm == "consulter") {
            $this->typeForm = "modifier";
        } elseif($this->typeForm == "modifier") {
            $this->typeForm = "consulter";
            #this->$nom,
            $this->analyse = $this->fiche->analyse;
            $this->conseilsPrevention = $this->fiche->conseilsPrevention;
            // Anamnese et Suivi SOAPIE
            $this->occupation = $this->fiche->occupation;
            $this->loisirs = $this->fiche->loisirs;
            $this->lateralite = $this->fiche->lateralite;
            $this->diagnostic = $this->fiche->diagnostic;
            $this->medic = $this->fiche->medic;
            $this->contreIndication = $this->fiche->contreIndication;
            $this->rced = $this->fiche->rced;
            $this->localIrr = $this->fiche->localIrr;
            $this->douleur = $this->fiche->douleur;
            $this->fa = $this->fiche->fa;
            $this->fd = $this->fiche->fd;
            $this->nuit = $this->fiche->nuit;
            $this->sa = $this->fiche->sa;
            $this->investigation = $this->fiche->investigation;
            $this->trauma = $this->fiche->trauma;
            $this->chx = $this->fiche->chx;
            $this->familiaux = $this->fiche->familiaux;
            $this->cardioVasculaire = $this->fiche->cardioVasculaire;
            $this->pulmonaire = $this->fiche->pulmonaire;
            $this->snc = $this->fiche->snc;
            $this->orl = $this->fiche->orl;
            $this->digestif = $this->fiche->digestif;
            $this->gynecoAndrologie = $this->fiche->gynecoAndrologie;
            $this->urinaire = $this->fiche->urinaire;
            $this->hs = $this->fiche->hs;
            $this->psychologique = $this->fiche->psychologique;
            $this->msk = $this->fiche->msk;
            $this->dermato = $this->fiche->dermato;
            $this->autre = $this->fiche->autre;
            // Éval Nourrisson
            $this->observation = $this->fiche->observation;
            $this->commentaire = $this->fiche->commentaire;
            $this->nbreSemGestation = $this->fiche->nbreSemGestation;
            $this->apgar = $this->fiche->apgar;
            $this->poid = $this->fiche->poid;
            $this->taille = $this->fiche->taille;
            $this->perCranien = $this->fiche->perCranien;
            $this->maladieALaNaissance = $this->fiche->maladieALaNaissance;
            $this->medicaments = $this->fiche->medicaments;
            $this->nomsParent = $this->fiche->nomsParent;
            $this->historiqueGrossesse = $this->fiche->historiqueGrossesse;
            $this->historiqueAccouchement = $this->fiche->historiqueAccouchement;
            $this->cesarienne = $this->fiche->cesarienne == 1;
            $this->forceps = $this->fiche->forceps == 1;
            $this->ventouse = $this->fiche->ventouse == 1;
            $this->episiotomie = $this->fiche->episiotomie == 1;
            $this->alimentation = $this->fiche->alimentation;
            $this->digestion = $this->fiche->digestion;
            $this->sommeil = $this->fiche->sommeil;
            $this->pleurs = $this->fiche->pleurs;
            $this->motricite = $this->fiche->motricite;
            $this->neuro = $this->fiche->neuro;
            $this->motifConsultation = $this->fiche->motifConsultation;
            $this->techniques = $this->fiche->techniques;
            $this->age = $this->fiche->age;
            $this->succ = $this->fiche->succ;
            $this->foulard = $this->fiche->foulard;
            $this->marcheAuto = $this->fiche->marcheAuto;
            $this->grasping = $this->fiche->grasping;
            $this->redressement = $this->fiche->redressement;
            $this->babinski = $this->fiche->babinski;
            $this->moro = $this->fiche->moro;
            $this->toniqueAsym = $this->fiche->toniqueAsym;
            $this->tonusActifPassif = $this->fiche->tonusActifPassif;
            $this->depuisDerniereSeance = $this->fiche->depuisDerniereSeance;
        }
    }

    public function modifierFiche() {

        switch ($this->idTypeFiche) {
            case 1: // Anamnèse
                $this->fiche->analyse = $this->analyse;
                $this->fiche->conseilsPrevention = $this->conseilsPrevention;
                $this->fiche->occupation = $this->occupation;
                $this->fiche->loisirs = $this->loisirs;
                $this->fiche->lateralite = $this->lateralite;
                $this->fiche->diagnostic = $this->diagnostic;
                $this->fiche->medic = $this->medic;
                $this->fiche->contreIndication = $this->contreIndication;
                $this->fiche->rced = $this->rced;
                $this->fiche->localIrr = $this->localIrr;
                $this->fiche->douleur = $this->douleur;
                $this->fiche->fa = $this->fa;
                $this->fiche->fd = $this->fd;
                $this->fiche->nuit = $this->nuit;
                $this->fiche->sa = $this->sa;
                $this->fiche->investigation = $this->investigation;
                $this->fiche->trauma = $this->trauma;
                $this->fiche->chx = $this->chx;
                $this->fiche->familiaux = $this->familiaux;
                $this->fiche->cardioVasculaire = $this->cardioVasculaire;
                $this->fiche->pulmonaire = $this->pulmonaire;
                $this->fiche->snc = $this->snc;
                $this->fiche->orl = $this->orl;
                $this->fiche->digestif = $this->digestif;
                $this->fiche->gynecoAndrologie = $this->gynecoAndrologie;
                $this->fiche->urinaire = $this->urinaire;
                $this->fiche->hs = $this->hs;
                $this->fiche->psychologique = $this->psychologique;
                $this->fiche->msk = $this->msk;
                $this->fiche->dermato = $this->dermato;
                $this->fiche->autre = $this->autre;
                $this->fiche->observation = $this->observation;
                $this->fiche->commentaire = $this->commentaire;

                break;

            case 2: // Éval nourrisson

                    $this->fiche->analyse = $this->analyse;
                    $this->fiche->conseilsPrevention = $this->conseilsPrevention;
                    $this->fiche->nbreSemGestation = $this->nbreSemGestation;
                    $this->fiche->apgar = $this->apgar;
                    $this->fiche->poid = $this->poid;
                    $this->fiche->taille = $this->taille;
                    $this->fiche->perCranien = $this->perCranien;
                    $this->fiche->maladieALaNaissance = $this->maladieALaNaissance;
                    $this->fiche->medicaments = $this->medicaments;
                    $this->fiche->nomsParent = $this->nomsParent;
                    $this->fiche->historiqueGrossesse = $this->historiqueGrossesse;
                    $this->fiche->historiqueAccouchement = $this->historiqueAccouchement;
                    $this->fiche->cesarienne = $this->cesarienne;
                    $this->fiche->forceps = $this->forceps;
                    $this->fiche->ventouse = $this->ventouse;
                    $this->fiche->episiotomie = $this->episiotomie;
                    $this->fiche->alimentation = $this->alimentation;
                    $this->fiche->digestion = $this->digestion;
                    $this->fiche->sommeil = $this->sommeil;
                    $this->fiche->pleurs = $this->pleurs;
                    $this->fiche->motricite = $this->motricite;
                    $this->fiche->neuro = $this->neuro;
                    $this->fiche->motifConsultation = $this->motifConsultation;
                    $this->fiche->techniques = $this->techniques;
                    $this->fiche->age = $this->age;
                    $this->fiche->succ = $this->succ;
                    $this->fiche->foulard = $this->foulard;
                    $this->fiche->marcheAuto = $this->marcheAuto;
                    $this->fiche->grasping = $this->grasping;
                    $this->fiche->redressement = $this->redressement;
                    $this->fiche->babinski = $this->babinski;
                    $this->fiche->moro = $this->moro;
                    $this->fiche->toniqueAsym = $this->toniqueAsym;
                    $this->fiche->tonusActifPassif = $this->tonusActifPassif;
                break;

            case 3: // Suivi SOAPIE

                $this->fiche->analyse = $this->analyse;
                $this->fiche->conseilsPrevention = $this->conseilsPrevention;
                $this->fiche->occupation = $this->occupation;
                $this->fiche->loisirs = $this->loisirs;
                $this->fiche->lateralite = $this->lateralite;
                $this->fiche->diagnostic = $this->diagnostic;
                $this->fiche->medic = $this->medic;
                $this->fiche->contreIndication = $this->contreIndication;
                $this->fiche->rced = $this->rced;
                $this->fiche->localIrr = $this->localIrr;
                $this->fiche->douleur = $this->douleur;
                $this->fiche->fa = $this->fa;
                $this->fiche->fd = $this->fd;
                $this->fiche->nuit = $this->nuit;
                $this->fiche->sa = $this->sa;
                $this->fiche->investigation = $this->investigation;
                $this->fiche->trauma = $this->trauma;
                $this->fiche->chx = $this->chx;
                $this->fiche->familiaux = $this->familiaux;
                $this->fiche->cardioVasculaire = $this->cardioVasculaire;
                $this->fiche->pulmonaire = $this->pulmonaire;
                $this->fiche->snc = $this->snc;
                $this->fiche->orl = $this->orl;
                $this->fiche->digestif = $this->digestif;
                $this->fiche->gynecoAndrologie = $this->gynecoAndrologie;
                $this->fiche->urinaire = $this->urinaire;
                $this->fiche->hs = $this->hs;
                $this->fiche->psychologique = $this->psychologique;
                $this->fiche->msk = $this->msk;
                $this->fiche->dermato = $this->dermato;
                $this->fiche->autre = $this->autre;
                $this->fiche->observation = $this->observation;
                $this->fiche->commentaire = $this->commentaire;
                $this->fiche->depuisDerniereSeance = $this->depuisDerniereSeance;

                break;

            default:
                # code...
                break;
        }
        $this->fiche->save();
        session()->flash('success', 'Les modification ont été enregistrées');
        return redirect()->route('ficheCliniqueConsulter', ['id' => $this->fiche->id]);
    }

    public function render()
    {
        $typeFiches = TypeFiche::all();
        return view('livewire.fiche-clinique-component',[
            'typeFiches' =>$typeFiches
        ]);
    }
}
