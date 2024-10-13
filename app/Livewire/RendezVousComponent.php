<?php

namespace App\Livewire;

use App\Models\Rdv;
use Livewire\Component;
use App\Models\Client;
use App\Models\Service;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RendezVousComponent extends Component
{
    public $rdv;
    public $selectedTime;
    public $clientSelected;
    public $clients;
    public $filter;
    public $serviceSelected;
    public $cliniqueSelected;
    public $formattedDate;
    public $formattedDateDebut;
    public $formattedDateFin;
    public $raison;


    protected $listeners = ['createRdvModal' => 'createRdvModal',
                            'timeUpdated' => 'updateTime',
                            'consulterModalRdv' => 'consulterModalRdv'];


    public function mount()
    {
        $this->filter = '';
        $this->selectedTime = null;
        $this->clientSelected = null;
        $this->serviceSelected = null;
        $this->cliniqueSelected = null;
        $this->formattedDate = null;
        $this->formattedDateDebut = null;
        $this->formattedDateFin = null;
        $this->raison = null;

        $this->updatedFilter("");
    }


    public function createRdvModal($selectedTime) {

        $this->resetExcept("clients");
        $this->selectedTime = $selectedTime;

        Carbon::setLocale('fr');
        $this->formattedDate = Carbon::parse($selectedTime);
        
        $this->formattedDate = $this->formattedDate->translatedFormat('l \l\e d F Y \à H:i');

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

        $this->validate([
            'clientSelected' => 'required|exists:clients,id',
            'serviceSelected' => 'required|exists:services,id',
            'cliniqueSelected' => 'required|exists:cliniques,id',
            'raison' => 'nullable|string|max:255',
        ]);

        $dossier = Dossier::whereHas('professionnels', function ($query) {
            $query->where('idProfessionnel', Auth::user()->id);})
            ->where('idClient', $this->clientSelected)
        ->first();


        Rdv::create([
            'dateHeureDebut' => $this->selectedTime,
            'idDossier' => $dossier->id,
            'idService' => $this->serviceSelected,
            'idClinique' => $this->cliniqueSelected,
            'raison' => $this->raison,
        ]);

        $this->reset();

        $this->dispatch('close-modal');

        $this->dispatch('refreshAgenda');

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
        return view('livewire.rendez-vous-component', [
            'services' => $services,
            'cliniques' => $cliniques,
        ]);
    }


    public function consulterModalRdv(Rdv $rdv) {
        $this->resetExcept('clients');
        $this->rdv = $rdv;
        

        #$this->selectedTime = null;
        $this->clientSelected = $rdv->client;
        $this->serviceSelected =  $rdv->service;
        $this->cliniqueSelected = $rdv->clinique;
        $this->raison = $rdv->raison;
        
        Carbon::setLocale('fr');
        $this->formattedDate = Carbon::parse($rdv->dateHeureDebut);
        $this->formattedDate = $this->formattedDate->translatedFormat('l \l\e d F Y');

        $this->formattedDateDebut = Carbon::parse($rdv->dateHeureDebut);
        $this->formattedDateDebut = $this->formattedDateDebut->translatedFormat('H:i');

        $this->formattedDateFin = Carbon::parse($rdv->dateHeureDebut)->addMinutes($rdv->service->duree);
        $this->formattedDateFin = $this->formattedDateFin->translatedFormat('H:i');
    
        $this->dispatch('open-modal', name: 'consulterRdv');
        #dd($this);

    }

    public function annuler()
    {

        #$this->selectedTime = null;
        $this->clientSelected = $this->rdv->client;
        $this->serviceSelected =  $this->rdv->service;
        $this->cliniqueSelected = $this->rdv->clinique;
        $this->raison = $this->rdv->raison;
    }


}
