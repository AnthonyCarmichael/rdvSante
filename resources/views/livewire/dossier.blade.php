<div class="flex min-h-screen">
    <div class="w-1/5 p-4 border-r border-gray-300">
        <div class="items-center mb-4">
            <input wire:model.live="search" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mb-2">

            <label class="ml-4 text-m text-right font-bold" for="actif">Statut:</label>
            <select wire:change="filtreDossier" wire:model="filtreActif" id="filtreActif" name="filtreActif"
                class="h-8 text-m ml-2 py-0 rounded mb-2">
                <option value='1' selected>Actif</option>
                <option value='0'>Inactif</option>
                <option value='2'>Tous</option>
            </select>

            <button wire:click="resetFilters"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-auto">
                Réinitialiser les filtres
            </button>
        </div>

        <table class="table-auto w-full border-solid border-2 border-gray-400">
            <thead>
                <tr>
                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        <button wire:click="sortBy('id')" class="font-bold">
                            Dossier
                            @if ($sortField === 'id')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </button>
                    </th>

                    <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                        <button wire:click="sortBy('nom')" class="font-bold">
                            Clients
                            @if ($sortField === 'nom')
                                @if ($sortDirection === 'asc')
                                    ↑
                                @else
                                    ↓
                                @endif
                            @endif
                        </button>
                    </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($dossiers as $dossier)
                    <tr
                        class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                        <td wire:click="consulterDossier({{ $dossier->id }})" class="w-auto pr-4">{{ $dossier->client->id }}</td>
                        <td wire:click="consulterDossier({{ $dossier->id }})" class="w-auto pr-4">{{ $dossier->client->nom }} {{ $dossier->client->prenom }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="w-4/5 p-4">
        <div class="w-full bg-green flex">
            @if ($client)
                <div class="w-1/2 p-2">
                    <h1 class="text-xl font-bold mb-2">{{ $client->prenom }} {{ $client->nom }}</h1>
                    <p class="text-center">{{ $client->ddn }}</p>
                </div>

                <div class="w-1/2 p-2">
                    <p class="flex-end"><strong>Téléphone : </strong>{{ $client->telephone }}</p>
                    <p class="flex-end"><strong>Courriel : </strong>{{ $client->courriel }}</p>
                    <p class="flex-end"><strong>Adresse : {{ $client->noCivique ?? 'N/A' }} {{ $client->rue ?? 'N/A' }}, {{ $client->codePostal ?? 'N/A' }}, {{ $client->ville?->nom ?? 'N/A' }} ({{ $clinique->ville?->province?->nom ?? 'N/A' }})</p>
                </div>
            @else
                <p>Sélectionnez un client dans le tableau pour voir ses informations.</p>
            @endif
        </div>

        <div class="pt-12 pb-0 mb-0">
            <div class="flex space-x-4 mb-4 bg-green">
                <button wire:click="setView('Fiches')" class="btn w-1/3 p-2">Fiches du dossier</button>
                <button wire:click="setView('Images')" class="btn w-1/3 p-2">Images</button>
                <button wire:click="setView('Documents')" class="btn w-1/3 p-2">Documents</button>
            </div>
        </div>


        @if ($view == "Fiches")
            <div class="flex z-0">
                <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide">
                    Ajouter
                </button>
            </div>

            <table class="table-auto w-full border-solid border-2 border-gray-400">
                <thead>
                    <tr>
                        <th class="border-solid border-b-2 border-black bg-mid-green text-left">
                            <button wire:click="sortBy('nom')" class="font-bold">
                                Type fiche
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
                            <button wire:click="sortBy('nom')" class="font-bold">
                                Date de dernière modification
                                @if ($sortField === 'nom')
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
                    @if ($fiches)
                        @foreach ($fiches as $fiche)
                            <tr
                                class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                                <td wire:click="consulterDossier({{ $fiche->id }})" class="w-auto pr-4">{{ $fiche->id }}</td>
                                <td wire:click="consulterDossier({{ $fiche->id }})" class="w-auto pr-4">{{ $fiche->dateHeure }}</td>
                                <td class="w-auto pr-4 justify-between">
                                    <button type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                        Modifier
                                    </button>

                                    @if ($dossier)
                                        <button type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                            Désactiver
                                        </button>
                                    @else
                                        <button type="button" class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                            Activer
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        @else
            <p>Sélectionnez un client dans le tableau pour voir ses informations.</p>
        @endif

    </div>
</div>