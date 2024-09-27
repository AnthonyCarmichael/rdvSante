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


    public $action;
    public $users;

    public function mount()
    {
        $this->services = Service::where('idProfessionnel', 1)->get();
        $this->categories = CategorieService::all();
        #dd($this->services);
    }

    public function ajouterService()
    {
        $validatedData = $this->validate([
            'nomservice' => 'required|string|max:255',
            'categorieservice' => 'required|exists:categorie_services,id',
            'descriptionservice' => 'nullable|string',
            'dureeservice' => 'required|integer',
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

    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
