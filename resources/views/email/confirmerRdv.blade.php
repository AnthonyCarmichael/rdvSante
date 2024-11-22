<x-mail::layout>

# Confirmation du rendez-vous avec {{$professionnel->prenom}} {{$professionnel->nom}}


Bonjour {{$rdv->client->prenom}},

Votre rendez-vous sera le **{{$dateHeureDebut->translatedFormat('l, d F Y')}}** à **{{$dateHeureDebut->translatedFormat('H:i')}}**.

Lieu du rendez-vous :
{{$rdv->clinique->noCivique}} {{$rdv->clinique->rue}}
{{$rdv->clinique->ville->nom}}, {{$rdv->clinique->ville->province->nom}}, {{$rdv->clinique->ville->province->pays->nom}}, {{$rdv->clinique->codePostal}}, {{$rdv->clinique->nom}}.


**Cout:** {{$rdv->service->prix}} $ + {{$tps->nom}} {{number_format(($tps->valeur/100)*$rdv->service->prix,2)}} $ + {{$tvq->nom}} {{number_format(($tvq->valeur/100)*$rdv->service->prix,2)}} $ = **{{$rdv->service->prix + number_format(($tps->valeur/100)*$rdv->service->prix,2) + number_format(($tvq->valeur/100)*$rdv->service->prix,2)}} $**

{{$professionnel->messagePersonnalise}}

{{$professionnel->prenom}} {{$professionnel->nom}} @foreach ($professionnel->professions as $profession ), {{$profession->nom}}
@endforeach

@component('mail::button', ['url' => $urlModif])
Modifier
@endcomponent

@component('mail::button', ['url' => $urlAnnuler])
Annuler
@endcomponent
Ma Clinique Générale

{{$professionnel->telephone}}, {{$professionnel->email}}


<x-slot:footer>
<x-mail::footer>
</x-mail::footer>
</x-slot:foot>

</x-mail::layout>

