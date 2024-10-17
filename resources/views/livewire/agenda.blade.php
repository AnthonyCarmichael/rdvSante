
<div class="">
    <!-- Bug avec la vue de mois qui change le now for some reason -->
    <div>
        <select id="view" name="view" wire:model="view" wire:change="setView($event.target.value)"
            class="border-none bg-mid-green">
            <option value="semaine" {{ $view === 'semaine' ? 'selected' : '' }}>Semaine</option>
            <option value="mois" {{ $view === 'mois' ? 'selected' : '' }}>Mois</option>
        </select>

        <div>
            <input class="focus:outline-none focus:ring-0 mt-6 border-none bg-pale-green"type="date" wire:model="settingDate" wire:change="dateChanged" name="settingDate" style="text-indent: -9999px;"> 
        </div>

    </div>

    


    <!-- Affichage de la vue sélectionnée -->
    <div class="w-full text-gray-800">
        @if($view === 'semaine')
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

                        <?php
                        foreach ($datesArr as $date) {?>
                            <th class="{{ $date->isSameDay($now) ? ' bg-blue-400' : '' }} border-solid border-2 border-gray-600">{{$date->translatedFormat('l d')}}</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $selectedDateTime = $startingDate->copy();
                    $selectedDateTime->setTime(7, 0, 0);

                    for ($i=0; $i < 180; $i++) {
                        if ($i % 6 == 0) {
                            $rowColor = ($i / 6) % 2 == 0 ? 'bg-gray-100' : 'bg-mid-green'; // Alterne les couleurs toutes les 30 minutes
                        }

                        ?>

                        <!-- Gestion de l'aternance des couleurs dans l'agenda -->
                        <tr class=" {{$rowColor}} text-center">

                        <!-- colonne temps -->
                        @if ($selectedDateTime->minute % 30 == 0)
                            <td class="border-solid border-2 border-gray-600" rowspan="6"><?php echo $selectedDateTime->format('H:i') ?></td>
                        @endif
                            <!-- colonne interactive de l'agenda -->
                            <?php

                                for ($j=0; $j <7; $j++) {
                                    $findIndispo = false;
                                    ?>
                                    <!-- Cellule intéractible -->
                                    <td class="relative border-r-2 border-gray-600">
                                        <!-- verification cellule indispo -->
                                        @if (!empty($indispoArr))
                                            @foreach ($indispoArr as $indispo)
                                                @if ($indispo->dateHeureDebut <= $selectedDateTime && $indispo->dateHeureFin > $selectedDateTime )

                                                    <button class=" {{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(30) ? 'border-2 border-blue-700' : ' ' }} absolute top-0 left-0 w-full h-full bg-orange-500 "
                                                        wire:click="consulterModalIndispo({{$indispo}})"
                                                        value="{{$indispo->id}}"
                                                        onclick="console.log(event.target.value);"
                                                        onmouseover="document.querySelectorAll('button[value=\'{{$indispo->id}}\']').forEach(btn => btn.classList.add('hover-effect-orange'))"
                                                        onmouseout="document.querySelectorAll('button[value=\'{{$indispo->id}}\']').forEach(btn => btn.classList.remove('hover-effect-orange'))">
                                                    </button>
                                                    <?php $findIndispo = true?>
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
                                                @if ($debut <= $selectedDateTime && $debut->addMinutes($rdv->service->duree) > $selectedDateTime)
                                                    <button class=" {{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(30) ? 'border-2 border-blue-700' : ' ' }} absolute top-0 left-0 w-full h-full bg-blue-500 "
                                                        wire:click="consulterModalRdv({{$rdv}})"
                                                        value="{{$rdv->id}}"
                                                        onclick="console.log(event.target.value);"
                                                        onmouseover="document.querySelectorAll('button[value=\'{{$rdv->id}}\']').forEach(btn => btn.classList.add('hover-effect-blue'))"
                                                        onmouseout="document.querySelectorAll('button[value=\'{{$rdv->id}}\']').forEach(btn => btn.classList.remove('hover-effect-blue'))">
                                                    </button>
                                                    <?php $findIndispo = true?>
                                                    @break
                                                @endif
                                            @endforeach

                                        @endif


                                        @if ($findIndispo != true)
                                            <button type="button" wire:click="consulterModalChoixRdvIndispo('<?php echo $selectedDateTime ?>')"
                                                    class="{{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(30) ? 'border-2 border-blue-700' : ' ' }} absolute top-0 left-0 w-full h-full hover:bg-blue-400">
                                            </button>
                                        @endif
                                    </td>
                                    <?php
                                    $selectedDateTime->modify('+1 day');
                                }
                                $selectedDateTime->modify('-7 day');
                            ?>
                        </tr>


                    <?php
                        $selectedDateTime->modify('+5 minutes');
                    }
                    ?>

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
        <div class="flex mt-8">
            <button wire:click="openModalRdv()" class="mr-4 px-4 py-2 bg-green hover:bg-darker-green text-white rounded">Rendez-vous</button>
            <button wire:click="openModalIndispo()" class="px-4 py-2 bg-orange-500 hover:bg-orange-700 text-white rounded">Indisponibilite</button>
        </div>
    </x-modal>

</div>



