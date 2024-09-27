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
    public $pauserdv = false;
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
            'categorieservice' => 'required|exists:categorie_services,id', // Valider l'existence de la catégorie
            'descriptionservice' => 'nullable|string',
            'dureeservice' => 'required|integer',
            'prixservice' => 'required|numeric|min:0',
            'taxableservice' => 'nullable|boolean',
            'pauserdv' => 'nullable|boolean',
            'dureepause' => 'nullable|integer|min:0',
            'rdvderniereminute' => 'nullable|boolean',
            'tempsavantrdv' => 'nullable|integer|min:0',
            'personneacharge' => 'nullable|boolean',
        ]);

        // Création du service
        Service::create([
            'nom' => $validatedData['nomservice'],
            'description' => $validatedData['descriptionservice'],
            'prix' => $validatedData['prixservice'],
            'taxable' => $validatedData['taxableservice'] ?? false, // Assurer une valeur booléenne
            'minutePause' => $validatedData['dureepause'] ?? 0,
            'nombreHeureLimiteReservation' => $validatedData['tempsavantrdv'] ?? 0,
            'droitPersonneACharge' => $validatedData['personneacharge'] ?? false,
            'actif' => true, // Par défaut, on suppose que le service est actif
            'idCategorieService' => $validatedData['categorieservice'],
            'idProfessionnel' => 1, // Remplace avec l'ID de l'utilisateur connecté
        ]);

        // Rafraîchir les services après l'ajout
        $this->services = Service::where('idProfessionnel', 1)->get();

        // Fermer le modal
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
