
<div class="">

    <!-- Affichage de la vue sélectionnée -->
    <div class="w-full text-gray-800">
        @if($view === 'semaine')
            <!-- TEST GIT HOSTPAPA -->
            <!-- Affichage de la vue semaine -->
             <div class="flex w-full bg-mid-green border-solid border-2 border-gray-600 mb-1 mt-1 font-bold text-center justify-between">
                <button wire:click="changeStartingDate(-7)"
                    class="text-xl ml-6 hover:text-white"><</button>
                <p class="">{{$startingDate->translatedFormat('d F')}} au {{$endingDate->translatedFormat('d F Y')}} </p>
                <button wire:click="changeStartingDate(7)"
                    class="text-xl mr-6 hover:text-white">></button>
             </div>

            <table class="border-solid border-2 border-gray-600 table-fixed w-full text-sm text-darker-green">
                <thead>
                    <tr class="bg-mid-green">
                        <!-- Titre col -->
                        <th class="border-solid border-2 border-gray-600">Heure </th>

                        @foreach ($datesArr as $date) 
                            <th class="{{ $date->isSameDay($now) ? ' bg-blue-400' : '' }} border-solid border-2 border-gray-600">{{$date->isoFormat('ddd D')}}</th>
                        @endforeach 
                    </tr>
                </thead>
                <tbody>

                    @php
                    $selectedDateTime = $startingDate->copy();
                    $selectedDateTime->setTime(7, 0, 0);

                    for ($i=0; $i < 180; $i++) {
                        if ($i % 6 == 0) {
                            $rowColor = ($i / 6) % 2 == 0 ? 'bg-green-100' : 'bg-mid-green'; // Alterne les couleurs toutes les 30 minutes
                        }

                        @endphp

                        <!-- Gestion de l'aternance des couleurs dans l'agenda -->
                        <tr class=" {{$rowColor}} text-center">

                        <!-- colonne temps -->
                        @if ($selectedDateTime->minute % 30 == 0)
                            <td class="border-solid border-r-2 border-gray-600 text-xs text-[8px] leading-tight" rowspan="6">
                                <p class="block ">
                                    @php echo $selectedDateTime->format('H:i');@endphp
                                </p>
                                <p class="block ">
                                    @php echo $selectedDateTime->copy()->addMinutes(30)->format('H:i');@endphp
                                </p>
                            </td>
                        @endif
                            <!-- colonne interactive de l'agenda -->
                            @php

                                for ($j=0; $j <7; $j++) {
                                    $findIndispo = false;
                                    @endphp
                                    <!-- Cellule intéractible -->
                                    <td class="relative border-r-2 border-gray-600">
                                        <!-- verification cellule indispo -->
                                        @if (!empty($indispoArr))
                                            @foreach ($indispoArr as $indispo)
                                                @if ($indispo->dateHeureDebut <= $selectedDateTime && $indispo->dateHeureFin > $selectedDateTime )

                                                    <button class=" {{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(5) ? 'border-t-2 border-blue-700' : ' '  }} absolute top-0 left-0 w-full h-full bg-orange-500 "
                                                        wire:click="consulterModalIndispo({{$indispo}})"
                                                        value="indispo{{$indispo->id}}"
                                                        onclick="console.log(event.target.value);"
                                                        onmouseover="document.querySelectorAll('button[value=\'indispo{{$indispo->id}}\']').forEach(btn => btn.classList.add('hover-effect-orange'))"
                                                        onmouseout="document.querySelectorAll('button[value=\'indispo{{$indispo->id}}\']').forEach(btn => btn.classList.remove('hover-effect-orange'))">
                                                    </button>
                                                    @php $findIndispo = true;@endphp
                                                    @break
                                                @endif
                                            @endforeach

                                        @endif

                                        <!-- verification cellule rdv -->
                                        @if (!empty($rdvArr))
                                            @foreach ($rdvArr as $rdv)

                                                @php
                                                    $debut = \Carbon\Carbon::parse($rdv->dateHeureDebut);
                                                @endphp
                                                @if ($debut <= $selectedDateTime && $debut->copy()->addMinutes($rdv->service->duree) > $selectedDateTime)

                                                    <button class=" {{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(5) ? 'border-t-2 border-blue-700' : ' ' }} absolute top-0 left-0 w-full h-full bg-blue-500 "
                                                        wire:click="consulterModalRdv({{$rdv}})"
                                                        value="rdv{{$rdv->id}}"
                                                        onclick="console.log(event.target.value);"
                                                        onmouseover="document.querySelectorAll('button[value=\'rdv{{$rdv->id}}\']').forEach(btn => btn.classList.add('hover-effect-blue'))"
                                                        onmouseout="document.querySelectorAll('button[value=\'rdv{{$rdv->id}}\']').forEach(btn => btn.classList.remove('hover-effect-blue'))">
                                                        @if ($debut == $selectedDateTime)

                                                            <div class="text-left text-[8px] absolute top-1 left-1 text-white z-10 ">
                                                                <p class="leading-tight block">{{$rdv->client->prenom}} {{$rdv->client->nom}}</p>
                                                                <p class="leading-tight block">Début : {{$debut->format('H:i')}}</p>
                                                                <p class="leading-tight block">Fin : {{$debut->copy()->addMinutes($rdv->service->duree)->format('H:i')}}</p>
                                                                @php

                                                                    $totalPaiement = 0;
                                                                    $totalFacture= round($rdv->service->prix + ($taxes[0]->valeur/100 *$rdv->service->prix)+ ($taxes[1]->valeur/100 *$rdv->service->prix),2);
                                                                @endphp
                                                                @foreach ($rdv->transactions as $transaction )

                                                                    @php
                                                                        if($transaction->idTypeTransaction == 2){
                                                                            $totalPaiement += ( -1 * $transaction->montant);
                                                                        } else {
                                                                            $totalPaiement += ( 1 * $transaction->montant);
                                                                        }
                                                                        $totalPaiement = round($totalPaiement,2);

                                                                    @endphp

                                                                @endforeach

                                                                @if ( $totalPaiement < $totalFacture)
                                                                    <p class="leading-tight block text-red-400 text-sm">Pas payé</p>
                                                                @elseif ($totalPaiement == $totalFacture)
                                                                    <p class="leading-tight block text-green text-sm">Payé {{$totalPaiement}}</p>
                                                                @elseif ($totalPaiement > $totalFacture)
                                                                    <p class="leading-tight block text-red-400 text-sm">Trop payé</p>
                                                                @endif

                                                            </div>

                                                        @endif

                                                    </button>

                                                    @php $findIndispo = true;@endphp
                                                    @break
                                                @endif
                                            @endforeach

                                        @endif




                                        @if ($findIndispo != true)

                                            <button type="button" wire:click="consulterModalChoixRdvIndispo('@php echo $selectedDateTime;@endphp')"
                                                class="tooltip {{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(5) ? 'border-t-2 border-blue-700' : ' ' }} absolute top-0 left-0 w-full h-full hover:bg-blue-400">
                                                <span class="tooltiptext">{{$selectedDateTime->format('H:i')}}</span>
                                            </button>

                                        @endif


                                    </td>
                                    @php
                                    $selectedDateTime->modify('+1 day');
                                }
                                $selectedDateTime->modify('-7 day');
                            @endphp
                        </tr>


                    @php
                        $selectedDateTime->modify('+5 minutes');
                    }
                    @endphp

                </tbody>
                <tfoot>

                </tfoot>
            </table>

        @elseif($view === 'mois')
            <!-- Affichage de la vue mois -->
            <p>Vue Mois NOT READY</p>
        @endif
    </div>


    <x-modal title="Choisir" name="choixRdvIndispo" :show="false">
        <p>Voulez-vous ajouter un rendez-vous ou une indisponibilité ?</p>
        @if($selectedTime!=null)
            <p class="font-bold">{{$selectedTime->translatedFormat('d F Y H:i')}}</p>
        @endif
        <div class="flex mt-8">
            <button wire:click="openModalRdv()" class="mr-4 px-4 py-2 bg-green hover:bg-darker-green text-white rounded">Rendez-vous</button>
            <button wire:click="openModalIndispo()" class="px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white rounded">Indisponibilite</button>
        </div>
    </x-modal>

</div>



