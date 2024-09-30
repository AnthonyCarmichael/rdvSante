<?php

namespace App\Livewire;

use Auth;
use Livewire\Component;

use App\Models\Disponibilite;
use App\Models\DiponibiliteProfessionnel;
use App\Models\Jour;

class GestionDispo extends Component
{
    public $dispo;
    public $idDispo;
    public $jours;
    public $jour = '1';
    public $heureDebut;
    public $heureFin;
    public function render()
    {
        return view('livewire.gestion-dispo');
    }

    protected function rules()
    {
        return [
            'heureFin' => 'required',
            'heureDebut' => 'required',
            'jour' => 'required'
        ];
    }

    public function mount()
    {
        $this->dispo = Disponibilite::orderBy('heureDebut', 'asc')->findMany(DiponibiliteProfessionnel::where('id_user', '=', Auth::user()->id)->get());
        $this->jours = Jour::all();
    }

    public function formAjout()
    {

        $this->dispatch('open-modal', name: 'ajouterDispo');

    }
    public function ajoutDispo()
    {
        $this->validate();

        $empietement = false;

        foreach ($this->dispo as $d){
            if ($d->idJour == $this->jour){
                if ((($this->heureDebut >= $d->heureDebut && $this->heureDebut <= $d->heureFin) || ($this->heureFin >= $d->heureDebut && $this->heureFin <= $d->heureFin)) || (($d->heureDebut >= $this->heureDebut && $d->heureFin <= $this->heureDebut) || ($d->heureDebut >= $this->heureFin && $d->heureFin <= $this->heureFin))){
                    $empietement = true;
                    break;
                }
            }
        }

        if(!$empietement){
            $this->idDispo = Disponibilite::insertGetId([
                'heureDebut' => $this->heureDebut,
                'heureFin' => $this->heureFin,
                'idJour' => $this->jour
            ]);

            DiponibiliteProfessionnel::create([
                'idDisponibilite' => $this->idDispo,
                'id_user' => Auth::user()->id
            ]);
        }


        $this->reset(['jour', 'heureDebut', 'heureFin']);
        $this->dispo = Disponibilite::orderBy('heureDebut', 'asc')->findMany(DiponibiliteProfessionnel::where('id_user', '=', Auth::user()->id)->get());
        $this->jours = Jour::all();
        $this->dispatch('close-modal');
    }
}
