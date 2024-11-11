<div>
    <x-input-error :messages="$errors->get('clinique')" class="mt-2 mb-4" />

    <div class="relative min-h-screen" x-data="{ open: true}">
        <aside :class="{ '-translate-x-full': !open }"
            class="bg-mid-green z-10 text-darker-green absolute inset-y-0 left-0
            transform overflow-y-auto transition ease-in-out duration-200 shadow-lg">

            <div class="flex justify-end">
                <button type="button" @click="open = !open" class="inline-flex justify-center items-center rounded-md absolute bg-pale-green
                    hover:bg-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex items-center mb-4">
                <input wire:model.live="search" type="text" placeholder="Rechercher..."
                    class="form-input rounded-md shadow-sm mr-2">

                <label class="ml-4 text-m text-right font-bold" for="actif">Statut:</label>
                <select wire:change="filtreClient" wire:model="filtreActif" id="filtreActif" name="filtreActif"
                    class="h-8 text-m ml-2 py-0 rounded">
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
                            <button wire:click="sortBy('nom')" class="font-bold">
                                Dossier
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
                            <button wire:click="sortBy('nocivique')" class="font-bold">
                                Clients
                                @if ($sortField === 'nocivique')
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
                    @foreach ($clients as $client)
                        <tr
                            class="@if ($loop->odd) bg-white @else bg-table-green @endif hover:bg-blue-300 cursor-pointer">
                            <td wire:click="consulterClient({{ $client->id }})" class="w-auto pr-4">{{ $client->nom }}</td>
                            <td wire:click="consulterClient({{ $client->id }})" class="w-auto pr-4">{{ $client->noCivique }} {{ $client->rue }}, {{ $client->codePostal }}, {{ $client->ville->nom }} ({{ $client->ville->province->nom }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </aside>
    </div>
</div>
