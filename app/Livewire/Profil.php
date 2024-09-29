<?php

namespace App\Livewire;

use Livewire\Component;

class Profil extends Component
{
    public $view = 'AjouterService';

    public function setView($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.profil');
    }
}
