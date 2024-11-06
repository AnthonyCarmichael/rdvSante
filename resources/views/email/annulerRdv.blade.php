<x-mail::layout>

# Annulation du rendez-vous avec {{$professionnel->prenom}} {{$professionnel->nom}}


Bonjour {{$rdv->client->prenom}},

Ce rendez-vous à été annuler: **{{$dateHeureDebut->translatedFormat('l, d F Y')}}** à **{{$dateHeureDebut->translatedFormat('H:i')}}**.

Lieu du rendez-vous :
{{$rdv->clinique->noCivique}} {{$rdv->clinique->rue}}
{{$rdv->clinique->ville->nom}}, {{$rdv->clinique->ville->province->nom}}, {{$rdv->clinique->ville->province->pays->nom}}, {{$rdv->clinique->codePostal}}, {{$rdv->clinique->nom}}.

N'hésitez pas à me contacter en répondant à ce courriel pour toutes questions, inquiétudes, etc.

Au plaisir de vous accompagner !

{{$professionnel->prenom}} {{$professionnel->nom}} @foreach ($professionnel->professions as $profession ), {{$profession->nom}}
@endforeach


Ma Clinique Générale

{{$professionnel->telephone}}, {{$professionnel->email}}


<x-slot:footer>
<x-mail::footer>
</x-mail::footer>
</x-slot:foot>

</x-mail::layout>

