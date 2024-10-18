<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Clinique;
use App\Models\CliniqueProfessionnel;
use App\Models\Ville;
use Illuminate\Support\Facades\Auth;


class CliniqueComponent extends Component
{
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

        $this->foundCliniques = Auth::user()->cliniques;
    }

    public function resetFilters()
    {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function updatedSearch($nomRecherche)
    {
        $query = Clinique::with(['ville.province.pays'])
            ->where(function($query) {
                $query->where('cliniques.nom', 'like', '%' . $this->search . '%')
                    ->orWhere('cliniques.rue', 'like', '%' . $this->search . '%')
                    ->orWhere('cliniques.nocivique', 'like', '%' . $this->search . '%')
                    ->orWhere('cliniques.codePostal', 'like', '%' . $this->search . '%')
                    ->orWhereHas('ville', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('ville.province', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('ville.province.pays', function ($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%');
                    })->where('actif', true);
        });

        if ($this->sortField === 'ville') {
            $query = $query->join('villes', 'cliniques.idVille', '=', 'villes.id')
                           ->select('cliniques.*', 'villes.nom as ville_nom')
                           ->orderBy('ville_nom', $this->sortDirection);
        } elseif ($this->sortField === 'province') {
            $query = $query->join('villes', 'cliniques.idVille', '=', 'villes.id')
                           ->join('provinces', 'villes.idProvince', '=', 'provinces.id')
                           ->select('cliniques.*', 'provinces.nom as province_nom')
                           ->orderBy('province_nom', $this->sortDirection);
        } elseif ($this->sortField === 'pays') {
            $query = $query->join('villes', 'cliniques.idVille', '=', 'villes.id')
                           ->join('provinces', 'villes.idProvince', '=', 'provinces.id')
                           ->join('pays', 'provinces.idPays', '=', 'pays.id')
                           ->select('cliniques.*', 'pays.nom as pays_nom')
                           ->orderBy('pays_nom', $this->sortDirection);
        } else {
            $query = $query->orderBy($this->sortField, $this->sortDirection);
        }

        $this->foundCliniques = $query->get();
    }

    public function openModalAjouterClinique()
    {
        $this->resetExcept('foundCliniques','villes');
        $this->dispatch('open-modal', name : 'ajouterClinique');
    }

    public function rules()
    {
        $rules=[
            'nomClinique' => 'required|string|max:255',
            'rueClinique' => 'required|string|max:255',
            'noCiviqueClinique' => 'nullable|integer|min:0',
            'codePostalClinique' => 'required|string|max:255|regex:/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/',
            'villeClinique' => 'required|exists:villes,id'
        ];

        return $rules;
    }

    public function ajouterClinique()
    {
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

        $this->foundCliniques = Auth::user()->cliniques;

        $this->resetExcept('foundCliniques','villes');
        $this->dispatch('close-modal');
    }

    public function consulterClinique($id)
    {
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

    public function modifierClinique($id)
    {
        $clinique = Clinique::findOrFail($id);
        $this->clinique_id = $clinique->id;
        $this->nomClinique = $clinique->nom;
        $this->rueClinique = $clinique->rue;
        $this->noCiviqueClinique = $clinique->noCivique;
        $this->codePostalClinique = $clinique->codePostal;
        $this->villeClinique = $clinique->idVille;
        $this->principalClinique = $clinique->principal;

        $this->dispatch('open-modal', name: 'modifierClinique');
    }

    public function updateClinique()
    {
        $this->validate();

        $clinique = Clinique::find($this->clinique_id);

        if ($clinique->principal) {
            $cliniquePrincipal = Clinique::where('principal', true);
            if($cliniquePrincipal){
                $cliniquePrincipal->update([
                    'actif' => false
                ]);
            }
            if ($clinique) {
                $clinique->update([
                    'actif' => true
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

            $this->foundCliniques = Auth::user()->cliniques;
            $this->dispatch('close-modal');
        }
    }

    public function desactiverClinique($id){
        $service = Clinique::findOrFail($id);

        if ($service) {
            $service->update([
                'actif' => false,
            ]);

            $this->resetExcept('foundCliniques', 'villes');
            $this->foundCliniques = Clinique::where('idProfessionnel', Auth::user()->id)->where('actif', true)->get();
        }

    }

    public function confirmDelete($id)
    {
        $this->cliniqueIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteService()
    {
        if ($this->cliniqueIdToDelete) {
            Clinique::find($this->cliniqueIdToDelete)->delete();;
        }

        $this->mount();
        $this->reset('cliniqueIdToDelete', 'showDeleteModal');
    }

    public function cancelDelete()
    {
        $this->reset('cliniqueIdToDelete', 'showDeleteModal');
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->cliniques = $this->updatedSearch($this->search);
    }

    public function render()
    {
        return view('livewire.clinique-component');
    }
}
