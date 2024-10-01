
<div class="">
    <div>
        <select id="view" name="view" wire:model="view" wire:change="setView($event.target.value)"
            class="border-none bg-mid-green">
            <option value="semaine" {{ $view === 'semaine' ? 'selected' : '' }}>Semaine</option>
            <option value="mois" {{ $view === 'mois' ? 'selected' : '' }}>Mois</option>
        </select>

        <div>
            <input class="mt-6 border-none bg-pale-green" placeholder="Sélectionnez une date" type="date" wire:model="settingDate" wire:change="dateChanged" name="settingDate" style="text-indent: -9999px;"> 
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

                    for ($i=0; $i < 30; $i++) {

                        ?>

                        <!-- Gestion de l'aternance des couleurs dans l'agenda -->
                        @if(($i %4)<2)
                            <tr class="bg-gray-100 text-center">

                        @else
                            <tr class=" bg-mid-green text-center">
                        @endif

                        <!-- colonne temps -->
                        <td class="border-solid border-2 border-gray-600"><?php echo $selectedDateTime->format('H:i') ?></td>

                            <!-- colonne interactive de l'agenda -->
                            <?php

                                for ($j=0; $j <7; $j++) {
                                    $findIndispo = false;
                                    ?>
                                    <td class="relative">
                                    @if (!empty($indispoArr))
                                        @foreach ($indispoArr as $indispo)
                                            @if ($indispo->dateHeureDebut <= $selectedDateTime && $indispo->dateHeureFin > $selectedDateTime )

                                                <button class=" {{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(30) ? 'border-2 border-blue-700' : 'border-dotted border-b-2 border-r-2 border-gray-600' }} absolute top-0 left-0 w-full h-full bg-orange-500 "
                                                    wire:click="consulterModalIndispo({{$indispo}})"
                                                    value="{{$indispo->id}}"
                                                    onclick="console.log(event.target.value);"
                                                    onmouseover="document.querySelectorAll('button[value=\'{{$indispo->id}}\']').forEach(btn => btn.classList.add('hover-effect'))"
                                                    onmouseout="document.querySelectorAll('button[value=\'{{$indispo->id}}\']').forEach(btn => btn.classList.remove('hover-effect'))">
                                                </button>
                                                <?php $findIndispo = true?>
                                                @break
                                            @endif
                                        @endforeach

                                    @endif


                                    @if ($findIndispo != true)
                                        <button wire:click="openModalIndispo('<?php echo $selectedDateTime ?>')"
                                                class="{{ $selectedDateTime <= $now && $now < $selectedDateTime->copy()->addMinutes(30) ? 'border-2 border-blue-700' : 'border-dotted border-b-2 border-r-2 border-gray-600' }} absolute top-0 left-0 w-full h-full hover:bg-blue-400">
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
                        $selectedDateTime->modify('+30 minutes');
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

</div>



