<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;

class RendezVous extends Component
{
    public $rdv;
    public $selectedTime;
    public $clients;

    protected $listeners = ['createRdvModal' => 'createRdvModal',
                            'timeUpdated' => 'updateTime'];


    public function mount()
    {
        $this->clients = Client::all();
    }


    public function createRdvModal($selectedTime) {
        $this->reset();
        $this->selectedTime = $selectedTime;
        $this->dispatch('open-modal', name: 'ajouterRdv');
    }

    public function createRdv()
    {
        dd();
        /*

        $this->dateHeureDebut = $this->selectedTime;
        
        $this->validate([
            'note' => 'required|string',
            'dateHeureDebut' => 'required|date',
            'dateHeureFin' => 'required|date|after:dateHeureDebut',
        ]);
        

        Indisponibilite::create([
            'note' => $this->note,
            'dateHeureDebut' => $this->dateHeureDebut,
            'dateHeureFin' => $this->dateHeureFin,
            'idProfessionnel' =>  Auth::user()->id, # A changer!!
        ]);

        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');
        $this->dispatch('refreshAgenda');
        
        */
    }


    public function render()
    {
        return view('livewire.rendez-vous');
    }
}
