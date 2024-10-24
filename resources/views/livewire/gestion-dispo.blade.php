<div class="mx-16">
    @if ($empietement)
        <p class="text-red-400 text-l font-bold mb-8">L'ajout ou la modification de la disponibilité n'a pas fonctionné,
            car
            il y a empiêtement avec une autre disponibilité</p>
    @endif
    <table class="w-full border-solid border border-black mb-4">
        <thead class="sticky top-0">
            <tr>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-3/8 pl-2">Jour</th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2/8">Heure de début</th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-2-8">Heure de fin</th>
                <th class="border-solid border-b-2 border-black bg-mid-green text-left w-1/8">Action</th>
            </tr>
        </thead>
        @php
            $cpt = 0;
        @endphp

        @foreach ($jours as $j)
            <?php if ($cpt%2 == 0){ ?>
            <tr class="">
                <td class="bg-white align-top pl-2">
                    {{ $j->nom }}</td>
                <td class="bg-white align-center">
                    @foreach ($dispos as $d)
                        @if ($d->idJour == $j->id)
                            <div class="my-2">
                                {{ Carbon\Carbon::createFromFormat('H:i:s', $d->heureDebut)->format('H:i') }}</div>
                        @endif
                    @endforeach
                </td>
                <td class="bg-white">
                    @foreach ($dispos as $d)
                        @if ($d->idJour == $j->id)
                            <div class="my-2">
                                {{ Carbon\Carbon::createFromFormat('H:i:s', $d->heureFin)->format('H:i') }}</div>
                        @endif
                    @endforeach
                </td>
                <td class="bg-white">
                    @foreach ($dispos as $d)
                        @if ($d->idJour == $j->id)
                            <button class="bg-selected-green mx-1 my-1 rounded p-0.5 w-5/12" type="button"
                                wire:click="getInfoDispo({{ $d->id }})">Modifier</button>
                            <button class="bg-selected-green mx-1 my-1 rounded p-0.5 w-5/12" type="button"
                                wire:click="confirmerSuppression({{ $d->id }})">Supprimer</button>
                        @endif
                    @endforeach
                </td>
            </tr>
            <?php } else { ?>
            <tr>
                <td class="bg-table-green align-top pl-2">
                    {{ $j->nom }}</td>
                <td class="bg-table-green">
                    @foreach ($dispos as $d)
                        @if ($d->idJour == $j->id)
                            <div class="my-2">
                                {{ Carbon\Carbon::createFromFormat('H:i:s', $d->heureDebut)->format('H:i') }}</div>
                        @endif
                    @endforeach
                </td>
                <td class="bg-table-green pr-4">
                    @foreach ($dispos as $d)
                        @if ($d->idJour == $j->id)
                            <div class="my-2">
                                {{ Carbon\Carbon::createFromFormat('H:i:s', $d->heureFin)->format('H:i') }}</div>
                        @endif
                    @endforeach
                </td>
                <td class="bg-table-green">
                    @foreach ($dispos as $d)
                        @if ($d->idJour == $j->id)
                            <button class="bg-selected-green mx-1 my-1 rounded p-0.5 w-5/12" type="button"
                                wire:click="getInfoDispo({{ $d->id }})">Modifier</button>
                            <button class="bg-selected-green mx-1 my-1 rounded p-0.5 w-5/12" type="button"
                                wire:click="confirmerSuppression({{ $d->id }})">Supprimer</button>
                        @endif
                    @endforeach
                </td>
            </tr>
            <?php } ?>

            <?php $cpt += 1; ?>
        @endforeach

    </table>

    <div class="flex justify-end">
        <button wire:click="formAjout" class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide"
            type="button">Ajouter</button>
    </div>

    <x-modal title="Ajouter une disponibilité" name="ajouterDispo" :show="false">
        <ul class="ml-8">
            @error('heureDebut')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('heureFin')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('jour')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
        </ul>
        <form wire:submit.prevent="ajoutDispo" class="bg-white p-4 rounded-lg">
            <div class="grid grid-cols-4 gap-y-4">

                <label class="text-right" for="heureDebut">Heure de début:*</label>
                <input wire:model="heureDebut" class="ml-2" type="time" min="07:00" max="22:00"
                    id="heureDebut" name="heureDebut" />

                <label class="text-right" for="heureFin">Heure de fin:*</label>
                <input wire:model="heureFin" class="ml-2" type="time" min="07:00" max="22:00" id="heureFin"
                    name="heureFin" />


                <label class="text-right" for="jour">Jour:*</label>
                <select wire:model="jour" id="jour" name="jour" class="ml-2">
                    @foreach ($jours as $j)
                        <option value={{ $j->id }}>
                            {{ $j->nom }}</option>
                    @endforeach
                </select>

            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>

    <x-modal title="Modifier une disponibilité" name="modifierDispo" :show="false">
        <ul class="ml-8">
            @error('heureDebut')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('heureFin')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
            @error('jour')
                <li class="list-disc text-red-400">

                    <span class="error text-red-400">{{ $message }}</span>

                </li>
            @enderror
        </ul>
        <form wire:submit.prevent="modifDispo" class="bg-white p-4 rounded-lg">
            <div class="grid grid-cols-4 gap-y-4">

                <label class="text-right" for="heureDebut">Heure de début:*</label>
                <input wire:model="heureDebut" class="ml-2" type="time" min="07:00" max="22:00"
                    id="heureDebut" name="heureDebut" />

                <label class="text-right" for="heureFin">Heure de fin:*</label>
                <input wire:model="heureFin" class="ml-2" type="time" min="07:00" max="22:00"
                    id="heureFin" name="heureFin" />


                <label class="text-right" for="jour">Jour:*</label>
                <select wire:model="jour" id="jour" name="jour" class="ml-2">
                    @foreach ($jours as $j)
                        <option value={{ $j->id }} {{ $j->id === $jour ? 'selected' : '' }}>
                            {{ $j->nom }}</option>
                    @endforeach
                </select>

            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>

    <x-modal title="Supprimer une disponibilité" name="supprimerDispo" :show="false">
        <form wire:submit.prevent="supDispo" class="bg-white p-4 rounded-lg">
            <div class="">
                <p>Êtes vous sûr de vouloir supprimer cette disponibilité?</p><br>
                <p>Le {{ $nomJour }} de {{ $heureDebut }} à {{ $heureFin }}. </p>

            </div>
            <div class="flex justify-center mt-4">
                <button class="w-3/12 bg-selected-green mx-1 my-1 rounded p-0.5" type="submit">Confirmer</button>
            </div>

        </form>
    </x-modal>
</div>
