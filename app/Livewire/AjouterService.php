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

    public $serviceIdToDelete;
    public $showDeleteModal;

    public $nomservice;
    public $professionservice;
    public $descriptionservice;
    public $dureeservice;
    public $prixservice;
    public $taxableservice;
    public $dureepause;
    public $checkboxpause;
    public $checkboxrdv;
    public $tempsavantrdv;
    public $personneacharge;

    public $users;
    public $service_id;

    public $search;
    public $sortField;
    public $sortDirection;

    public $searchQuery;

    public function mount()
    {
        $this->search = '';
        $this->sortField = 'nom';
        $this->sortDirection = 'asc';

        $this->taxableservice = false;
        $this->checkboxpause = false;
        $this->checkboxrdv = false;
        $this->personneacharge = false;

        $this->services = Service::where('idProfessionnel', Auth::user()->id)->get();
        $this->professions = Profession::all();
        $this->updatedSearch("");
        #dd($this->professions);
    }

    public function openModalAjouterService()
    {
        $this->resetExcept('services','professions');
        $this->dispatch('open-modal', name : 'ajouterService');
    }

    public function updatedSearch($value)
    {
        $query = Service::where('idProfessionnel', Auth::user()->id)
            ->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('prix', 'like', '%' . $this->search . '%')
                    ->orWhere('duree', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $this->services = $query->get();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->services = $this->updatedSearch($this->search);
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
        $this->checkboxrdv = $service->nombreHeureLimiteReservation > 0;
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
            'dureeservice' => 'nullable|integer|min:1',
            'taxableservice' => 'nullable|boolean',
            'checkboxrdv' => 'nullable|boolean',
            'personneacharge' => 'nullable|boolean'
        ];

        if ($this->checkboxpause)
            $rules['dureepause'] = 'required|integer|min:1';
        else
            $this->dureepause = 0;

        if ($this->checkboxrdv)
            $rules['tempsavantrdv'] = 'required|integer|min:1';
        else
            $this->tempsavantrdv = 0;

        return $rules;
    }

    public function ajouterService()
    {
        $this->validate();

        Service::create([
            'nom' => $this->nomservice,
            'description' => $this->descriptionservice,
            'duree' => $this->dureeservice,
            'prix' => $this->prixservice,
            'taxable' => $this->taxableservice,
            'minutePause' => $this->dureepause,
            'nombreHeureLimiteReservation' => $this->tempsavantrdv,
            'droitPersonneACharge' => $this->personneacharge,
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
        $this->taxableservice = $service->taxable == 1;
        $this->dureepause = $service->minutePause;
        $this->checkboxpause = $service->minutePause > 0;
        $this->checkboxrdv = $service->nombreHeureLimiteReservation > 0;
        $this->tempsavantrdv = $service->nombreHeureLimiteReservation;
        $this->personneacharge = $service->droitPersonneACharge == 1;

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
                'duree' => $this->dureeservice,
                'prix' => $this->prixservice,
                'taxable' => $this->taxableservice,
                'minutePause' => $this->dureepause,
                'nombreHeureLimiteReservation' => $this->tempsavantrdv,
                'droitPersonneACharge' => $this->personneacharge,
                'actif' => true,
                'idProfessionService' => $this->professionservice,
                'idProfessionnel' => Auth::user()->id,
            ]);

            $this->resetExcept('services', 'professions');
            $this->services = Service::where('idProfessionnel', Auth::user()->id)->get();
            $this->dispatch('close-modal');
        }
    }

    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
