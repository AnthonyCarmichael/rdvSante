
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


            <table class="w-full text-sm text-darker-green dark:text-gray-400">
                <thead>
                    <tr class="bg-mid-green">
                        <!-- Titre col -->
                        <th class="border-solid border-2 border-gray-600">Heure </th>

                        <!--
                        <th class="border-solid border-2 border-gray-600">Dim {{$datesArr[0]->format('d-M')}}</th>
                        <th class="border-solid border-2 border-gray-600">Lun {{$datesArr[1]->format('d-M')}}</th>
                        <th class="border-solid border-2 border-gray-600">Mar {{$datesArr[2]->format('d-M')}}</th>
                        <th class="border-solid border-2 border-gray-600">Mer {{$datesArr[3]->format('d-M')}}</th>
                        <th class="border-solid border-2 border-gray-600">Jeu {{$datesArr[4]->format('d-M')}}</th>
                        <th class="border-solid border-2 border-gray-600">Ven {{$datesArr[5]->format('d-M')}}</th>
                        <th class="border-solid border-2 border-gray-600">Sam {{$datesArr[6]->format('d-M')}}</th>
-->
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
                    $heure = new DateTime('7:00');
                    for ($i=0; $i < 30; $i++) {

                        ?>

                        <!-- Gestion de l'aternance des couleurs dans l'agenda -->
                        @if(($i %4)<2)
                            <tr class="border-solid border-2 border-gray-600  bg-gray-100 text-center">

                        @else
                            <tr class="border-solid border-2 border-gray-600  bg-mid-green text-center">
                        @endif

                        <!-- Gestion du temps -->

                            <td class="border-solid border-2 border-gray-600"><?php echo $heure->format('H:i') ?></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                            <td class="border-solid border-2 border-gray-600"></td>
                        </tr>


                    <?php
                        $heure->modify('+30 minutes');
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


    

</div>



