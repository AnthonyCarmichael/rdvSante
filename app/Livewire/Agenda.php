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

    public $note;
    public $dateHeureDebut;
    public $dateHeureFin;

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


        $this->indispoArr = Indisponibilite::where('dateHeureDebut', '>=', $this->startingDate)->get();
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

    public function openModalIndispo($selectedTime) {
        #$this->updateSelectedTime($selectedTime);
        #dd($this->selectedTime);
        $this->selectedTime = $selectedTime;
        $this->dispatch('open-modal', name: 'ajouterIndisponibilite');
    }

    /*
    public function updateSelectedTime($newTime)
    {
        $this->selectedTime = $newTime;
        $this->dispatch('timeUpdated', ['time' => $this->selectedTime]);
    }
*/

    public function createIndisponibilite()
    {
        $this->validate([
            'note' => 'required|string',
            'dateHeureDebut' => 'required|date',
            'dateHeureFin' => 'required|date|after:dateHeureDebut',
        ]);

        Indisponibilite::create([
            'note' => $this->note,
            'dateHeureDebut' => $this->dateHeureDebut,
            'dateHeureFin' => $this->dateHeureFin,
            'idProfessionnel' => 1, # A changer!!
        ]);

        $this->reset(['note', 'dateHeureDebut', 'dateHeureFin']);
        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');
        $this->indispoArr = Indisponibilite::where('dateHeureDebut', '>=', $this->startingDate)->get();

    }

    public function consultIndispo() {

    }
}
