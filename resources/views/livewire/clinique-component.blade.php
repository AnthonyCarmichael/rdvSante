<div>
    <x-input-error :messages="$errors->get('clinique')" class="mt-2 mb-4" />

    <div class="m-4">
        <div class="flex items-center mb-4">
            <input wire:model.live="search" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mr-2">

            <label class="ml-4 text-m text-right font-bold" for="actif">Statut:</label>
            <select wire:change="filtreClinique" wire:model="filtreActif" id="filtreActif" name="filtreActif"
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
                        <button wire:click="sortBy('nocivique')" class="font-bold">
                            Adresse
                            @if ($sortField === 'nocivique')
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
                        <td wire:click="consulterClinique({{ $clinique->id }})" class="w-auto pr-4">{{ $clinique->nom }}</td>
                        <td wire:click="consulterClinique({{ $clinique->id }})" class="w-auto pr-4">{{ $clinique->noCivique }} {{ $clinique->rue }}, {{ $clinique->codePostal }}, {{ $clinique->ville->nom }} ({{ $clinique->ville->province->nom }})</td>
                        <td class="w-auto pr-4 justify-between">
                            <button class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5"
                                wire:click="modifierClinique({{ $clinique->id }})" type="button">
                                Modifier
                            </button>

                            @if ($clinique->actif == 1)
                                <button type="button" wire:click="desactiverClinique({{ $clinique->id }})"
                                    class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                    Désactiver
                                </button>
                            @elseif ($clinique->actif == 0)
                                <button type="button" wire:click="activerClinique({{ $clinique->id }})"
                                    class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                    Activer
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end z-0">
            <button wire:click="openModalAjouterClinique()"
                class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide">
                Ajouter
            </button>
        </div>
    </div>

    <div class="flex justify-end">
        <x-modal title="Ajouter une clinique" name="ajouterClinique" :show="false">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form wire:submit.prevent="ajouterClinique">
                    <div class="mb-4">
                        <label for="nomClinique" class="block text-sm font-medium text-gray-700">Nom de la clinique *</label>
                        <input required minlength="3" type="text" name="nomClinique" id="nomClinique"
                            wire:model="nomClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="rueClinique" class="block text-sm font-medium text-gray-700">Rue *</label>
                        <input required minlength="3" type="text" name="rueClinique" id="rueClinique"
                            wire:model="rueClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="noCiviqueClinique" class="block text-sm font-medium text-gray-700">Numéro civique *</label>
                        <input required min="0" step="0.01" type="number" pattern="\d" name="noCiviqueClinique" id="noCiviqueClinique"
                            wire:model="noCiviqueClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="codePostalClinique" class="block text-sm font-medium text-gray-700">Code postal *</label>
                        <input required type="text" name="codePostalClinique" id="codePostalClinique" wire:model="codePostalClinique" pattern="[A-Z]\d[A-Z] \d[A-Z]\d" placeholder="ex: A0A 0A0" maxlength="7"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').replace(/^(.{3})/, '$1 ').trim()">
                    </div>

                    <div class="mb-4">
                        <label for="villeClinique" class="block text-sm font-medium text-gray-700">Ville *</label>
                        <select required name="villeClinique" id="villeClinique" wire:model.live="villeClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner une ville</option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

        <x-modal title="Modifier une clinique" name="modifierClinique" :show="false">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form wire:submit.prevent="updateClinique">
                    <div class="mb-4">
                        <label for="nomClinique" class="block text-sm font-medium text-gray-700">Nom de la clinique *</label>
                        <input required minlength="3" type="text" name="nomClinique" id="nomClinique"
                            wire:model="nomClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="rueClinique" class="block text-sm font-medium text-gray-700">Rue *</label>
                        <input required minlength="3" type="text" name="rueClinique" id="rueClinique"
                            wire:model="rueClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="noCiviqueClinique" class="block text-sm font-medium text-gray-700">Numéro civique *</label>
                        <input required min="0" step="0.01" type="number" pattern="\d" name="noCiviqueClinique" id="noCiviqueClinique"
                            wire:model="noCiviqueClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="codePostalClinique" class="block text-sm font-medium text-gray-700">Code postal *</label>
                        <input maxlength="7" required type="text" name="codePostalClinique" id="codePostalClinique"
                            wire:model="codePostalClinique" pattern="[A-Z]\d[A-Z] \d[A-Z]\d" title="Code postal"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="villeClinique" class="block text-sm font-medium text-gray-700">Ville *</label>
                        <select required name="villeClinique" id="villeClinique" wire:model="villeClinique"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner une ville</option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville->id }}">{{ $ville->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

        <x-modal title="Informations clinique" name="consulterClinique" :show="false">
            <div class="border border-gray-300 bg-white p-6 m-4 rounded-lg shadow-md">
                <div class="flex flex-col gap-y-4">
                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Nom clinique</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $nomClinique }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Numéro civique</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $noCiviqueClinique }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Rue</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $rueClinique }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Code postal</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $codePostalClinique }}</p>
                    </div>

                    @foreach ($villes as $ville)
                        @if ($ville->id == $villeClinique)
                            <div class="flex items-center">
                                <p class="text-sm font-semibold text-gray-700 w-1/3">Ville</p>
                                <p class="text-sm text-gray-900 ml-2"> {{ $ville->nom }}</p>
                            </div>

                            <div class="flex items-center">
                                <p class="text-sm font-semibold text-gray-700 w-1/3">Province</p>
                                <p class="text-sm text-gray-900 ml-2"> {{ $ville->province->nom }}</p>
                            </div>

                            <div class="flex items-center">
                                <p class="text-sm font-semibold text-gray-700 w-1/3">Pays</p>
                                <p class="text-sm text-gray-900 ml-2"> {{ $ville->province->pays->nom }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center mt-4">
                <button wire:click="modifierClinique({{ $clinique_id }})"
                    class="w-3/12 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out duration-150">
                    Modifier
                </button>
            </div>
        </x-modal>
    </div>

    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg">
                <p>Êtes-vous sûr de vouloir supprimer cette clinique ?</p>
                <div class="flex justify-between mt-4">
                    <button wire:click="deleteClinique" class="bg-red-500 text-white px-4 py-2">
                        Confirmer
                    </button>
                    <button wire:click="cancelDelete" class="bg-gray-500 text-white px-4 py-2">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

        <div class="fixed inset-0 bg-black opacity-50 z-40"></div>
    @endif


</div>

