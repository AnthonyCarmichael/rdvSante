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
    public function render()
    {
        return view('livewire.gestion-transactions');
    }

    public function mount($transactions)
    {
        $this->transactions = $transactions;
        $this->remboursements = Transaction::where('idTypeTransaction', '=', '2')->get();
        $this->clients = Client::all();
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

        Transaction::create([
            'montant' => $this->transactionRembourse->montant,
            'dateHeure' => $Date,
            'idRdv' => $this->transactionRembourse->idRdv,
            'idTypeTransaction' => 2,
            'idMoyenPaiement' => $this->moyenPaiement,
            'idTransaction' => $this->transactionRembourse->id,
        ]);


        $this->transactions = Transaction::all();
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
        if ($this->filtrePeriode == 1) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '=', $Date)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date)->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $Date)->get();
                }
            }
        } else if ($this->filtrePeriode == 2) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonth())->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonth())->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subMonth())->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subMonth())->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $Date->subMonth())->get();
                }
            }
        } else if ($this->filtrePeriode == 3) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonths(2))->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonths(2))->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonths(2))->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subMonths(2))->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subMonths(2))->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $Date->subMonths(2))->get();
                }
            }
        } else if ($this->filtrePeriode == 4) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonths(5))->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonths(5))->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subMonths(5))->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subMonths(5))->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subMonths(5))->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $Date->subMonths(5))->get();
                }
            }
        } else if ($this->filtrePeriode == 5) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subYear())->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date->subYear())->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $Date)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subYear())->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $Date->subYear())->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $Date->subYear())->get();
                }
            }
        } else if ($this->filtrePeriode == 6) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->get();
                } else {
                    $this->transactions = Transaction::all();
                }
            }
        }
    }
}
