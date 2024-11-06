<?php

namespace App\Http\Controllers;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Clinique;
use App\Models\Rdv;
use App\Models\Service;
use App\Models\Ville;
use App\Models\Province;
use App\Models\Taxe;
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
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "num membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "date epiration membre"), 0, 1);
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
        $this->fpdf->Image('../public/img/'.strval(Auth::user()->signature), 150, 105, 20);

        $recu = new Recu($client, $rdv, $user, $clinique);
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
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "num membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "date epiration membre"), 0, 1);
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
        $this->fpdf->Image('../public/img/'.strval(Auth::user()->signature), 150, 105, 20);
        $recu = new Recu($client, $rdv, $user, $clinique);
        $recu->attachData($this->fpdf->Output('', 'S'), 'recu.pdf');
        Mail::to($client->courriel)
            ->send($recu);

        return back();
    }

    public function facture($client, $clinique, $rdv, $service)
    {
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC

        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage();
        $this->Header();
        $tps = Taxe::select('valeur')->where('nom', '=', 'tps')->get();
        $tvq = Taxe::select('valeur')->where('nom', '=', 'tvq')->get();
        #dd($tps);
        $user = User::find(Auth::user()->id);
        $client = Client::find($client);
        $rdv = Rdv::find($rdv);
        $clinique = Clinique::find($clinique);
        $service = Service::find($service);
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
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "num membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "date epiration membre"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->noCivique rue $clinique->rue"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$ville->nom, $province->nom"), 0, 1);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->codePostal"), 0, 1);
        $this->fpdf->Ln(10);
        $this->fpdf->SetX(30);
        $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "Nom du client : $client->prenom $client->nom"), 0, 1);
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
        $this->fpdf->Image('../public/img/'.strval(Auth::user()->signature), 150, 105, 20);

        $this->fpdf->Output('Recu.pdf', 'D');
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
            $this->fpdf->SetFont('Arial', 'B', 15);
            $this->fpdf->AddPage();
            $this->Header();
            $tps = Taxe::select('valeur')->where('nom', '=', 'tps')->get();
            $tvq = Taxe::select('valeur')->where('nom', '=', 'tvq')->get();
            $user = User::find(Auth::user()->id);
            $clinique = Clinique::find($r->idClinique);
            $service = Service::find($r->idService);
            $ville = Ville::find($clinique->idVille);
            $province = Province::find($ville->idProvince);
            $dateRdv = Carbon::parse($r->dateHeureDebut)->translatedFormat('l d F Y');
            $heureRdv = Carbon::parse($r->dateHeureDebut)->translatedFormat('H:m');
            $montantTps = round($service->prix * $tps->value('valeur') / 100, 2);
            $montantTvq = round($service->prix * $tvq->value('valeur') / 100, 2);
            $total = $service->prix + $montantTvq + $montantTps;
            $this->fpdf->SetFillColor(240, 240, 240);
            $this->fpdf->Rect(10, 25, 190, 110, true);
            $this->fpdf->Image('../public/img/logoRdvSante.png', 170, 28, 20);
            $this->fpdf->SetFont('Arial', '', 10);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$user->prenom $user->nom"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "membre"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "num membre"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "date epiration membre"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->nom"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->noCivique rue $clinique->rue"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$ville->nom, $province->nom"), 0, 1);
            $this->fpdf->Cell(10, 5, iconv('UTF-8', 'windows-1252', "$clinique->codePostal"), 0, 1);
            $this->fpdf->Ln(10);
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
            $this->fpdf->Image('../public/img/'.strval(Auth::user()->signature), 150, 105, 20);
        }

        $this->fpdf->Output('recu.pdf', 'D');
        exit;
    }
}
