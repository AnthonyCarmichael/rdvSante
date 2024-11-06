
<div class="text-sm text-gray-700 bg-stone-200 my-10 grid grid-cols-3 gap-6 p-6">
    <div class="bg-white rounded shadow-md p-6 ">
        <div class="">
            <img src="{{ asset('img/logo.png') }}" alt="logo clinique" class="w-[200px]">
            <h2 class="text-xl my-8">{{$clinique->nom}}</h2>
        </div>

        <div class=" border-y py-6">
            <h2 class="text-xl ">Adresse</h2>
            <p>{{$clinique->noCivique}}, Rue {{$clinique->rue}}</p>
            <p>{{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada</p>
            <p>{{$clinique->codePostal}}</p>

            <a class="text-blue-700" href="https://maps.app.goo.gl/wwRDWyAPtB29TSMv8" target="_blank">Google Map</a>
        </div>
        @foreach ($users as $user )

            @if($user->lien != null && $user->description != null)
                <div class="my-2 font-bold">
                    <p class="inline ">{{$user->prenom}} {{$user->nom}}</p> @foreach($user->professions as $profession) <p class="inline">, {{$profession->nom}}</p> @endforeach
                </div>

                <p class="text-justify mb-2">
                    {{$user->description}}
                </p>

                <a class="text-justify mb-4 text-blue-700" href="{{$user->lien}}" target="_blank">
                    En savoir plus
                </a>
            @endif

        @endforeach
    </div>
    <div class="col-span-2">
        <img class="" src="{{ asset('img/imgMassage.jpg') }}" alt="image massage">
        <div class="">
            <form wire:submit.prevent="annuler">
                @switch ($modification)
                    @case(null)
                        <div class="p-5 bg-white rounded shadow-md">
                            <h2 class="text-lg font-bold text-center">Résumer de votre rendez-vous</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$oldDate->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$oldDate->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$oldRdv->service->nom}} {{$oldRdv->service->prix}}$</p>
                                <p class="mb-2"><b>Professionnel:</b> {{$this->oldRdv->dossier->professionnels[0]->prenom}} {{$oldRdv->dossier->professionnels[0]->nom}}

                                    @foreach ($this->oldRdv->dossier->professionnels[0]->professions as $profession )
                                    , {{$profession->nom}}
                                    @endforeach
                                    </p>
                                <p class=""><b>Lieu:</b> {{$clinique->nom}}, {{$clinique->noCivique}} rue {{$clinique->rue}}, {{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada {{$clinique->codePostal}}</p>
                            </div>

                            @if ($oldDate >= $now)
                                <div class="flex justify-center">
                                    <button type="submit" class="px-4 py-2 m-2 mb-4 text-white rounded-full bg-orange-500 hover:bg-orange-700">
                                        Annuler le rendez-vous
                                    </button>
                                </div>

                            @else
                                <p class="text-red-600">Vous ne pouvez pas annuler ce rendez-vous, car il est déjà passé</p>
                            @endif

                        </div>
                    @break
                    @case("confirmer")
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Résumé</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$heureSelected->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$heureSelected->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$service->nom}} {{$service->prix}}$</p>
                                <p class="mb-2"><b>Professionnel:</b> {{$professionnel->prenom}} {{$professionnel->nom}}

                                    @foreach ($professionnel->professions as $profession )
                                    , {{$profession->nom}}
                                    @endforeach
                                    </p>
                                <p class=""><b>Lieu:</b> {{$clinique->nom}}, {{$clinique->noCivique}} rue {{$clinique->rue}}, {{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada {{$clinique->codePostal}}</p>
                            </div>



                            @if ($dossierSelected)
                                <p>Veuillez confirmer la prise de rendez-vous pour <p class="font-bold">{{$dossierSelected->client->prenom}} {{$dossierSelected->client->nom}}</p></p>
                            @endif

                            <div class="mt-6">
                                <div class="flex justify-between">
                                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Confirmer</button>
                                </div>
                            </div>
                        </div>
                    @break
                    @case("end")
                        <div class="p-5 bg-white rounded shadow-md">
                            <h2 class="text-lg font-bold text-center">Votre date de rendez-vous a bien été modifiée !</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$heureSelected->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$heureSelected->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$service->nom}} {{$service->prix}}$</p>
                                <p class="mb-2"><b>Professionnel:</b> {{$professionnel->prenom}} {{$professionnel->nom}}

                                    @foreach ($professionnel->professions as $profession )
                                    , {{$profession->nom}}
                                    @endforeach
                                    </p>
                                <p class=""><b>Lieu:</b> {{$clinique->nom}}, {{$clinique->noCivique}} rue {{$clinique->rue}}, {{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada {{$clinique->codePostal}}</p>
                            </div>
                            <p>Vous allez recevoir très bientôt un courriel de confirmation avec les informations du rendez-vous.</p>
                        </div>
                    @break
                @endswitch

            </form>
        </div>

    </div>

</div>
