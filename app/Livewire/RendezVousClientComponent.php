<?php

namespace App\Livewire;

use Livewire\Component;

class RendezVousClientComponent extends Component
{
    public $step = 0; 
    
    public function render()
    {
        return view('livewire.rendez-vous-client-component');
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

    public function rdvClient(){
        dd();
    }
}
