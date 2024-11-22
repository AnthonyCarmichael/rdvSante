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
    public $checkboxpause = false;
    public $checkboxrdv = false;
    public $tempsavantrdv;
    public $personneacharge = false;
    public $montantPenalite;

    public $users;
    public $service_id;

    public $search = '';
    public $sortField = 'nom';
    public $sortDirection = 'asc';
    public $filtreActif = 1;

    public $searchQuery;

    public function mount()
    {
        $this->filtreService();

        $this->professions = Auth::user()->professions;
    }

    public function openModalAjouterService()
    {
        $this->resetExcept('services', 'professions');
        $this->dispatch('open-modal', name: 'ajouterService');
    }

    public function loadServices()
    {
        if ($this->filtreActif == 1) {
            return Service::where('idProfessionnel', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('prix', 'like', '%' . $this->search . '%')
                        ->orWhere('duree', 'like', '%' . $this->search . '%')
                        ->orWhere('montantPenalite', 'like', '%' . $this->search . '%');
                })
                ->where('actif', true)
                ->orderBy($this->sortField, $this->sortDirection)
                ->get();
        } elseif ($this->filtreActif == 0) {
            return Service::where('idProfessionnel', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('prix', 'like', '%' . $this->search . '%')
                        ->orWhere('duree', 'like', '%' . $this->search . '%')
                        ->orWhere('montantPenalite', 'like', '%' . $this->search . '%');
                })
                ->where('actif', false)
                ->orderBy($this->sortField, $this->sortDirection)
                ->get();
        } else {
            return Service::where('idProfessionnel', Auth::user()->id)
                ->where(function ($query) {
                    $query->where('nom', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhere('prix', 'like', '%' . $this->search . '%')
                        ->orWhere('duree', 'like', '%' . $this->search . '%')
                        ->orWhere('montantPenalite', 'like', '%' . $this->search . '%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->get();
        }
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
        $this->montantPenalite = $service->montantPenalite;

        $this->dispatch('open-modal', name: 'consulterService');
    }

    public function resetFilters()
    {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function rules()
    {
        $rules = [
            'nomservice' => 'required|string|max:255',
            'professionservice' => 'required|exists:professions,id',
            'descriptionservice' => 'nullable|string',
            'prixservice' => 'required|numeric|min:0',
            'dureeservice' => 'nullable|integer|min:1',
            'taxableservice' => 'nullable|boolean',
            'checkboxrdv' => 'nullable|boolean',
            'personneacharge' => 'nullable|boolean',
            'montantPenalite' => 'required|numeric|min:0'
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

        if (Auth::user()->cleStripe != null) {
            $stripe = new \Stripe\StripeClient(Auth::user()->cleStripe);

            if ($this->descriptionservice == null) {
                $produitStripe = $stripe->products->create(['name' => $this->nomservice]);
            } else {
                $produitStripe = $stripe->products->create(['name' => $this->nomservice, 'description' => $this->descriptionservice]);
            }
            $prixStripe = $stripe->prices->create([
                'currency' => 'cad',
                'custom_unit_amount' => ["enabled" => true],
                'product' => $produitStripe->id,
            ]);
        }



        Service::create([
            'nom' => $this->nomservice,
            'description' => $this->descriptionservice,
            'duree' => $this->dureeservice,
            'prix' => $this->prixservice,
            'taxable' => $this->taxableservice,
            'minutePause' => $this->dureepause,
            'nombreHeureLimiteReservation' => $this->tempsavantrdv,
            'droitPersonneACharge' => $this->personneacharge,
            'montantPenalite' => $this->montantPenalite,
            'actif' => true,
            'idProfessionService' => $this->professionservice,
            'idProfessionnel' => Auth::user()->id,
            'prixStripe' => $prixStripe->id,
            'produitStripe' => $produitStripe->id,

        ]);
        $this->filtreService();

        $this->resetExcept('services', 'professions');
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
        $this->montantPenalite = $service->montantPenalite;

        $this->dispatch('open-modal', name: 'modifierService');
    }

    public function desactiverService($id)
    {
        $service = Service::findOrFail($id);

        if ($service) {
            $service->update([
                'actif' => false,
            ]);

            $this->resetExcept('services', 'professions');

            $this->filtreService();
        }
    }

    public function activerService($id)
    {
        $service = Service::findOrFail($id);

        if ($service) {
            $service->update([
                'actif' => true,
            ]);

            $this->resetExcept('services', 'professions');

            $this->filtreService();
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
            Service::find($this->serviceIdToDelete)->delete();
            ;
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

        $stripe = new \Stripe\StripeClient('sk_test_51QLRk0G8MNDQfBDwRqTNqHUZSEmqRHPJJwWOb90PfAnEVd6Vrr3S857Z3boV4kv0ZBdwQHQEbFuRw1IbRyIiYUDa005h9SywCD');
        $produitStripe = $stripe->products->update($service->produitStripe, ['name' => $this->nomservice, 'description' => $this->descriptionservice]);
        $paiement = $stripe->paymentIntents->retrieve('pi_3QMKeBG8MNDQfBDw16XsYDWa');
        dd($paiement->amount);

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
                'montantPenalite' => $this->montantPenalite,
                'idProfessionService' => $this->professionservice,
                'idProfessionnel' => Auth::user()->id,
                'produitStripe' => $produitStripe->id,
            ]);

            $this->resetExcept('services', 'professions');

            $this->filtreService();

            $this->dispatch('close-modal');
        }
    }

    public function filtreService()
    {
        if ($this->filtreActif == 1)
            $this->services = Service::where('idProfessionnel', Auth::user()->id)->where('actif', true)->get();
        elseif ($this->filtreActif == 0)
            $this->services = Service::where('idProfessionnel', Auth::user()->id)->where('actif', false)->get();
        else
            $this->services = Service::where('idProfessionnel', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.ajouter-service');
    }
}
