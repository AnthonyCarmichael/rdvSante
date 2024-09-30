<?php

namespace App\Livewire;

use App\Models\ProfessionProfessionnel;
use App\Models\User;

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
        $this->idProfession = [$user->idProfession];
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

        $user = User::find(Auth::user()->id);

        if ($user) {
            $user->update([
                'nom' => $this->nom,
                'prenom' => $this->prenom,
                'email' => $this->email,
                'telephone' => $this->telephone,
                'idRole' => $this->idRole,
            ]);

            ProfessionProfessionnel::where('user_id', $user->id)->delete();

            foreach ($this->idProfession as $id) {
                ProfessionProfessionnel::create([
                    'idProfession' =>$id,
                    'user_id' => $user->id
                ]);
            }


            session()->flash('message', 'Profil mis à jour avec succès.');
        }
    }

    public function render()
    {
        return view('livewire.compte');
    }
}
