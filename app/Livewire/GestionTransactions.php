<?php

namespace App\Livewire;

use App\Models\Transaction;
use Livewire\Component;

use App\Models\Client;

use App\Models\TypeTransaction;

use App\Models\MoyenPaiement;

use App\Models\Rdv;

use App\Models\Dossier;

use Carbon\Carbon;

class GestionTransactions extends Component
{
    public $transactions;
    public $clients;
    public $typeTransactions;
    public $moyenPaiements;
    public $rdvs;
    public $dossiers;
    public $typeTransaction = 1;
    public $moyenPaiement = 1;
    public $transactionRembourse;
    public function render()
    {
        return view('livewire.gestion-transactions');
    }

    public function mount($transactions){
        $this->transactions = $transactions;
        $this->clients = Client::all();
        $this->typeTransactions = TypeTransaction::all();
        $this->moyenPaiements = MoyenPaiement::all();
        $this->rdvs = Rdv::all();
        $this->dossiers = Dossier::all();
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
            'typeTransaction' => 2,
            'idMoyenPaiement' => $this->moyenPaiement,
            'idTransaction' => $this->transactionRembourse->id,
        ]);



        $this->dispatch('close-modal');
        #exemple open modal dispatch
        #$this->dispatch('open-modal', name: 'modal-name');

    }

    public function formRemboursement($id)
    {
        $this->transactionRembourse = Transaction::find($id);
        $this->dispatch('open-modal', name: 'rembourserPaiement');
    }
}
