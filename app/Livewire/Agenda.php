<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Agenda extends Component
{
    public $view;
    public $startingDate;

    public function mount()
    {
        $this->view = "semaine";
        $this->startingDate = Carbon::now()->format('d-M-Y');
    }

    public function setView($view)
    {
        if ($view !== $this->view) {
            $this->view = $view;
            $this->startingDate = Carbon::now()->format('d-M-Y');
        }
    }

    public function render()
    {
        return view('livewire.agenda');
    }
}
