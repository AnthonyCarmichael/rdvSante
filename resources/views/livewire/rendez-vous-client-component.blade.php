
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
            <form wire:submit.prevent="rdvClient">
                @switch ($step)
                    @case(0)
                        <div class="p-5 bg-white rounded shadow-md">
                            <div class="flex justify-center">
                                <button type="button" wire:click="nextStep" class="px-4 py-2 mt-2 mb-4 text-white rounded-full bg-dark-green hover:bg-darker-green">
                                    Prendre rendez-vous
                            </button>
                            </div>
                        </div>
                    @break
                    @case(1)
                        <!-- Section 1 -->
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Sélectionnez un professionnel</h2>

                            @foreach($users as $user)
                                @if ($user->actif)
                                    <div class="flex border-y py-6 hover:bg-stone-200 cursor-pointer"  wire:click="getProfessionnelId({{ $user->id }})">
                                        <div class="">


                                            @if ($user->photoProfil)
                                                @php
                                                    $path = asset('storage/' . ($user->photoProfil) );
                                                    @endphp
                                                    <img src="{{ $path }}" alt="{{ $path  }}" class="w-[200px] mr-6">
                                            @else

                                                <img src="{{ asset('img/icone_'.$user->id.'.jpg') }}" alt="image{{$user->prenom}}"
                                                    class="w-[200px] mr-6">

                                            @endif

                                        </div>
                                        <div class="mx-4 self-center w-2/4">
                                            <div class="mb-8">
                                                <p class="inline ">{{$user->nom}} {{$user->prenom}}</p> @foreach($user->professions as $profession) <p class="inline">, {{$profession->nom}}</p> @endforeach
                                            </div>

                                            <p class="text-justify">
                                                {{$user->description}}
                                            </p>
                                        </div>

                                        <div>
                                            <p class="text-stone-300 self-center text-lg mr-4">></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @break
                    @case(2)
                        <!-- Section 2 -->
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="border-b text-lg font-bold text-center">Sélectionnez un service</h2>
                            <div class="">
                                @if($services->count()>0)
                                    @foreach($services as $service)
                                        <div class="border-b py-6 hover:bg-stone-200 cursor-pointer flex items-center place-content-between"  wire:click="getServiceId({{ $service->id }})">
                                            <div>
                                                <p class="mb-2"><b>Service:</b> {{$service->nom}}</p>
                                                @if($service->description != null)
                                                    <p class="mb-2"><b>Description:</b> {{$service->description}}</p>
                                                @endif
                                                <p class="mb-2"><b>Durée:</b> {{$service->duree}} min</p>
                                                <p><b>Prix:</b> {{$service->prix}} $</p>
                                            </div>
                                            <div>
                                                <p class="text-stone-300 self-center text-lg mr-4">></p>
                                            </div>

                                        </div>
                                    @endforeach

                                @else
                                    <p class="border-y py-6 mb-4">{{$professionnel->prenom}} {{$professionnel->nom}} n'offre aucun services pour le moment. Veuillez nous contacter pour plus d'information.</p>
                                @endif

                            </div>
                        </div>

                    @break
                    @case(3)
                        <!-- Section 3 -->
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Sélectionnez une heure</h2>
                            <p class="text-center">Cliquer sur une des heures proposées dans le calendrier</p>
                            <div class="border-y py-6">

                                @if($dispoNotFounded==false)
                                    <div class="flex justify-between">
                                        <button type="button" wire:click="changeWeek(-1)"><</button>
                                        <h3>{{$startingWeek->translatedFormat('F')}}</h3>
                                        <button type="button" wire:click="changeWeek(1)">></button>
                                    </div>

                                    <table class="table-fixed w-full text-sm text-stone-700 text-xs">
                                        <thead>
                                            <tr class="bg-stone-200">
                                                <!-- Titre col -->
                                                <th class="">Heure </th>

                                                
                                                @foreach ($datesArr as $date) 
                                                    <th class="">{{$date->isoFormat('ddd D')}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @php
                                            $selectedDateTime = $startingWeek->copy();
                                            $heureDispoInit = null;
                                            $heureDispoFin = null;

                                            foreach ($professionnel->disponibilites as $dispo) {
                                                if ($heureDispoInit >  $dispo->heureDebut || $heureDispoInit == null) {
                                                    $heureDispoInit =  $dispo->heureDebut;
                                                }
                                                if ($heureDispoFin <  $dispo->heureFin || $heureDispoFin == null) {
                                                    $heureDispoFin =  $dispo->heureFin;
                                                }

                                            }
                                            $heureDispoInit = \Carbon\Carbon::parse($heureDispoInit, 'America/Toronto');
                                            $heureDispoFin = \Carbon\Carbon::parse($heureDispoFin, 'America/Toronto');
                                            $selectedDateTime->setTime($heureDispoInit->hour,0,0);


                                            for ($i=0; $i < (($heureDispoFin->hour-$heureDispoInit->hour)*60)/($service->duree+15); $i++) {

                                                @endphp

                                                <!-- Gestion de l'aternance des couleurs dans l'agenda -->
                                                @if(($i %2)==0)
                                                    <tr class="bg-gray-100 text-center">

                                                @else
                                                    <tr class=" bg-gray-200 text-center">
                                                @endif

                                                <!-- colonne temps -->
                                                <td class="">@php echo $selectedDateTime->format('H:i'); @endphp</td>

                                                    <!-- colonne interactive de l'agenda -->
                                                    @php

                                                        for ($j=0; $j <7; $j++) {
                                                            @endphp
                                                            <!-- Cellule intéractible -->
                                                            <td class="">
                                                                <!-- verification cellule dispo -->
                                                                @if (!empty($dispoDateArr))

                                                                    @foreach ($dispoDateArr as $dispo)
                                                                        @if ($dispo == $selectedDateTime)
                                                                            <button class="w-full h-full bg-blue-500 text-white rounded"
                                                                                type="button"
                                                                                wire:click="choixDate('{{ $selectedDateTime }}')"
                                                                                value="{{$selectedDateTime}}"
                                                                                onclick="console.log(event.target.value);"
                                                                                onmouseover="document.querySelectorAll('button[value=\'{{$dispo}}\']').forEach(btn => btn.classList.add('hover-effect-blue'))"
                                                                                onmouseout="document.querySelectorAll('button[value=\'{{$dispo}}\']').forEach(btn => btn.classList.remove('hover-effect-blue'))">
                                                                                <span class="">{{$selectedDateTime->format('H:i')}}</span>
                                                                            </button>
                                                                            @break
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </td>
                                                            @php
                                                            $selectedDateTime->modify('+1 day');
                                                        }
                                                        $selectedDateTime->modify('-7 day');
                                                    @endphp
                                                </tr>


                                            @php


                                                $totalMinutes = $service->duree + 15;

                                                $selectedDateTime->modify("+{$totalMinutes} minutes");
                                            }
                                            @endphp

                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>

                                @else
                                    <p class="">{{$professionnel->prenom}} {{$professionnel->nom}} n'a aucune disponibilité pour les trois prochains mois, veuillez nous contacter pour plus d'informations.</p>
                                @endif

                            </div>

                        </div>
                    @break
                    @case(4)
                        <!-- Section 4 -->
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Résumé</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$heureSelected->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$heureSelected->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$service->nom}}</p>
                                <p class="mb-2"><b>Couts:</b> {{$service->prix}} $
                                    @php $total =  $service->prix;@endphp
                                    @foreach ($taxes as $taxe )
                                    + {{$taxe->nom}} {{number_format(($taxe->valeur /100) * $service->prix,2)}} $
                                    @php $total += ($taxe->valeur /100) * $service->prix; @endphp
                                    @endforeach
                                    =  {{number_format($total, 2)}} $
                                </p>
                                <p class="mb-2"><b>Professionnel:</b> {{$professionnel->prenom}} {{$professionnel->nom}}

                                    @foreach ($professionnel->professions as $profession )
                                    , {{$profession->nom}}
                                    @endforeach
                                    </p>
                                <p class=""><b>Lieu:</b> {{$clinique->nom}}, {{$clinique->noCivique}} rue {{$clinique->rue}}, {{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada {{$clinique->codePostal}}</p>
                            </div>

                            <h2 class="text-lg font-bold text-center">Avez-vous un dossier avec ce professionnel ?</h2>
                            <div class=" flex justify-center">
                                <button type="button" wire:click="lookingDossier('{{ true }}')" class="mt-4 mx-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Oui</button>
                                <button type="button" wire:click="nextStep" class="mt-4 mx-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Non</button>
                            </div>

                            <div>
                                @if ($lookDossier == true)
                                    <div class="mb-4">
                                        <label for="courrielClient" class="block text-sm font-medium text-gray-700">Courriel</label>
                                        <input required type="email" name="courrielClient" id="courrielClient"
                                            wire:model="courrielClient"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    <button type="button" wire:click="fetchDossier()" class="my-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Rechercher</button>
                                @endif

                                @if ($dossiers)
                                    <div class="border-y py-6 mb-4">
                                        @if ($dossiers->count() !== 0)
                                            <p>Est-ce que le rendez-vous est pour l'une de ces personnes ?</p>
                                            @foreach ($dossiers as $dossier)
                                                <button type="button"  wire:click="selectDossierClient({{$dossier}})" class="block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">{{$dossier->client->prenom}} {{$dossier->client->nom}}</button>
                                            @endforeach
                                            <button type="button" wire:click="nextStep" class="block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Autre</button>
                                        @else
                                            <p>Aucun dossier client n'a été trouvé associé à ce professionnel et cette adresse courriel</p>
                                        @endif
                                    </div>
                                @endif


                            </div>
                        </div>
                    @break
                    @case(5)
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Résumé</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$heureSelected->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$heureSelected->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$service->nom}}</p>
                                <p class="mb-2"><b>Couts:</b> {{$service->prix}} $
                                    @php $total =  $service->prix;@endphp
                                    @foreach ($taxes as $taxe )
                                    + {{$taxe->nom}} {{number_format(($taxe->valeur /100) * $service->prix,2)}} $
                                    @php $total += ($taxe->valeur /100) * $service->prix;@endphp
                                    @endforeach
                                    =  {{number_format($total, 2)}} $
                                </p>
                                <p class="mb-2"><b>Professionnel:</b> {{$professionnel->prenom}} {{$professionnel->nom}}

                                    @foreach ($professionnel->professions as $profession )
                                    , {{$profession->nom}}
                                    @endforeach
                                    </p>
                                <p class=""><b>Lieu:</b> {{$clinique->nom}}, {{$clinique->noCivique}} rue {{$clinique->rue}}, {{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada {{$clinique->codePostal}}</p>
                            </div>



                            @if ($dossierSelected)
                                <p>Veuillez confirmer la prise de rendez-vous pour <p class="font-bold">{{$dossierSelected->client->prenom}} {{$dossierSelected->client->nom}}</p></p>
                            @else
                                <fieldset class="mb-4">
                                    <legend class="text-sm font-bold mb-2">Informations de la personne qui recevera le traitement</legend>
                                    <div class="mb-4">
                                        <label for="prenomClient" class="block text-sm font-medium text-gray-700">Prénom *</label>
                                        <input required type="text" name="prenomClient" id="prenomClient"
                                            wire:model="prenomClient"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="mb-4">
                                        <label for="nomClient" class="block text-sm font-medium text-gray-700">nom *</label>
                                        <input required type="text" name="nomClient" id="nomClient"
                                            wire:model="nomClient"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="mb-4">
                                        <label for="courrielClient" class="block text-sm font-medium text-gray-700">Courriel *</label>
                                        <input required type="email" name="courrielClient" id="courrielClient"
                                            wire:model="courrielClient"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="mb-4">
                                        <label for="telephoneClient" class="block text-sm font-medium text-gray-700">Téléphone *</label>
                                        <input required type="text" name="telephoneClient" id="telephoneClient" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            wire:model.live="telephoneClient"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>

                                    <div class="mb-4">
                                        <label for="sexe" class="block text-sm font-medium text-gray-700">Sexe *</label>
                                        <select required name="sexe" id="sexe" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            wire:model="genreId">
                                            <option class="font-bold" value="">Sélectionnez une option</option>
                                            @foreach ($genres as $genre)
                                                <option value="{{$genre->id}}">{{$genre->nom}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="ddn" class="block text-sm font-medium text-gray-700">Date de naissance *</label>
                                        <input required type="date" name="ddn" id="ddn"  min='1899-01-01' max='{{date('Y-m-d')}}'
                                            wire:model="ddn"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                </fieldset>

                                <div class="mb-6">
                                    <div class="mb-2">
                                        <input type="radio" id="pourMoi" name="pourmoi" value="1" wire:model.live="pourmoi">
                                        <label for="pourMoi">Ce rendez-vous est pour moi</label>
                                    </div>

                                    <div>
                                        <input type="radio" id="pourAutre" name="pourmoi"  value="0" wire:model.live="pourmoi">
                                        <label for="pourAutre">Ce rendez-vous est pour mon enfant ou une personne à charge</label>
                                    </div>

                                </div>


                                @if ($pourmoi == false)

                                    <fieldset class="mb-6">
                                        <legend class="text-sm font-bold mb-2">Informations de la personne responsable</legend>
                                        <div class="mb-4">
                                            <label for="prenomResponsable" class="block text-sm font-medium text-gray-700">Prénom *</label>
                                            <input required type="text" name="prenomResponsable" id="prenomResponsable"
                                                wire:model="prenomResponsable"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>

                                        <div class="mb-4">
                                            <label for="nomResponsable" class="block text-sm font-medium text-gray-700">Nom *</label>
                                            <input required type="text" name="nomResponsable" id="nomResponsable"
                                                wire:model="nomResponsable"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div class="mb-4">
                                            <label for="nomResponsable" class="block text-sm font-medium text-gray-700">Lien entre le responsable et l'autre personne *</label>
                                            <input required type="text" name="nomResponsable" id="nomResponsable"
                                                wire:model="lienResponsable"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                    </fieldset>
                                @endif


                            @endif

                            <div class="mt-6">
                                <div class="flex justify-between">
                                    <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Confirmer</button>
                                </div>
                            </div>
                        </div>
                    @break
                    @case(6)
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="resetForm" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Merci d'avoir prix rendez-vous avec nous !</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$heureSelected->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$heureSelected->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$service->nom}}</p>
                                <p class="mb-2"><b>Couts:</b> {{$service->prix}} $
                                    @php $total =  $service->prix;@endphp
                                    @foreach ($taxes as $taxe )
                                    + {{$taxe->nom}} {{number_format(($taxe->valeur /100) * $service->prix,2)}} $
                                    @php $total += ($taxe->valeur /100) * $service->prix;@endphp
                                    @endforeach
                                    =  {{number_format($total, 2)}} $
                                </p>
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
