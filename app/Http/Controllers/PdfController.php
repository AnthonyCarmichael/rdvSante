<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Pays;
use App\Models\User;
use App\Models\Dossier;
use App\Models\Transaction;
use App\Models\Clinique;
use App\Models\Rdv;
use App\Models\Service;
use App\Models\Profession;
use App\Models\Ville;
use App\Models\Province;
use App\Models\Taxe;
use App\Models\Organisation;
use App\Models\OrganisationProfessionnel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Recu;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PdfController extends Controller
{
    protected $fpdf;

    public function __construct()
    {
        $this->fpdf = new Fpdf;
    }

    function Header()
    {
        // Logo

        // Police Arial gras 15
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->SetFillColor(176, 217, 177);
        $this->fpdf->Rect(10, 10, 190, 15, true);
        // Titre
        $titre = iconv('UTF-8', 'windows-1252', 'Reçu');
        $this->fpdf->Cell(10, 15, $titre);
        // Saut de ligne
        $this->fpdf->Ln(20);
    }

    public function recuPaiement($client, $transaction, $clinique, $rdv, $service)
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC

        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage();
        $this->Header();
        $tps = Taxe::select('valeur')->where('nom', '=', 'tps')->get();
        $tvq = Taxe::select('valeur')->where('nom', '=', 'tvq')->get();

        $user = User::find(Auth::user()->id);
        $client = Client::find($client);
        $transaction = Transaction::find($transaction);
        $rdv = Rdv::find($rdv);
        $clinique = Clinique::find($clinique);
        $service = Service::find($service);
        $infoOrg = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $service->idProfessionService)->get();
        $organisation = Organisation::find($infoOrg[0]->idOrganisation);
        $profession = Profession::find($service->idProfessionService);
        $ville = Ville::find($clinique->idVille);
        $province = Province::find($ville->idProvince);
        $dateRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('l d F Y');
        $heureRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('H:m');
        $montantTps = round($service->prix * $tps->value('valeur') / 100, 2);
        $montantTvq = round($service->prix * $tvq->value('valeur') / 100, 2);
        $total = $service->prix + $montantTvq + $montantTps;
        $this->fpdf->SetFillColor(240, 240, 240);
        $this->fpdf->Rect(10, 25, 190, 110, true);
        $this->fpdf->Image('../public/img/logoRdvSante.png', 170, 28, 20);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$user->prenom $user->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Membre de : " . $organisation->nom), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Numéro de membre : " . $infoOrg[0]->numMembre), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Date d'expiration : " . $infoOrg[0]->dateExpiration), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->noCivique rue $clinique->rue"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$ville->nom, $province->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->codePostal"), 0, 1);
        $this->fpdf->Ln(10);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Nom du client : $client->prenom $client->nom"), 0, 1);
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Numéro du reçu : $transaction->id"), 0);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Date du rendez-vous : $dateRdv"), 0, 1);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Heure du rendez-vous : $heureRdv"), 0, 1);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Service : $service->nom"), 0, 1);
        $this->fpdf->SetX(150);
        $this->fpdf->SetFont('Arial', '', 20);
        $this->fpdf->SetTextColor(255, 0, 0);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "PAYÉ"), 0);
        $this->fpdf->SetX(30);
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Prix : $service->prix $"), 0, 1);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->SetX(40);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$montantTvq $ TVQ (TVQ $user->numTvq)"), 0, 1);
        $this->fpdf->SetX(40);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$montantTps $ TPS (TPS $user->numTps)"), 0, 1);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Total : $total $"), 0, 1);
        $this->fpdf->SetX(150);
        $this->fpdf->Image('../storage/app/public/' . Auth::user()->signature, 150, 110, 20);

        $recu = new Recu($client, $rdv, $user, $clinique, $profession);
        $recu->attachData($this->fpdf->Output('', 'S'), 'recu.pdf');
        Mail::to($client->courriel)
            ->send($recu);
        return back();
    }

    public function recuRemboursement($client, $transaction, $clinique, $rdv, $service)
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC

        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage();
        $this->Header();
        $tps = Taxe::select('valeur')->where('nom', '=', 'tps')->get();
        $tvq = Taxe::select('valeur')->where('nom', '=', 'tvq')->get();
        $user = User::find(Auth::user()->id);
        $client = Client::find($client);
        $transaction = Transaction::find($transaction);
        $rdv = Rdv::find($rdv);
        $clinique = Clinique::find($clinique);
        $service = Service::find($service);
        $infoOrg = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $service->idProfessionService)->get();
        $organisation = Organisation::find($infoOrg[0]->idOrganisation);
        $profession = Profession::find($service->idProfessionService);
        $ville = Ville::find($clinique->idVille);
        $province = Province::find($ville->idProvince);
        $dateRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('l d F Y');
        $heureRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('H:m');
        $montantTps = round($service->prix * $tps->value('valeur') / 100, 2);
        $montantTvq = round($service->prix * $tvq->value('valeur') / 100, 2);
        $total = $service->prix + $montantTvq + $montantTps;
        $this->fpdf->SetFillColor(240, 240, 240);
        $this->fpdf->Rect(10, 25, 190, 110, true);
        $this->fpdf->Image('../public/img/logoRdvSante.png', 170, 28, 20);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$user->prenom $user->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Membre de : " . $organisation->nom), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Numéro de membre : " . $infoOrg[0]->numMembre), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Date d'expiration : " . $infoOrg[0]->dateExpiration), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->noCivique rue $clinique->rue"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$ville->nom, $province->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->codePostal"), 0, 1);
        $this->fpdf->Ln(10);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Nom du client : $client->prenom $client->nom"), 0, 1);
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Numéro du reçu : $transaction->id"), 0);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Date du rendez-vous : $dateRdv"), 0, 1);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Heure du rendez-vous : $heureRdv"), 0, 1);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Service : $service->nom"), 0, 1);
        $this->fpdf->SetX(150);
        $this->fpdf->SetFont('Arial', '', 20);
        $this->fpdf->SetTextColor(255, 0, 0);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Remboursé"), 0);
        $this->fpdf->SetX(30);
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Prix : $service->prix $"), 0, 1);
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->SetX(40);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$montantTvq $ TVQ (TVQ $user->numTvq)"), 0, 1);
        $this->fpdf->SetX(40);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$montantTps $ TPS (TPS $user->numTps)"), 0, 1);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Total : $total $"), 0, 1);
        $this->fpdf->SetX(150);
        $this->fpdf->Image('../storage/app/public/' . Auth::user()->signature, 150, 110, 20);
        $recu = new Recu($client, $rdv, $user, $clinique, $profession);
        $recu->attachData($this->fpdf->Output('', 'S'), 'recu.pdf');
        Mail::to($client->courriel)
            ->send($recu);

        return back();
    }

    public function facture($client, $clinique, $rdv, $service)
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC

        $this->fpdf->SetFont('Helvetica', '', 20);
        $this->fpdf->AddPage();
        $this->fpdf->Ln(10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Ma Clinique Générale - Thérapeute du Local 8"), 0, 1);
        $tps = Taxe::select('valeur')->where('nom', '=', 'tps')->get();
        $tvq = Taxe::select('valeur')->where('nom', '=', 'tvq')->get();
        $user = User::find(Auth::user()->id);
        $client = Client::find($client);
        $rdv = Rdv::find($rdv);
        $clinique = Clinique::find($clinique);
        $service = Service::find($service);
        $infoOrg = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $service->idProfessionService)->get();
        $organisation = Organisation::find($infoOrg[0]->idOrganisation);
        $profession = Profession::find($service->idProfessionService);
        $ville = Ville::find($clinique->idVille);
        $province = Province::find($ville->idProvince);
        $pays = Pays::find($province->idPays);
        $dateRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('d-m-Y');
        $heureRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('H:m');
        $montantTps = round($service->prix * $tps->value('valeur') / 100, 2);
        $montantTvq = round($service->prix * $tvq->value('valeur') / 100, 2);
        $total = $service->prix + $montantTvq + $montantTps;
        $paye = 0;
        $transactions = Transaction::all();
        foreach ($transactions as $t) {
            if ($t->idRdv == $rdv->id) {
                if ($t->idTypeTransaction == 1) {
                    $paye += $t->montant;
                }
                if ($t->idTypeTransaction == 2) {
                    $paye -= $t->montant;
                }
            }
        }
        $solde = $total - $paye;
        #$this->fpdf->SetFillColor(240, 240, 240);
        #$this->fpdf->Rect(10, 25, 190, 110, true);
        $this->fpdf->Image('../public/img/logo.png', 170, 15, 20);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Ln(1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->noCivique rue $clinique->rue"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$ville->nom, $province->nom, $pays->nom, $clinique->codePostal"), 0, 1);
        $this->fpdf->Ln(10);

        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->SetTextColor(92, 152, 255);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Client"));
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Numéro de facture"), 0, 1, 'R');
        $this->fpdf->Ln(1);

        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetX(10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$client->prenom $client->nom"));
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$rdv->id"), 0, 1, 'R');

        $this->fpdf->SetTextColor(92, 152, 255);
        $this->fpdf->SetX(150);
        $this->fpdf->SetFont('Arial', '', 12);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Date de la facture"), 0, 1, 'R');
        $this->fpdf->Ln(1);
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->SetX(150);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$dateRdv"), 0, 1, 'R');

        $this->fpdf->Ln(10);
        $this->fpdf->SetX(10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Item / Description"));
        $this->fpdf->SetX(80);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Date du"), 0, 0, 'R');
        $this->fpdf->SetX(100);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Qté /"), 0, 0, 'R');
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Prix"), 0, 0, 'R');
        $this->fpdf->SetX(150);

        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Montant"), 0, 1, 'R');
        $this->fpdf->SetX(80);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "service"), 0, 0, 'R');
        $this->fpdf->SetX(100);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "durée"), 0, 0, 'R');
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "unitaire"), 0, 1, 'R');

        $this->fpdf->SetX(10);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$service->nom - $service->description"));
        $this->fpdf->SetX(80);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$dateRdv"), 0, 0, 'R');
        $this->fpdf->SetX(100);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "1"), 0, 0, 'R');
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$service->prix $"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$service->prix $"), 0, 1, 'R');

        $this->fpdf->Ln(10);
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Sous-total"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$service->prix $"), 0, 1, 'R');

        if ($solde == 0) {
            $this->fpdf->SetX(50);
            $this->fpdf->SetDrawColor(255, 145, 145);
            $this->fpdf->SetLineWidth(1);
            $this->fpdf->SetTextColor(255, 145, 145);
            $this->fpdf->SetFont('Arial', '', 40);
            $this->fpdf->Cell(60, 30, iconv('UTF-8', 'windows-1252', "PAYÉ"), 1, 0, 'C');
        }
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetTextColor(0, 0, 0);
        $this->fpdf->Ln(1);
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "TVQ(TPS $user->numTvq) " . round($tvq->value('valeur'), 3) . "%"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($montantTvq, 2) . "$"), 0, 1, 'R');

        $this->fpdf->Ln(1);
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "TPS(TPS $user->numTps) " . round($tps->value('valeur'), 3) . "%"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($montantTps, 2) . "$"), 0, 1, 'R');

        $this->fpdf->Ln(10);
        $this->fpdf->SetFont('Arial', '', 15);
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Total"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$total $"), 0, 1, 'R');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Payé"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($paye, 2) . "$"), 0, 1, 'R');

        $this->fpdf->Ln(5);
        $this->fpdf->SetFont('Arial', '', 15);
        $this->fpdf->SetX(120);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Solde"), 0, 0, 'R');
        $this->fpdf->SetX(150);
        $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($solde, 2) . "$"), 0, 1, 'R');

        $this->fpdf->Output("Facture-$rdv->id.pdf", 'D');
        /*$recu = new Recu($client, $rdv, $user, $clinique);
        $recu->attachData($this->fpdf->Output('', 'S'), 'recu.pdf');
        Mail::to($user->email)
            ->send($recu);*/

        return back();
    }

    public function factureTout($rdvs)
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC

        $rdvs = json_decode($rdvs);
        foreach ($rdvs as $r) {
            $this->fpdf->SetFont('Helvetica', '', 20);
            $this->fpdf->AddPage();
            $this->fpdf->Ln(10);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Ma Clinique Générale - Thérapeute du Local 8"), 0, 1);

            $tps = Taxe::select('valeur')->where('nom', '=', 'tps')->get();
            $tvq = Taxe::select('valeur')->where('nom', '=', 'tvq')->get();
            $user = User::find(Auth::user()->id);
            $clinique = Clinique::find($r->idClinique);
            $service = Service::find($r->idService);
            $dossier = Dossier::find($r->idDossier);
            $client = Client::find($dossier->idClient);
            $organisations = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->get();
            foreach ($organisations as $o) {
                $organisation = Organisation::find($o->idOrganisation);
                if ($organisation->idProfession == $service->idProfessionService) {
                    $infoOrg = OrganisationProfessionnel::find($o->id);
                    $organisation = Organisation::find($o->idOrganisation);
                    break;
                }
            }
            $ville = Ville::find($clinique->idVille);

            $province = Province::find($ville->idProvince);
            $pays = Pays::find($province->idPays);
            $dateRdv = Carbon::parse($r->dateHeureDebut)->translatedFormat('l d F Y');
            $heureRdv = Carbon::parse($r->dateHeureDebut)->translatedFormat('H:m');
            $montantTps = round($service->prix * $tps->value('valeur') / 100, 2);
            $montantTvq = round($service->prix * $tvq->value('valeur') / 100, 2);
            $total = $service->prix + $montantTvq + $montantTps;
            $paye = 0;
            $transactions = Transaction::all();
            foreach ($transactions as $t) {
                if ($t->idRdv == $r->id) {
                    if ($t->idTypeTransaction == 1) {
                        $paye += $t->montant;
                    }
                    if ($t->idTypeTransaction == 2) {
                        $paye -= $t->montant;
                    }
                }
            }
            $solde = $total - $paye;
            #$this->fpdf->SetFillColor(240, 240, 240);
            #$this->fpdf->Rect(10, 25, 190, 110, true);
            $this->fpdf->Image('../public/img/logo.png', 170, 15, 20);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Ln(1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->noCivique rue $clinique->rue"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$ville->nom, $province->nom, $pays->nom, $clinique->codePostal"), 0, 1);
            $this->fpdf->Ln(10);

            $this->fpdf->SetFont('Arial', '', 12);
            $this->fpdf->SetTextColor(92, 152, 255);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Client"));
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Numéro de facture"), 0, 1, 'R');
            $this->fpdf->Ln(1);

            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$client->prenom $client->nom"));
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$r->id"), 0, 1, 'R');

            $this->fpdf->SetTextColor(92, 152, 255);
            $this->fpdf->SetX(150);
            $this->fpdf->SetFont('Arial', '', 12);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Date de la facture"), 0, 1, 'R');
            $this->fpdf->Ln(1);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->SetX(150);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$dateRdv"), 0, 1, 'R');

            $this->fpdf->Ln(10);
            $this->fpdf->SetX(10);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Item / Description"));
            $this->fpdf->SetX(80);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Date du"), 0, 0, 'R');
            $this->fpdf->SetX(100);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Qté /"), 0, 0, 'R');
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Prix"), 0, 0, 'R');
            $this->fpdf->SetX(150);

            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Montant"), 0, 1, 'R');
            $this->fpdf->SetX(80);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "service"), 0, 0, 'R');
            $this->fpdf->SetX(100);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "durée"), 0, 0, 'R');
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "unitaire"), 0, 1, 'R');

            $this->fpdf->SetX(10);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$service->nom - $service->description"));
            $this->fpdf->SetX(80);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$dateRdv"), 0, 0, 'R');
            $this->fpdf->SetX(100);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "1"), 0, 0, 'R');
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$service->prix $"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$service->prix $"), 0, 1, 'R');

            $this->fpdf->Ln(10);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Sous-total"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$service->prix $"), 0, 1, 'R');

            if ($solde == 0) {
                $this->fpdf->SetX(50);
                $this->fpdf->SetDrawColor(255, 145, 145);
                $this->fpdf->SetLineWidth(1);
                $this->fpdf->SetTextColor(255, 145, 145);
                $this->fpdf->SetFont('Arial', '', 40);
                $this->fpdf->Cell(60, 30, iconv('UTF-8', 'windows-1252', "PAYÉ"), 1, 0, 'C');
            }
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetTextColor(0, 0, 0);
            $this->fpdf->Ln(1);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "TVQ(TPS $user->numTvq) " . round($tvq->value('valeur'), 3) . "%"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($montantTvq, 2) . "$"), 0, 1, 'R');

            $this->fpdf->Ln(1);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "TPS(TPS $user->numTps) " . round($tps->value('valeur'), 3) . "%"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($montantTps, 2) . "$"), 0, 1, 'R');

            $this->fpdf->Ln(10);
            $this->fpdf->SetFont('Arial', '', 15);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Total"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "$total $"), 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Payé"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($paye, 2) . "$"), 0, 1, 'R');

            $this->fpdf->Ln(5);
            $this->fpdf->SetFont('Arial', '', 15);
            $this->fpdf->SetX(120);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', "Solde"), 0, 0, 'R');
            $this->fpdf->SetX(150);
            $this->fpdf->Cell(37, 5, iconv('UTF-8', 'windows-1252', number_format($solde, 2) . "$"), 0, 1, 'R');

        }

        $this->fpdf->Output('factures.pdf', 'D');
        exit;
    }
}
