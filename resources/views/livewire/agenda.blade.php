
<div class="">
    <div>
        <select id="view" name="view" wire:model="view" wire:change="setView($event.target.value)"
            class="border-solid border-2 border-gray-600  bg-mid-green">
            <option value="semaine" {{ $view === 'semaine' ? 'selected' : '' }}>Semaine</option>
            <option value="mois" {{ $view === 'mois' ? 'selected' : '' }}>Mois</option>
        </select>
    </div>

    <!-- Affichage de la vue sélectionnée -->
    <div class="w-full text-gray-800 dark:text-gray-400">
        @if($view === 'semaine')
            <!-- Affichage de la vue semaine -->
            <p class="bg-mid-green border-solid border-2 border-gray-600 mb-1 mt-1 font-bold text-center ">Semaine du {{$startingDate->translatedFormat('d F')}} au {{$endingDate->translatedFormat('d F Y')}} </p>


            <table class="table-fixed w-full text-sm text-darker-green dark:text-gray-400">
                <thead>
                    <tr class="bg-mid-green">
                        <!-- Titre col -->
                        <th class="border-solid border-2 border-gray-600">Heure </th>

                        <?php
                        foreach ($datesArr as $date) {?>
                            <th class="border-solid border-2 border-gray-600">{{$date->translatedFormat('l d')}}</th>
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

                                        @foreach ($indispoArr as $indispo)
                                            @if ($indispo->dateHeureDebut <= $selectedDateTime && $indispo->dateHeureFin > $selectedDateTime )

                                                <button class="absolute top-0 left-0 w-full h-full bg-orange-500 border-b-2 border-r-2 border-gray-600"
                                                    value="{{$indispo->id}}"
                                                    onclick="console.log(event.target.value);"
                                                    onmouseover="document.querySelectorAll('button[value=\'{{$indispo->id}}\']').forEach(btn => btn.classList.add('hover-effect'))"
                                                    onmouseout="document.querySelectorAll('button[value=\'{{$indispo->id}}\']').forEach(btn => btn.classList.remove('hover-effect'))">


                                                </button>


                                                <?php $findIndispo = true?>
                                                @break
                                            @endif

                                        @endforeach

                                        @if ($findIndispo != true)
                                            <button wire:click="openModalIndispo('<?php echo $selectedDateTime ?>')"
                                                    class="absolute top-0 left-0 w-full h-full hover:bg-blue-400 border-b-2 border-r-2 border-gray-600">
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

    <?php echo $startingDate ?>
    <?php echo $endingDate ?>
    <?php var_dump(sizeof($datesArr)) ?>



    <h3>Indisponibilités</h3>
    <ul>
        @foreach($indispoArr as $indisponibilite)
            <li>{{ $indisponibilite->note }} ({{ $indisponibilite->dateHeureDebut }} - {{ $indisponibilite->dateHeureFin }})</li>
        @endforeach
    </ul>
    <div>
        <x-modal title="Ajouter une indisponibilité le {{$selectedTime}}" name="ajouterIndisponibilite" :show="false">
            <form wire:submit.prevent="createIndisponibilite">
                <div>
                    <label class="block" for="note">Note :</label> 
                    <input type="text" name="note" wire:model="note" placeholder="Note" required>
                </div>
                 
                <div class="my-4">
                    <label class="block" for="dateFin">Date et heure de la fin de l'indisponibilité :</label>
                    <input type="datetime-local" name="dateFin" min="{{$selectedTime }}"required>
                </div>


                <div class="">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                </div>
            </form>
        </x-modal>

        <button x-data x-on:click="$dispatch('open-modal', { name : 'ajouterIndisponibilite'  })" class="px-3 py-1 bg-teal-500 text-white rounded">
            Ajouter une indisponibilité
        </button>
    </div>



</div>



