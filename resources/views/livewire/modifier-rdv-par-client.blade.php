
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
            <form wire:submit.prevent="modifierRdvClient">
                @switch ($modification)
                    @case(null)
                        <div class="p-5 bg-white rounded shadow-md">
                            <h2 class="text-lg font-bold text-center">Résumer de votre rendez-vous</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$oldDate->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$oldDate->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$oldRdv->service->nom}}</p>
                                <p class="mb-2"><b>Couts:</b> {{$service->prix}} $
                                    <?php $total =  $service->prix?>
                                    @foreach ($taxes as $taxe )
                                    + {{$taxe->nom}} {{number_format(($taxe->valeur /100) * $service->prix,2)}} $
                                    <?php $total += ($taxe->valeur /100) * $service->prix?>
                                    @endforeach
                                    =  {{number_format($total, 2)}} $
                                </p>
                                <p class="mb-2"><b>Professionnel:</b> {{$this->oldRdv->dossier->professionnels[0]->prenom}} {{$oldRdv->dossier->professionnels[0]->nom}}

                                    @foreach ($this->oldRdv->dossier->professionnels[0]->professions as $profession )
                                    , {{$profession->nom}}
                                    @endforeach
                                    </p>
                                <p class=""><b>Lieu:</b> {{$clinique->nom}}, {{$clinique->noCivique}} rue {{$clinique->rue}}, {{$clinique->ville->nom}}, {{$clinique->ville->province->nom}}, Canada {{$clinique->codePostal}}</p>
                            </div>

                            <div class="flex justify-center">

                                @if ($oldDate >= $now)
                                    <div class="flex justify-center">
                                        <button type="button" wire:click="modifierDate" class="px-4 py-2 m-2 mb-4 text-white rounded-full bg-orange-500 hover:bg-orange-700">
                                            Modifier la date
                                        </button>
                                    </div>

                                @else
                                    <p class="text-red-600">Vous ne pouvez pas modifier ce rendez-vous, car il est déjà passé</p>
                                @endif



                                <!--
                                <button type="button" wire:click="modifierDossier" class="px-4 py-2 m-2 mb-4 text-white rounded-full bg-orange-500 hover:bg-orange-700">
                                    Modifier le dossier
                                </button>
                                -->
                            </div>
                        </div>
                    @break
                    @case("date")
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

                                                <?php
                                                foreach ($datesArr as $date) {?>
                                                    <th class="">{{$date->isoFormat('ddd D')}}</th>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php
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

                                                ?>

                                                <!-- Gestion de l'aternance des couleurs dans l'agenda -->
                                                @if(($i %2)==0)
                                                    <tr class="bg-gray-100 text-center">

                                                @else
                                                    <tr class=" bg-gray-200 text-center">
                                                @endif

                                                <!-- colonne temps -->
                                                <td class=""><?php echo $selectedDateTime->format('H:i') ?></td>

                                                    <!-- colonne interactive de l'agenda -->
                                                    <?php

                                                        for ($j=0; $j <7; $j++) {
                                                            ?>
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
                                                            <?php
                                                            $selectedDateTime->modify('+1 day');
                                                        }
                                                        $selectedDateTime->modify('-7 day');
                                                    ?>
                                                </tr>


                                            <?php


                                                $totalMinutes = $service->duree + 15;

                                                $selectedDateTime->modify("+{$totalMinutes} minutes");
                                            }
                                            ?>

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
                    @case("confirmer")
                        <div class="p-5 bg-white rounded shadow-md">
                            <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                            <h2 class="text-lg font-bold text-center">Résumé</h2>
                            <div class="border-y py-6 mb-4">
                                <p class="mb-2"><b>Date:</b> {{$heureSelected->translatedFormat('l, d F Y')}}</p>
                                <p class="mb-2"><b>Heure:</b> {{$heureSelected->translatedFormat('H:i')}}</p>
                                <p class="mb-2"><b>Service:</b> {{$service->nom}}</p>
                                <p class="mb-2"><b>Couts:</b> {{$service->prix}} $
                                    <?php $total =  $service->prix?>
                                    @foreach ($taxes as $taxe )
                                    + {{$taxe->nom}} {{number_format(($taxe->valeur /100) * $service->prix,2)}} $
                                    <?php $total += ($taxe->valeur /100) * $service->prix?>
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
                                <p class="mb-2"><b>Service:</b> {{$service->nom}}</p>
                                <p class="mb-2"><b>Couts:</b> {{$service->prix}} $
                                    <?php $total =  $service->prix?>
                                    @foreach ($taxes as $taxe )
                                    + {{$taxe->nom}} {{number_format(($taxe->valeur /100) * $service->prix,2)}} $
                                    <?php $total += ($taxe->valeur /100) * $service->prix?>
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
