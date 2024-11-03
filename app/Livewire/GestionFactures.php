<?php

namespace App\Livewire;

use App\Models\Transaction;

use Livewire\Component;

use App\Models\Client;

use App\Models\Service;

use App\Models\TypeTransaction;

use App\Models\MoyenPaiement;

use App\Http\Controllers\PdfController;

use App\Models\Rdv;

use App\Models\Dossier;

use App\Models\DossierProfessionnel;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class GestionFactures extends Component
{
    public $transactions;
    public $services;
    public $remboursements;
    public $clients;
    public $typeTransactions;
    public $moyenPaiements;
    public $rdvs;
    public $dossiers;
    public $typeTransaction = 1;
    public $moyenPaiement = 1;
    public $transactionRembourse;
    public $filtreClient;
    public $filtrePeriode = 1;
    public $pdf;
    public $dateDebut;
    public $dateFin;
    public function render()
    {
        return view('livewire.gestion-factures');
    }

    public function mount()
    {
        $this->rdvs = Rdv::all();
        $this->transactions = Transaction::all();
        #$this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->get();
        $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
        $dossier = Dossier::select('idClient')->whereIn('id', $dossierPro);
        $this->clients = Client::whereIn('id', $dossier)->orderBy('nom', 'asc')->get();
        $this->services = Service::all();
        #$this->typeTransactions = TypeTransaction::all();
        #$this->moyenPaiements = MoyenPaiement::all();

        $this->dossiers = Dossier::all();

        $this->filtrePaiement();
    }

    public function remboursementPaiement()
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC
        $Date = Carbon::now('America/Toronto');

        Transaction::create([
            'montant' => $this->transactionRembourse->montant,
            'dateHeure' => $Date,
            'idRdv' => $this->transactionRembourse->idRdv,
            'idTypeTransaction' => 2,
            'idMoyenPaiement' => $this->moyenPaiement,
            'idTransaction' => $this->transactionRembourse->id,
        ]);


        $this->filtrePaiement();
        $this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->get();
        $this->dispatch('close-modal');

    }

    public function formRemboursement($id)
    {
        $this->transactionRembourse = Transaction::find($id);
        $this->dispatch('open-modal', name: 'rembourserPaiement');
    }

    public function filtrePaiement()
    {
        $demain = Carbon::now('America/Toronto')->addDay();
        /*$Date = Carbon::now('America/Toronto');
        $DernierMois = Carbon::now('America/Toronto')->startOfMonth();
        $TroisDernierMois = Carbon::now('America/Toronto')->startOfMonth()->subMonths(2);
        $SixDernierMois = Carbon::now('America/Toronto')->startOfMonth()->subMonths(5);
        $DerniereAnnee = Carbon::now('America/Toronto')->startOfYear();*/
        #if ($this->filtrePeriode == 1) {
        if ($this->filtreClient != null) {
            if ($this->dateDebut != null && $this->dateFin == null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('id', $dossierPro)->where('idClient', '=', $client);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '>=', $this->dateDebut)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else if ($this->dateDebut == null && $this->dateFin != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossierPro = DossierProfessionnel::select('id')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro)->where('idClient', '=', $client);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '<=', $this->dateFin)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else if ($this->dateDebut != null && $this->dateFin != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossierPro = DossierProfessionnel::select('id')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro)->where('idClient', '=', $client);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '>=', $this->dateDebut)->whereDate('dateHeureDebut', '<=', $this->dateFin)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else if ($this->dateDebut == null && $this->dateFin == null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('id', $dossierPro)->where('idClient', '=', $client);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '<', $demain)->get();
            }

        } else {
            if ($this->dateDebut != null && $this->dateFin == null) {
                $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '>=', $this->dateDebut)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else if ($this->dateDebut == null && $this->dateFin != null) {
                $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '<=', $this->dateFin)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else if ($this->dateDebut != null && $this->dateFin != null) {
                $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '>=', $this->dateDebut)->whereDate('dateHeureDebut', '<=', $this->dateFin)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else if ($this->dateDebut == null && $this->dateFin == null) {
                $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
                $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro);
                $this->rdvs = Rdv::whereIn('idDossier', $dossier)->whereDate('dateHeureDebut', '<', $demain)->get();
            }

        }
        /*} else if ($this->filtrePeriode == 2) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $DernierMois)->whereDate('dateHeureDebut', '<', $demain)->get();

            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $DernierMois)->whereDate('dateHeureDebut', '<', $demain)->get();

            }
            } else if ($this->filtrePeriode == 3) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $TroisDernierMois)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $TroisDernierMois)->whereDate('dateHeureDebut', '<', $demain)->get();

            }
            } else if ($this->filtrePeriode == 4) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $SixDernierMois)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $SixDernierMois)->whereDate('dateHeureDebut', '<', $demain)->get();

            }
            } else if ($this->filtrePeriode == 5) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $DerniereAnnee)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $DerniereAnnee)->whereDate('dateHeureDebut', '<', $demain)->get();

            }
            } else if ($this->filtrePeriode == 6) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '<', $demain)->get();
            } else {
                $this->rdvs = Rdv::whereDate('dateHeureDebut', '<', $demain)->get();
            }
             }*/
    }

}