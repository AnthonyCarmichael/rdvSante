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

    protected $listeners = ['timeUpdated' => 'updateTime',
                            'passingIndispo' => 'passingIndispo',
                            'resetIndispo' => 'resetIndispo',
                            'createIndispoModal' => 'createIndispoModal',
                            'consulterModalIndispo' => 'consulterModalIndispo'];


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


    public function createIndispoModal($selectedTime) {
        $this->reset();
        $this->selectedTime = $selectedTime;
        $this->dispatch('open-modal', name: 'ajouterIndisponibilite');
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

    public function consulterModalIndispo(Indisponibilite $indispo) {
        $this->reset();
        $this->note = $indispo->note;
        $this->dateHeureDebut = $indispo->dateHeureDebut;
        $this->dateHeureFin = $indispo->dateHeureFin;
        $this->dispatch('open-modal', name: 'consulterIndisponibilite');

    }

    public function resetIndispo(){
        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
    }

}
