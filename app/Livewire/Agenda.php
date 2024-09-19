<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class Agenda extends Component
{
    public $view;
    public $now;
    public $startingDate;

    public function mount()
    {
        $this->view = "semaine";
        $this->now= Carbon::now();
        $this->startingDate = $this->now->modify('last week sunday');
    }

    public function setView($view)
    {
        if ($view !== $this->view) {
            $this->view = $view;
            #$start = new DateTime();
            #$this->startingDate = $start->modify('this week sunday');
        }
    }

    

    public function render()
    {
        return view('livewire.agenda');
    }
}
