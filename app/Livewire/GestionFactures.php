<?php

namespace App\Livewire;

use App\Models\Transaction;

use Livewire\Component;

use App\Models\Client;
use App\Models\Profession;
use App\Models\Clinique;

use App\Models\Service;
use Illuminate\Support\Facades\Mail;

use App\Models\TypeTransaction;

use App\Models\MoyenPaiement;

use App\Http\Controllers\PdfController;

use App\Models\Rdv;

use App\Models\Dossier;

use App\Models\Taxe;

use App\Models\DossierProfessionnel;

use Carbon\Carbon;
use App\Mail\LienPaiement;
use App\Models\User;
use App\Listeners\StripeEventListener;

use Illuminate\Support\Facades\Auth;

class GestionFactures extends Component
{
    public $transactions;
    public $services;
    public $remboursements;
    public $clients;
    public $montant;
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
    public $tps;
    public $tvq;
    public $rdv;
    public $restePayer;
    public function render()
    {
        return view('livewire.gestion-factures');
    }

    public function mount()
    {
        $this->rdvs = Rdv::all();
        $this->transactions = Transaction::all();
        $this->moyenPaiements = MoyenPaiement::all();
        #$this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->get();
        $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
        $dossier = Dossier::select('idClient')->whereIn('id', $dossierPro);
        $this->clients = Client::whereIn('id', $dossier)->orderBy('nom', 'asc')->get();
        $this->services = Service::all();
        #$this->typeTransactions = TypeTransaction::all();
        #$this->moyenPaiements = MoyenPaiement::all();
        $this->tvq = Taxe::find(2);
        $this->tps = Taxe::find(1);
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

    }

    public function addPaiement($idRdv, $reste)
    {
        $this->restePayer = $reste;
        $this->rdv = Rdv::find($idRdv);
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

        Transaction::create([
            'montant' => $this->montant,
            'dateHeure' => $Date,
            'idRdv' => $this->rdv->id,
            'idTypeTransaction' => 1,
            'idMoyenPaiement' => $this->moyenPaiement

        ]);

        $dossier = Dossier::find($this->rdv->idDossier);
        $client = Client::find($dossier->idClient);
        $service = Service::find($this->rdv->idService);
        $user = User::find(Auth::user()->id);
        $clinique = Clinique::find($this->rdv->idClinique);
        $profession = Profession::find($service->idProfessionService);
        if ($this->moyenPaiement == 1) {
            $lienPaiement = new LienPaiement($service, $client, $this->rdv, $user, $profession, $clinique);
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
        file_put_contents(app()->environmentFilePath(), str_replace(
            "ID_RDV" . '=' . env("ID_RDV"),
            "ID_RDV" . '=' . $this->rdv->id,
            file_get_contents(app()->environmentFilePath())
        ));
        $this->transactions = Transaction::all();
        $this->dispatch('close-modal');
    }

}
