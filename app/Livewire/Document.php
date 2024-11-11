<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Document extends Component
{
    public $dossiers;

    public $search = '';
    public $sortField = 'nom';
    public $sortDirection = 'asc';
    public $filtreActif = 1;

    public function mount() {
        $this->filtreDossier();

        $this->dossiers = Auth::user()->dossiers();
    }

    public function resetFilters() {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function filtreDossier()
    {
        if ($this->filtreActif == 1) {
            $this->dossiers = Auth::user()->dossiers()->where('actif', true)->get();
        }
        elseif ($this->filtreActif == 0) {
            $this->dossiers = Auth::user()->dossiers()->where('actif', false)->get();
        }
        elseif ($this->filtreActif == 2) {
            $this->dossiers = Auth::user()->dossiers()->get();
        }
    }

    public function updatedSearch()
    {
        if ($this->filtreActif == 1)
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('dateCreation', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%');
                    });
            })
            ->where('actif', true)  #client doit etre actif
            ->orderBy($this->sortField, $this->sortDirection);


            $this->dossiers = $query->get();
        }
        elseif ($this->filtreActif == 0)
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('dateCreation', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%');
                    });
            })
            ->where('actif', false)
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
        else
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('dateCreation', 'like', '%' . $this->search . '%')
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

    public function render()
    {
        return view('livewire.document');
    }
}
