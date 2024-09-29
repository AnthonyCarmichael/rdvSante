<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Compte extends Component
{
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $idProfession;
    public $idRole;

    public function mount()
    {
        $user = Auth::user();

        $this->nom = $user->nom;
        $this->prenom = $user->prenom;
        $this->email = $user->email;
        $this->telephone = $user->telephone;
        $this->idProfession = $user->idProfession;
        $this->idRole = $user->idRole;
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:15',
        ]);

        $user = Auth::user();
        $user->update([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'idProfession' => $this->idProfession,
            'idRole' => $this->idRole,
        ]);

        session()->flash('message', 'Profil mis à jour avec succès.');
    }

    public function render()
    {
        return view('livewire.compte');
    }
}
