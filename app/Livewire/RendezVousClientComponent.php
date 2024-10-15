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

    public function mount(){
        $this->users = User::all();
        $this->dispoDateArr = [];
    }

    public function nextStep()
    {
        if ($this->step < 3) { 
            $this->step++;
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
        

        $weekIndisponibilites = $profesh->indisponibilites()
            ->where('dateHeureFin', '>=', $this->startingWeek)
            ->get();
        

        $rdvArr = Rdv::where('dateHeureDebut', '>=', $this->startingWeek)->get();

        $dateTemp = $this->startingWeek->copy();
        $endWeek = $this->startingWeek->copy()->addDays(6)->setTime(22, 0);



        for ($i=0; $i < 7 ; $i++) { 
            $dateTemp->setTime(7, 0);
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
                    $heureTester = Carbon::parse($dateTemp->format('H:i:s'));
                    if ($heureTester->between($heureDebut, $heureFin) && $heureTester != $heureFin ) {
                        
                        foreach ($weekIndisponibilites as $indispo) {

                            $dateDebut = Carbon::parse($indispo->dateHeureDebut);
                            $dateFin = Carbon::parse($indispo->dateHeureFin);
    
                            #dd("indispo debut: ",$indispo->dateHeureDebut,"indispo fin:",$indispo->dateHeureFin, "dateTemp:",$dateTemp->format('Y-m-d H:i'));
                            #dd($dateDebut, $dateFin, $dateTemp);
                            if ($dateDebut <= $dateTemp && $dateFin > $dateTemp ) {
                                $findIndispo = true;
                                #dd($dateDebut,$dateFin,$dateTemp, $findIndispo);
                                break;
                            }
    
                        }
    
                        foreach ($rdvArr as $rdv){
                            $debut = Carbon::parse($rdv->dateHeureDebut);
                            if ($debut <= $dateTemp && $debut->addMinutes($rdv->service->duree) > $dateTemp) {
    
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
                }
            }
            $dateTemp->modify('+1 day');
        }
        
        dd($this->dispoDateArr);
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
