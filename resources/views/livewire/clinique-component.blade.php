<div>
    <div class="m-16">
        <div class="flex items-center mb-4">
            <input wire:model.live="search" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mr-2">
        </div>

        <table class="table-auto w-full border-solid border-2 border-gray-400">
            <thead>
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        <button wire:click="sortBy('nom')" class="font-bold">
                            Nom
                            @if ($sortField === 'nom')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </button>
                    </th>

                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        <button wire:click="sortBy('description')" class="font-bold">
                            Rue
                            @if ($sortField === 'description')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </button>
                    </th>

                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        <button wire:click="sortBy('duree')" class="font-bold">
                            Numéro civique
                            @if ($sortField === 'duree')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </button>
                    </th>

                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        <button wire:click="sortBy('prix')" class="font-bold">
                            Code postal
                            @if ($sortField === 'prix')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </button>
                    </th>

                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($foundCliniques as $clinique)
                    <tr
                        class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                        <td wire:click="consulterclinique({{ $clinique->id }})" class="w-2/12 pr-4">{{ $clinique->nom }}</td>
                        <td wire:click="consulterclinique({{ $clinique->id }})" class="w-2/12 pr-4">{{ $clinique->rue }}</td>
                        <td wire:click="consulterclinique({{ $clinique->id }})" class="w-2/12 pr-4">{{ $clinique->noCivique }}</td>
                        <td wire:click="consulterclinique({{ $clinique->id }})" class="w-2/12 pr-4">{{ $clinique->codePostal }}</td>
                        <td class="w-2/12 pr-4 justify-between">
                            <button class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5"
                                wire:click="modifierclinique({{ $clinique->id }})" type="button">
                                Modifier
                            </button>

                            <button type="button" wire:click="confirmDelete({{ $clinique->id }})"
                                class="w-5/12 bg-selected-green mx-1 my-1 rounded p-0.5">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end">
            <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5" wire:click="openModalAjouterclinique()">
                Ajouter
            </button>
        </div>
    </div>
</div>
