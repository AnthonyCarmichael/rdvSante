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

use Carbon\Carbon;

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
    public function render()
    {
        return view('livewire.gestion-factures');
    }

    public function mount()
    {
        $this->rdvs = Rdv::all();
        $this->transactions = Transaction::all();
        #$this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->get();
        $this->clients = Client::all();
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
        $Date = Carbon::now('America/Toronto');
        $DernierMois = Carbon::now('America/Toronto')->startOfMonth();
        $TroisDernierMois = Carbon::now('America/Toronto')->startOfMonth()->subMonths(2);
        $SixDernierMois = Carbon::now('America/Toronto')->startOfMonth()->subMonths(5);
        $DerniereAnnee = Carbon::now('America/Toronto')->startOfYear();
        if ($this->filtrePeriode == 1) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $Date)->get();

            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $Date)->get();

            }
        } else if ($this->filtrePeriode == 2) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $DernierMois)->get();

            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $DernierMois)->get();

            }
        } else if ($this->filtrePeriode == 3) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $TroisDernierMois)->get();
            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $TroisDernierMois)->get();

            }
        } else if ($this->filtrePeriode == 4) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $SixDernierMois)->get();
            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $SixDernierMois)->get();

            }
        } else if ($this->filtrePeriode == 5) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->whereDate('dateHeureDebut', '>=', $DerniereAnnee)->get();
            } else {

                $this->rdvs = Rdv::whereDate('dateHeureDebut', '>=', $DerniereAnnee)->get();

            }
        } else if ($this->filtrePeriode == 6) {
            if ($this->filtreClient != null) {
               $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $this->rdvs = Rdv::where('idDossier', '=', $dossier)->get();
            } else {
                $this->rdvs = Rdv::all();
            }
        }
    }

    public function envoiRecu($client, $transaction, $clinique, $rdv, $service)
    {
        $pdf = new PdfController;
        $t = Transaction::find($transaction);
        if ($t->idTypeTransaction == 1) {
            $pdf->recuPaiement($client, $transaction, $clinique, $rdv, $service);
        } elseif ($t->idTypeTransaction == 2) {
            $pdf->recuRemboursement($client, $transaction, $clinique, $rdv, $service);
        }

    }
}
