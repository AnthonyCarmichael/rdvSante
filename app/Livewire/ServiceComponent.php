<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;

class ServiceComponent extends Component
{
    public $note;
    public $dateHeureDebut;
    public $dateHeureFin;
    public $services;

    protected function rules()
    {
        return [
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'prix' => 'required|date|after:dateHeureDebut',
            'minutePause' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        $this->services = Service::all();
        #dd($this->services);
    }

    public function createService()
    {
        $this->validate();

        Service::create([
            'note' => $this->note,
            'dateHeureDebut' => $this->dateHeureDebut,
            'dateHeureFin' => $this->dateHeureFin,
            'idProfessionnel' => 1, # A changer!!
        ]);

        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
        $this->services = Service::all();
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function render()
    {
        return view('livewire.Service-component',['services' => $this->services]);
    }
}
