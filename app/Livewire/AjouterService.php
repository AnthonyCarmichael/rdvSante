<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class AjouterService extends Component
{

    public $services;
    public $categories;
    public $users;
    public $action;

    public function mount()
    {
        $this->services = Service::where('idProfessionnel', 1)->get();
        #dd($this->services);
    }

    public function ajouterService()
    {
        $this->action = 'Ajouter';
    }
    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
