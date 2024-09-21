<?php

namespace App\Livewire;

use Livewire\Component;

class AjouterClient extends Component
{
    public $clients;
    public $genres;
    public $villes;
    public $action;

    public function render()
    {
        return view('livewire.ajouter-client');
    }
    public function mount($clients, $genres, $villes)
    {
        $this->clients = $clients;

        $this->genres = $genres;

        $this->villes = $villes;
    }

    public function ajouterClient()
    {
        $this->action = 'Ajouter';
    }
}
