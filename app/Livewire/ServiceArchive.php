<?php

namespace App\Livewire;

use App\Models\Profession;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ServiceArchive extends Component
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
    public $checkboxpause = false;
    public $checkboxrdv = false;
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
        $this->services = Service::where('idProfessionnel', Auth::user()->id)
                                    ->where('actif', false)->get();
        $this->professions = Profession::all();
        #dd($this->professions);
    }

    public function loadServices()
    {
        return Service::where('idProfessionnel', Auth::user()->id)
            ->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('prix', 'like', '%' . $this->search . '%')
                    ->orWhere('duree', 'like', '%' . $this->search . '%');
            })
            ->where('actif', true)
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

    public function consulterService($id) {
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

    public function activerService($id){
        $service = Service::findOrFail($id);

        if ($service) {
            $service->update([
                'actif' => true,
            ]);

            $this->resetExcept('services', 'professions');
            $this->services = Service::where('idProfessionnel', Auth::user()->id)->where('actif', false)->get();
        }

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

    public function render()
    {
        return view('livewire.service-archive');
    }
}
