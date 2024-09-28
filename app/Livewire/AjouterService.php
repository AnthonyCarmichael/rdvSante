<?php

namespace App\Livewire;

use App\Models\CategorieService;
use App\Models\Service;
use Livewire\Component;

class AjouterService extends Component
{
    public $services;
    public $categories;

    public $nomservice;
    public $categorieservice;
    public $descriptionservice;
    public $dureeservice;
    public $prixservice;
    public $taxableservice = false;
    public $dureepause;
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
        $this->categories = CategorieService::all();
        #dd($this->services);
    }

    public function loadServices()
    {
        return Service::where('idProfessionnel', 1)
            ->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('prix', 'like', '%' . $this->search . '%')
                    ->orWhere('minutePause', 'like', '%' . $this->search . '%');
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

    public function resetFilters()
    {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function ajouterService()
    {
        $validatedData = $this->validate([
            'nomservice' => 'required|string|max:255',
            'categorieservice' => 'required|exists:categorie_services,id',
            'descriptionservice' => 'nullable|string',
            'prixservice' => 'required|numeric|min:0',
            'taxableservice' => 'nullable|boolean',
            'dureepause' => 'nullable|integer|min:0',
            'rdvderniereminute' => 'nullable|boolean',
            'tempsavantrdv' => 'nullable|integer|min:0',
            'personneacharge' => 'nullable|boolean',
        ]);

        Service::create([
            'nom' => $validatedData['nomservice'],
            'description' => $validatedData['descriptionservice'],
            'prix' => $validatedData['prixservice'],
            'taxable' => $validatedData['taxableservice'] ?? false,
            'minutePause' => $validatedData['dureepause'] ?? 0,
            'nombreHeureLimiteReservation' => $validatedData['tempsavantrdv'] ?? 0,
            'droitPersonneACharge' => $validatedData['personneacharge'] ?? false,
            'actif' => true, #Désactivaion du service possible?
            'idCategorieService' => $validatedData['categorieservice'],
            'idProfessionnel' => 1, #idProffessionnel à modifier doit être celui de l'utilisateur présentement connecté
        ]);

        $this->services = Service::where('idProfessionnel', 1)->get(); #idProffessionnel à modifier doit être celui de l'utilisateur présentement connecté

        $this->resetExcept('services','categories');
        $this->dispatch('close-modal');
    }

    public function modifierService($id)
    {
        $service = Service::findOrFail($id);
        $this->service_id = $service->id;
        $this->nomservice = $service->nom;
        $this->categorieservice = $service->idCategorieService;
        $this->descriptionservice = $service->description;
        $this->dureeservice = $service->dureeservice;
        $this->prixservice = $service->prix;
        $this->taxableservice = $service->taxable;
        $this->dureepause = $service->minutePause;
        $this->rdvderniereminute = $service->nombreHeureLimiteReservation > 0;
        $this->tempsavantrdv = $service->nombreHeureLimiteReservation;
        $this->personneacharge = $service->droitPersonneACharge;

        $this->dispatch('open-modal', name: 'modifierService');
    }

    public function updateService()
    {
        $validatedData = $this->validate([
            'nomservice' => 'required|string|max:255',
            'categorieservice' => 'required|exists:categorie_services,id',
            'descriptionservice' => 'nullable|string',
            'prixservice' => 'required|numeric|min:0',
            'taxableservice' => 'nullable|boolean',
            'dureepause' => 'nullable|integer|min:0',
            'rdvderniereminute' => 'nullable|boolean',
            'tempsavantrdv' => 'nullable|integer|min:0',
            'personneacharge' => 'nullable|boolean',
        ]);

        $service = Service::find($this->service_id);

        if ($service) {
            $service->update([
                'nom' => $validatedData['nomservice'],
                'description' => $validatedData['descriptionservice'],
                'prix' => $validatedData['prixservice'],
                'taxable' => $validatedData['taxableservice'] ?? false,
                'minutePause' => $validatedData['dureepause'] ?? 0,
                'nombreHeureLimiteReservation' => $validatedData['tempsavantrdv'] ?? 0,
                'droitPersonneACharge' => $validatedData['personneacharge'] ?? false,
                'actif' => true,
                'idCategorieService' => $validatedData['categorieservice'],
                'idProfessionnel' => 1,
            ]);

            $this->resetExcept('services', 'categories');
            $this->dispatch('close-modal');
        }
    }

    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
