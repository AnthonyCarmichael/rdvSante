<section>

    @if ($typeForm == "ajouter")
        <div>
            <select id="typeFiche" name="typeFiche" wire:model.live="idTypeFiche" class="border-none bg-green m-6">
                <option class="" value="" selected>Sélectionnez un type de fiche</option>
                @foreach ($typeFiches as $typeFiche )
                    <option  value="{{$typeFiche->id}}">{{$typeFiche->nom}}</option>
                @endforeach
            </select>
        </div>

    @else
        <div class="pl-6 pb-6">
            <button type="button" wire:click="alternateEditingMode" class="mt-4 px-4 py-2 bg-green text-white rounded hover:bg-darker-green">{{$typeForm == 'consulter' ? 'Modifier' : 'Annuler' }}</button>
        </div>
    @endif

    <form wire:submit.prevent="{{$typeForm}}Fiche" class="">
        @if ($fiche->typeFiche)
            <div class="px-6 pb-6 border-b">
                <p class="underline underline-offset-2">Type de fiche :</p>
                <p class="text-sm mt-2">{{$fiche->typeFiche->nom}}</p>

                @if ($fiche->typeFiche->description != null)
                    <p class="mt-4 underline underline-offset-2">Description :</p>
                    <p class="text-sm mt-2">{!! nl2br(e($fiche->typeFiche->description)) !!}</p>
                @endif
            </div>

        @endif


        @switch($idTypeFiche)
            @case(1) <!-- Amamnèse -->

                <div class="px-6 py-2 text-sm">
                    <fieldset class="bg-gray-200 rounded text-gray-700">
                        <legend class="text-lg relative top-4 ml-2 mb-4">Information client</legend>
                        <div class="flex">
                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="occupation">Occupation/travail</label>
                                <textarea {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="occupation" name="occupation" id="occupation"
                                class=" {{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }} mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="loisirs">Sports et loisirs</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="loisirs" name="loisirs" id="loisirs"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="lateralite">Latéralité</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="lateralite" name="lateralite" id="lateralite"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </div>



                        <div class="flex">
                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="diagnostic">Diagnostic</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="diagnostic" name="diagnostic" id="diagnostic"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="medic">Médic</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="medic" name="medic" id="medic"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="contreIndication">Contre indications</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="contreIndication" name="contreIndication" id="contreIndication"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </div>

                    </fieldset>
                </div>

                <div class=" text-sm flex">
                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4 ">Raison de consultation client</legend>

                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="rced">RC et ED</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="rced" name="rced" id="rced"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="localIrr">Local et irr</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="localIrr" name="localIrr" id="localIrr"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="douleur">Douleur (Type, intensité, évolution)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="douleur" name="douleur" id="douleur"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="fa">FA</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="fa" name="fa" id="fa"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="fd">FD</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="fd" name="fd" id="fd"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="nuit">Nuit</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="nuit" name="nuit" id="nuit"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="sa">SA</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="sa" name="sa" id="sa"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                        </fieldset>
                    </div>

                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="investigation" class="text-lg ml-2 mb-4">Investigation</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="investigation" name="investigation" id="investigation"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>



                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">ATCD</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="trauma">Trauma</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="trauma" name="trauma" id="trauma"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="chx">Chx</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="chx" name="chx" id="chx"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="familiaux">Familiaux</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="familiaux" name="familiaux" id="familiaux"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>

                    </div>
                </div>

                <div class=" text-sm">
                    <div class="px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4 ">Revue des systèmes</legend>

                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="cardioVasculaire">Cardio-vasculaire</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="cardioVasculaire" name="cardioVasculaire" id="cardioVasculaire"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="pulmonaire">Pulmonaire</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="pulmonaire" name="pulmonaire" id="pulmonaire"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="snc">SNC (commotion, céphalées, AVC)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="snc" name="snc" id="snc"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="orl">ORL (ATM, vision, sinus, audition)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="orl" name="orl" id="orl"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="digestif">Digestif</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="digestif" name="digestif" id="digestif"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="gynecoAndrologie">Gyneco/andrologie (menstru, grossesses) (prostate)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="gynecoAndrologie" name="gynecoAndrologie" id="gynecoAndrologie"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="urinaire">Urinaire</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="urinaire" name="urinaire" id="urinaire"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="hs">Hs (thyroïde, ménopause)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="hs" name="hs" id="hs"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="psychologique">Psychologique</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="psychologique" name="psychologique" id="psychologique"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="msk">MSK (arti, N, muscles)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="msk" name="msk" id="msk"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="dermato">Dermato</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="dermato" name="dermato" id="dermato"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="autre">Autre</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="autre" name="autre" id="autre"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>


                        </fieldset>
                    </div>
                </div>


                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="observation" class="text-lg ml-2 mb-4">Observation</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="observation" name="observation" id="observation"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="analyse" class="text-lg ml-2 mb-4">Analyse et Tk</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="analyse" name="analyse" id="analyse"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>

                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="conseilsPrevention" class="text-lg ml-2 mb-4">Conseil de prévention</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="conseilsPrevention" name="conseilsPrevention" id="conseilsPrevention"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="commentaire" class="text-lg ml-2 mb-4">Autres / Ajouts / Commentaires</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="commentaire" name="commentaire" id="commentaire"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>



                <div class="pl-6 pb-6 flex justify-center">
                    @if($typeForm != "consulter" )
                        <button type="submit" class="mt-4 px-4 py-2 bg-green text-white rounded hover:bg-darker-green">Enregistrer</button>
                    @endif
                </div>

                @break

            @case(2) <!-- Nourrisson -->


                <div class=" text-sm flex">
                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Information générales</legend>
                            <div class="flex">
                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="age">Âge</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="age" name="age" id="age"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="nbreSemGestation">Nbre sem. gestation</label>
                                    <input type="number" step="1" min="0" {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="nbreSemGestation" name="nbreSemGestation" id="nbreSemGestation"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></input>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="apgar">Apgar</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="apgar" name="apgar" id="apgar"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>
                                </div>

                            </div>



                            <div class="flex">
                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="poid">Poids</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="poid" name="poid" id="poid"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="taille">Taille</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="taille" name="taille" id="taille"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="perCranien">Pér. crânien</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="perCranien" name="perCranien" id="perCranien"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>
                                </div>

                            </div>

                            <div class="flex">
                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="maladieALaNaissance">Maladie à la naissance</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="maladieALaNaissance" name="maladieALaNaissance" id="maladieALaNaissance"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="medicaments">Médicaments</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="medicaments" name="medicaments" id="medicaments"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="nomsParent">Noms parents</label>
                                    <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="nomsParent" name="nomsParent" id="nomsParent"
                                    class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="5"></textarea>
                                </div>

                            </div>

                        </fieldset>
                    </div>

                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Historique</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="historiqueGrossesse">Historique de grossesse</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="historiqueGrossesse" name="historiqueGrossesse" id="historiqueGrossesse"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="historiqueAccouchement">Historique d'accouchement</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="historiqueAccouchement" name="historiqueAccouchement" id="historiqueAccouchement"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>


                            <div class="flex">
                                <div class="w-1/2">
                                    <input type="checkbox" {{ $typeForm == 'consulter' ? 'disabled' : '' }} id="cesarienne" name="cesarienne" value="true" wire:model="cesarienne" class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }} rounded ml-4 mr-2">
                                    <label for="cesarienne">Césarienne</label>
                                </div>
                                <div class="w-1/2">
                                    <input type="checkbox" {{ $typeForm == 'consulter' ? 'disabled' : '' }} id="forceps" name="forceps" value="true" wire:model="forceps" class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }} rounded ml-4 mr-2">
                                    <label for="forceps">Forceps</label>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="m-4  w-1/2">
                                    <input type="checkbox" {{ $typeForm == 'consulter' ? 'disabled' : '' }} id="ventouse" name="ventouse" value="true"  wire:model="ventouse" class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }} rounded  mr-2">
                                    <label for="ventouse">Ventouse</label>
                                </div>
                                <div class="m-4 w-1/2">
                                    <input type="checkbox" {{ $typeForm == 'consulter' ? 'disabled' : '' }} id="episiotomie" name="episiotomie" value="true"  wire:model="episiotomie" class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}  rounded mr-2">
                                    <label for="episiotomie">Épisiotomie</label>
                                </div>
                            </div>



                        </fieldset>
                    </div>
                </div>


                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">État actuel</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="alimentation">Boires/Alimentation (tétées, quant, etc.)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="alimentation" name="alimentation" id="alimentation"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="digestion">Digestion</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="digestion" name="digestion" id="digestion"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="sommeil">Sommeil</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="sommeil" name="sommeil" id="sommeil"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="pleurs">Pleurs</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="pleurs" name="pleurs" id="pleurs"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="motricite">Motricité</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="motricite" name="motricite" id="motricite"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="neuro">Neuro (Eveil, sourire, parole, attention)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="neuro" name="neuro" id="neuro"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4 mt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="motifConsultation" class="text-lg ml-2 mb-4">Motif de consultation</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="motifConsultation" name="motifConsultation" id="motifConsultation"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>

                        <fieldset class="bg-gray-200 rounded text-gray-700 mt-4">
                            <label for="analyse" class="text-lg ml-2 mb-4">Analyse</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="analyse" name="analyse" id="analyse"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>

                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Réflexes et test neuro</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="succ">Réflexe de succion</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="succ" name="succ" id="succ"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="foulard">Réflexe foulard (entre 1-2m)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="foulard" name="foulard" id="foulard"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="marcheAuto">Réflexe de la marche automatique (av 2m)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="marcheAuto" name="marcheAuto" id="marcheAuto"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="grasping">Réflexe Grasping (av 4m)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="grasping" name="grasping" id="grasping"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="redressement">Redressement vx (av 4-5m)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="redressement" name="redressement" id="redressement"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="babinski">Babinski (av 6m)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="babinski" name="babinski" id="babinski"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="moro">Réflexe de Moro</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="moro" name="moro" id="moro"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="toniqueAsym">Réflexe tonique asym. cou</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="toniqueAsym" name="toniqueAsym" id="toniqueAsym"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="tonusActifPassif">Tonus actif et passif (hypo av 2-3m, symetrie, msup et inf)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="tonusActifPassif" name="tonusActifPassif" id="tonusActifPassif"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4 mt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="techniques" class="text-lg ml-2 mb-4">Techniques</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="techniques" name="techniques" id="techniques"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>

                        <fieldset class="bg-gray-200 rounded text-gray-700 mt-4">
                            <label for="conseilsPrevention" class="text-lg ml-2 mb-4">Conseils</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="conseilsPrevention" name="conseilsPrevention" id="conseilsPrevention"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="pl-6 pb-6 flex justify-center">
                    @if($typeForm != "consulter" )
                        <button type="submit" class="mt-4 px-4 py-2 bg-green text-white rounded hover:bg-darker-green">Enregistrer</button>
                    @endif
                </div>

                @break

            @case(3) <!-- Suivi -->

                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="depuisDerniereSeance" class="text-lg ml-2 mb-4">Depuis la dernière séance</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="depuisDerniereSeance" name="depuisDerniereSeance" id="depuisDerniereSeance"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>
                    </div>


                    <div class="w-1/2 px-6 pb-2">

                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4 ">NRC</legend>

                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="rced">RC et ED</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="rced" name="rced" id="rced"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="localIrr">Local et irr</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="localIrr" name="localIrr" id="localIrr"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="douleur">Douleur (Type, intensité, évolution)</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="douleur" name="douleur" id="douleur"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="fa">FA</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="fa" name="fa" id="fa"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="fd">FD</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="fd" name="fd" id="fd"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="nuit">Nuit</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="nuit" name="nuit" id="nuit"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="sa">SA</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="sa" name="sa" id="sa"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="investigation">Investigations</label>
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="investigation" name="investigation" id="investigation"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>


                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="observation" class="text-lg ml-2 mb-4">Observation</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="observation" name="observation" id="observation"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="analyse" class="text-lg ml-2 mb-4">Analyse et Tk</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="analyse" name="analyse" id="analyse"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>

                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="conseilsPrevention" class="text-lg ml-2 mb-4">Conseil de prévention</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="conseilsPrevention" name="conseilsPrevention" id="conseilsPrevention"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="commentaire" class="text-lg ml-2 mb-4">Autres / Ajouts / Commentaires</label>

                            <div class="p-4">
                                <textarea  {{ $typeForm == 'consulter' ? 'disabled' : '' }} wire:model="commentaire" name="commentaire" id="commentaire"
                                class="{{ $typeForm == 'consulter' ? 'bg-gray-300' : '' }}   mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>


                <div class="pl-6 pb-6 flex justify-center">
                    @if($typeForm != "consulter" )
                        <button type="submit" class="mt-4 px-4 py-2 bg-green text-white rounded hover:bg-darker-green">Enregistrer</button>
                    @endif
                </div>


                @break
            @default

        @endswitch

    </form>
</section>

<script>


</script>
