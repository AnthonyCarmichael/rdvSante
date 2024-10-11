<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Service;
use App\Models\Clinique;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RendezVous extends Component
{
    public $rdv;
    public $selectedTime;
    public $clientSelected;
    public $filter;
    public $serviceSelected;
    public $cliniqueSelected;
    public $raison;

    protected $listeners = ['createRdvModal' => 'createRdvModal',
                            'timeUpdated' => 'updateTime'];


    public function mount()
    {
        $this->filter = '';
        $this->selectedTime = null;
        $this->clientSelected = null;
        $this->serviceSelected = null;
        $this->cliniqueSelected = null;
        $this->raison = '';
    }


    public function createRdvModal($selectedTime) {
        $this->resetExcept('clients');
        Carbon::setLocale('fr');
        $this->selectedTime = Carbon::parse($selectedTime);
        
        $this->selectedTime = $this->selectedTime->translatedFormat('l \l\e d F Y');
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
        dd($this);
        /*
            $this->validate([
                'clientSelected' => 'required|exists:clients,id',
                'serviceSelected' => 'required|exists:services,id',
                'cliniqueSelected' => 'required|exists:cliniques,id',
                'raison' => 'nullable|string|max:255',
            ]);

            RendezVous::create([
                'client_id' => $this->clientSelected,
                'service_id' => $this->serviceSelected,
                'clinique_id' => $this->cliniqueSelected,
                'date_heure' => $this->selectedTime,
                'raison' => $this->raison,
            ]);

            $this->reset(['clientSelected', 'serviceSelected', 'cliniqueSelected', 'raison']);

            $this->dispatch('close-modal');

            $this->dispatch('refreshAgenda');

        */
    }

    public function fetchServices() {
        $services = Service::where('idProfessionnel',Auth::user()->id )->
                                    orderBy('nom')->get();
        return $services;
    }

    public function render()
    {
        $clients = Client::where('actif', '1')
            ->orderBy('prenom')
            ->get();
        $cliniques = Auth::user()->cliniques;
        #dd($cliniques);
        $services = $this->fetchServices();
        return view('livewire.rendez-vous', [
            'services' => $services,
            'cliniques' => $cliniques,
            'clients' => $clients
        ]);
    }
}
