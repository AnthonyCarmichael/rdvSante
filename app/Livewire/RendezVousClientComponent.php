<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Indisponibilite;
use App\Models\Rdv;
use Livewire\Component;
use App\Models\User;
use App\Models\Service;

class RendezVousClientComponent extends Component
{
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

    # Section 4
    public $prenomClient;

    public function mount(){
        $now = Carbon::now(('America/Toronto'));


        if ($now->isSunday())
            $this->startingWeek = $now->copy();
        else
            $this->startingWeek = $now->copy()->startOfWeek()->subDay();

        $this->startingWeek->setTime(7, 0);
        $this->users = User::all();
        $this->dispoDateArr = [];
    }

    public function nextStep()
    {
        if ($this->step < 4) {
            $this->step++;
        }
        if ($this->step == 3) {
            $now = Carbon::now('America/Toronto');
            $this->changeWeek(0);
            while(empty($this->dispoDateArr) && $now->diffInMonths($this->startingWeek) <= 3)
            {
                $this->changeWeek(1);
            }
        }
    }
    public function backStep()
    {
        if ($this->step > 0) {
            $this->step--;
        }
    }

    public function getProfessionnelId($id) {
        $this->professionnelId = $id;
        $this->services = Service::
            where('idProfessionnel',$this->professionnelId)->
            where('actif',true)->get();
        $this->nextStep();

    }

    public function getServiceId($id) {
        $this->serviceId = $id;
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


        $rdvArr = Rdv::where('dateHeureDebut', '>=', $this->startingWeek)->get();

        $dateTemp = $this->startingWeek->copy();

        $endWeek = $this->startingWeek->copy()->addDays(6)->setTime(22, 0);

        $service = Service::find($this->serviceId);

        for ($i=0; $i < 7 ; $i++) {
            #var_dump($i);
            foreach ($disponibilites as $dispo) {

                # Gèrer le timzone ici
                $dateTemp = $this->datesArr[$i]->copy();
                $dateTemp->setTime(7, 0);
                $dateToCheck = Carbon::createFromFormat('Y-m-d', '2024-10-27', 'America/Toronto');



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
                        for ($j=0; $j < 60 ; $j++) {
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
                                        // Si le début de dateTemp est dans l'indisponibilité
                                        ($debut <= $dateTemp && $fin > $dateTemp) ||

                                        // Si la fin de dateTemp chevauche une indisponibilité
                                        ($debut < $dateTempEndAvecService && $fin >= $dateTempEndAvecService) ||

                                        // Si dateTemp chevauche toute l'indisponibilité
                                        ($dateTemp <= $debut && $dateTempEndAvecService >= $fin)
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
                            $dateTemp->modify('+15 minutes');
                            $dateTempEndAvecService->modify('+15 minutes');
                        }
                    }
                }
            }


            $dateTemp->modify('+1 day');
        }

        if ($this->startingWeek->isSameDay($dateToCheck) ) {
            #dd($this);
        }


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


    public function rdvClient(){
        dd($this);

    }

    public function render()
    {
        return view('livewire.rendez-vous-client-component');
    }

}
