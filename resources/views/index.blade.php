<?php
use App\Models\Service;
use App\Models\ProfessionProfessionnel;
use App\Models\DiponibiliteProfessionnel;
use App\Models\CliniqueProfessionnel;
use Illuminate\Support\Facades\Auth;
?>



<x-admin-layout>
    @if (session('success'))
        <div class="alert alert-success">
            <h3 class="center">{{ session('success') }}</h3>
        </div>
    @endif

    <div class="container mx-auto p-4">
        <h2 class="text-4xl font-bold mb-6">Bienvenue sur votre tableau de bord</h2>
    </div>
    @php

        $photo = false;
        $service = false;
        $clinique = false;
        $description = false;
        $dispo = false;
        $profession = false;

        $services = Service::all();
        $professionProfessionnel = ProfessionProfessionnel::all();
        $dispoProfessionnel = DiponibiliteProfessionnel::all();
        $cliniqueProfessionnel = CliniqueProfessionnel::all();

        foreach ($services as $s) {
            if ($s->idProfessionnel == Auth::user()->id) {
                $service = true;
            }
        }
        foreach ($professionProfessionnel as $p) {
           if ($p->user_id == Auth::user()->id) {
            $profession = true;
           }
        }
        foreach ($dispoProfessionnel as $d) {
           if ($d->id_user == Auth::user()->id) {
            $dispo = true;
           }
        }
        foreach ($cliniqueProfessionnel as $c) {
           if ($c->idProfessionnel == Auth::user()->id) {
            $clinique = true;
           }
        }
        if (Auth::user()->description != null) {
            $description = true;
        }
        if (file_exists("../public/img/icone_" . strval(Auth::user()->id) . ".jpg")) {
            $photo = true;
        }
    @endphp
    @if (!$photo || !$service || !$clinique || !$description || !$dispo || !$profession)
        <div class="container mx-auto p-4">
            <h3 class="text-2xl font-bold mb-6">Voici une liste de choses à faire pour officielement activé votre compte!
            </h3>
            <ul class="mx-auto p-4 text-xl">
                @if (!$photo)
                    <li class="list-disc">Envoyer une photo à l'administrateur pour l'ajouter à votre profil</li>
                @endif
                @if (!$profession)
                    <li class="list-disc">Ajouter au moins une profession à votre profil</li>
                @endif
                @if (!$service)
                    <li class="list-disc">Ajouter au moins un service</li>
                @endif
                @if (!$clinique)
                    <li class="list-disc">Ajouter au moins une clinique</li>
                @endif
                @if (!$description)
                    <li class="list-disc">Ajouter une description de vous à votre profil</li>
                @endif
                @if (!$dispo)
                    <li class="list-disc">Ajouter vos disponibilités dans l'onglet profil</li>
                @endif
            </ul>
        </div>
    @endif

</x-admin-layout>
