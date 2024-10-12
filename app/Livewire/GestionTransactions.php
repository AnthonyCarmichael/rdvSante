<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Client;

use App\Models\TypeTransaction;

use App\Models\MoyenPaiement;

use App\Models\Rdv;

use App\Models\Dossier;

class GestionTransactions extends Component
{
    public $transactions;
    public $clients;
    public $typeTransactions;
    public $moyenPaiement;
    public $rdvs;
    public $dossiers;
    public function render()
    {
        return view('livewire.gestion-transactions');
    }

    public function mount($transactions){
        $this->transactions = $transactions;
        $this->clients = Client::all();
        $this->typeTransactions = TypeTransaction::all();
        $this->moyenPaiement = MoyenPaiement::all();
        $this->rdvs = Rdv::all();
        $this->dossiers = Dossier::all();
    }
}
