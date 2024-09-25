<?php

namespace App\Livewire;

use App\Models\Indisponibilite;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class Agenda extends Component
{
    public $view;
    public $now;
    public $startingDate;
    public $endingDate;
    public $datesArr;
    public $selectedTime;

    public function mount()
    {
        $this->view = "semaine";
        Carbon::setLocale('fr_CA');


        // Obtenir l'heure actuelle en UTC
        $this->now = Carbon::now('UTC');

        $this->now->setTimezone('America/Toronto');

        $this->startingDate = $this->now->copy()->modify('last sunday');
        $this->endingDate = $this->startingDate->copy()->modify('+6 days');


        $this->datesArr = [];
        for ($i=0; $i < 7; $i++) {

            $date = $this->startingDate->copy()->addDays($i);
            $this->datesArr[] = $date;

        }
    }

    public function setView($view)
    {
        $this->view = $view;

        if ($this->view == "semaine") {
            $this->startingDate = $this->now->copy()->modify('this week sunday');
            $this->endingDate = $this->startingDate->copy()->modify('+6 days');
            $this->datesArr = [];

            for ($i = 0; $i < 7; $i++) {
                $date = $this->startingDate->copy()->addDays($i);
                $this->datesArr[] = $date;
            }

        } elseif ($this->view == "mois") {
            $this->startingDate = $this->now->copy()->firstOfMonth();
            $this->endingDate = $this->now->copy()->lastOfMonth();
            $this->datesArr = [];

            for ($i = 0; $i < $this->now->daysInMonth; $i++) {
                $date = $this->startingDate->copy()->addDays($i);
                $this->datesArr[] = $date;
            }
        }
    }
    public function render()
    {
        return view('livewire.agenda');
    }
    
    public function createIndispoModal($selectedTime) {
        $this->selectedTime = Carbon::createFromFormat('Y-m-d H:i', $selectedTime);
        #dd($this->selectedTime);
        $this->dispatch('open-modal', name: 'ajouterIndisponibilite');
    }
}
