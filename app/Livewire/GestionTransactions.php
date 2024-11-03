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
    public function render()
    {
        return view('livewire.gestion-transactions');
    }

    public function mount()
    {
        $this->transactions = Transaction::where('idTypeTransaction', '=', '1')->get();
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
        #if ($this->filtrePeriode == 1) {
        if ($this->filtreClient != null) {
            $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
            $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
            $dossier = Dossier::select('id')->whereIn('id', $dossierPro)->where('idClient', '=', $client);
            $rdvs = Rdv::select('id')->whereIn('idDossier', $dossier)->get();
            if ($this->dateDebut != null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                }
            } else if ($this->dateDebut != null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->get();
                }
            }

        } else {
            $dossierPro = DossierProfessionnel::select('idDossier')->where('idProfessionnel', '=', Auth::user()->id);
            $dossier = Dossier::select('id')->whereIn('idDossier', $dossierPro);
            $rdvs = Rdv::select('id')->whereIn('idDossier', $dossier)->get();
            if ($this->dateDebut != null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                }
            } else if ($this->dateDebut != null && $this->dateFin != null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $this->dateDebut)->whereDate('dateHeure', '<=', $this->dateFin)->get();
                }
            } else if ($this->dateDebut == null && $this->dateFin == null) {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->get();
                }
            }

        }
        /*} else if ($this->filtrePeriode == 2) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $DernierMois)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $DernierMois)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $DernierMois)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $DernierMois)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $DernierMois)->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $DernierMois)->get();
                }
            }
        #} else if ($this->filtrePeriode == 3) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $TroisDernierMois)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $TroisDernierMois)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $TroisDernierMois)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $TroisDernierMois)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $TroisDernierMois)->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $TroisDernierMois)->get();
                }
            }
        #} else if ($this->filtrePeriode == 4) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $SixDernierMois)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $SixDernierMois)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $SixDernierMois)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $SixDernierMois)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $SixDernierMois)->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $SixDernierMois)->get();
                }
            }
        #} else if ($this->filtrePeriode == 5) {
            if ($this->filtreClient != null) {
                $client = Client::select('id')->whereRaw("CONCAT(`prenom`, ' ', `nom`) = ?", [$this->filtreClient]);
                $dossier = Dossier::select('id')->where('idClient', '=', $client);
                $rdvs = Rdv::select('id')->where('idDossier', '=', $dossier);
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $DerniereAnnee)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $DerniereAnnee)->get();
                } else {
                    $this->transactions = Transaction::whereIn('idRdv', $rdvs)->whereDate('dateHeure', '>=', $DerniereAnnee)->get();
                }
            } else {
                if ($this->filtreType == 1) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $DerniereAnnee)->get();
                } elseif ($this->filtreType == 2) {
                    $this->transactions = Transaction::where('idTypeTransaction', '=', $this->filtreType)->whereDate('dateHeure', '>=', $DerniereAnnee)->get();
                } else {
                    $this->transactions = Transaction::whereDate('dateHeure', '>=', $DerniereAnnee)->get();
                }
            }
        #} else if ($this->filtrePeriode == 6) {
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
        }*/
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
