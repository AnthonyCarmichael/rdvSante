<?php

namespace App\Livewire;

use App\Models\FicheClinique;
use App\Models\TypeFiche;
use Livewire\Component;

class FicheCliniqueComponent extends Component
{
    public $dossierClient;
    public $newFiche;
    public $typeFicheId;

    public function mount($dossierClient)
    {
        $this->dossierClient = $dossierClient;
        $this->newFiche = new FicheClinique();

    }

    public function ajouterFiche()
    {
        dd("AjouterFiche",$this);
    }

    public function render()
    {
        $typeFiches = TypeFiche::all();
        return view('livewire.fiche-clinique-component',[
            'typeFiches' =>$typeFiches
        ]);
    }
}
