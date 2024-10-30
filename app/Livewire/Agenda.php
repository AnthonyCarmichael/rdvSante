<?php

namespace App\Livewire;

use App\Models\Indisponibilite;
use App\Models\Rdv;
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
    public $rdvArr;

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


        // Trouver le deuxième dimanche de mars de l'année en cours
        $secondSundayOfMarch = Carbon::create($this->now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

        // Calculer le premier dimanche de novembre
        $firstSundayOfNovember = Carbon::createFromDate($this->startingDate->year, 11, 1)->next(Carbon::SUNDAY);

        // Vérifiez si la date est entre ces deux dates
        if ($this->startingDate->greaterThanOrEqualTo($secondSundayOfMarch) && $this->startingDate->lessThan($firstSundayOfNovember)) {
            // Heure d'été (UTC - 4)
            // Pas besoin de changer ici, car nous gérons déjà le fuseau horaire avec 'America/Toronto'
            $this->startingDate->setTimezone('America/Toronto');
        } else {
            // Heure normale (UTC - 5)
            $this->startingDate->setTimezone('America/Toronto');
        }

        $this->startingDate->setTime(7, 0);
        
        $this->endingDate = $this->startingDate->copy()->modify('+6 days');
        
        $this->datesArr = [];
        for ($i=0; $i < 7; $i++) {
            $date = $this->startingDate->copy()->addDays($i);


            // Trouver le deuxième dimanche de mars de l'année en cours
            $secondSundayOfMarch = Carbon::create($this->now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

            // Calculer le premier dimanche de novembre
            $firstSundayOfNovember = Carbon::createFromDate($date->year, 11, 1)->next(Carbon::SUNDAY);

            // Vérifiez si la date est entre ces deux dates
            if ($date->greaterThanOrEqualTo($secondSundayOfMarch) && $date->lessThan($firstSundayOfNovember)) {
                // Heure d'été (UTC - 4)
                // Pas besoin de changer ici, car nous gérons déjà le fuseau horaire avec 'America/Toronto'
                $date->setTimezone('America/Toronto');
            } else {
                // Heure normale (UTC - 5)
                $date->setTimezone('America/Toronto');
            }
            $date->setTime(7, 0);
            $this->datesArr[] = $date;
        }


        $this->indispoArr = Indisponibilite::where('dateHeureFin', '>=', $this->startingDate)->get();
        $this->rdvArr = Rdv::where('dateHeureDebut', '>=', $this->startingDate)->get();
        #dd($this->rdvArr);
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

    public function openModalIndispo() {
        $this->dispatch('createIndispoModal', $this->selectedTime->format('Y-m-d H:i'));
    }

    public function openModalRdv(){
        $this->dispatch('createRdvModal', $this->selectedTime->format('Y-m-d H:i'));
    }

    public function consulterModalChoixRdvIndispo($selectedTime){

        $this->selectedTime = Carbon::parse($selectedTime);
        $this->dispatch('open-modal', name: 'choixRdvIndispo');
    }

    


    public function updateSelectedTime($newTime)
    {
        $this->selectedTime = $newTime;
        $this->dispatch('timeUpdated', ['time' => $this->selectedTime]);
    }

    public function refreshAgenda(){
        $this->indispoArr = [];
        $this->indispoArr = Indisponibilite::where('dateHeureFin', '>=', $this->startingDate)->get();
        $this->rdvArr = [];
        $this->rdvArr = Rdv::where('dateHeureDebut', '>=', $this->startingDate)->
            where('actif', true)->get();
        #dd($this);
    }

    public function fullRefresh($startingDate){
        if ($this->view == "semaine") {
            
            if ($startingDate->isSunday())
                $this->startingDate = $startingDate->copy();
            else
                $this->startingDate = $startingDate->copy()->modify('last sunday');

            // Trouver le deuxième dimanche de mars de l'année en cours
            $secondSundayOfMarch = Carbon::create($this->now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

            // Calculer le premier dimanche de novembre
            $firstSundayOfNovember = Carbon::createFromDate($this->startingDate->year, 11, 1)->next(Carbon::SUNDAY);

            // Vérifiez si la date est entre ces deux dates
            if ($this->startingDate->greaterThanOrEqualTo($secondSundayOfMarch) && $this->startingDate->lessThan($firstSundayOfNovember)) {
                // Heure d'été (UTC - 4)
                // Pas besoin de changer ici, car nous gérons déjà le fuseau horaire avec 'America/Toronto'
                $this->startingDate->setTimezone('America/Toronto');
            } else {
                // Heure normale (UTC - 5)
                $this->startingDate->setTimezone('America/Toronto');
            }
            $startingDate->setTime(7, 0);
            dd($this->startingDate);
            $this->endingDate = $this->startingDate->copy()->modify('+6 days');


            $this->datesArr = [];
            for ($i=0; $i < 7; $i++) {

                $date = $this->startingDate->copy()->addDays($i);

                // Trouver le deuxième dimanche de mars de l'année en cours
                $secondSundayOfMarch = Carbon::create($this->now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

                // Calculer le premier dimanche de novembre
                $firstSundayOfNovember = Carbon::createFromDate($date->year, 11, 1)->next(Carbon::SUNDAY);

                // Vérifiez si la date est entre ces deux dates
                if ($date->greaterThanOrEqualTo($secondSundayOfMarch) && $date->lessThan($firstSundayOfNovember)) {
                    // Heure d'été (UTC - 4)
                    // Pas besoin de changer ici, car nous gérons déjà le fuseau horaire avec 'America/Toronto'
                    $date->setTimezone('America/Toronto');
                } else {
                    // Heure normale (UTC - 5)
                    $date->setTimezone('America/Toronto');
                }
                $date->setTime(7, 0);
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

            // Trouver le deuxième dimanche de mars de l'année en cours
            $secondSundayOfMarch = Carbon::create($this->now->year, 3, 1)->next(Carbon::SUNDAY)->addWeek();

            // Calculer le premier dimanche de novembre
            $firstSundayOfNovember = Carbon::createFromDate($date->year, 11, 1)->next(Carbon::SUNDAY);

            // Vérifiez si la date est entre ces deux dates
            if ($date->greaterThanOrEqualTo($secondSundayOfMarch) && $date->lessThan($firstSundayOfNovember)) {
                // Heure d'été (UTC - 4)
                // Pas besoin de changer ici, car nous gérons déjà le fuseau horaire avec 'America/Toronto'
                $date->setTimezone('America/Toronto');
            } else {
                // Heure normale (UTC - 5)
                $date->setTimezone('America/Toronto');
            }


            $date->setTime(7, 0);
            $this->datesArr[] = $date;
        }
        $this->refreshAgenda();
        
    }

    public function consulterModalIndispo(Indisponibilite $indispo) {

        #dd($indispo);
        $this->dispatch('consulterModalIndispo', $indispo);
    }

    
    public function consulterModalRdv(Rdv $rdv) {

        #dd($indispo);
        $this->dispatch('consulterModalRdv', $rdv);
    }

    public function dateChanged()
    {
        #Vérifier si c'est encore utilisé pense pas tho
        Carbon::setLocale('fr_CA');
        $this->settingDate = Carbon::parse($this->settingDate);
        $this->settingDate->setTimezone('America/Toronto');
        $this->settingDate->addHours(4);
        $this->fullRefresh($this->settingDate->copy());
        $this->now = Carbon::now('America/Toronto');
    }


}
