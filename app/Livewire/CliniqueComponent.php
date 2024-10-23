<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Clinique;
use App\Models\CliniqueProfessionnel;
use App\Models\Ville;
use Illuminate\Support\Facades\Auth;

class CliniqueComponent extends Component {
    public $clinique_id;
    public $nomClinique;
    public $rueClinique;
    public $noCiviqueClinique;
    public $codePostalClinique;
    public $villeClinique;
    public $principalClinique;

    public $cliniqueIdToDelete;
    public $showDeleteModal;

    public $cliniques;
    public $villes;
    public $foundCliniques;

    public $search = '';
    public $sortField = 'nom';
    public $sortDirection = 'asc';

    public $searchQuery;

    public function mount() {
        $this->villes = Ville::all();

        $indice=0;
        foreach (Auth::user()->cliniques as $clinique) {
            if ($clinique->actif) {
                $this->foundCliniques[$indice] = $clinique;
            }
            $indice++;
        }
    }

    public function resetFilters() {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function updatedSearch($nomRecherche) {
        $indice=0;

        foreach (Auth::user()->cliniques as $clinique) {
            #dd($clinique->nom,$this->search,str_contains(strtolower($clinique->nom),strtolower($this->search)));
            if (!str_contains(strtolower($clinique->nom),strtolower($this->search)) &&
                !str_contains(strtolower($clinique->noCivique),strtolower($this->search)) &&
                !str_contains(strtolower($clinique->rue),strtolower($this->search)) &&
                !str_contains(strtolower($clinique->CodePostal),strtolower($this->search)) &&
                !str_contains(strtolower($clinique->ville->nom),strtolower($this->search)) &&
                !str_contains(strtolower($clinique->ville->province->nom),strtolower($this->search)) &&
                !str_contains(strtolower($clinique->ville->province->pays->nom),strtolower($this->search))) {
                #dd("true");
                unset($this->foundCliniques[$indice]);
            }

            $indice++;
        }
    }

    public function openModalAjouterClinique() {
        $this->resetExcept('foundCliniques','villes');
        $this->dispatch('open-modal', name : 'ajouterClinique');
    }

    public function rules() {
        $rules=[
            'nomClinique' => 'required|string|max:255',
            'rueClinique' => 'required|string|max:255',
            'noCiviqueClinique' => 'nullable|integer|min:0',
            'codePostalClinique' => 'required|string|max:255|regex:/^[A-Z]\d[A-Z][ -]?\d[A-Z]\d$/',
            'villeClinique' => 'required|exists:villes,id',
            'principalClinique' => 'nullable|boolean'
        ];

        return $rules;
    }

    public function ajouterClinique() {
        $this->validate();

        $idClinique = Clinique::insertGetId([
            'nom' => $this->nomClinique,
            'rue' => $this->rueClinique,
            'noCivique' => $this->noCiviqueClinique,
            'codePostal' => $this->codePostalClinique,
            'actif' => true,
            'principal' => false,
            'idVille' => $this->villeClinique
        ]);

        CliniqueProfessionnel::create([
            'idClinique' => $idClinique,
            'idProfessionnel' => Auth::user()->id
        ]);

        $indice=0;
        foreach (Auth::user()->cliniques as $clinique) {
            if ($clinique->actif) {
                $this->foundCliniques[$indice] = $clinique;
            }
            $indice++;
        }

        $this->resetExcept('foundCliniques','villes');
        $this->dispatch('close-modal');
    }

    public function consulterClinique($id) {
        $clinique = Clinique::findOrFail($id);
        $this->clinique_id = $clinique->id;
        $this->nomClinique = $clinique->nom;
        $this->rueClinique = $clinique->rue;
        $this->noCiviqueClinique = $clinique->noCivique;
        $this->codePostalClinique = $clinique->codePostal;
        $this->villeClinique = $clinique->idVille;
        $this->principalClinique = $clinique->principal;

        $this->dispatch('open-modal', name: 'consulterClinique');
    }

    public function modifierClinique($id) {
        $clinique = Clinique::findOrFail($id);
        $this->clinique_id = $clinique->id;
        $this->nomClinique = $clinique->nom;
        $this->rueClinique = $clinique->rue;
        $this->noCiviqueClinique = $clinique->noCivique;
        $this->codePostalClinique = $clinique->codePostal;
        $this->villeClinique = $clinique->idVille;
        $this->principalClinique = $clinique->principal == 1;

        $this->dispatch('open-modal', name: 'modifierClinique');
    }

    public function updateClinique() {
        $this->validate();

        $clinique = Clinique::find($this->clinique_id);

        if ($this->principalClinique) {
            $cliniquePrincipal = Clinique::where('principal', true);

            if($cliniquePrincipal){
                $cliniquePrincipal->update([
                    'principal' => false
                ]);
            }

            if ($clinique) {
                $clinique->update([
                    'principal' => true
                ]);
            }
        }

        if ($clinique) {
            $clinique->update([
                'nom' => $this->nomClinique,
                'rue' => $this->rueClinique,
                'noCivique' => $this->noCiviqueClinique,
                'codePostal' => $this->codePostalClinique,
                'idVille' => $this->villeClinique
            ]);

            $this->resetExcept('foundCliniques', 'villes');

            $indice=0;

            foreach (Auth::user()->cliniques as $clinique) {
                if ($clinique->actif) {
                    $this->foundCliniques[$indice] = $clinique;
                }
                $indice++;
            }

            $this->dispatch('close-modal');
        }
    }

    public function desactiverClinique($id) {
        $clinique = Clinique::findOrFail($id);

        if ($clinique) {
            $clinique->update([
                'actif' => false,
            ]);

            $this->resetExcept('foundCliniques', 'villes');
            $this->foundCliniques = Clinique::where('idProfessionnel', Auth::user()->id)->where('actif', true)->get();
        }

    }

    public function confirmDelete($id) {
        $this->cliniqueIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteService() {
        if ($this->cliniqueIdToDelete) {
            Clinique::find($this->cliniqueIdToDelete)->delete();;
        }

        $this->mount();
        $this->reset('cliniqueIdToDelete', 'showDeleteModal');
    }

    public function cancelDelete() {
        $this->reset('cliniqueIdToDelete', 'showDeleteModal');
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->cliniques = $this->updatedSearch($this->search);
    }

    public function render() {
        return view('livewire.clinique-component');
    }
}
