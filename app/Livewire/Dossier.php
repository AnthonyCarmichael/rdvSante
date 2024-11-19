<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Dossier as ModelsDossier;
use App\Models\FicheClinique;
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
    public $images;
    public $documents;
    public $client;


    public $document;
    public $document_id;
    public $nomDocument;

    public $image;
    public $image_id;
    public $nomImage;

    public $showDeleteConfirmation = false;
    public $showDeleteConfirmationDocument = false;

    public $search = '';
    public $searchFiche = '';
    public $searchImage = '';
    public $searchDocument = '';
    public $sortField = 'id';
    public $sortFieldFiche = 'id';
    public $sortDirection = 'asc';
    public $sortDirectionFiche = 'asc';
    public $view = null;
    public $filtreActif = 1;

    public $selectedFiche;

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
                    ->orWhereHas('typeFiche', function ($query) {
                        $query->where('nom', 'like', '%' . $this->searchFiche . '%');
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $this->fiches = $query->get();
        #dd($this->fiches);
    }

    public function updatedSearchDocument()
    {
        $query = $this->dossier->fichiers()
            ->where('lien', 'like', '%Documents/document%') // Filtre uniquement les fichiers contenant "document" dans le lien
            ->where(function ($subQuery) {
                $subQuery->where('id', 'like', '%' . $this->searchDocument . '%')
                         ->orWhere('nom', 'like', '%' . $this->searchDocument . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $this->documents = $query->get();
    }

    public function openModalAjouterDocument() {
        $this->dispatch('open-modal', name : 'ajouterDocument');
    }

    public function consulterDocument($id)
    {
        $document = Fichier::find($id);

        if ($document) {
            return redirect()->to(asset('storage/' . $document->lien));
        } else {
            session()->flash('error', 'Document introuvable.');
        }
    }

    public function ajouterDocument() {
        $this->validate([
            'nomDocument' => 'required|string|max:255',
            'document' => 'required|mimes:pdf,doc,docx,xls,xlsx',
        ], [
            'nomDocument.required' => 'Le champ Nom de l\'image * est obligatoire.',
            'nomDocument.string' => 'Le champ Nom de l\'image * doit être une chaîne de caractères.',
            'nomDocument.max' => 'Le champ Nom de l\'image * ne doit pas dépasser 255 caractères.',

            'document.required' => 'Le champ Document * est obligatoire.',
            'document.mimes' => 'Le fichier doit être un document de type PDF, Word ou Excel.',
        ]);

        if ($this->document) {
            $documentPath = $this->document->storeAs('Documents', 'document' . $this->nomDocument . '.pdf', 'public');
        }

        Fichier::create([
            'nom' => $this->nomDocument,
            'dateHeureAjout' => now(),
            'lien' => $documentPath,
            'idDossier' => $this->dossier->id,
        ]);

        $query = $this->dossier->fichiers()
        ->where(function ($query) {
            $query->where('lien', 'like', '%' . "document" . '%');
        })
        ->orderBy("dateHeureAjout", "desc");

        $this->documents = $query->get();

        $this->resetExcept('dossiers', 'dossier', 'view', 'client', 'documents');
        $this->dispatch('close-modal');
    }

    public function updatedSearchImage()
    {
        $query = $this->dossier->fichiers()
            ->where('lien', 'like', '%Images/image%')
            ->where(function ($subQuery) {
                $subQuery->where('id', 'like', '%' . $this->searchImage . '%')
                         ->orWhere('nom', 'like', '%' . $this->searchImage . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $this->images = $query->get();
    }


    public function openModalAjouterImage() {
        #$this->resetExcept('dossiers','fiches');
        $this->dispatch('open-modal', name : 'ajouterImage');
    }

    public function consulterImage($id)
    {
        $image = Fichier::find($id);

        if ($image) {
            return redirect()->to(asset('storage/' . $image->lien));
        } else {
            session()->flash('error', 'Image introuvable.');
        }
    }

    public function ajouterImage() {
        $this->validate([
            'nomImage' => 'required|string|max:255',
            'image' => 'mimes:jpg,jpeg,png|max:1024',
        ], [
            'nomImage.required' => 'Le champ Nom de l\'image * est obligatoire.',
            'nomImage.string' => 'Le champ Nom de l\'image * doit être une chaîne de caractères.',
            'nomImage.max' => 'Le champ Nom de l\'image * ne doit pas dépasser 255 caractères.',

            'image.mimes' => 'Sélectionner une image JPG, JPEG ou PNG.',
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


        $query = $this->dossier->fichiers()
        ->where(function ($query) {
            $query->where('lien', 'like', '%' . "image" . '%');
        })
        ->orderBy("dateHeureAjout", "desc");

        $this->images = $query->get();

        $this->resetExcept('dossiers', 'dossier', 'view', 'client', 'images');
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

    public function sortByImage($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->updatedSearchImage();
    }

    public function sortByDocument($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->updatedSearchDocument();
    }

    public function setView($view) {
        $this->view = $view;
        if ($this->view == "Fiches")
        {
            $this->fiches = $this->dossier->fichesCliniques;
        }
        elseif ($this->view == "Images")
        {
            $query = $this->dossier->fichiers()
            ->where(function ($query) {
                $query->where('lien', 'like', '%' . "image" . '%');
            })
            ->orderBy("dateHeureAjout", "desc");

            $this->images = $query->get();
        }
        elseif ($this->view == "Documents")
        {
            $query = $this->dossier->fichiers()
            ->where(function ($query) {
                $query->where('lien', 'like', '%' . "document" . '%');
            })
            ->orderBy("dateHeureAjout", "desc");

            $this->documents = $query->get();
        }
    }

    public function modifierImage($id) {
        $image = Fichier::findOrFail($id);
        $this->image = $image->lien;
        $this->nomImage = $image->nom;
        $this->image_id = $image->id;

        $this->dispatch('open-modal', name: 'modifierImage');
    }

    public function updateImage()
    {
        $this->validate([
            'nomImage' => 'required|string|max:255',
        ], [
            'nomImage.required' => 'Le champ Nom de l\'image * est obligatoire.',
            'nomImage.string' => 'Le champ Nom de l\'image * doit être une chaîne de caractères.',
            'nomImage.max' => 'Le champ Nom de l\'image * ne doit pas dépasser 255 caractères.',
        ]);

        $image = Fichier::find($this->image_id);

        if (!$image) {
            session()->flash('error', 'Image non trouvée.');
            return;
        }

        $imagePath = $image->lien;
        if ($this->image && $this->image != $image->lien) {
            $imagePath = $this->image->storeAs('Images', 'image' . $this->nomImage . '.png', 'public');
            // Supprimer l'ancien fichier
            // Storage::disk('public')->delete($image->lien);
        }

        // Mise à jour des informations de l'image
        $image->update([
            'nom' => $this->nomImage,
            'lien' => $imagePath,
            'idDossier' => $this->dossier->id,
        ]);

        // Réinitialisation et fermeture du modal
        $this->resetExcept('dossiers', 'dossier', 'view', 'client', 'images');
        $this->dispatch('close-modal');

        // Mise à jour de la collection d'images
        $this->images = $this->dossier->fichiers()
            ->where('lien', 'like', '%image%')
            ->orderBy('dateHeureAjout', 'desc')
            ->get();
    }


    public function modifierDocument($id) {
        $document = Fichier::findOrFail($id);
        $this->document = $document->lien;
        $this->nomDocument = $document->nom;
        $this->document_id = $document->id;

        $this->dispatch('open-modal', name: 'modifierDocument');
    }

    public function updateDocument() {
        $this->validate([
            'nomDocument' => 'required|string|max:255',
        ], [
            'nomDocument.required' => 'Le champ Nom du document * est obligatoire.',
            'nomDocument.string' => 'Le champ Nom du document * doit être une chaîne de caractères.',
            'nomDocument.max' => 'Le champ Nom du document * ne doit pas dépasser 255 caractères.',
        ]);

        $document = Fichier::find($this->document_id);

        if ($this->document) {
            if($this->document != $document->lien){
                $documentPath = $this->document->storeAs('Documents', 'document' . $this->nomDocument . '.pdf', 'public');

                if ($document) {
                    $document->update([
                        'nom' => $this->nomDocument,
                        'lien' => $documentPath,
                        'idDossier' => $this->dossier->id,
                    ]);

                    $query = $this->dossier->fichiers()
                    ->where(function ($query) {
                        $query->where('lien', 'like', '%' . "document" . '%');
                    })
                    ->orderBy("dateHeureAjout", "desc");

                    $this->documents = $query->get();
                    $this->resetExcept('dossiers', 'dossier', 'view', 'client', 'documents');
                    $this->dispatch('close-modal');
                }
            }

            if ($document) {
                $document->update([
                    'nom' => $this->nomDocument,
                    'idDossier' => $this->dossier->id,
                ]);

                $this->resetExcept('dossiers', 'dossier', 'view', 'client', 'documents');

                $this->dispatch('close-modal');

                $query = $this->dossier->fichiers()
                ->where(function ($query) {
                    $query->where('lien', 'like', '%' . "document" . '%');
                })
                ->orderBy("dateHeureAjout", "desc");

                $this->documents = $query->get();
            }
        }
    }

    public function confirmDelete($id)
    {
        $this->image_id = $id;
        $this->showDeleteConfirmation = true;
    }

    public function confirmDeleteDocument($id)
    {
        $this->document_id = $id;
        $this->showDeleteConfirmationDocument = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteConfirmation = false;
    }

    public function cancelDeleteDocument()
    {
        $this->showDeleteConfirmationDocument = false;
    }

    public function deleteImage()
    {
        $image = Fichier::find($this->image_id);

        if ($image) {
            if ($image->lien && file_exists(public_path('storage/' . $image->lien))) {
                unlink(public_path('storage/' . $image->lien));
            }

            $image->delete();

            session()->flash('success', 'L\'image a été supprimée avec succès.');
        } else {
            session()->flash('error', 'L\'image n\'existe pas ou a déjà été supprimée.');
        }

        $this->reset(['image_id', 'showDeleteConfirmation']);

        $query = $this->dossier->fichiers()
        ->where(function ($query) {
            $query->where('lien', 'like', '%' . "image" . '%');
        })
        ->orderBy("dateHeureAjout", "desc");

        $this->images = $query->get();
    }


    public function deleteDocument()
    {
        $document = Fichier::find($this->document_id);

        if ($document) {
            if ($document->lien && file_exists(public_path('storage/' . $document->lien))) {
                unlink(public_path('storage/' . $document->lien));
            }

            $document->delete();

            session()->flash('success', 'Le document a été supprimée avec succès.');
        } else {
            session()->flash('error', 'Le document n\'existe pas ou a déjà été supprimée.');
        }

        $this->reset(['document_id', 'showDeleteConfirmationDocument']);

        $query = $this->dossier->fichiers()
        ->where(function ($query) {
            $query->where('lien', 'like', '%' . "document" . '%');
        })
        ->orderBy("dateHeureAjout", "desc");

        $this->documents = $query->get();
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
        $this->selectedFiche = $idFiche;
        $this->dispatch('open-modal', name : 'confirmDeleteFicheModal');
        //return redirect()->route('ficheClinique',$this->dossier);
    }

    public function deleteFiche() {
        $this->selectedFiche = FicheClinique::find($this->selectedFiche);
        if ($this->selectedFiche) {
            $this->selectedFiche->delete();
        } else {
            session()->flash('error', 'La fiche clinique est introuvable.');
        }
        $this->dispatch('close-modal');
        $this->selectedFiche = null;
        $this->updatedSearchFiche();
    }

    public function render()
    {
        return view('livewire.dossier');
    }
}
