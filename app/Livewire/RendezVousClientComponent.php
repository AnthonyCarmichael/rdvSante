<?php

namespace App\Livewire;

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
    public $disponibilites;
    public $indisponibilites;
    public $rdvs;

    public function mount(){
        $this->users = User::all();
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
    

    public function rdvClient(){
        dd($this);
    }
    
    public function render()
    {
        return view('livewire.rendez-vous-client-component');
    }

}
