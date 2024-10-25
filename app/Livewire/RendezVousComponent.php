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

        $this->reset();
        $this->updatedFilter("");
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
            'actif' => true,
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
        $this->reset();
        $this->updatedFilter("");

        $this->rdv = $rdv;
        

        #$this->selectedTime = null;
        $this->clientSelected = $rdv->client->id;
        $this->serviceSelected =  $rdv->service->id;
        $this->cliniqueSelected = $rdv->clinique->id;
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

    public function modifierRdv()
    {
        $this->validate([
            'clientSelected' => 'required|exists:clients,id',
            'serviceSelected' => 'required|exists:services,id',
            'cliniqueSelected' => 'required|exists:cliniques,id',
            'raison' => 'nullable|string|max:255',
        ],[
            'clientSelected.required' => 'Le client est requis.',
            'clientSelected.exists' => 'Le client sélectionné est invalide.',
            'serviceSelected.required' => 'Le service est requis.',
            'serviceSelected.exists' => 'Le service sélectionné est invalide.',
            'cliniqueSelected.required' => 'La clinique est requise.',
            'cliniqueSelected.exists' => 'La clinique sélectionnée est invalide.',
            'raison.max' => 'La raison ne peut pas dépasser 255 caractères.',
        ]);
        
        $rdv = Rdv::find($this->rdv->id);
        
        if ($rdv) {
            #$rdv->dateHeureDebut = $this->selectedTime;

            $dossier = Dossier::whereHas('professionnels', function ($query) {
                $query->where('idProfessionnel', Auth::user()->id);})
                ->where('idClient', $this->clientSelected)
            ->first();
            $rdv->idDossier = $dossier->id;

            $rdv->idService = $this->serviceSelected;

            $rdv->idClinique = $this->cliniqueSelected;
            $rdv->raison = $this->raison;
            $rdv->actif = true;
            
            $rdv->save();
        }
        else {
            session()->flash('error', 'Rendez-vous non trouvée.');
        }


        $this->reset();
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');
        $this->consulterModalRdv($rdv);

    }

    public function deleteRdv(){
        
        if ($this->rdv->transactions()->exists()) {
            dd(); // As tester et gèrer
        } else {
            $deleted = Rdv::destroy($this->rdv->id);
            $this->resetExcept('clients');
        }
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');

    }


}
