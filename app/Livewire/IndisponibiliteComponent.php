<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Indisponibilite;

use Carbon\Carbon;

class IndisponibiliteComponent extends Component
{
    public $id;
    public $note;
    public $dateHeureDebut;
    public $dateHeureFin;
    public $selectedTime;

    public $tempNote;
    public $tempDateHeureFin;

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
        $this->id = $indispo->id;
        $this->note = $this->tempNote = $indispo->note;
        
        $this->dateHeureDebut = Carbon::parse($indispo->dateHeureDebut)->translatedFormat('l \l\e d F Y \à H:i');
        $this->dateHeureFin = $this->tempDateHeureFin = Carbon::parse($indispo->dateHeureFin)->translatedFormat('l \l\e d F Y \à H:i');
    
        $this->dispatch('open-modal', name: 'consulterIndisponibilite');
        #dd($this);

    }

    public function resetIndispo(){
        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
    }


    public function modifierIndisponibilite()
    {

        $this->validate([
            'tempNote' => 'required|string',
            'dateHeureDebut' => 'required|date',
            'tempDateHeureFin' => 'required|date|after:dateHeureDebut',
        ]);


        $indispo = Indisponibilite::find($this->id);
        
        if ($indispo) {

            $this->note = $this->tempNote;
            $this->dateHeureFin = $this->tempDateHeureFin;

            $indispo->note = $this->tempNote;
            $indispo->dateHeureFin = $this->tempDateHeureFin;
            
            $indispo->save();
        }
        else {
            session()->flash('error', 'Indisponibilité non trouvée.');
        }


        $this->reset();
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');
        $this->consulterModalIndispo($indispo);

    }

    public function annuler()
    {
        #dd($this);
        $this->tempNote = $this->note;
        $this->tempDateHeureFin = $this->dateHeureFin;
    }

    public function deleteIndispo(){

        $deleted = Indisponibilite::destroy($this->id);
        $this->reset();
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');

    }
}
