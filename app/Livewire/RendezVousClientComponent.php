<?php

namespace App\Livewire;

use App\Mail\ConfirmerRdv;
use App\Models\Clinique;
use Carbon\Carbon;
use App\Models\Indisponibilite;
use App\Models\DossierProfessionnel;
use App\Models\Dossier;
use App\Models\Client;
use App\Models\Rdv;
use App\Models\Genre;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\User;
use App\Models\Service;
use App\Models\Taxe;
use Illuminate\Support\Str;

class RendezVousClientComponent extends Component
{
    public $taxes;
    # Section 0
    public $step = 0;
    public $users;
    # Section 1
    public $professionnelId;
    # Section 2
    public $services;
    public $serviceId;
    # Section 3
    public $dispoDateArr;
    public $startingWeek;
    public $heureDebut;
    public $datesArr;
    public $heureSelected;

    public $dispoNotFounded;


    # Section 4

    public $newClient;
    public $lookDossier; # boolean
    public $dossiers;
    public $dossierSelected;

    # Section 5
    public $service;
    public $professionnel;
    public $clinique;
    public $pourmoi;
    public $genreId;
    public $ddn;
    public $telephoneClient;
    public $courrielClient;
    public $prenomClient;
    public $nomClient;
    public $prenomResponsable;
    public $nomResponsable;
    public $lienResponsable;




    public function mount(){
        $this->taxes = Taxe::all();
        $now = Carbon::now(('America/Toronto'));
        $this->clinique = Clinique::find(1); # A changer pour clinique principal


        if ($now->isSunday())
            $this->startingWeek = $now->copy();
        else
            $this->startingWeek = $now->copy()->startOfWeek();

        $this->startingWeek->setTime(7, 0);
        $this->users = User::all();
        $this->dispoDateArr = [];
        $this->pourmoi = true;
        $this->newClient = null;

    }

    public function resetForm() {
        $this->reset();
        $this->taxes = Taxe::all();
        $now = Carbon::now(('America/Toronto'));
        $this->clinique = Clinique::find(1); # A changer pour clinique principal


        if ($now->isSunday())
            $this->startingWeek = $now->copy();
        else
            $this->startingWeek = $now->copy()->startOfWeek();

        $this->startingWeek->setTime(7, 0);
        $this->users = User::all();
        $this->dispoDateArr = [];
        $this->pourmoi = true;
        $this->newClient = null;

    }

    public function updatedtelephoneClient($value) {

        if (strlen($this->telephoneClient) == 10) {
            $this->telephoneClient = '('.substr($this->telephoneClient, 0, 3).') '.substr($this->telephoneClient, 3, 3).'-'.substr($this->telephoneClient, 6);

        }
    }

    public function nextStep()
    {
        if ($this->step < 6) {
            $this->step++;
        }
        if ($this->step == 3) {
            $now = Carbon::now('America/Toronto');
            $this->changeWeek(0);
            while(empty($this->dispoDateArr) && $now->diffInMonths($this->startingWeek) <= 3)
            {
                $this->changeWeek(1);
            }
            if (empty($this->dispoDateArr)) {
                $this->dispoNotFounded=true;
            }
            else {
                $this->dispoNotFounded=false;
            }
        }
        if ($this->step == 4) {
            $this->professionnel = User::find($this->professionnelId);
            $this->service = Service::find($this->serviceId);

        }
    }
    public function backStep()
    {
        if ($this->step == 3) {
            $now = Carbon::now(('America/Toronto'));
            if ($now->isSunday())
                $this->startingWeek = $now->copy();
            else
                $this->startingWeek = $now->copy()->startOfWeek();

            $this->startingWeek->setTime(7, 0);
        }
        $this->dossiers = [];
        $this->lookDossier =0;
        $this->dossierSelected = null;
        if ($this->step > 0) {
            $this->step--;
        }
    }

    public function getProfessionnelId($id) {
        $this->professionnelId = $id;
        $this->professionnel = User::find($id);
        $this->services = Service::
            where('idProfessionnel',$this->professionnelId)->
            where('actif',true)->get();
        $this->nextStep();

    }

    public function getServiceId($id) {
        $this->serviceId = $id;
        $this->service = Service::find($id);
        $this->nextStep();
    }

    public function fetchDispoDateArr() {
        $this->dispoDateArr = [];
        $profesh = User::find($this->professionnelId);
        $disponibilites = $profesh->disponibilites;


        $now = Carbon::now('America/Toronto');

        $this->datesArr = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $this->startingWeek->copy()->addDays($i);

            // Trouver le deuxième dimanche de mars de l'année en cours
            $secondSundayOfMarch = Carbon::create($now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

            // Calculer le premier dimanche de novembre
            $firstSundayOfNovember = Carbon::createFromDate($date->year, 11, 1)->next(Carbon::SUNDAY);

            // Vérifiez si la date est entre ces deux dates
            if ($date->greaterThanOrEqualTo($secondSundayOfMarch) && $date->lessThan($firstSundayOfNovember)) {
                // Heure d'été (UTC - 4)
                // Pas besoin de changer ici, car nous gérons déjà le fuseau horaire avec 'America/Toronto'
                $date->setTimezone('America/Toronto');
            } else {
                // Heure normale (UTC - 5)
                $date->setTimezone('America/Toronto');
            }

            // Ajoutez la date ajustée au tableau
            $this->datesArr[] = $date;
        }


        $weekIndisponibilites = $profesh->indisponibilites()
            ->where('dateHeureFin', '>=', $this->startingWeek)
            ->get();


        $rdvArr = $profesh->rdvs()
            ->where('dateHeureDebut', '>=', $this->startingWeek)
            ->where('rdvs.actif', true)->get();

        $dateTemp = $this->startingWeek->copy();

        $endWeek = $this->startingWeek->copy()->addDays(6)->setTime(22, 0);

        $service = Service::find($this->serviceId);

        for ($i=0; $i < 7 ; $i++) {
            #var_dump($i);
            foreach ($disponibilites as $dispo) {

                # Gèrer le timzone ici
                $dateTemp = $this->datesArr[$i]->copy();
                $dateTemp->setTime(7, 0);
                $dateToCheck = Carbon::createFromFormat('Y-m-d', '2024-10-25', 'America/Toronto');



                ############################################################################################

                $dateTempEndAvecService = $dateTemp->copy();
                $dateTempEndAvecService->addMinutes($service->duree);

                $goodDay = false;
                # Vérification si le professionnel à mit disponible cette journée
                if($dateTemp->translatedFormat('l') == strtolower($dispo->jours->nom)){

                    $goodDay = true;
                    $goodDispo = $dispo;
                    if ($goodDay) {
                        # Le professionnel à mit de dispo cette journée
                        # Vérification si il y aurait des blocs possible pour un rdv
                        for ($j=0; $j < 180 ; $j++) {
                            $findIndispo = false;
                            $heureDebut = Carbon::parse($goodDispo->heureDebut, 'America/Toronto');
                            $heureFin = Carbon::parse($goodDispo->heureFin, 'America/Toronto');

                            $heureDebut->setDateFrom($dateTemp);
                            $heureFin->setDateFrom($dateTemp);



                            /*
                            if ($i == 1 && $j == 7) {
                                dd($this,$i,$j,$dateTemp,$dateTempEndAvecService,$heureDebut,$heureFin);
                            }
                            */
                            if ($dateTemp->between($heureDebut, $heureFin) && $dateTempEndAvecService->between($heureDebut, $heureFin)) {


                                #dd($this,$i,$j,$dateTemp,$dateTempEndAvecService,$heureDebut,$heureFin);
                                foreach ($weekIndisponibilites as $indispo) {

                                    $dateDebut = Carbon::parse($indispo->dateHeureDebut,'America/Toronto');
                                    $dateFin = Carbon::parse($indispo->dateHeureFin,'America/Toronto');

                                    #dd("indispo debut: ",$indispo->dateHeureDebut,"indispo fin:",$indispo->dateHeureFin, "dateTemp:",$dateTemp->format('Y-m-d H:i'));
                                    #dd($dateDebut, $dateFin, $dateTemp);

                                    if (
                                        // Si le début de dateTemp est dans l'indisponibilité
                                        ($dateDebut <= $dateTemp && $dateFin > $dateTemp) ||

                                        // Si la fin de dateTemp chevauche une indisponibilité
                                        ($dateDebut < $dateTempEndAvecService && $dateFin >= $dateTempEndAvecService) ||

                                        // Si dateTemp chevauche toute l'indisponibilité
                                        ($dateTemp <= $dateDebut && $dateTempEndAvecService >= $dateFin)
                                    ) {
                                        $findIndispo = true;
                                        #dd($dateDebut,$dateFin,$dateTemp, $findIndispo);
                                        break;
                                    }

                                }

                                foreach ($rdvArr as $rdv){
                                    $debut = Carbon::parse($rdv->dateHeureDebut,'America/Toronto');
                                    $fin = $debut->copy()->addMinutes($rdv->service->duree+$rdv->service->minutePause);

                                    if (
                                        // Si le début de dateTemp est dans un rdv
                                        ($debut <= $dateTemp && $fin > $dateTemp) ||

                                        // Si la fin de dateTemp chevauche un rdv
                                        ($debut <= $dateTempEndAvecService && $fin > $dateTempEndAvecService) ||

                                        // Si dateTemp chevauche toute un rdv
                                        ($dateTemp <= $debut && $dateTempEndAvecService > $fin)
                                    )  {

                                        $findIndispo = true;
                                        break;
                                    }

                                }

                                if (!$findIndispo) {
                                    if ($now->diffInHours($dateTemp) >= 1) {
                                        $this->dispoDateArr[] = $dateTemp->copy();
                                        #dd("pas d'indispo ajouter cette date dans le arrDateDispo",$dateTemp);
                                    }

                                }
                            }
                            $dateTemp->modify('+5 minutes');
                            $dateTempEndAvecService->modify('+5 minutes');
                        }
                    }
                }
            }


            $dateTemp->modify('+1 day');
        }

        /*
        if ($this->startingWeek->isSameDay($dateToCheck) ) {
            #dd($this);
        }
*/


        #$rdvs;

        # verification indispo ($indispo->dateHeureDebut <= $selectedDateTime && $indispo->dateHeureFin > $selectedDateTime )
        # verification rdv ($debut <= $selectedDateTime && $debut->addMinutes($rdv->service->duree) > $selectedDateTime)

    }

    public function changeWeek($value) {
        // Déterminer la date actuelle
        $now = Carbon::now('America/Toronto');

        // Déterminer le fuseau horaire approprié
        $timezone = 'America/Toronto'; // Valeur par défaut

        // Trouver le premier dimanche de novembre de l'année en cours
        $firstSundayOfNovember = Carbon::create($now->year, 11, 1)->next(Carbon::SUNDAY);

        // Trouver le deuxième dimanche de mars de l'année en cours
        $secondSundayOfMarch = Carbon::create($now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

        // Vérifier si la date actuelle est entre le premier dimanche de novembre et le deuxième dimanche de mars
        if ($now->between($firstSundayOfNovember, $secondSundayOfMarch)) {
            // Appliquer l'heure d'hiver (UTC-5)
            $timezone = 'America/Toronto'; // UTC-5 pour l'heure d'hiver
        } else {
            // Appliquer l'heure d'été (UTC-4)
            $timezone = 'America/Toronto'; // UTC-4 pour l'heure d'été
        }

        if ($value > 0) {
            if ($now->diffInMonths($this->startingWeek) <= 3) {
                $this->startingWeek = $this->startingWeek->addWeek();
            }
        } else if ($value < 0) {
            if ($now->diffInWeeks($this->startingWeek) >0) {
                $this->startingWeek = $this->startingWeek->subWeek();
            }

        }

        // Appliquer le fuseau horaire pour la semaine de départ
        $this->startingWeek->setTimezone($timezone);
        $this->refresh();

    }

    public function refresh(){
        $this->datesArr = [];
        #dd($this->startingWeek);
        for ($i=0; $i < 7; $i++) {
            $date = $this->startingWeek->copy()->addDays($i);
            $this->datesArr[] = $date;
        }

        $this->fetchDispoDateArr();
        #dd( $this->datesArr,$this->startingWeek);
    }

    public function choixDate($value){

        $this->heureSelected = Carbon::parse($value, 'America/Toronto');
        $this->nextStep();

    }



    public function lookingDossier($value) {
        $this->lookDossier = $value;
    }

    public function fetchDossier() {
        $dossierIds  = DossierProfessionnel::join('dossiers', 'dossier_professionnels.idDossier', '=', 'dossiers.id')
        ->join('clients', 'dossiers.idClient', '=', 'clients.id')
        ->where('dossier_professionnels.idProfessionnel', $this->professionnelId)
        ->where('clients.courriel', $this->courrielClient)
        ->where('clients.actif', true)
        ->pluck('dossiers.id');


        $this->dossiers = Dossier::whereIn('id', $dossierIds)->get();
        $this->dossierSelected = null;

        #dd($this->dossiers);
    }

    public function selectDossierClient(Dossier $dossier) {
        $this->dossierSelected = $dossier;
        $this->nextStep();
    }


    public function rdvClient(){

        if ($this->pourmoi == 1) {
            $this->prenomResponsable = null;
            $this->nomResponsable = null;
            $this->lienResponsable = null;
        }

        $client = null;
        $token = Str::random(32);


        if ($this->dossierSelected) {
            $client = $this->dossierSelected->client;
            $nouveauRdv = Rdv::create([
                'dateHeureDebut' => $this->heureSelected,
                'idDossier' => $this->dossierSelected->id,
                'idService' => $this->serviceId,
                'idClinique' => $this->clinique->id,
                'raison' => null,
                'actif' => true,
                'token' => $token,
            ]);
        } else {
            $client = Client::create([
                'nom' => $this->nomClient,
                'prenom' => $this->prenomClient,
                'courriel' => $this->courrielClient,
                'telephone' => $this->telephoneClient,
                'ddn' => $this->ddn,
                'actif' => true,
                'nomResponsable' => $this->nomResponsable = null,
                'prenomResponsable' => $this->prenomResponsable,
                'lienResponsable' => $this->lienResponsable,
                'idGenre' =>$this->genreId,

            ]);
            $nouveauDossier = Dossier::create([
                'dateCreation' => Carbon::now('America/Toronto')->format('Y-m-d'),
                'permissionPartage' => false,
                'idClient' => $client->id
            ]);

            $nouveauDossierProfessionnel = DossierProfessionnel::create([
                'principal' => true,
                'idDossier' => $nouveauDossier->id,
                'idProfessionnel' => $this->professionnel->id,
            ]);
            $nouveauRdv = Rdv::create([
                'dateHeureDebut' => $this->heureSelected,
                'idDossier' => $nouveauDossier->id,
                'idService' => $this->serviceId,
                'idClinique' => $this->clinique->id,
                'raison' => null,
                'actif' => true,
                'token' => $token,
            ]);

        }

        $this->sendConfirmedRdvMail($client,$nouveauRdv,$this->professionnel);

        $this->nextStep();

    }

    public function sendConfirmedRdvMail($client,$rdv,$professionnel) {

        $tps = Taxe::where('nom','TPS')->first();
        $tvq =  Taxe::where('nom','TVQ')->first();

        Mail::to($client->courriel)
            ->send(new ConfirmerRdv($rdv,$professionnel,$tps,$tvq,"confirmer"));
    }

    public function render()
    {
        return view('livewire.rendez-vous-client-component',[
            'genres' => $genres = Genre::all()
        ]);
    }


}
