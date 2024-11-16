<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Dossier as ModelsDossier;
use App\Models\Fichier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Dossier extends Component
{
    use WithFileUploads;

    public $dossiers;
    public $dossier;
    public $fiches;
    public $client;

    public $image;
    public $nomImage;

    public $search = '';
    public $searchFiche = '';
    public $sortField = 'id';
    public $sortFieldFiche = 'id';
    public $sortDirection = 'asc';
    public $sortDirectionFiche = 'asc';
    public $view = null;
    public $filtreActif = 1;

    public function mount($dossierClient = null) {
        $this->filtreDossier();

        /*$this->dossiers = Auth::user()->dossiers()->get();

        foreach ($this->dossiers as $d) {
            dd($d);
        }*/
        if ($dossierClient) {
            $this->dossier = ModelsDossier::findOrFail($dossierClient->id);

            $this->client = $this->dossier->client;

            $this->view = "Fiches";
            $this->fiches = $this->dossier->fichesCliniques;
        }
    }

    public function consulterDossier($id) {
        $this->dossier = ModelsDossier::findOrFail($id);

        $this->client = $this->dossier->client;

        $this->view = "Fiches";
        $this->fiches = $this->dossier->fichesCliniques;
    }

    public function resetFilters() {
        $this->mount();
        $this->reset('sortDirection');
    }

    public function filtreDossier()
    {
        if ($this->filtreActif == 1) {
            $this->dossiers = Auth::user()->dossiers;   #->where('actif', true)->get();
        }
        elseif ($this->filtreActif == 0) {
            $this->dossiers = Auth::user()->dossiers;   #->where('actif', false)->get();
        }
        elseif ($this->filtreActif == 2) {
            $this->dossiers = Auth::user()->dossiers;
        }
    }

    public function updatedSearch()
    {
        if ($this->filtreActif == 1)
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('idDossier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%')
                                ->where('actif', true);
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
        elseif ($this->filtreActif == 0)
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('idDossier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%')
                                ->where('actif', false);
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
        else
        {
            $query = Auth::user()->dossiers()->where(function($query) {
                $query->where('idDossier', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($query) {
                        $query->where('nom', 'like', '%' . $this->search . '%')
                                ->orWhere('prenom', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

            $this->dossiers = $query->get();
        }
    }

    public function updatedSearchFiche()
    {
        $query = $this->dossier->fichesCliniques()
            ->where(function ($query) {
                $query->where('id', 'like', '%' . $this->searchFiche . '%')
                    ->orWhere('dateHeure', 'like', '%' . $this->searchFiche . '%')
                    ->orWhereHas('typeFiche', function ($query) {
                        $query->where('nom', 'like', '%' . $this->searchFiche . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $this->fiches = $query->get();
        #dd($this->fiches);
    }

    public function openModalAjouterImage() {
        #$this->resetExcept('dossiers','fiches');
        $this->dispatch('open-modal', name : 'ajouterImage');
    }

    public function ajouterImage() {
        $this->validate([
            'nomImage' => 'required|string|max:255',
            'image' => 'image|mimes:jpg,jpeg,png|max:1024',
        ], [
            'nomImage.required' => 'Le champ Nom de l\'image * est obligatoire.',
            'nomImage.string' => 'Le champ Nom de l\'image * doit être une chaîne de caractères.',
            'nomImage.max' => 'Le champ Nom de l\'image * ne doit pas dépasser 255 caractères.',

            'image.image' => 'Le fichier de l\'image doit être une image.',
            'image.mimes' => 'L\'image doit être au format JPG, JPEG ou PNG.',
            'image.max' => 'L\'image ne doit pas dépasser 1 Mo.',
        ]);

        if ($this->image) {
            $imagePath = $this->image->storeAs('Images', 'image' . $this->nomImage . '.png', 'public');
        }

        Fichier::create([
            'nom' => $this->nomImage,
            'dateHeureAjout' => now(),
            'lien' => $imagePath,
            'idDossier' => $this->dossier->id,
        ]);

        $this->resetExcept('dossiers', 'dossier', 'view', 'client');
        $this->dispatch('close-modal');
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->updatedSearch();
    }

    public function sortByFiche($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->updatedSearchFiche();
    }

    public function setView($view) {
        $this->view = $view;
        if ($this->view == "Fiches")
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
        elseif ($this->view == "Images")
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
        else
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
    }


    public function redirectAjouterFiche() {
        return redirect()->route('ficheClinique',$this->dossier);
    }

    public function consulterFiche($idFiche) {
        #dd("consulter fiche",$idFiche);
        return redirect()->route('ficheCliniqueConsulter',$idFiche);
    }

    public function redirectModifierFiche($idFiche) {
        dd("modifier fiche",$idFiche);
        //return redirect()->route('ficheClinique',$this->dossier);
    }

    public function supprimerFiche($idFiche) {
        dd("supprimer fiche",$idFiche);
        //return redirect()->route('ficheClinique',$this->dossier);
    }

    public function render()
    {
        return view('livewire.dossier');
    }
}
