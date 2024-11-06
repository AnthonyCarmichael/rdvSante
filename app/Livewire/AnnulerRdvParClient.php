<?php


namespace App\Livewire;

use App\Mail\ConfirmerRdv;
use App\Models\Clinique;
use Carbon\Carbon;
use App\Models\Indisponibilite;
use App\Models\DossierProfessionnel;
use App\Models\Dossier;
use App\Models\Client;
use App\Models\Rdv;
use App\Models\Genre;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\User;
use App\Models\Service;

use Illuminate\Support\Str;

class AnnulerRdvParClient extends Component
{
    # Section 0
    public $step = 0;
    public $users;
    # Section 1
    public $professionnelId;
    # Section 2
    public $services;
    public $serviceId;
    # Section 3
    public $dispoDateArr;
    public $startingWeek;
    public $heureDebut;
    public $datesArr;
    public $heureSelected;

    public $dispoNotFounded;


    # Section 4

    public $newClient;
    public $lookDossier; # boolean
    public $dossiers;
    public $dossierSelected;

    # Section 5
    public $service;
    public $professionnel;
    public $clinique;
    public $pourmoi;
    public $genreId;
    public $ddn;
    public $telephoneClient;
    public $courrielClient;
    public $prenomClient;
    public $nomClient;
    public $prenomResponsable;
    public $nomResponsable;
    public $lienResponsable;

    # Modifier un rdv
    public $oldRdv;
    public $modification;
    public $oldDate;
    public $now;




    public function mount(Rdv $oldRdv){
        $this->now = Carbon::now(('America/Toronto'));
        $this->clinique = Clinique::find(1); # A changer pour clinique principal
        $this->users = User::all();

        if ($oldRdv->id !=null) {
            $this->oldRdv = $oldRdv;
            $this->oldDate = Carbon::parse($this->oldRdv->dateHeureDebut, 'America/Toronto');

            $this->lookDossier = true;

            $this->courrielClient= $this->oldRdv->client->courriel;
            $this->service =$this->oldRdv->service;
            $this->serviceId =$this->oldRdv->service->id;
            $this->professionnel = $this->oldRdv->dossier->professionnels[0];
            $this->professionnelId =$this->oldRdv->dossier->professionnels[0]->id;
            $this->dossierSelected =$this->oldRdv->dossier;

        }

    }


    public function sendConfirmedRdvMail($client,$rdv,$professionnel) {

        Mail::to($client->courriel)
            ->send(new ConfirmerRdv($rdv,$professionnel));
    }



    public function annuler(){
        dd();
        $token = Str::random(32);

        $rdv = Rdv::find($this->oldRdv->id);

        $rdv->dateHeureDebut = $this->heureSelected;
        $rdv->token = $token;
        $rdv->save();
        $this->sendConfirmedRdvMail($rdv->dossier->client,$rdv,$this->professionnel);
        $this->modification = "end";



    }

    public function render()
    {
        return view('livewire.annuler-rdv-par-client');
    }
}
