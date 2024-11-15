<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Dossier as ModelsDossier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dossier extends Component
{
    public $dossiers;
    public $dossier;
    public $fiches;
    public $client;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $view = null;
    public $filtreActif = 1;

    public function mount($dossierClient = null) {
        $this->filtreDossier();

        /*$this->dossiers = Auth::user()->dossiers()->get();

        foreach ($this->dossiers as $d) {
            dd($d);
        }*/
        if ($dossierClient) {
            $this->dossier = ModelsDossier::findOrFail($dossierClient->id);

            $this->client = $this->dossier->client;

            $this->view = "Fiches";
            $this->fiches = $this->dossier->fichesCliniques;
        }
    }

    public function consulterDossier($id) {
        $this->dossier = ModelsDossier::findOrFail($id);

        $this->client = $this->dossier->client;

        $this->view = "Fiches";
        $this->fiches = $this->dossier->fichesCliniques;
    }

    public function resetFilters() {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function filtreDossier()
    {
        if ($this->filtreActif == 1) {
            $this->dossiers = Auth::user()->dossiers;   #->where('actif', true)->get();
        }
        elseif ($this->filtreActif == 0) {
            $this->dossiers = Auth::user()->dossiers;   #->where('actif', false)->get();
        }
        elseif ($this->filtreActif == 2) {
            $this->dossiers = Auth::user()->dossiers;
        }
    }

    public function updatedSearch()
    {
        if ($this->filtreActif == 1)
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('idDossier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%')
                                ->where('actif', true);
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
        elseif ($this->filtreActif == 0)
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('idDossier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%')
                                ->where('actif', false);
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
        else
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('idDossier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->dossiers = $this->updatedSearch();
    }

    public function setView($view) {
        $this->view = $view;
        if ($this->view == "Fiches")
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
        elseif ($this->view == "Images")
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
        else
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
    }


    public function redirectAjouterFiche() {
        return redirect()->route('ficheClinique',$this->dossier);
    }

    public function consulterFiche($idFiche) {
        #dd("consulter fiche",$idFiche);
        return redirect()->route('ficheCliniqueConsulter',$idFiche);
    }

    public function redirectModifierFiche($idFiche) {
        dd("modifier fiche",$idFiche);
        //return redirect()->route('ficheClinique',$this->dossier);
    }

    public function supprimerFiche($idFiche) {
        dd("supprimer fiche",$idFiche);
        //return redirect()->route('ficheClinique',$this->dossier);
    }

    public function render()
    {
        return view('livewire.dossier');
    }
}
