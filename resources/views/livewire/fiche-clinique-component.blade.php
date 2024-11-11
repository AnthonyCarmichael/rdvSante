<section>

    <div>
        <select id="typeFiche" name="typeFiche" wire:model.live="typeFicheId" class="border-none bg-green m-6">
            <option class="" value="" selected>Sélectionnez un type de fiche</option>
            @foreach ($typeFiches as $typeFiche )
                <option  value="{{$typeFiche->id}}">{{$typeFiche->nom}}</option>
            @endforeach
        </select>
    </div>


    <form wire:submit.prevent="ajouterFiche" class="">
        @if ($typeFicheId)
            <div class="pl-6 pb-6 border-b">
                <p class="underline underline-offset-2">Type de fiche :</p>
                <p class="text-sm mt-2">{{$newFiche->typeFiche->nom}}</p>

                @if ($newFiche->typeFiche->description != null)
                    <p class="mt-4 underline underline-offset-2">Description :</p>
                    <p class="text-sm mt-2">{{$newFiche->typeFiche->description}}</p>
                @endif
            </div>

        @endif


        @switch($typeFicheId)
            @case(1) <!-- Amamnèse -->

                <div class="p-6 text-sm">
                    <fieldset class="">
                        <legend class="text-lg">Information client</legend>
                        <div class="flex">
                            <div class="m-4">
                                <label class="block text-sm" for="occupation">Occupation/travail</label>
                                <textarea name="occupation" id="occupation"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4">
                                <label class="block text-sm" for="loisirs">Sports et loisirs</label>
                                <textarea name="loisirs" id="loisirs"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4">
                                <label class="block text-sm" for="lateralite">Latéralité</label>
                                <textarea name="lateralite" id="lateralite"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                        </div>



                        <div class="flex">
                            <div class="m-4">
                                <label class="block text-sm" for="diagnostic">Diagnostic</label>
                                <textarea name="diagnostic" id="diagnostic"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4">
                                <label class="block text-sm" for="medic">Médic</label>
                                <textarea name="loisirs" id="loisirs"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>

                            </div>

                            <div class="m-4">
                                <label class="block text-sm" for="contreIndication">Contre indications</label>
                                <textarea name="contreIndication" id="contreIndication"
                                class="mt-1 text-black block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="1"></textarea>
                            </div>

                        </div>


                        <!-- more form input elements -->
                    </fieldset>
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
