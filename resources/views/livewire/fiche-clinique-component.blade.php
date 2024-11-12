<section>

    <div>
        <select id="typeFiche" name="typeFiche" wire:model.live="idTypeFiche" class="border-none bg-green m-6">
            <option class="" value="" selected>Sélectionnez un type de fiche</option>
            @foreach ($typeFiches as $typeFiche )
                <option  value="{{$typeFiche->id}}">{{$typeFiche->nom}}</option>
            @endforeach
        </select>
    </div>


    <form wire:submit.prevent="ajouterFiche" class="">
        @if ($idTypeFiche)
            <div class="pl-6 pb-6 border-b">
                <p class="underline underline-offset-2">Type de fiche :</p>
                <p class="text-sm mt-2">{{$newFiche->typeFiche->nom}}</p>

                @if ($newFiche->typeFiche->description != null)
                    <p class="mt-4 underline underline-offset-2">Description :</p>
                    <p class="text-sm mt-2">{{$newFiche->typeFiche->description}}</p>
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
                                <textarea name="occupation" id="occupation"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="loisirs">Sports et loisirs</label>
                                <textarea name="loisirs" id="loisirs"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="lateralite">Latéralité</label>
                                <textarea name="lateralite" id="lateralite"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                        </div>



                        <div class="flex">
                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="diagnostic">Diagnostic</label>
                                <textarea name="diagnostic" id="diagnostic"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="medic">Médic</label>
                                <textarea name="loisirs" id="loisirs"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="contreIndication">Contre indications</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                        </div>

                    </fieldset>
                </div>

                <div class=" text-sm flex">
                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4 ">Raison de consultation client</legend>

                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">RC et ED</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">Local et irr</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">Douleur (Type, intensité, évolution)</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">FA</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">FD</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">Nuit</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">SA</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                        </fieldset>
                    </div>

                    <div class="w-1/2 pr-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Investigation</legend>

                            <div class="p-4">
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>



                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">ATCD</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">Trauma</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">Chx</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="contreIndication">Familiaux</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                        </fieldset>

                    </div>
                </div>

                <div class=" text-sm">
                    <div class="px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4 ">Revue des systèmes</legend>

                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Cardio-vasculaire</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Pulmonaire</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">SNC (commotion, céphalées, AVC)</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">ORL (ATM, vision, sinus, audition)</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Digestif</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Gyneco/andrologie (menstru, grossesses) (prostate)</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Urinaire</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Hs (thyroïde, ménopause)</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Psychologique</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">MSK (arti, N, muscles)</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Dermato</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="contreIndication">Autre</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>


                        </fieldset>
                    </div>
                </div>


                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Observation</legend>

                            <div class="p-4">
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Analyse et Tk</legend>

                            <div class="p-4">
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>

                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Conseil de prévention</legend>

                            <div class="p-4">
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Autres / Ajouts / Commentaires</legend>

                            <div class="p-4">
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>
                </div>


                <div class="pl-6 pb-6 flex justify-center">

                    <button type="submit" class="mt-4 px-4 py-2 bg-green text-white rounded hover:bg-darker-green">Enregistrer</button>

                </div>




                @break
            @case(2) <!-- Nourrisson -->

                @break

            @case(3) <!-- Suivi -->

                @break
            @default

        @endswitch

    </form>
</section>
