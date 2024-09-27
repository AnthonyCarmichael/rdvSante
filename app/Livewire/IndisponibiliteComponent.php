<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Indisponibilite;

class IndisponibiliteComponent extends Component
{
    public $note;
    public $dateHeureDebut;
    public $dateHeureFin;
    public $selectedTime;

    protected $listeners = ['timeUpdated' => 'updateTime'];

    public function updateTime($newTime)
    {
        $this->selectedTime = $newTime['time'];
    }

    protected function rules()
    {
        return [
            'note' => 'required|string|max:255',
            'dateHeureDebut' => 'required|date',
            'dateHeureFin' => 'required|date|after:dateHeureDebut',
        ];
    }

    public function mount()
    {
        #dd($this->indisponibilites);
    }



    public function render()
    {
        return view('livewire.Indisponibilite-component');
    }
    
    public function createIndisponibilite()
    {
        $this->dateHeureDebut = $this->selectedTime;
        $this->validate([
            'note' => 'required|string',
            'dateHeureDebut' => 'required|date',
            'dateHeureFin' => 'required|date|after:dateHeureDebut',
        ]);
        

        Indisponibilite::create([
            'note' => $this->note,
            'dateHeureDebut' => $this->dateHeureDebut,
            'dateHeureFin' => $this->dateHeureFin,
            'idProfessionnel' => 1, # A changer!!
        ]);

        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');
        $this->dispatch('refreshAgenda');

    }

}
