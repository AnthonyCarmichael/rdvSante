<?php

namespace App\Livewire;

use Livewire\Component;

class Profil extends Component
{
    public $view = 'Compte';

    public function setView($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.profil');
    }
}
