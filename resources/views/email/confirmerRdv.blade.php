<x-mail::layout>

# Confirmation du rendez-vous avec {{$professionnel->prenom}} {{$professionnel->nom}}


Bonjour {{$rdv->client->prenom}},

Votre rendez-vous sera le {{$rdv->dateHeureDebut->translatedFormat('l, d F Y')}} à {{$rdv->dateHeureDebut->translatedFormat('H:i')}}

Lieu du rendez-vous :
{{$rdv->clinique->noCivique}} {{$rdv->clinique->rue}}
{{$rdv->clinique->ville->nom}}, {{$rdv->clinique->ville->province->nom}}, {{$rdv->clinique->ville->province->pays->nom}}, {{$rdv->clinique->codePostal}}
{{$rdv->clinique->nom}}


Merci de prendre le temps de lire ce courriel.

**IMPORTANT**

Il y aura maintenant un code à la porte d’entrée. Voici le code

5124


Pour la séance, pensez à vous apporter un top et un short de sport ainsi que des vêtements amples.

** Pour faciliter le paiement par virement interac, je vous invite à préparer à l'avance le virement avec ces informations:

    Au nom de: {{$professionnel->prenom}} {{$professionnel->nom}}
    À l'adresse: {{$professionnel->email}}
    Question de sécurité: Adresse
    Réponse: 6050

​** Par respect pour votre thérapeute et les autres client-es, merci d'annuler ou déplacer le rendez-vous au moins 24h à l'avance. Des frais de 40$ peuvent s’appliquer.

N'hésitez pas à me contacter en répondant à ce courriel pour toutes questions, inquiétudes, etc.

Au plaisir de vous accompagner !

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

