<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Service;
use App\Models\DiponibiliteProfessionnel;
use App\Models\CliniqueProfessionnel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class Compte extends Component
{
    use WithFileUploads;

    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $idRole;
    public $actif;
    public $lien;
    public $description;
    public $photoProfil;
    public $signature;
    public $numTvq;
    public $numTps;


    public function mount()
    {
        $user = Auth::user();

        $this->nom = $user->nom;
        $this->prenom = $user->prenom;
        $this->email = $user->email;
        $this->telephone = $user->telephone;
        $this->idRole = $user->idRole;
        $this->actif = $user->actif;
        $this->lien = $user->lien;
        $this->description = $user->description;
        $this->photoProfil = $user->photoProfil;
        $this->signature = $user->signature;
        $this->numTvq = $user->numTvq;
        $this->numTps = $user->numTps;

    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|regex:^\(\d{3}\)\s\d{3}-\d{4}^',
        ], [
            'nom.required' => 'Le champ nom est obligatoire.',
            'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
            'nom.max' => 'Le champ nom ne doit pas dépasser 255 caractères.',

            'prenom.required' => 'Le champ prénom est obligatoire.',
            'prenom.string' => 'Le champ prénom doit être une chaîne de caractères.',
            'prenom.max' => 'Le champ prénom ne doit pas dépasser 255 caractères.',

            'email.required' => 'Le champ email est obligatoire.',
            'email.email' => 'Le champ email doit être une adresse email valide.',
            'email.max' => 'Le champ email ne doit pas dépasser 255 caractères.',

            'telephone.required' => 'Le champ téléphone est obligatoire.',
            'telephone.regex' => 'Le champ téléphone doit être au format (123) 456-7890.',
        ]);

        $user = User::find(Auth::user()->id);

        if ($user) {
            $user->nom = $this->nom;
            $user->prenom = $this->prenom;
            $user->email = $this->email;
            $user->telephone = $this->telephone;

            $user->lien = $this->lien;
            $user->description = $this->description;
            $user->numTvq = $this->numTvq;
            $user->numTps = $this->numTps;

            /*if ($this->photoProfil) {
                $filename = 'photoProfil' . $this->prenom . $this->nom . '.jpg';
                $path = $this->photoProfil->storeAs('public/img/photos_profil', $filename);

                $user->photoProfil = Storage::url($path);
            }

            if ($this->signature) {
                $filename = 'signature' . $this->prenom . $this->nom . '.jpg';
                $path = $this->signature->storeAs('public/img/signatures', $filename);

                $user->signature = Storage::url($path);
            }*/

            if ($this->photoProfil != "") {
                $photoProfilPath = $this->photoProfil->storeAs('photos_profil', 'photoProfil' . $this->prenom . $this->nom . '.png', 'public');
                $user->photoProfil = $photoProfilPath;
            }

            if ($this->signature != "") {
                $signaturePath = $this->signature->storeAs('signatures', 'signature' . $this->prenom . $this->nom . '.png', 'public');
                $user->signature = $signaturePath;
            }

            $user->save();

            session()->flash('message', 'Profil mis à jour avec succès.');
        }
    }

    public function updatedtelephone($value) {

        if (strlen($this->telephone) == 10) {
            $this->telephone = '('.substr($this->telephone, 0, 3).') '.substr($this->telephone, 3, 3).'-'.substr($this->telephone, 6);
        }
    }

    public function activer()
    {
        $service = false;
        $clinique = false;
        $dispo = false;
        $photo = false;
        $signatureUser = false;

        $services = Service::all();
        $dispoProfessionnel = DiponibiliteProfessionnel::all();
        $cliniqueProfessionnel = CliniqueProfessionnel::all();

        foreach ($services as $s) {
            if ($s->idProfessionnel == Auth::user()->id) {
                $service = true;
            }
        }
        foreach ($dispoProfessionnel as $d) {
            if ($d->id_user == Auth::user()->id) {
                $dispo = true;
            }
        }
        foreach ($cliniqueProfessionnel as $c) {
            if ($c->idProfessionnel == Auth::user()->id) {
                $clinique = true;
            }
        }

        if (Auth::user()->description != null) {
            $description = true;
        }

        /*if (file_exists(strval($this->photoProfil))) {
            $photo = true;
        }*/

        if ($this->photoProfil && Storage::exists('public/' . $this->photoProfil)) {
            $photo = true;
        }

        if ($this->signature && Storage::exists('public/' . $this->signature)) {
            $signature = true;
        }

        if (!$photo || !$service || !$clinique || !$description || !$dispo || !$signatureUser) {
            session()->flash('message', 'Impossible d\'activer votre compte. Vérifier que toutes les conditions mentionner à l\'acceuil sont remplies.');
        } else {
            User::find(Auth::user()->id)->update([
                'actif' => 1,
            ]);
            $this->actif = 1;
        }
        #dd(Auth::user()->actif);
    }

    public function desactiver()
    {
        User::find(Auth::user()->id)->update([
            'actif' => 0,
        ]);

        $this->actif = 0;
    }

    public function render()
    {
        return view('livewire.compte');
    }
}
