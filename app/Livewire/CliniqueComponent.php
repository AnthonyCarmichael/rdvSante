<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Clinique;
use Illuminate\Support\Facades\Auth;


class CliniqueComponent extends Component
{

    public $cliniques;
    public $foundCliniques;

    public $search;
    public $sortField;
    public $sortDirection;

    public $searchQuery;

    public function mount() {
        $this->search = '';
        $this->sortField = 'nom';
        $this->sortDirection = 'asc';

        $this->cliniques = Auth::user()->cliniques;
        $this->updatedSearch("");
        #dd($this->cliniques );
    }

    public function updatedSearch($value){
        $this->loadCliniques($value);
    }

    public function resetFilters()
    {

        $this->reset('sortDirection');
    }

    public function loadCliniques($nomRecherche)
    {
        $this->foundCliniques = Clinique::with(['ville.province.pays'])
            ->where(function($query) {
                $query->where('cliniques.nom', 'like', '%' . $this->search . '%')
                    ->orWhere('cliniques.rue', 'like', '%' . $this->search . '%')
                    ->orWhere('cliniques.nocivique', 'like', '%' . $this->search . '%')
                    ->orWhere('cliniques.codePostal', 'like', '%' . $this->search . '%')
                    ->orWhereHas('ville', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('ville.province', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('ville.province.pays', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    });
        });

        if ($this->sortField === 'ville')
        {
            $this->foundCliniques = $this->foundCliniques->join('villes', 'cliniques.idVille', '=', 'villes.id')
                                ->orderBy('villes.nom', $this->sortDirection)
                                ->get();
        }
        elseif ($this->sortField === 'province')
        {
            $this->foundCliniques = $this->foundCliniques->join('villes', 'cliniques.idVille', '=', 'villes.id')
                                ->join('provinces', 'villes.idProvince', '=', 'provinces.id')
                                ->orderBy('provinces.nom', $this->sortDirection)
                                ->get();
        }
        elseif ($this->sortField === 'pays')
        {
            $this->foundCliniques = $this->foundCliniques->join('villes', 'cliniques.idVille', '=', 'villes.id')
                                ->join('provinces', 'villes.idProvince', '=', 'provinces.id')
                                ->join('pays', 'provinces.idPays', '=', 'pays.id')
                                ->orderBy('pays.nom', $this->sortDirection)
                                ->get();
        }
        else
        {
            $this->foundCliniques = $this->foundCliniques->orderBy($this->sortField, $this->sortDirection)->get();
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->cliniques = $this->loadCliniques($this->search);
    }

    public function render()
    {
        return view('livewire.clinique-component');
    }
}
