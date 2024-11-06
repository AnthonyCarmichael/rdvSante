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


class ModifierRdvParClient extends Component
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

    # Modifier un rdv
    public $oldRdv;
    public $modification;
    public $oldDate;
    public $now;




    public function mount(Rdv $oldRdv){
        $this->taxes = Taxe::all();
        $now = Carbon::now(('America/Toronto'));
        $this->now = $now->copy();
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

        if ($oldRdv->id !=null) {
            $this->oldRdv = $oldRdv;
            $this->oldDate = Carbon::parse($this->oldRdv->dateHeureDebut, 'America/Toronto');

            $this->lookDossier = true;

            $this->courrielClient= $this->oldRdv->client->courriel;
            $this->service =$this->oldRdv->service;
            $this->serviceId =$this->oldRdv->service->id;
            $this->professionnel = $this->oldRdv->dossier->professionnels[0];
            $this->professionnelId =$this->oldRdv->dossier->professionnels[0]->id;
            $this->dossierSelected =$this->oldRdv->dossier;

        }

    }

    public function backStep()
    {
        $this->modification = null;
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
        $this->modification="confirmer";

    }


    public function sendConfirmedRdvMail($client,$rdv,$professionnel) {

        $tps = Taxe::where('nom','TPS')->first();
        $tvq =  Taxe::where('nom','TVQ')->first();

        Mail::to($client->courriel)
            ->send(new ConfirmerRdv($rdv,$professionnel,$tps,$tvq,"confirmer"));
    }

    # Non gèré en standby
    public function modifierDossier() {
        $this->modification = "dossier";

    }

    public function modifierDate() {
        $this->modification = "date";

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

    public function modifierRdvClient(){
        $token = Str::random(32);

        $rdv = Rdv::find($this->oldRdv->id);

        $rdv->dateHeureDebut = $this->heureSelected;
        $rdv->token = $token;
        $rdv->save();
        $this->sendConfirmedRdvMail($rdv->dossier->client,$rdv,$this->professionnel);
        $this->modification = "end";

    }

    public function render()
    {
        return view('livewire.modifier-rdv-par-client',[
            'genres' => $genres = Genre::all()
        ]);
    }
}
