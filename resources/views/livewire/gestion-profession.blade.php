<div class="mx-16">
    <table class="w-full border-solid border border-black mb-4">
        <thead class="sticky top-0">
            <tr>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8 pl-2">Mes professions
                </th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8 pl-2">Organisation associée
                </th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8 pl-2">Numéro de membre</th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8 pl-2">Date d'expiration</th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8 pl-2">Actions</th>
            </tr>
        </thead>
        @php
            $cpt = 0;
        @endphp
        @foreach ($professionsPro as $pp)
            @php
                $orgProFound = false;
            @endphp
            @foreach ($orgPro as $op)
                @if ($pp->idProfession == $op->idProfession)
                    @php
                        $orgProFound = true;
                    @endphp
                    @if ($cpt % 2 == 0)
                        <tr class="bg-white">
                            @if ($op->dateExpiration >= $today)
                                @foreach ($professions as $p)
                                    @if ($p->id == $op->idProfession)
                                        <td class="pl-2"> {{ $p->nom }} </td>
                                    @endif
                                @endforeach
                                @foreach ($org as $o)
                                    @if ($o->id == $op->idOrganisation)
                                        <td class="pl-2"> {{ $o->nom }} </td>
                                    @endif
                                @endforeach
                                <td class="pl-2"> {{ $op->numMembre }} </td>
                                <td class="pl-2"> {{ $op->dateExpiration }} </td>
                                <td><button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                        wire:click="formModif({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Modifier</button>
                                    <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                        wire:click="formSup({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Supprimer</button>
                                </td>
                            @else
                                @foreach ($professions as $p)
                                    @if ($p->id == $op->idProfession)
                                        <td class="pl-2 text-red-600"> {{ $p->nom }} </td>
                                    @endif
                                @endforeach
                                @foreach ($org as $o)
                                    @if ($o->id == $op->idOrganisation)
                                        <td class="pl-2 text-red-600"> {{ $o->nom }} </td>
                                    @endif
                                @endforeach
                                <td class="pl-2 text-red-600"> {{ $op->numMembre }} </td>
                                <td class="pl-2 text-red-600"> {{ $op->dateExpiration }} </td>
                                <td><button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                        wire:click="formModif({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Modifier</button>
                                    <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                        wire:click="formSup({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Supprimer</button>
                                </td>
                            @endif

                        </tr>
                    @elseif ($cpt % 2 == 1)
                        <tr class="bg-table-green">
                            @if ($op->dateExpiration >= $today)
                                @foreach ($professions as $p)
                                    @if ($p->id == $op->idProfession)
                                        <td class="pl-2"> {{ $p->nom }} </td>
                                    @endif
                                @endforeach
                                @foreach ($org as $o)
                                    @if ($o->id == $op->idOrganisation)
                                        <td class="pl-2"> {{ $o->nom }} </td>
                                    @endif
                                @endforeach
                                <td class="pl-2"> {{ $op->numMembre }} </td>
                                <td class="pl-2"> {{ $op->dateExpiration }} </td>
                                <td><button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                        wire:click="formModif({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Modifier</button>
                                    <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                        wire:click="formSup({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Supprimer</button>
                                </td>
                            @else
                                @foreach ($professions as $p)
                                    @if ($p->id == $op->idProfession)
                                        <td class="pl-2 text-red-600"> {{ $p->nom }} </td>
                                    @endif
                                @endforeach
                                @foreach ($org as $o)
                                    @if ($o->id == $op->idOrganisation)
                                        <td class="pl-2 text-red-600"> {{ $o->nom }} </td>
                                    @endif
                                @endforeach
                                <td class="pl-2 text-red-600"> {{ $op->numMembre }} </td>
                                <td class="pl-2 text-red-600"> {{ $op->dateExpiration }} </td>
                                <td><button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                        wire:click="formModif({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Modifier</button>
                                    <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                        wire:click="formSup({{ $op }}, {{ $op->idProfession }}, {{ $op->idOrganisation }})">Supprimer</button>
                                </td>
                            @endif
                        </tr>
                    @endif
                    <?php $cpt += 1; ?>
                @endif
            @endforeach
            @if (!$orgProFound)
                @if ($cpt % 2 == 0)
                    <tr class="bg-white">
                        @foreach ($professions as $p)
                            @if ($p->id == $pp->idProfession)
                                <td class="pl-2"> {{ $p->nom }} </td>
                            @endif
                        @endforeach
                        <td class="pl-2"> Aucune </td>
                        <td class="pl-2"> N/A </td>
                        <td class="pl-2">N/A </td>
                        <td><button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                wire:click="formModif(null, {{ $pp->idProfession }}, null)">Modifier</button>
                            <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                wire:click="formSup(null, {{ $pp->idProfession }}, null)">Supprimer</button>
                        </td>
                    </tr>
                @elseif ($cpt % 2 == 1)
                    <tr class="bg-table-green">
                        @foreach ($professions as $p)
                            @if ($p->id == $pp->idProfession)
                                <td class="pl-2"> {{ $p->nom }} </td>
                            @endif
                        @endforeach
                        <td class="pl-2"> Aucune </td>
                        <td class="pl-2"> N/A </td>
                        <td class="pl-2">N/A </td>
                        <td><button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button"
                                wire:click="formModif(null, {{ $pp->idProfession }}, null)">Modifier</button>
                            <button class="w-6/12 bg-selected-green mx-0.5 rounded p-0.5" type="button"
                                wire:click="formSup(null, {{ $pp->idProfession }}, null)">Supprimer</button>
                        </td>
                    </tr>
                @endif
                <?php $cpt += 1; ?>
            @endif
        @endforeach
    </table>

    <div class="flex justify-end">
        <button wire:click="formAjout" class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide"
            type="button">Ajouter</button>
    </div>
    <x-modal title="Ajouter une profession et/ou l'organisation liée" name="ajouterOrg" :show="false">
        <ul class="ml-8">
            @error('profession')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('numMembre')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('dateExpiration')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
        </ul>
        <form wire:submit.prevent="ajoutOrg" class="bg-white p-4 rounded-lg">
            <div class="grid grid-cols-2 gap-y-4 pr-32">

                <label class="text-sm text-right" for="profession">Profession:</label>
                <input wire:model="profession" type="text" list="profession"
                    class="h-8 text-xs ml-2">
                <datalist wire:model="profession" id="profession" name="profession"
                    class="h-8 text-xs ml-2">
                    @foreach ($professions as $p)
                        <option data-value={{ $p->id }}> {{ $p->nom }}</option>
                    @endforeach
                </datalist>

                <label class="text-sm text-right" for="organisation">Organisation:</label>
                <input wire:model="organisation" type="text" list="organisation"
                    class="h-8 text-xs ml-2">
                <datalist wire:model="organisation" id="organisation"
                    name="organisation" class="h-8 text-xs ml-2">
                    @foreach ($organisations as $o)
                        <option data-value={{ $o->id }}> {{ $o->nom }}</option>
                    @endforeach
                </datalist>

                <label class="text-sm text-right" for="numMembre">Numéro de membre:</label>
                <input wire:model="numMembre" type="text" name="numMembre" class="h-8 text-xs ml-2">

                <label class="text-sm text-right" for="dateExpiration">Date d'expiration:</label>
                <input wire:model="dateExpiration" type="date" name="dateExpiration" class="h-8 text-xs ml-2">


            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>

    <x-modal title="Modifier sa profession et/ou l'organisation liée" name="modifierOrg" :show="false">
        <ul class="ml-8">
            @error('profession')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('numMembre')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('dateExpiration')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
        </ul>
        <form wire:submit.prevent="modifOrg" class="bg-white p-4 rounded-lg">
            <div class="grid grid-cols-2 gap-y-4 pr-32">

                <label class="text-sm text-right" for="profession">Profession:</label>
                <input wire:model="profession" type="text" list="profession"
                    class="h-8 text-xs ml-2">
                <datalist wire:model="profession" id="profession" name="profession"
                    class="h-8 text-xs ml-2">
                    @foreach ($professions as $p)
                        <option data-value={{ $p->id }}> {{ $p->nom }}</option>
                    @endforeach
                </datalist>

                <label class="text-sm text-right" for="organisation">Organisation:</label>
                <input wire:model="organisation" type="text" list="organisation"
                    class="h-8 text-xs ml-2">
                <datalist wire:model="organisation" id="organisation"
                    name="organisation" class="h-8 text-xs ml-2">
                    @foreach ($organisations as $o)
                        <option data-value={{ $o->id }}> {{ $o->nom }}</option>
                    @endforeach
                </datalist>

                <label class="text-sm text-right" for="numMembre">Numéro de membre:</label>
                <input wire:model="numMembre" type="text" name="numMembre" class="h-8 text-xs ml-2">

                <label class="text-sm text-right" for="dateExpiration">Date d'expiration:</label>
                <input wire:model="dateExpiration" type="date" name="dateExpiration" class="h-8 text-xs ml-2">


            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>

    <x-modal title="Supprimer sa profession et/ou l'organisation liée" name="supprimerOrg" :show="false">

            <div class="gap-y-4">
                <p>Voulez-vous supprimer seulement le lien avec l'organisation ou la profession au complet?</p>
            </div>
            <div class="flex justify-center mt-4">

                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button" wire:click="supprimerOrg('org')">L'organisation</button>

                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="button" wire:click="supprimerOrg('pro')">La profession</button>
            </div>
    </x-modal>
</div>
