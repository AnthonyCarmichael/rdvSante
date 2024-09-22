<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Indisponibilite;

class IndisponibiliteComponent extends Component
{
    public $note;
    public $dateHeureDebut;
    public $dateHeureFin;
    public $indisponibilitesArr;

    protected function rules()
    {
        return [
            'note' => 'required|string|max:255',
            'dateHeureDebut' => 'required|date',
            'dateHeureFin' => 'required|date|after:start_date',
        ];
    }

    public function mount()
    {
        $this->indisponibilites = Indisponibilite::all();
        #dd($this->indisponibilites);
    }

    public function createIndisponibilite()
    {
        $this->validate();
        
        Indisponibilite::create([
            'note' => $this->note,
            'dateHeureDebut' => $this->dateHeureDebut,
            'dateHeureFin' => $this->dateHeureFin,
        ]);

        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
        $this->indisponibilitesArr = Indisponibilite::all();
    }

    public function render()
    {
        return view('livewire.indisponibilite',['indisponibilites' => $this->indisponibilites]);
    }
    
}
