<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Clinique;
use App\Models\CliniqueProfessionnel;
use App\Models\User;
use App\Models\Ville;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    public $filtreActif = 1;

    public $searchQuery;

    public function mount() {
        $this->filtreClinique();

        $this->villes = Ville::all();
    }

    public function resetFilters() {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function updatedSearch()
    {
        if ($this->filtreActif == 1)
        {
            $query = Auth::user()->cliniques()->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('noCivique', 'like', '%' . $this->search . '%')
                    ->orWhere('rue', 'like', '%' . $this->search . '%')
                    ->orWhere('CodePostal', 'like', '%' . $this->search . '%')
                    ->orWhereHas('ville', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhereHas('province', function($query) {
                                    $query->where('nom', 'like', '%' . $this->search . '%')
                                        ->orWhereHas('pays', function($query) {
                                            $query->where('nom', 'like', '%' . $this->search . '%');
                                        });
                                });
                    });
            })
            ->where('actif', true)
            ->orderBy($this->sortField, $this->sortDirection);

            $this->foundCliniques = $query->get();
        }
        elseif ($this->filtreActif == 0)
        {
            $query = Auth::user()->cliniques()->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('noCivique', 'like', '%' . $this->search . '%')
                    ->orWhere('rue', 'like', '%' . $this->search . '%')
                    ->orWhere('CodePostal', 'like', '%' . $this->search . '%')
                    ->orWhereHas('ville', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhereHas('province', function($query) {
                                    $query->where('nom', 'like', '%' . $this->search . '%')
                                        ->orWhereHas('pays', function($query) {
                                            $query->where('nom', 'like', '%' . $this->search . '%');
                                        });
                                });
                    });
            })
            ->where('actif', false)
            ->orderBy($this->sortField, $this->sortDirection);


            $this->foundCliniques = $query->get();
        }
        else
        {
            $query = Auth::user()->cliniques()->where(function($query) {
                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('noCivique', 'like', '%' . $this->search . '%')
                    ->orWhere('rue', 'like', '%' . $this->search . '%')
                    ->orWhere('CodePostal', 'like', '%' . $this->search . '%')
                    ->orWhereHas('ville', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhereHas('province', function($query) {
                                    $query->where('nom', 'like', '%' . $this->search . '%')
                                        ->orWhereHas('pays', function($query) {
                                            $query->where('nom', 'like', '%' . $this->search . '%');
                                        });
                                });
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);


            $this->foundCliniques = $query->get();
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

        $this->filtreClinique();

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

            $this->filtreClinique();

            $this->dispatch('close-modal');
        }
    }

    public function desactiverClinique($id) {
        $clinique = Clinique::findOrFail($id);

        if ($clinique) {

            if ($clinique->principal == 1) {
                throw ValidationException::withMessages([
                    'clinique' => 'La clinique principale ne peut pas être désactivée.',
                ]);
            }
            else{
                $clinique->update([
                    'actif' => false,
                ]);
            }

            $this->resetExcept('foundCliniques', 'villes');
            $this->filtreClinique();
        }
    }

    public function activerClinique($id) {
        $clinique = Clinique::findOrFail($id);

        if ($clinique) {
            $clinique->update([
                'actif' => true,
            ]);

            $this->resetExcept('foundCliniques', 'villes');
            $this->filtreClinique();
        }
    }

    public function confirmDelete($id) {
        $this->cliniqueIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteClinique() {
        if ($this->cliniqueIdToDelete) {
            Clinique::find($this->cliniqueIdToDelete)->delete();;
        }

        $this->mount();
        $this->reset('cliniqueIdToDelete', 'showDeleteModal');
    }

    public function cancelDelete() {
        $this->reset('cliniqueIdToDelete', 'showDeleteModal');
    }

    public function updatedcodePostal($value) {
        if (strlen($this->codePostalClinique) == 6) {
            $this->codePostalClinique = ''.strtoupper(substr($this->codePostalClinique, 0, 1)) .substr($this->codePostalClinique, 1,  1) .strtoupper(substr($this->codePostalClinique, 2, 1)) .' '.substr($this->codePostalClinique, 3,  1) .strtoupper(substr($this->codePostalClinique, 4, 1)).substr($this->codePostalClinique, 5,  1);
        }
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->cliniques = $this->updatedSearch();
    }

    public function filtreClinique()
    {
        if ($this->filtreActif == 1) {
            $this->foundCliniques = Auth::user()->cliniques()->where('actif', true)->get();
        }
        elseif ($this->filtreActif == 0) {
            $this->foundCliniques = Auth::user()->cliniques()->where('actif', false)->get();
        }
        elseif ($this->filtreActif == 2) {
            $this->foundCliniques = Auth::user()->cliniques()->get();
        }
    }

    public function render() {
        return view('livewire.clinique-component');
    }
}
