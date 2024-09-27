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
    
}
