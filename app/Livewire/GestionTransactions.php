<?php

namespace App\Livewire;

use App\Models\Transaction;

use Livewire\Component;

use App\Models\Client;

use App\Models\TypeTransaction;

use App\Models\MoyenPaiement;

use App\Http\Controllers\PdfController;

use App\Models\Rdv;

use App\Models\Dossier;

use App\Models\DossierProfessionnel;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class GestionTransactions extends Component
{
    public $transactions;
    public $remboursements;
    public $clients;
    public $typeTransactions;
    public $moyenPaiements;
    public $rdvs;
    public $dossiers;
    public $typeTransaction = 1;
    public $moyenPaiement = 1;
    public $transactionRembourse;
    public $filtreType = 1;
    public $filtreClient;
    public $filtrePeriode = 1;
    public $pdf;
    public $dateDebut;
    public $dateFin;
    public $envoiCourriel = false;
    public function render()
    {
        return view('livewire.gestion-transactions');
    }

    public function mount()
    {
        $this->envoiCourriel = false;
        $this->transactions = Transaction::where('idTypeTransaction', '=', '1')->orderBy('dateHeure', 'desc')->get();
        $this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->get();
        $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
        $dossier = Dossier::select('idClient')->whereIn('id', $dossierPro);
        $this->clients = Client::whereIn('id', $dossier)->orderBy('nom', 'asc')->get();
        $this->typeTransactions = TypeTransaction::all();
        $this->moyenPaiements = MoyenPaiement::all();
        $this->rdvs = Rdv::all();
        $this->dossiers = Dossier::all();

        $this->filtrePaiement();
    }

    public function remboursementPaiement()
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC
        $Date = Carbon::now('America/Toronto');


        if ($this->transactionRembourse->idMoyenPaiement == 1) {
            $stripe = new \Stripe\StripeClient(Auth::user()->cleStripe);
            $stripe->refunds->create(['payment_intent' => $this->transactionRembourse->paymentIntent]);
        }

        Transaction::create([
            'montant' => $this->transactionRembourse->montant,
            'dateHeure' => $Date,
            'idRdv' => $this->transactionRembourse->idRdv,
            'idTypeTransaction' => 2,
            'idMoyenPaiement' => $this->moyenPaiement,
            'idTransaction' => $this->transactionRembourse->id,
        ]);

        $this->envoiCourriel = false;
        $this->filtrePaiement();
        $this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->orderBy('dateHeure', 'desc')->get();
        $this->dispatch('close-modal');

    }

    public function formRemboursement($id)
    {
        $this->envoiCourriel = false;
        $this->transactionRembourse = Transaction::find($id);
        $this->moyenPaiement = $this->transactionRembourse->idMoyenPaiement;
        $this->dispatch('open-modal', name: 'rembourserPaiement');
    }

    public function filtrePaiement()
    {
        $Date = Carbon::now('America/Toronto');
        $DernierMois = Carbon::now('America/Toronto')->startOfMonth();
        $TroisDernierMois = Carbon::now('America/Toronto')->startOfMonth()->subMonths(2);
        $SixDernierMois = Carbon::now('America/Toronto')->startOfMonth()->subMonths(5);
        $DerniereAnnee = Carbon::now('America/Toronto')->startOfYear();
        #if ($this->filtrePeriode == 1) {
        if ($this->filtreClient != null) {
            $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
            $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
            $dossier = Dossier::select('id')->whereIn('id', $dossierPro)->where('idClient', '=', $client);
            $rdvs = Rdv::select('id')->whereIn('idDossier', $dossier)->get();
            if ($this->dateDebut != null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->orderBy('dateHeure', 'desc')->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                }
            } else if ($this->dateDebut != null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->orderBy('dateHeure', 'desc')->get();
                }
            }

        } else {
            $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
            $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro);
            $rdvs = Rdv::select('id')->whereIn('idDossier', $dossier)->get();
            if ($this->dateDebut != null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->orderBy('dateHeure', 'desc')->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                }
            } else if ($this->dateDebut != null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->orderBy('dateHeure', 'desc')->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->orderBy('dateHeure', 'desc')->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->orderBy('dateHeure', 'desc')->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->orderBy('dateHeure', 'desc')->get();
                }
            }

        }
        $this->envoiCourriel = false;
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
        $this->envoiCourriel = true;

    }
}
