<?php

namespace App\Livewire;

use App\Mail\ConfirmerRdv;
use App\Models\Rdv;
use Livewire\Component;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\Service;
use App\Models\Dossier;
use App\Models\DossierProfessionnel;
use App\Models\MoyenPaiement;
use App\Models\Profession;
use App\Models\Taxe;
use App\Models\User;
use App\Models\Clinique;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\LienPaiement;

use Illuminate\Support\Str;

class RendezVousComponent extends Component
{
    public $rdv;
    public $selectedTime;
    public $clientSelected;
    public $clients;
    public $filter;
    public $serviceSelected;
    public $cliniqueSelected;
    public $formattedDate;
    public $formattedDateDebut;
    public $formattedDateFin;
    public $raison;
    public $moyenPaiements;
    public $moyenPaiement = 1;
    public $montant;
    public $dossiers;
    public $restePayer;

    # Facturation
    public $sousMenuConsult;
    public $taxes;







    protected $listeners = [
        'createRdvModal' => 'createRdvModal',
        'timeUpdated' => 'updateTime',
        'consulterModalRdv' => 'consulterModalRdv'
    ];


    public function mount()
    {
        $this->filter = '';
        $this->selectedTime = null;
        $this->clientSelected = null;
        $this->serviceSelected = null;
        $this->cliniqueSelected = null;
        $this->formattedDate = null;
        $this->formattedDateDebut = null;
        $this->formattedDateFin = null;
        $this->raison = null;
        $this->sousMenuConsult = null;
        $this->moyenPaiements = MoyenPaiement::all();

        $this->updatedFilter("");
    }


    public function createRdvModal($selectedTime)
    {

        $this->reset();
        $this->updatedFilter("");
        $this->selectedTime = $selectedTime;

        Carbon::setLocale('fr');
        $this->formattedDate = Carbon::parse($selectedTime);

        $this->formattedDate = $this->formattedDate->translatedFormat('l \l\e d F Y \à H:i');

        $this->dispatch('open-modal', name: 'ajouterRdv');

    }

    // Pour le filtre de recherche. Cette méthode est appelé à chaque fois que filter change. On peut costume la méthode pour par l'adapter aux besoins
    public function updatedFilter($value)
    {

        $this->clients = Client::select('id')->where(function ($query) {
            $query->where('actif', '1')
                ->where('nom', 'like', '%' . $this->filter . '%');
        })->orWhere(function ($query) {
            $query->where('actif', '1')
                ->where('prenom', 'like', '%' . $this->filter . '%');
        })->
            orderBy('prenom')->get();

        $dossiers = DossierProfessionnel::select('idDossier')->where('idProfessionnel', Auth::user()->id);
        #dd($this->clients);

        if (!is_null($this->clients))
            $this->clients = Dossier::whereIn('id', $dossiers)->whereIn('idClient', $this->clients)->get();
        #dd($this->clients);

    }


    public function createRdv()
    {

        $this->validate([
            'clientSelected' => 'required|exists:clients,id',
            'serviceSelected' => 'required|exists:services,id',
            'cliniqueSelected' => 'required|exists:cliniques,id',
            'raison' => 'nullable|string|max:255',
        ]);

        $dossier = Dossier::whereHas('professionnels', function ($query) {
            $query->where('idProfessionnel', Auth::user()->id);
        })
            ->where('idClient', $this->clientSelected)
            ->first();


        $rdv = Rdv::create([
            'dateHeureDebut' => $this->selectedTime,
            'idDossier' => $dossier->id,
            'idService' => $this->serviceSelected,
            'idClinique' => $this->cliniqueSelected,
            'raison' => $this->raison,
            'actif' => true,
        ]);


        $this->sendConfirmedRdvMail($rdv->dossier->client, $rdv, $rdv->service->professionnel, "confirmer");

        $this->reset();

        $this->dispatch('close-modal');

        $this->dispatch('refreshAgenda');

    }

    public function fetchServices()
    {
        $services = Service::where('idProfessionnel', Auth::user()->id)->
            orderBy('nom')->get();
        return $services;
    }

    public function render()
    {
        $clients = Client::where('actif', '1')
            ->orderBy('prenom')
            ->get();
        $cliniques = Auth::user()->cliniques;
        #dd($cliniques);
        $services = $this->fetchServices();
        $this->moyenPaiements = MoyenPaiement::all();
        return view('livewire.rendez-vous-component', [
            'services' => $services,
            'cliniques' => $cliniques,
        ]);
    }


    public function consulterModalRdv(Rdv $rdv)
    {
        $this->reset();
        $this->resetValidation();
        $this->updatedFilter("");

        $this->rdv = $rdv;
        $this->sousMenuConsult = "rdv";



        $this->clientSelected = $rdv->client->id;
        $this->serviceSelected = $rdv->service->id;
        $this->cliniqueSelected = $rdv->clinique->id;
        $this->raison = $rdv->raison;

        Carbon::setLocale('fr');
        $this->formattedDate = Carbon::parse($rdv->dateHeureDebut);
        $this->formattedDate = $this->formattedDate->translatedFormat('l \l\e d F Y');

        $this->formattedDateDebut = Carbon::parse($rdv->dateHeureDebut);
        $this->formattedDateDebut = $this->formattedDateDebut->translatedFormat('H:i');

        $this->formattedDateFin = Carbon::parse($rdv->dateHeureDebut)->addMinutes($rdv->service->duree);
        $this->formattedDateFin = $this->formattedDateFin->translatedFormat('H:i');

        $this->taxes = Taxe::all();
        $this->selectedTime = $rdv->dateHeureDebut;

        $this->dispatch('open-modal', name: 'consulterRdv');
        #dd($this);

    }

    public function annuler()
    {
        #$this->selectedTime = null;
        # Sert à rien à Revoir!!!
    }

    public function modifierRdv()
    {

        if (!$this->selectedDateCheckDispo()) {
            $this->addError('selectedDate', 'La date sélectionnée n\'est pas disponible.');
            return;
        }

        $this->validate([
            'clientSelected' => 'required|exists:clients,id',
            'serviceSelected' => 'required|exists:services,id',
            'cliniqueSelected' => 'required|exists:cliniques,id',
            'raison' => 'nullable|string|max:255',
        ], [
            'clientSelected.required' => 'Le client est requis.',
            'clientSelected.exists' => 'Le client sélectionné est invalide.',
            'serviceSelected.required' => 'Le service est requis.',
            'serviceSelected.exists' => 'Le service sélectionné est invalide.',
            'cliniqueSelected.required' => 'La clinique est requise.',
            'cliniqueSelected.exists' => 'La clinique sélectionnée est invalide.',
            'raison.max' => 'La raison ne peut pas dépasser 255 caractères.',
        ]);

        $rdv = Rdv::find($this->rdv->id);

        if ($rdv) {
            #$rdv->dateHeureDebut = $this->selectedTime;

            $dossier = Dossier::whereHas('professionnels', function ($query) {
                $query->where('idProfessionnel', Auth::user()->id);
            })
                ->where('idClient', $this->clientSelected)
                ->first();
            $rdv->idDossier = $dossier->id;

            $rdv->idService = $this->serviceSelected;

            $rdv->idClinique = $this->cliniqueSelected;
            $rdv->raison = $this->raison;
            $rdv->actif = true;
            $rdv->dateHeureDebut = $this->selectedTime;


            $token = Str::random(32);
            $rdv->token = $token;
            $rdv->save();
        } else {
            session()->flash('error', 'Rendez-vous non trouvée.');
        }

        $this->sendConfirmedRdvMail($rdv->dossier->client, $rdv, $rdv->service->professionnel, "confirmer");
        $this->reset();
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');
        $this->consulterModalRdv($rdv);


    }

    public function deleteRdv()
    {
        $rdv = $this->rdv;

        if ($this->rdv->transactions()->exists()) {
            dd("Gestion du remboursement lors de la tentative de suppression d'un rdv ayant des paiement éffectué à compléter"); // As tester et gèrer
        } else {
            $deleted = Rdv::destroy($this->rdv->id);
            $this->resetExcept('clients');
        }
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');

        $this->sendConfirmedRdvMail($rdv->dossier->client, $rdv, $rdv->service->professionnel, "annuler");
    }

    public function changeSousMenu($sousMenu)
    {
        $this->sousMenuConsult = $sousMenu;
    }

    public function addPaiement($reste)
    {
        $this->restePayer = $reste;
        $this->dispatch('open-modal', name: 'ajouterPaiement');
    }

    public function ajoutPaiement()
    {
        $this->validate([
            'montant' => 'required',
        ], [
            'montant.required' => 'Veuillez entrer un montant.',
        ]);

        $Date = Carbon::now('America/Toronto');


        $dossier = Dossier::find($this->rdv->idDossier);
        $client = Client::find($dossier->idClient);
        $service = Service::find($this->rdv->idService);
        $user = User::find(Auth::user()->id);
        $clinique = Clinique::find($this->rdv->idClinique);
        $profession = Profession::find($service->idProfessionService);
        if ($this->moyenPaiement == 1) {
            $stripe = new \Stripe\StripeClient('sk_test_51QLRk0G8MNDQfBDwRqTNqHUZSEmqRHPJJwWOb90PfAnEVd6Vrr3S857Z3boV4kv0ZBdwQHQEbFuRw1IbRyIiYUDa005h9SywCD');

            $lienStripe = $stripe->paymentLinks->create([
                'line_items' => [
                    [
                        'price' => $service->prixStripe,
                        'quantity' => 1,
                    ],

                ],
                'metadata' => [
                    'idRdv' => $this->rdv->id
                ],
            ]);
            $lienPaiement = new LienPaiement($service, $client, $this->rdv, $user, $profession, $clinique, $lienStripe->url );
            Mail::to($client->courriel)
                ->send($lienPaiement);
        } else {
            Transaction::create([
                'montant' => $this->montant,
                'dateHeure' => $Date,
                'idRdv' => $this->rdv->id,
                'idTypeTransaction' => 1,
                'idMoyenPaiement' => $this->moyenPaiement
            ]);
        }
        $this->dispatch('close-modal');
        $this->dispatch('refreshAgenda');
        $this->consulterModalRdv($this->rdv);
        $this->sousMenuConsult = 'facture';
    }


    public function sendConfirmedRdvMail($client, $rdv, $professionnel, $raison)
    {

        $tps = Taxe::where('nom', 'TPS')->first();
        $tvq = Taxe::where('nom', 'TVQ')->first();

        Mail::to($client->courriel)
            ->send(new ConfirmerRdv($rdv, $professionnel, $tps, $tvq, $raison));
    }


    public function selectedDateCheckDispo()
    {

        $dispo = true;

        $debut = Carbon::parse($this->selectedTime);


        $fin = $debut->copy()->addMinutes($this->rdv->service->duree);
        if ($debut->hour < 7 || $fin->hour > 22) {
            $dispo = false;
            return $dispo;
        }

        $result = Auth::user()->rdvs()
            ->whereDate('dateHeureDebut', $debut) // Compare uniquement la date (sans l'heure)
            ->get();

        foreach ($result as $rdv) {
            if ($rdv->id != $this->rdv->id) {
                $dateFinRdv = Carbon::parse($rdv->dateHeureDebut)->addMinutes($rdv->service->duree);
                if (($rdv->dateHeureDebut < $fin && $dateFinRdv > $debut)) {
                    $dispo = false;
                    break;
                }
            }

        }
        return $dispo;
    }



}
