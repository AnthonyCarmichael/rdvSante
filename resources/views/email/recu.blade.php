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
    <h2>Reçu d'assurance</h2>
    <p>Bonjour {{ $client->prenom }}, </p>
    <p>Votre reçu pour votre rendez-vous avec {{ $user->prenom }} {{ $user->nom }} le {{ $dateRdv }} à
        {{ $heureRdv }} est attaché à ce courriel.</p>
    <p>{{ $user->prenom }} {{ $user->nom }}, {{$profession->nom}}</p>
    <p> {{ $clinique->nom }} </p>
    <p> {{ $user->telephone }} {{ $user->email }} </p>
</body>

</html>
