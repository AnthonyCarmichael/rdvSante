<html lang="fr">

<head>
    <meta charset="utf-8">
</head>
<?php
use Carbon\Carbon;
$dateRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('l d F Y');
$heureRdv = Carbon::parse($rdv->dateHeureDebut)->translatedFormat('H:m');
?>

<body>
    <h2>Lien Stripe pour le paiement de votre rendez-vous</h2>
    <p>Bonjour {{ $client->prenom }}, </p>
    <p>Voici le lien de paiement Stripe pour votre rendez-vous avec {{ $user->prenom }} {{ $user->nom }} le
        {{ $dateRdv }} à
        {{ $heureRdv }}.</p>
    <p> {{ $service->lienStripe }} </p>
    <p>{{ $user->prenom }} {{ $user->nom }}, {{ $profession->nom }}</p>
    <p> {{ $clinique->nom }} </p>
    <p> {{ $user->telephone }} {{ $user->email }} </p>
</body>

</html>
