<?php

namespace App\Livewire;

use App\Models\ProfessionProfessionnel;
use App\Models\Profession;
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
    public $idProfession;
    public $idRole;
    public $stringProfession;
    public $selectedIdProfession;
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
        $this->idProfession = $user->professions()->get();
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
            'photoProfil' => 'image|mimes:jpg,jpeg,png|max:1024',
            'signature' => 'image|mimes:jpg,jpeg,png|max:1024',
        ]);

        $user = User::find(Auth::user()->id);

        if ($user) {
            $user->nom = $this->nom;
            $user->prenom = $this->prenom;
            $user->email = $this->email;
            $user->telephone = $this->telephone;

            ProfessionProfessionnel::where('user_id', $user->id)->delete();
            foreach ($this->selectedIdProfession as $profession) {
                $user->professions()->attach($profession);
            }

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

            if ($this->photoProfil) {
                $photoProfilPath = $this->photoProfil->storeAs('photos_profil', 'photoProfil' . $this->prenom . $this->nom . '.jpg', 'public');
                $user->photoProfil = $photoProfilPath;
            }

            if ($this->signature) {
                $signaturePath = $this->signature->storeAs('signatures', 'signature' . $this->prenom . $this->nom . '.jpg', 'public');
                $user->signature = $signaturePath;
            }

            $user->save();
            $this->idProfession = $user->professions()->get();

            session()->flash('message', 'Profil mis à jour avec succès.');
        }
    }

    public function activer()
    {
        $service = false;
        $clinique = false;
        $dispo = false;
        $profession = false;
        $photo = false;
        $signatureUser = false;

        $services = Service::all();
        $professionProfessionnel = ProfessionProfessionnel::all();
        $dispoProfessionnel = DiponibiliteProfessionnel::all();
        $cliniqueProfessionnel = CliniqueProfessionnel::all();

        foreach ($services as $s) {
            if ($s->idProfessionnel == Auth::user()->id) {
                $service = true;
            }
        }
        foreach ($professionProfessionnel as $p) {
            if ($p->user_id == Auth::user()->id) {
                $profession = true;
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

        if (!$photo || !$service || !$clinique || !$description || !$dispo || !$profession || !$signatureUser) {
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
