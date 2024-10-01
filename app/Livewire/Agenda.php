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

    public $indispoArr;

    public $settingDate;

    protected $listeners = ['refreshAgenda' => 'refreshAgenda'];


    public function mount()
    {
        $this->view = "semaine";
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC
        $this->now = Carbon::now('America/Toronto');

        if ($this->now->isSunday())
            $this->startingDate = $this->now->copy();
        else
            $this->startingDate = $this->now->copy()->modify('last sunday');

        $this->startingDate->setTime(7, 0);
        $this->endingDate = $this->startingDate->copy()->modify('+6 days');
        
        $this->datesArr = [];
        for ($i=0; $i < 7; $i++) {
            $date = $this->startingDate->copy()->addDays($i);
            $this->datesArr[] = $date;
        }


        $this->indispoArr = Indisponibilite::where('dateHeureFin', '>=', $this->startingDate)->get();
        #dd($this->startingDate);
    }

    public function setView($view)
    {
        Carbon::setLocale('fr_CA');
        $this->now = Carbon::now('America/Toronto');
        $this->view = $view;
        $this->fullRefresh($this->now->copy());
    }
    public function render()
    {
        return view('livewire.agenda');
    }

    public function openModalIndispo($selectedTime) {
        $date = Carbon::parse($selectedTime);
        $this->dispatch('createIndispoModal', $date->format('Y-m-d H:i'));

    }


    public function updateSelectedTime($newTime)
    {
        $this->selectedTime = $newTime;
        $this->dispatch('timeUpdated', ['time' => $this->selectedTime]);
    }

    public function refreshAgenda(){
        $this->indispoArr = [];
        $this->indispoArr = Indisponibilite::where('dateHeureFin', '>=', $this->startingDate)->get();
    }

    public function fullRefresh($startingDate){
        if ($this->view == "semaine") {
            
            if ($startingDate->isSunday())
                $this->startingDate = $startingDate->copy();
            else
                $this->startingDate = $startingDate->copy()->modify('last sunday');
            $startingDate->setTime(7, 0);
            $this->endingDate = $this->startingDate->copy()->modify('+6 days');


            $this->datesArr = [];
            for ($i=0; $i < 7; $i++) {

                $date = $this->startingDate->copy()->addDays($i);
                $this->datesArr[] = $date;

            }

            $this->indispoArr = Indisponibilite::where('dateHeureFin', '>=', $this->startingDate)->get();

        } elseif ($this->view == "mois") {
            $this->startingDate = $startingDate->copy()->firstOfMonth();
            $this->endingDate = $startingDate->copy()->lastOfMonth();
            $this->datesArr = [];

            for ($i = 0; $i < $startingDate->daysInMonth; $i++) {
                $date = $this->startingDate->copy()->addDays($i);
                $this->datesArr[] = $date;
            }
        }
    }

    public function changeStartingDate($days) {
        $this->startingDate->addDays($days);
        $this->endingDate->addDays($days);

        $this->datesArr = [];
        for ($i=0; $i < 7; $i++) {

            $date = $this->startingDate->copy()->addDays($i);
            $this->datesArr[] = $date;
        }
        $this->refreshAgenda();
    }

    public function consulterModalIndispo(Indisponibilite $indispo) {

        #dd($indispo);
        $this->dispatch('consulterModalIndispo', $indispo);
    }

    public function dateChanged()
    {
        $this->settingDate = Carbon::parse($this->settingDate);
        #dd($this->settingDate);
        $this->fullRefresh($this->settingDate);
        
    }

}
