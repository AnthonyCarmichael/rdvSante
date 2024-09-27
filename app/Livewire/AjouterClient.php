<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Client;

use App\Models\Ville;

class AjouterClient extends Component
{
    public $clients;
    public $genres;
    public $villes;
    public $action;

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
        $this->clients = $clients;

        $this->genres = $genres;

        $this->villes = $villes;
    }

    protected function rules()
    {
        return [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'courriel' => 'required|email',
            'telephone' => 'required|regex:^[\][(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{4}$^',
            'ddn' => 'required',
            'genre' => 'required',
            'nomResponsable' => 'string|nullable',
            'prenomResponsable' => 'string|nullable',
            'lienResponsable' => 'string|nullable',
            'rue' => 'string|nullable',
            'noCivique' => 'numeric|nullable',
            'codePostal' => 'string|nullable|regex:/^[A-Z]\d[A-Z][ ]\d[A-Z]\d$/'
        ];
    }

    public function ajoutClient()
    {
        $villeFound = False;
        foreach ($this->villes as $v) {
            if ($this->ville == $v->nom) {
                $this->idVille = $v->id;
                $villeFound == True;
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
            $this->ville = null;
        }

        $this->validate();

        Client::create([
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
        $this->clients = Client::all();
        $this->villes = Ville::all();
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function getInfoClient($id)
    {
        $client = Client::where('id', '=', $id);
    }

}
