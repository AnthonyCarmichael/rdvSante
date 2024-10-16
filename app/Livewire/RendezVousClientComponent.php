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

    public $datesArr;

    public function mount(){
        $this->users = User::all();
        $this->dispoDateArr = [];
    }

    public function nextStep()
    {
        if ($this->step < 3) { 
            $this->step++;
        }
        if ($this->step == 3) { 
            $this->fetchDispoDateArr();
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
        

        $now = Carbon::now();
        if ($now->isSunday())
            $this->startingWeek = $now->copy();
        else
            $this->startingWeek = $now->copy()->modify('last sunday');

        $this->startingWeek->setTime(7, 0);

        $this->datesArr = [];
        for ($i=0; $i < 7; $i++) {
            $date = $this->startingWeek->copy()->addDays($i);
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
            $dateTemp->setTime(7, 0);
            $dateTempEndAvecService = $dateTemp->copy();
            $dateTempEndAvecService->addMinutes($service->duree);
            
            #var_dump($i);
            $goodDay = false;
            foreach ($disponibilites as $dispo) {
                # Vérification si le professionnel à mit disponible cette journée
                if($dateTemp->translatedFormat('l') == strtolower($dispo->jours->nom)){
                    $goodDay = true;
                    $goodDispo = $dispo;
                    break;
                }
            }

            if ($goodDay) {
                # Le professionnel à mit de dispo cette journée
                # Vérification si il y aurait des blocs possible pour un rdv
                for ($j=0; $j < 30 ; $j++) { 
                    $findIndispo = false;
                    $heureDebut = Carbon::parse($goodDispo->heureDebut);
                    $heureFin = Carbon::parse($goodDispo->heureFin);

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

                            $dateDebut = Carbon::parse($indispo->dateHeureDebut);
                            $dateFin = Carbon::parse($indispo->dateHeureFin);
    
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
                                if($i ==1 && $j == 6)
                                    dd($dateTemp,$dateTempEndAvecService,$dateDebut, $dateFin);
                                $findIndispo = true;
                                #dd($dateDebut,$dateFin,$dateTemp, $findIndispo);
                                break;
                            }
    
                        }
    
                        foreach ($rdvArr as $rdv){
                            $debut = Carbon::parse($rdv->dateHeureDebut);
                            $fin = $debut->copy()->addMinutes($rdv->service->duree);

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
                            $this->dispoDateArr[] = $dateTemp->copy();
                            #dd("pas d'indispo ajouter cette date dans le arrDateDispo",$dateTemp);
                        }
                    }
                    $dateTemp->modify('+30 minutes');
                    $dateTempEndAvecService->modify('+30 minutes');
                }
            }
            $dateTemp->modify('+1 day');
        }
        
        #dd($this->dispoDateArr);
        #$rdvs;

        # verification indispo ($indispo->dateHeureDebut <= $selectedDateTime && $indispo->dateHeureFin > $selectedDateTime )
        # verification rdv ($debut <= $selectedDateTime && $debut->addMinutes($rdv->service->duree) > $selectedDateTime)

    }
    

    public function rdvClient(){
        dd($this);
    }
    
    public function render()
    {
        return view('livewire.rendez-vous-client-component');
    }

}
