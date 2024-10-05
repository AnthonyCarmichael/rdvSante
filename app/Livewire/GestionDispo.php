<?php

namespace App\Livewire;

use Carbon\Carbon;

use Auth;
use Livewire\Component;

use App\Models\Disponibilite;
use App\Models\DiponibiliteProfessionnel;
use App\Models\Jour;

class GestionDispo extends Component
{
    public $dispos;
    public $dispo;
    public $idDispo;
    public $jours;
    public $journee;
    public $jour = '1';
    public $nomJour;
    public $heureDebut;
    public $heureFin;
    public $empietement = false;
    public function render()
    {
        return view('livewire.gestion-dispo');
    }

    protected function rules()
    {
        return [
            'heureFin' => 'required|after:heureDebut',
            'heureDebut' => 'required',
            'jour' => 'required'
        ];
    }

    protected $messages = [
        'heureFin.required' => 'Veuillez entrer une heure de fin.',
        'heureFin.after' => 'Veuillez entrer une heure de fin qui est après l\'heure de début.',
        'heureDebut.required' => 'Veuillez entrer une heure de début.',
        'jour.required' => 'Veuillez entrer un jour.',
    ];

    public function mount()
    {
        $this->dispos = Disponibilite::orderBy('heureDebut', 'asc')->findMany(DiponibiliteProfessionnel::where('id_user', '=', Auth::user()->id)->get());
        $this->jours = Jour::all();
    }

    public function formAjout()
    {
        $this->reset(['jour', 'heureDebut', 'heureFin']);
        $this->dispatch('open-modal', name: 'ajouterDispo');

    }
    public function ajoutDispo()
    {
        $this->validate();

        $this->empietement = false;

        foreach ($this->dispos as $d) {
            if ($d->idJour == $this->jour) {
                if ((($this->heureDebut >= $d->heureDebut && $this->heureDebut <= $d->heureFin) || ($this->heureFin >= $d->heureDebut && $this->heureFin <= $d->heureFin)) || (($d->heureDebut >= $this->heureDebut && $d->heureFin <= $this->heureDebut) || ($d->heureDebut >= $this->heureFin && $d->heureFin <= $this->heureFin))) {
                    $this->empietement = true;
                    break;
                }
            }
        }

        if (!$this->empietement) {
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
        $this->dispos = Disponibilite::orderBy('heureDebut', 'asc')->findMany(DiponibiliteProfessionnel::where('id_user', '=', Auth::user()->id)->get());
        $this->jours = Jour::all();
        $this->dispatch('close-modal');
    }

    public function modifDispo()
    {
        $this->validate();

        $this->empietement = false;

        foreach ($this->dispos as $d) {
            if ($d->idJour == $this->jour && $d->id != $this->dispo->id) {
                if ((($this->heureDebut >= $d->heureDebut && $this->heureDebut <= $d->heureFin) || ($this->heureFin >= $d->heureDebut && $this->heureFin <= $d->heureFin)) || (($d->heureDebut >= $this->heureDebut && $d->heureFin <= $this->heureDebut) || ($d->heureDebut >= $this->heureFin && $d->heureFin <= $this->heureFin))) {
                    $this->empietement = true;
                    break;
                }
            }
        }

        if (!$this->empietement) {
            Disponibilite::find($this->dispo->id)->update([
                'heureDebut' => $this->heureDebut,
                'heureFin' => $this->heureFin,
                'idJour' => $this->jour
            ]);
        }

        $this->reset(['jour', 'heureDebut', 'heureFin']);
        $this->dispos = Disponibilite::orderBy('heureDebut', 'asc')->findMany(DiponibiliteProfessionnel::where('id_user', '=', Auth::user()->id)->get());
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function getInfoDispo($id)
    {
        $this->dispo = Disponibilite::find($id);
        #$this->heureDebut = $this->dispo->heureDebut;
        $this->heureDebut = Carbon::createFromFormat('H:i:s', $this->dispo->heureDebut)->format('H:i');
        $this->heureFin = Carbon::createFromFormat('H:i:s', $this->dispo->heureFin)->format('H:i');
        #$this->heureFin = $this->dispo->heureFin;
        $this->jour = $this->dispo->idJour;
        $this->dispatch('open-modal', name: 'modifierDispo');

    }

    public function confirmerSuppression($id)
    {
        $this->dispo = Disponibilite::find($id);
        $this->heureDebut = $this->dispo->heureDebut;
        $this->heureFin = $this->dispo->heureFin;
        $this->journee = Jour::find($this->dispo->idJour);
        $this->nomJour = $this->journee->nom;
        $this->dispatch('open-modal', name: 'supprimerDispo');
    }

    public function supDispo()
    {
        DiponibiliteProfessionnel::where('idDisponibilite', '=', $this->dispo->id)->delete();
        Disponibilite::where('id', '=', $this->dispo->id)->delete();

        $this->reset(['dispo', 'jour', 'heureDebut', 'heureFin']);
        $this->dispos = Disponibilite::orderBy('heureDebut', 'asc')->findMany(DiponibiliteProfessionnel::where('id_user', '=', Auth::user()->id)->get());
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }
}
