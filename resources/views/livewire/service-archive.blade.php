<div>
    <div class="m-16">
        <div class="flex items-center mb-4">
            <input wire:model.live="search" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mr-2">

            <button wire:click="resetFilters"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-auto">
                Réinitialiser les filtres
            </button>
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
                            Description
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
                            Durée
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
                            Prix
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
                @foreach ($services as $service)
                    <tr
                        class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                        <td wire:click="consulterService({{ $service->id }})" class="w-2/12 pr-4">{{ $service->nom }}
                        </td>
                        <td wire:click="consulterService({{ $service->id }})" class="w-2/12 pr-4">
                            {{ $service->description }}</td>
                        <td wire:click="consulterService({{ $service->id }})" class="w-2/12 pr-4">{{ $service->duree }}
                            {{ $service->duree > 1 ? 'minutes' : 'minute' }}</td>
                        <td wire:click="consulterService({{ $service->id }})" class="w-2/12 pr-4">{{ $service->prix }} $</td>
                        <td class="w-2/12 pr-4 justify-between">
                            <button type="button" wire:click="activerService({{ $service->id }})"
                                class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                Activer
                            </button>

                            <button type="button" wire:click="confirmDelete({{ $service->id }})"
                                class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex items-center mt-4">
            <button wire:click="resetFilters"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-auto">
                Voir les services actifs
            </button>
        </div>
    </div>
</div>
