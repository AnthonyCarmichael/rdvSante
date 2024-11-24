<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Client;

use App\Models\Ville;
use App\Models\Genre;
use App\Models\Dossier;
use App\Models\DossierProfessionnel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AjouterClient extends Component
{
    public $clients;
    public $prenomFiltre = [];
    public $nomFiltre = [];
    public $filtreNom;
    public $filtrePrenom;
    public $filtreActif = 1;
    public $genres;
    public $villes;
    public $action;

    public $idClient;
    public $client;
    public $nom;
    public $prenom;
    public $courriel;
    public $telephone;
    public $genre = 1;
    public $ddn;
    public $nomResponsable = null;
    public $prenomResponsable = null;
    public $lienResponsable = null;
    public $rue = null;
    public $noCivique = null;
    public $codePostal = null;
    public $ville = null;
    public $idVille;

    public function render()
    {
        return view('livewire.ajouter-client');
    }
    public function mount($clients, $genres, $villes)
    {
        $this->filtreClient();

        foreach ($this->clients as $c) {
            $nomFound = false;

            $prenomFound = false;
            foreach ($this->nomFiltre as $n) {
                if ($n == $c->nom) {
                    $nomFound = true;
                    break;
                }
            }
            foreach ($this->prenomFiltre as $p) {
                if ($p == $c->prenom) {
                    $prenomFound = true;
                    break;
                }
            }
            if (!$nomFound) {
                array_push($this->nomFiltre, $c->nom);
            }
            if (!$prenomFound) {
                array_push($this->prenomFiltre, $c->prenom);
            }
        }

        $this->genres = $genres;

        $this->villes = $villes;
    }

    protected function rules()
    {
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'courriel' => 'required|email',
            'telephone' => 'required|regex:^\(\d{3}\)\s\d{3}-\d{4}^',
            'ddn' => 'nullable',
            'genre' => 'required',
            'nomResponsable' => 'string|nullable',
            'prenomResponsable' => 'string|nullable',
            'lienResponsable' => 'string|nullable',
            'rue' => 'string|nullable',
            'noCivique' => 'numeric|nullable',
            'codePostal' => 'string|nullable|regex:/^[A-Z]\d[A-Z][ ]\d[A-Z]\d$/'
        ];
    }

    protected $messages = [
        'nom.required' => 'Veuillez entrer un nom.',
        'prenom.required' => 'Veuillez entrer un prénom.',
        'courriel.required' => 'Veuillez entrer une adresse courriel.',
        'courriel.email' => 'Veuillez entrer une adresse courriel valide.',
        'telephone.required' => 'Veuillez entrer un numéro de téléphone.',
        'telephone.regex' => 'Veuillez respecter le format de numéro de téléphone demandé.',
        'genre.required' => 'Veuillez sélectionner un genre.',
        'codePostal.regex' => 'Veuillez respecter le format de code postal demandé.',
        'noCivique.numeric' => 'Veuillez entrer un nombre comme numéro civique.',
    ];

    public function ajoutClient()
    {
        $this->validate();

        $villeFound = False;
        foreach ($this->villes as $v) {
            if ($this->ville == $v->nom) {
                $this->idVille = $v->id;
                $villeFound = True;
                break;
            }
        }
        if ($villeFound == False && $this->ville != null) {
            $this->idVille = Ville::insertGetId([
                'nom' => $this->ville,
                'idProvince' => '1'
            ]);
        }

        if ($this->ville == " ") {
            $this->idVille = null;
        }

        if ($this->nomResponsable == " ") {
            $this->nomResponsable = null;
        }
        if ($this->prenomResponsable == " ") {
            $this->prenomResponsable = null;
        }
        if ($this->lienResponsable == " ") {
            $this->lienResponsable = null;
        }
        if ($this->rue == " ") {
            $this->rue = null;
        }
        $this->noCivique = intval($this->noCivique);
        #dd($this->noCivique);
        if ($this->noCivique == 0) {
            $this->noCivique = null;
        }
        if ($this->codePostal == " ") {
            $this->codePostal = null;
        }

        $idClient = Client::insertGetId([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'courriel' => $this->courriel,
            'telephone' => $this->telephone,
            'ddn' => $this->ddn,
            'idGenre' => $this->genre,
            'nomResponsable' => $this->nomResponsable,
            'prenomResponsable' => $this->prenomResponsable,
            'lienResponsable' => $this->lienResponsable,
            'rue' => $this->rue,
            'noCivique' => $this->noCivique,
            'codePostal' => $this->codePostal,
            'actif' => 1,
            'idVille' => $this->idVille
        ]);

        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC
        $Date = Carbon::now('America/Toronto');

        $idDossier = Dossier::insertGetId([
            'dateCreation' => $Date,
            'permissionPartage' => 0,
            'idClient' => $idClient
        ]);

        DossierProfessionnel::create([
            'principal' => 1,
            'idDossier' => $idDossier,
            'idProfessionnel' => Auth::user()->id
        ]);

        $this->reset(['nom', 'prenom', 'courriel', 'telephone', 'ddn', 'genre', 'nomResponsable', 'prenomResponsable', 'lienResponsable', 'rue', 'noCivique', 'codePostal', 'ville']);
        $this->filtreClient();
        $this->villes = Ville::orderBy('nom', 'asc')->get();
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function modifClient()
    {
        $this->validate();

        $villeFound = False;
        foreach ($this->villes as $v) {
            if ($this->ville == $v->nom) {
                $this->idVille = $v->id;
                $villeFound = True;
                break;
            }
        }
        if ($villeFound == False && $this->ville != null) {
            $this->idVille = Ville::insertGetId([
                'nom' => $this->ville,
                'idProvince' => '1'
            ]);
        }

        if ($this->ville == " ") {
            $this->idVille = null;
        }

        if ($this->nomResponsable == " ") {
            $this->nomResponsable = null;
        }
        if ($this->prenomResponsable == " ") {
            $this->prenomResponsable = null;
        }
        if ($this->lienResponsable == " ") {
            $this->lienResponsable = null;
        }
        if ($this->rue == " ") {
            $this->rue = null;
        }
        $this->noCivique = intval($this->noCivique);
        #dd($this->noCivique);
        if ($this->noCivique == 0) {
            $this->noCivique = null;
        }
        if ($this->codePostal == " ") {
            $this->codePostal = null;
        }


        Client::find($this->client->id)->update([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'courriel' => $this->courriel,
            'telephone' => $this->telephone,
            'ddn' => $this->ddn,
            'idGenre' => $this->genre,
            'nomResponsable' => $this->nomResponsable,
            'prenomResponsable' => $this->prenomResponsable,
            'lienResponsable' => $this->lienResponsable,
            'rue' => $this->rue,
            'noCivique' => $this->noCivique,
            'codePostal' => $this->codePostal,
            'idVille' => $this->idVille
        ]);

        $this->reset(['nom', 'prenom', 'courriel', 'telephone', 'ddn', 'genre', 'nomResponsable', 'prenomResponsable', 'lienResponsable', 'rue', 'noCivique', 'codePostal', 'ville']);
        $this->filtreClient();
        $this->villes = Ville::orderBy('nom', 'asc')->get();
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function getInfoClient($id)
    {
        $this->client = Client::find($id);
        $this->nom = $this->client->nom;
        $this->prenom = $this->client->prenom;
        $this->courriel = $this->client->courriel;
        $this->telephone = $this->client->telephone;
        $this->ddn = $this->client->ddn;
        $this->genre = $this->client->idGenre;
        $this->nomResponsable = $this->client->nomResponsable;
        $this->prenomResponsable = $this->client->prenomResponsable;
        $this->lienResponsable = $this->client->lienResponsable;
        $this->rue = $this->client->rue;
        $this->noCivique = $this->client->noCivique;
        $this->codePostal = $this->client->codePostal;
        $v = Ville::find($this->client->idVille);
        if ($v != null) {
            $this->ville = $v->nom;
            $this->idVille = $v->id;
        }
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'modifierClient');

    }

    public function desactiverClient($id)
    {
        $this->client = Client::find($id);
        $this->nom = $this->client->nom;
        $this->prenom = $this->client->prenom;
        $this->courriel = $this->client->courriel;
        $this->telephone = $this->client->telephone;
        $this->ddn = $this->client->ddn;
        $this->genre = $this->client->idGenre;
        $this->nomResponsable = $this->client->nomResponsable;
        $this->prenomResponsable = $this->client->prenomResponsable;
        $this->lienResponsable = $this->client->lienResponsable;
        $this->rue = $this->client->rue;
        $this->noCivique = $this->client->noCivique;
        $this->codePostal = $this->client->codePostal;
        $v = Ville::find($this->client->idVille);
        if ($v != null) {
            $this->ville = $v->nom;
            $this->idVille = $v->id;
        }
        $this->dispatch('open-modal', name: 'desactiverClient');

    }

    public function activerClient($id)
    {
        $this->client = Client::find($id);
        $this->nom = $this->client->nom;
        $this->prenom = $this->client->prenom;
        $this->courriel = $this->client->courriel;
        $this->telephone = $this->client->telephone;
        $this->ddn = $this->client->ddn;
        $this->genre = $this->client->idGenre;
        $this->nomResponsable = $this->client->nomResponsable;
        $this->prenomResponsable = $this->client->prenomResponsable;
        $this->lienResponsable = $this->client->lienResponsable;
        $this->rue = $this->client->rue;
        $this->noCivique = $this->client->noCivique;
        $this->codePostal = $this->client->codePostal;
        $v = Ville::find($this->client->idVille);
        if ($v != null) {
            $this->ville = $v->nom;
            $this->idVille = $v->id;
        }
        $this->dispatch('open-modal', name: 'activerClient');

    }

    public function desacClient()
    {

        Client::find($this->client->id)->update([
            'actif' => 0
        ]);

        $this->reset(['nom', 'prenom', 'courriel', 'telephone', 'ddn', 'genre', 'nomResponsable', 'prenomResponsable', 'lienResponsable', 'rue', 'noCivique', 'codePostal', 'ville']);
        $this->filtreClient();
        $this->villes = Ville::orderBy('nom', 'asc')->get();
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }
    public function actClient()
    {

        Client::find($this->client->id)->update([
            'actif' => 1
        ]);

        $this->reset(['nom', 'prenom', 'courriel', 'telephone', 'ddn', 'genre', 'nomResponsable', 'prenomResponsable', 'lienResponsable', 'rue', 'noCivique', 'codePostal', 'ville']);
        $this->filtreClient();
        $this->villes = Ville::orderBy('nom', 'asc')->get();
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function formAjout()
    {
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'ajouterClient');
        $this->reset(['nom', 'prenom', 'courriel', 'telephone', 'ddn', 'genre', 'nomResponsable', 'prenomResponsable', 'lienResponsable', 'rue', 'noCivique', 'codePostal', 'ville']);

    }

    public function updatedtelephone($value)
    {

        if (strlen($this->telephone) == 10) {
            $this->telephone = '(' . substr($this->telephone, 0, 3) . ') ' . substr($this->telephone, 3, 3) . '-' . substr($this->telephone, 6);

        }
    }

    public function updatedcodePostal($value)
    {

        if (strlen($this->codePostal) == 6) {
            $this->codePostal = '' . strtoupper(substr($this->codePostal, 0, 1)) . substr($this->codePostal, 1, 1) . strtoupper(substr($this->codePostal, 2, 1)) . ' ' . substr($this->codePostal, 3, 1) . strtoupper(substr($this->codePostal, 4, 1)) . substr($this->codePostal, 5, 1);

        }
    }

    public function consulterClient($id)
    {
        $this->client = Client::find($id);
        $this->idClient = $this->client->id;
        $this->nom = $this->client->nom;
        $this->prenom = $this->client->prenom;
        $this->courriel = $this->client->courriel;
        $this->telephone = $this->client->telephone;
        $this->ddn = $this->client->ddn;
        $g = Genre::find($this->client->idGenre);
        $this->genre = $g->nom;
        $this->nomResponsable = $this->client->nomResponsable;
        $this->prenomResponsable = $this->client->prenomResponsable;
        $this->lienResponsable = $this->client->lienResponsable;
        $this->rue = $this->client->rue;
        $this->noCivique = $this->client->noCivique;
        $this->codePostal = $this->client->codePostal;
        $v = Ville::find($this->client->idVille);
        if ($v != null) {
            $this->ville = $v->nom;
            $this->idVille = $v->id;
        }
        $this->dispatch('open-modal', name: 'consulterClient');

    }


    public function filtreClient()
    {
        $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
        $dossier = Dossier::select('idClient')->whereIn('id', $dossierPro);
        if ($this->filtreActif == 2) {
            $this->clients = Client::whereIn('id', $dossier)->where('nom', 'like', '%' . $this->filtreNom . '%')->where('prenom', 'like', '%' . $this->filtrePrenom . '%')->orderBy('nom', 'asc')->get();
        } else {
            $this->clients = Client::whereIn('id', $dossier)->where('nom', 'like', '%' . $this->filtreNom . '%')->where('prenom', 'like', '%' . $this->filtrePrenom . '%')->where('actif', '=', $this->filtreActif)->orderBy('nom', 'asc')->get();
        }
    }

}
