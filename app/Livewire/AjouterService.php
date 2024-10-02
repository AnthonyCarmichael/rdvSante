<?php

namespace App\Livewire;

use App\Models\Profession;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AjouterService extends Component
{
    public $services;
    public $professions;

    public $serviceIdToDelete = null;
    public $showDeleteModal = false;

    public $nomservice;
    public $professionservice;
    public $descriptionservice;
    public $dureeservice;
    public $prixservice;
    public $taxableservice = false;
    public $dureepause;
    public $checkboxpause =false;
    public $checkboxrdv =false;
    public $rdvderniereminute = false;
    public $tempsavantrdv;
    public $personneacharge = false;

    public $users;
    public $service_id;

    public $search = '';
    public $sortField = 'nom';
    public $sortDirection = 'asc';

    public $searchQuery;

    public function mount()
    {
        $this->services = Service::where('idProfessionnel', 1)->get();
        $this->professions = Profession::all();
        #dd($this->professions);
    }

    public function refreshTable()
    {
        $this->services = Service::where('idProfessionnel', 1)->get();
    }

    public function openModalAjouterService()
    {
        $this->resetExcept('services','professions');
        $this->dispatch('open-modal', name : 'ajouterService');
    }

    public function loadServices()
    {
        return Service::where('idProfessionnel', 1)
            ->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('prix', 'like', '%' . $this->search . '%')
                    ->orWhere('duree', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();
    }

    public function searchServices()
    {
        $this->searchQuery = $this->search;
    }

    public function updatedSearch()
    {
        $this->services = $this->loadServices();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->services = $this->loadServices();
    }

    public function getInfoService($id)
    {
        $service = Service::findOrFail($id);
        $this->service_id = $service->id;
        $this->nomservice = $service->nom;
        $this->professionservice = $service->idProfessionService;
        $this->descriptionservice = $service->description;
        $this->dureeservice = $service->duree;
        $this->prixservice = $service->prix;
        $this->taxableservice = $service->taxable;
        $this->dureepause = $service->minutePause;
        $this->rdvderniereminute = $service->nombreHeureLimiteReservation > 0;
        $this->tempsavantrdv = $service->nombreHeureLimiteReservation;
        $this->personneacharge = $service->droitPersonneACharge;

        $this->dispatch('open-modal', name: 'modifierService');
    }

    public function consulterService($id)
    {
        $service = Service::findOrFail($id);
        $this->service_id = $service->id;
        $this->nomservice = $service->nom;
        $this->professionservice = $service->idProfessionService;
        $this->descriptionservice = $service->description;
        $this->dureeservice = $service->duree;
        $this->prixservice = $service->prix;
        $this->taxableservice = $service->taxable;
        $this->dureepause = $service->minutePause;
        $this->rdvderniereminute = $service->nombreHeureLimiteReservation > 0;
        $this->tempsavantrdv = $service->nombreHeureLimiteReservation;
        $this->personneacharge = $service->droitPersonneACharge;

        $this->dispatch('open-modal', name: 'consulterService');
    }

    public function resetFilters()
    {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function rules()
    {
        $rules=['nomservice' => 'required|string|max:255',
            'professionservice' => 'required|exists:professions,id',
            'descriptionservice' => 'nullable|string',
            'prixservice' => 'required|numeric|min:0',
            'dureeservice' => 'nullable|integer|min:0',
            'taxableservice' => 'nullable|boolean',
            'dureepause' => 'nullable|integer|min:0',
            'rdvderniereminute' => 'nullable|boolean',
            'tempsavantrdv' => 'nullable|integer|min:0',
            'personneacharge' => 'nullable|boolean'
        ];

        if ($this->checkboxpause) {
            $rules['dureepause'] = 'required|integer|min:0';
        }

        return $rules;
    }

    public function ajouterService()
    {
        $this->validate();

        Service::create([
            'nom' => $this->nomservice,
            'description' => $this->descriptionservice,
            'duree' => $this->dureeservice ?? 0,
            'prix' => $this->prixservice,
            'taxable' => $this->taxableservice ?? false,
            'minutePause' => $this->dureepause ?? 0,
            'nombreHeureLimiteReservation' => $this->tempsavantrdv ?? 0,
            'droitPersonneACharge' => $this->personneacharge ?? false,
            'actif' => true, #Désactivaion du service possible?
            'idProfessionService' => $this->professionservice,
            'idProfessionnel' => Auth::user()->id,
        ]);

        $this->services = Service::where('idProfessionnel', Auth::user()->id)->get();

        $this->resetExcept('services','professions');
        $this->dispatch('close-modal');
    }

    public function modifierService($id)
    {
        $service = Service::findOrFail($id);
        $this->service_id = $service->id;
        $this->nomservice = $service->nom;
        $this->professionservice = $service->idProfessionService;
        $this->descriptionservice = $service->description;
        $this->dureeservice = $service->duree;
        $this->prixservice = $service->prix;
        $this->taxableservice = $service->taxable;
        $this->dureepause = $service->minutePause;
        $this->rdvderniereminute = $service->nombreHeureLimiteReservation > 0;
        $this->tempsavantrdv = $service->nombreHeureLimiteReservation;
        $this->personneacharge = $service->droitPersonneACharge;

        $this->dispatch('open-modal', name: 'modifierService');
    }

    public function confirmDelete($id)
    {
        $this->serviceIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteService()
    {
        if ($this->serviceIdToDelete) {
            Service::find($this->serviceIdToDelete)->delete();;
        }

        $this->mount();
        $this->reset('serviceIdToDelete', 'showDeleteModal');
    }

    public function cancelDelete()
    {
        $this->reset('serviceIdToDelete', 'showDeleteModal');
    }

    public function updateService()
    {
        $this->validate();

        $service = Service::find($this->service_id);

        if ($service) {
            $service->update([
                'nom' => $this->nomservice,
                'description' => $this->descriptionservice,
                'duree' => $this->dureeservice ?? 0,
                'prix' => $this->prixservice,
                'taxable' => $this->taxableservice ?? false,
                'minutePause' => $this->dureepause ?? 0,
                'nombreHeureLimiteReservation' => $this->tempsavantrdv ?? 0,
                'droitPersonneACharge' => $this->personneacharge ?? false,
                'actif' => true,
                'idProfessionService' => $this->professionservice,
                'idProfessionnel' => 1,
            ]);

            $this->resetExcept('services', 'professions');
            $this->refreshTable();
            $this->dispatch('close-modal');
        }
    }

    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
