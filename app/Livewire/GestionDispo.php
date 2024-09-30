<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Disponibilite;
use App\Models\Jour;

class GestionDispo extends Component
{
    public $dispo;
    public $jour;
    public function render()
    {
        return view('livewire.gestion-dispo');
    }

    public function mount(){
        $this->dispo = Disponibilite::orderBy('heureDebut', 'asc')->get();
        $this->jour = Jour::all();
    }
}
