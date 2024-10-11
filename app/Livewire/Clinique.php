<?php

namespace App\Livewire;

use Livewire\Component;

class Clinique extends Component
{
    public $cliniques;

    public $search = '';
    public $sortField = 'nom';
    public $sortDirection = 'asc';

    public $searchQuery;

    public function searchCliniques()
    {
        $this->searchQuery = $this->search;
    }

    public function resetFilters()
    {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function loadServices()
    {
        return Clinique::where('idProfessionnel', 1)
            ->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('prix', 'like', '%' . $this->search . '%')
                    ->orWhere('duree', 'like', '%' . $this->search . '%');
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

        $this->cliniques = $this->loadCliniques();
    }

    public function render()
    {
        return view('livewire.clinique');
    }
}
