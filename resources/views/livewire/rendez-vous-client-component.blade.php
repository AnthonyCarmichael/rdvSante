
<div x-data="{ showForm: false }" class="text-xs text-gray-700 bg-stone-200 m-10 flex flex-col items-center m-6 p-6">
    <img class="rounded w-full max-w-md" src="{{ asset('img/imgMassage.jpg') }}" alt="image massage">
    <div class="w-full max-w-md">
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
                            @if ($user->id==1)
                                <div class="flex items-center border-y py-6 hover:bg-stone-200 cursor-pointer"  wire:click="getProfessionnelId({{ $user->id }})">
                                    <div>
                                        <img src="{{ asset('img/daph.jpg') }}" alt="imageDaph"
                                            class="mr">
                                    </div>
                                    <div class="mx-4 self-center">
                                        <div class="mb-8">
                                            <p class="inline ">Daphné Carmichael</p> @foreach($user->professions as $profession) <p class="inline">, {{$profession->nom}}</p> @endforeach
                                        </div>
                
                                        <p class="text-justify">
                                            Afin de contribuer à l'accessibilité des soins, Daphné offre des tarifs préférentiels pour les artistes de la scène, les étudiant-es et les personnes de 65 ans et plus.
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
                        <h2 class="text-lg font-bold text-center">Sélectionnez un service</h2>
                        <div class="">
                            @foreach($services as $service)
                                <div class="border-y py-6 hover:bg-stone-200 cursor-pointer flex items-center place-content-between"  wire:click="getServiceId({{ $service->id }})">
                                    <div>
                                        <p>Service: {{$service->nom}}</p>
                                        @if($service->description != null)
                                            <p>description: {{$service->description}}</p>
                                        @endif
                                        <p>Durée: {{$service->duree}}min</p>
                                        <p>Prix: {{$service->prix}}$</p>
                                    </div> 
                                    <div>
                                        <p class="text-stone-300 self-center text-lg mr-4">></p>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>

                    @break
                @case(3)
                    <!-- Section 3 -->
                    <div class="p-5 bg-white rounded shadow-md">
                        <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                        <h2 class="text-lg font-bold text-center">Sélectionnez une heure</h2>
                        <div class="border-y py-6">
                            
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
                                $selectedDateTime->setTime(7, 0, 0);

                                for ($i=0; $i < 30; $i++) {

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
                                                <td class="relative">
                                                    <!-- verification cellule dispo -->
                                                    @if (!empty($dispoDateArr))

                                                        @foreach ($dispoDateArr as $dispo)

                                                            
                                                            @if ($dispo == $selectedDateTime)

                                                                
                                                                <button class="absolute top-0 left-0 w-full h-full bg-blue-500 "
                                                                    value="{{$dispo}}"
                                                                    onclick="console.log(event.target.value);"
                                                                    onmouseover="document.querySelectorAll('button[value=\'{{$dispo}}\']').forEach(btn => btn.classList.add('hover-effect-blue'))"
                                                                    onmouseout="document.querySelectorAll('button[value=\'{{$dispo}}\']').forEach(btn => btn.classList.remove('hover-effect-blue'))">
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
                                    $selectedDateTime->modify('+30 minutes');
                                }
                                ?>

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                        </div>
                        
                    </div>
                    @break
                @case(4)
                    <!-- Section 4 -->
                    <div class="p-5 bg-white rounded shadow-md">
                        <button type="button" wire:click="backStep" class="py-1 px-2 bg-gray-300 text-white rounded hover:bg-gray-500"><</button>
                        <h2 class="text-lg font-bold text-center">Résumé</h2>
                        <div class="flex justify-between">
                            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Confirmer</button>
                        </div>
                        
                    </div>
                    @break
            @endswitch
        
        </form>
    </div>
                    
</div>

