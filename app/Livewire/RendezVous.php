<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Service;
use App\Models\Clinique;
use Illuminate\Support\Facades\Auth;

class RendezVous extends Component
{
    public $user;
    public $rdv;
    public $selectedTime;
    public $clients;
    public $filter;
    public $service;

    protected $listeners = ['createRdvModal' => 'createRdvModal',
                            'timeUpdated' => 'updateTime'];


    public function mount()
    {
        
        $this->user = Auth::user();
        $this->clients = Client::where('actif', '1')->
                                    orderBy('prenom')->get();
    }


    public function createRdvModal($selectedTime) {
        $this->resetExcept('clients');
        $this->selectedTime = $selectedTime;
        $this->dispatch('open-modal', name: 'ajouterRdv');
    }

    // Pour le filtre de recherche. Cette méthode est appelé à chaque fois que filter change. On peut costume la méthode pour par l'adapter aux besoins
    public function updatedFilter($value)
    {

        $this->clients = Client::where(function ($query) {
            $query->where('actif', '1')
                ->where('nom', 'like', '%' . $this->filter . '%');
            })->orWhere(function($query) {
                $query->where('actif', '1')
                    ->where('prenom', 'like', '%' . $this->filter . '%');
            })->
            orderBy('prenom')->get();
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

    public function fetchServices() {
        $services = Service::where('idProfessionnel',Auth::user()->id )->
                                    orderBy('nom')->get();
        return $services;
    }

    public function fetchCliniques() {

        dd($this->user->cliniques());

        $cliniques = Clinique::where('idProfessionnel',Auth::user()->id )->
                                    orderBy('nom')->get();
        return $cliniques;
    }


    public function render()
    {
        $services = $this->fetchServices();
        return view('livewire.rendez-vous',compact('services'));
    }
}
