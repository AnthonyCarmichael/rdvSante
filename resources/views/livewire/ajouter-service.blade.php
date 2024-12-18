@if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div>
    <div class="m-16">
        <div class="flex items-center mb-4">
            <input wire:model.live="search" type="text" placeholder="Rechercher..."
                class="form-input rounded-md shadow-sm mr-2">

            <label class="ml-4 text-m text-right font-bold" for="actif">Statut:</label>
            <select wire:change="filtreService" wire:model="filtreActif" id="filtreActif" name="filtreActif"
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
                            @if ($service->actif == 1)
                                <button class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5"
                                    wire:click="modifierService({{ $service->id }})" type="button">
                                    Modifier
                                </button>

                                <button type="button" wire:click="desactiverService({{ $service->id }})"
                                    class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                    Désactiver
                                </button>
                            @elseif ($service->actif == 0)
                                <button class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5"
                                    wire:click="activerService({{ $service->id }})" type="button">
                                    Activer
                                </button>

                                <button type="button" wire:click="confirmDelete({{ $service->id }})"
                                    class="w-auto bg-selected-green mx-1 my-1 rounded p-0.5">
                                    Supprimer
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end z-0">
            <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" wire:click="openModalAjouterService()">
                Ajouter
            </button>
        </div>
    </div>

    <div class="flex justify-end z-0">
        <x-modal title="Ajouter un service" name="ajouterService" :show="false">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form wire:submit.prevent="ajouterService">
                    <div class="mb-4">
                        <label for="nomservice" class="block text-sm font-medium text-gray-700">Nom du service *</label>
                        <input required minlength="3" type="text" name="nomservice" id="nomservice"
                            wire:model="nomservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="professionservice" class="block text-sm font-medium text-gray-700">Profession *</label>
                        <select required name="professionservice" id="professionservice" wire:model="professionservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner une profession *</option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}">{{ $profession->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="descriptionservice"
                            class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="descriptionservice" id="descriptionservice" wire:model="descriptionservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            rows="4"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="dureeservice" class="block text-sm font-medium text-gray-700">Durée (minutes) *</label>
                        <input required min="1" type="number" name="dureeservice" id="dureeservice"
                            wire:model="dureeservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!--
                    <script>
                        let input = document.getElementById("dureeservice");

                        input.addEventListener("mousewheel",
                            function(event) {
                                this.blur()
                            });
                    </script>
                    -->

                    <div class="mb-4">
                        <label for="prixservice" class="block text-sm font-medium text-gray-700">Prix *</label>
                        <input required min="0" step="0.01" type="number" pattern="\d" name="prixservice" id="prixservice"
                            wire:model="prixservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <!--
                    <script>
                        let input = document.getElementById("prixservice");

                        input.addEventListener("mousewheel",
                            function(event) {
                                this.blur()
                            });
                    </script>
                -->

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="checkboxrdv" id="checkboxrdv" wire:model.live="checkboxrdv"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Empêcher les rendez-vous de dernière minute</span>
                        </label>
                        <div class="mt-2 {{ $checkboxrdv == true ? 'visible' : 'hidden' }}">
                            <label for="tempsavantrdv" class="block text-sm font-medium text-gray-700">Temps minimum avant rendez-vous (heures) *</label>
                            <input {$checkboxrdv ? required} type="number" name="tempsavantrdv" min="0"
                                id="tempsavantrdv" wire:model="tempsavantrdv"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!--<div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="personneacharge" id="personneacharge"

                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Permettre les rendez-vous pour une personne à charge</span>
                        </label>
                    </div>-->

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

        <x-modal title="Modifier un service" name="modifierService" :show="false">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form wire:submit.prevent="updateService">
                    <div class="mb-4">
                        <label for="nomservice" class="block text-sm font-medium text-gray-700">Nom du service *</label>
                        <input required minlength="3" type="text" name="nomservice" id="nomservice"
                            wire:model="nomservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="professionservice"
                            class="block text-sm font-medium text-gray-700">Profession *</label>
                        <select required name="professionservice" id="professionservice"
                            wire:model="professionservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner une profession *</option>
                            @foreach ($professions as $profession)
                                <option value="{{ $profession->id }}">{{ $profession->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="descriptionservice"
                            class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="descriptionservice" id="descriptionservice" wire:model="descriptionservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            rows="4"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="dureeservice" class="block text-sm font-medium text-gray-700">Durée (minutes) *</label>
                        <input required min="1" type="number" name="dureeservice" id="dureeservice"
                            wire:model="dureeservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label for="prixservice" class="block text-sm font-medium text-gray-700">Prix *</label>
                        <input required min="0" step="0.01" type="number" name="prixservice"
                            id="prixservice" wire:model="prixservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="checkboxrdv" id="checkboxrdv" wire:model.live="checkboxrdv"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Empêcher les rendez-vous de dernière minute</span>
                        </label>
                        <div class="{{ $checkboxrdv == true ? 'visible' : 'hidden' }} mt-2">
                            <label for="tempsavantrdv" class="block text-sm font-medium text-gray-700">Temps minimum avant rendez-vous (heures) *</label>
                            <input {{ $checkboxrdv ? 'required' : '' }} type="number" name="tempsavantrdv"
                                min="0" id="tempsavantrdv" wire:model="tempsavantrdv"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!--<div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="personneacharge" id="personneacharge"

                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Permettre les rendez-vous pour une personne à charge</span>
                        </label>
                    </div>-->

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </x-modal>

        <x-modal title="Informations service" name="consulterService" :show="false">
            <div class="border border-gray-300 bg-white p-6 m-4 rounded-lg shadow-md">
                <div class="flex flex-col gap-y-4">
                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Nom service</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $nomservice }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Profession</p>
                        <p class="text-sm text-gray-900 ml-2">
                            @foreach ($professions as $profession)
                                @if ($profession->id == $professionservice)
                                    {{ $profession->nom }}
                                @endif
                            @endforeach
                        </p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Description</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $descriptionservice }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Durée du service</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $dureeservice }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Prix du service</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $prixservice }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Nombre d'heures limite réservation</p>
                        <p class="text-sm text-gray-900 ml-2"> {{ $tempsavantrdv }}</p>
                    </div>

                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-700 w-1/3">Personne à charge</p>
                        <p class="text-sm text-gray-900 ml-2">
                            @if ($personneacharge == 0)
                                Non
                            @else
                                Oui
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4">
                <button wire:click="modifierService({{ $service_id }})"
                    class="w-3/12 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition ease-in-out duration-150">
                    Modifier
                </button>
            </div>

        </x-modal>


        @if ($showDeleteModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow-lg">
                    <p>Êtes-vous sûr de vouloir supprimer ce service ?</p>
                    <div class="flex justify-between mt-4">
                        <button wire:click="deleteService" class="bg-red-500 text-white px-4 py-2">
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
</div>
