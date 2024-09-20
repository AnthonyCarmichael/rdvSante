<?php

namespace App\Livewire;

use Livewire\Component;

class AjouterClient extends Component
{
    public $clients;

    public function render()
    {
        return view('livewire.ajouter-client');
    }
    public function mount($clients)
    {
        $this->clients = $clients;
    }

}
