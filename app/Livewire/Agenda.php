<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Agenda extends Component
{

    public function render()
    {
        return view('livewire.agenda')->layout('layouts.admin');
    }
}
