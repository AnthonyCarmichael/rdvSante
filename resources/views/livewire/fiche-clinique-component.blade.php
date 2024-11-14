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
            <div class="px-6 pb-6 border-b">
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
                                <textarea wire:model="occupation" name="occupation" id="occupation"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="loisirs">Sports et loisirs</label>
                                <textarea wire:model="loisirs" name="loisirs" id="loisirs"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="lateralite">Latéralité</label>
                                <textarea wire:model="lateralite" name="lateralite" id="lateralite"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                        </div>



                        <div class="flex">
                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="diagnostic">Diagnostic</label>
                                <textarea wire:model="diagnostic" name="diagnostic" id="diagnostic"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="medic">Médic</label>
                                <textarea wire:model="medic" name="medic" id="medic"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4 w-1/3">
                                <label class="block text-sm" for="contreIndication">Contre indications</label>
                                <textarea wire:model="contreIndication" name="contreIndication" id="contreIndication"
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
                                <label class="block text-sm w-1/3" for="rced">RC et ED</label>
                                <textarea wire:model="rced" name="rced" id="rced"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="localIrr">Local et irr</label>
                                <textarea wire:model="localIrr" name="localIrr" id="localIrr"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="douleur">Douleur (Type, intensité, évolution)</label>
                                <textarea wire:model="douleur" name="douleur" id="douleur"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="fa">FA</label>
                                <textarea wire:model="fa" name="fa" id="fa"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="fd">FD</label>
                                <textarea wire:model="fd" name="fd" id="fd"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="nuit">Nuit</label>
                                <textarea wire:model="nuit" name="nuit" id="nuit"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="sa">SA</label>
                                <textarea wire:model="sa" name="sa" id="sa"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                        </fieldset>
                    </div>

                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="investigation" class="text-lg ml-2 mb-4">Investigation</label>

                            <div class="p-4">
                                <textarea wire:model="investigation" name="investigation" id="investigation"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>



                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">ATCD</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="trauma">Trauma</label>
                                <textarea wire:model="trauma" name="trauma" id="trauma"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="chx">Chx</label>
                                <textarea wire:model="chx" name="chx" id="chx"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="familiaux">Familiaux</label>
                                <textarea wire:model="familiaux" name="familiaux" id="familiaux"
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
                                <label class="block text-sm w-1/3" for="cardioVasculaire">Cardio-vasculaire</label>
                                <textarea wire:model="cardioVasculaire" name="cardioVasculaire" id="cardioVasculaire"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="pulmonaire">Pulmonaire</label>
                                <textarea wire:model="pulmonaire" name="pulmonaire" id="pulmonaire"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="snc">SNC (commotion, céphalées, AVC)</label>
                                <textarea wire:model="snc" name="snc" id="snc"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="orl">ORL (ATM, vision, sinus, audition)</label>
                                <textarea wire:model="orl" name="orl" id="orl"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="digestif">Digestif</label>
                                <textarea wire:model="digestif" name="digestif" id="digestif"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="gynecoAndrologie">Gyneco/andrologie (menstru, grossesses) (prostate)</label>
                                <textarea wire:model="gynecoAndrologie" name="gynecoAndrologie" id="gynecoAndrologie"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="urinaire">Urinaire</label>
                                <textarea wire:model="urinaire" name="urinaire" id="urinaire"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="hs">Hs (thyroïde, ménopause)</label>
                                <textarea wire:model="hs" name="hs" id="hs"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="psychologique">Psychologique</label>
                                <textarea wire:model="psychologique" name="psychologique" id="psychologique"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="msk">MSK (arti, N, muscles)</label>
                                <textarea wire:model="msk" name="msk" id="msk"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="dermato">Dermato</label>
                                <textarea wire:model="dermato" name="dermato" id="dermato"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm w-1/3" for="autre">Autre</label>
                                <textarea wire:model="autre" name="autre" id="autre"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>


                        </fieldset>
                    </div>
                </div>


                <div class=" text-sm flex">

                    <div class="w-1/2 px-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="observation" class="text-lg ml-2 mb-4">Observation</label>

                            <div class="p-4">
                                <textarea wire:model="observation" name="observation" id="observation"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="analyse" class="text-lg ml-2 mb-4">Analyse et Tk</label>

                            <div class="p-4">
                                <textarea wire:model="analyse" name="analyse" id="analyse"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
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
                                <textarea wire:model="conseilsPrevention" name="conseilsPrevention" id="conseilsPrevention"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="commentaire" class="text-lg ml-2 mb-4">Autres / Ajouts / Commentaires</label>

                            <div class="p-4">
                                <textarea wire:model="commentaire" name="commentaire" id="commentaire"
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


                <div class=" text-sm flex">
                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Information générales</legend>
                            <div class="flex">
                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="age">Âge</label>
                                    <textarea wire:model="age" name="age" id="age"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="nbreSemGestation">Nbre sem. gestation</label>
                                    <textarea wire:model="nbreSemGestation" name="nbreSemGestation" id="nbreSemGestation"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="apgar">Apgar</label>
                                    <textarea wire:model="apgar" name="apgar" id="apgar"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>
                                </div>

                            </div>



                            <div class="flex">
                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="poid">Poids</label>
                                    <textarea wire:model="poid" name="poid" id="poid"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="taille">Taille</label>
                                    <textarea wire:model="taille" name="taille" id="taille"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="perCranien">Pér. crânien</label>
                                    <textarea wire:model="perCranien" name="perCranien" id="perCranien"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>
                                </div>

                            </div>

                            <div class="flex">
                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="maladieALaNaissance">Maladie à la naissance</label>
                                    <textarea wire:model="maladieALaNaissance" name="maladieALaNaissance" id="maladieALaNaissance"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="medicaments">Médicaments</label>
                                    <textarea wire:model="medicaments" name="medicaments" id="medicaments"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>

                                </div>

                                <div class="m-4 w-1/3">
                                    <label class="block text-sm" for="nomsParent">Noms parents</label>
                                    <textarea wire:model="nomsParent" name="nomsParent" id="nomsParent"
                                    class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    rows="1"></textarea>
                                </div>

                            </div>

                        </fieldset>
                    </div>

                    <div class="w-1/2 px-6 pb-2">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <legend class="text-lg relative top-4 ml-2 mb-4">Historique</legend>
                            <div class="flex m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="historiqueGrossesse">Historique de grossesse</label>
                                <textarea wire:model="historiqueGrossesse" name="historiqueGrossesse" id="historiqueGrossesse"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="historiqueAccouchement">Historique d'accouchement</label>
                                <textarea wire:model="historiqueAccouchement" name="historiqueAccouchement" id="historiqueAccouchement"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>


                            <div class="flex">
                                <div class="w-1/2">
                                    <input type="checkbox" id="cesarienne" name="cesarienne" value="true" wire:model="cesarienne" class="rounded ml-4 mr-2">
                                    <label for="cesarienne">Césarienne</label>
                                </div>
                                <div class="w-1/2">
                                    <input type="checkbox" id="forceps" name="forceps" value="true" wire:model="forceps" class="rounded ml-4 mr-2">
                                    <label for="forceps">Forceps</label>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="m-4  w-1/2">
                                    <input type="checkbox" id="ventouse" name="ventouse" value="true"  wire:model="ventouse" class="rounded  mr-2">
                                    <label for="ventouse">Ventouse</label>
                                </div>
                                <div class="m-4 w-1/2">
                                    <input type="checkbox" id="episiotomie" name="episiotomie" value="true"  wire:model="episiotomie" class="rounded mr-2">
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
                                <textarea wire:model="alimentation" name="alimentation" id="alimentation"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="digestion">Digestion</label>
                                <textarea wire:model="digestion" name="digestion" id="digestion"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="sommeil">Sommeil</label>
                                <textarea wire:model="sommeil" name="sommeil" id="sommeil"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="pleurs">Pleurs</label>
                                <textarea wire:model="pleurs" name="pleurs" id="pleurs"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="motricite">Motricité</label>
                                <textarea wire:model="motricite" name="motricite" id="motricite"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="neuro">Neuro (Eveil, sourire, parole, attention)</label>
                                <textarea wire:model="neuro" name="neuro" id="neuro"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4 mt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="motifConsultation" class="text-lg ml-2 mb-4">Motif de consultation</label>

                            <div class="p-4">
                                <textarea wire:model="motifConsultation" name="motifConsultation" id="motifConsultation"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>

                        <fieldset class="bg-gray-200 rounded text-gray-700 mt-4">
                            <label for="analyse" class="text-lg ml-2 mb-4">Analyse</label>

                            <div class="p-4">
                                <textarea wire:model="analyse" name="analyse" id="analyse"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
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
                                <textarea wire:model="succ" name="succ" id="succ"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="foulard">Réflexe foulard (entre 1-2m)</label>
                                <textarea wire:model="foulard" name="foulard" id="foulard"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="marcheAuto">Réflexe de la marche automatique (av 2m)</label>
                                <textarea wire:model="marcheAuto" name="marcheAuto" id="marcheAuto"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="grasping">Réflexe Grasping (av 4m)</label>
                                <textarea wire:model="grasping" name="grasping" id="grasping"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="redressement">Redressement vx (av 4-5m)</label>
                                <textarea wire:model="redressement" name="redressement" id="redressement"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="babinski">Babinski (av 6m)</label>
                                <textarea wire:model="babinski" name="babinski" id="babinski"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="moro">Réflexe de Moro</label>
                                <textarea wire:model="moro" name="moro" id="moro"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="toniqueAsym">Réflexe tonique asym. cou</label>
                                <textarea wire:model="toniqueAsym" name="toniqueAsym" id="toniqueAsym"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                            <div class="flex  m-4 justify-between items-center">
                                <label class="block text-sm w-1/3" for="tonusActifPassif">Tonus actif et passif (hypo av 2-3m, symetrie, msup et inf)</label>
                                <textarea wire:model="tonusActifPassif" name="tonusActifPassif" id="tonusActifPassif"
                                class="w-2/3 mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>
                        </fieldset>


                    </div>


                    <div class="w-1/2 pr-6 pb-2 pt-4 mt-4">
                        <fieldset class="bg-gray-200 rounded text-gray-700">
                            <label for="techniques" class="text-lg ml-2 mb-4">Techniques</label>

                            <div class="p-4">
                                <textarea wire:model="techniques" name="techniques" id="techniques"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="5"></textarea>
                            </div>

                        </fieldset>

                        <fieldset class="bg-gray-200 rounded text-gray-700 mt-4">
                            <label for="conseilsPrevention" class="text-lg ml-2 mb-4">Conseils</label>

                            <div class="p-4">
                                <textarea wire:model="conseilsPrevention" name="conseilsPrevention" id="conseilsPrevention"
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

            @case(3) <!-- Suivi -->

                @break
            @default

        @endswitch

    </form>
</section>
