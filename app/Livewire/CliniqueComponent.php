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

    # À vérifier
    public function searchCliniques()
    {
        $this->searchQuery = $this->search;
    }

    public function resetFilters()
    {

        $this->reset('sortDirection');
    }

    public function loadCliniques($nomRecherche)
    {
        $this->foundCliniques = Clinique::where(function($query) {
                                $query->where('nom', 'like', '%' . $this->search . '%')
                                    ->orWhere('rue', 'like', '%' . $this->search . '%')
                                    ->orWhere('nocivique', 'like', '%' . $this->search . '%')
                                    ->orWhere('codePostal', 'like', '%' . $this->search . '%');
                            })
                            ->orderBy($this->sortField, $this->sortDirection)
                            ->get();
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
