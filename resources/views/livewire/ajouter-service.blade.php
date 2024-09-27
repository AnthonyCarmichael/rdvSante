<div>
    <table class="table-auto z-0">
        <tr>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Nom</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Description</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Prix</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Pause</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
        </tr>

        @foreach($services as $service)
        <tr>
            <td class="border">{{ $service->nom }}</td>
            <td class="border">{{ $service->description }}</td>
            <td class="border">{{ $service->prix }}</td>
            <td class="border">{{ $service->pause ? 'Oui' : 'Non' }}</td>
            <td class="border">
                <!-- Ajoute des boutons d'action ici si nécessaire -->
            </td>
        </tr>
        @endforeach
    </table>

    <div class="flex justify-end z-0">
        <!--<button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" type="button"
            wire:click=ajouterClient()>Ajouter</button>-->

        <x-modal title="Ajouter un service" name="ajouterService" :show="false">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form wire:submit.prevent="ajouterService">
                    <!-- Nom du service -->
                    <div class="mb-4">
                        <label for="nomservice" class="block text-sm font-medium text-gray-700">Nom du service</label>
                        <input type="text" name="nomservice" id="nomservice" wire:model="nomservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Catégorie (Dropdown) -->
                    <div class="mb-4">
                        <label for="categorieservice" class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="categorieservice" id="categorieservice" wire:model="categorieservice"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="descriptionservice" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="descriptionservice" id="descriptionservice" wire:model="descriptionservice"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" rows="4"></textarea>
                    </div>

                    <!-- Durée -->
                    <div class="mb-4">
                        <label for="dureeservice" class="block text-sm font-medium text-gray-700">Durée (minutes)</label>
                        <input type="number" name="dureeservice" id="dureeservice" wire:model="dureeservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Prix -->
                    <div class="mb-4">
                        <label for="prixservice" class="block text-sm font-medium text-gray-700">Prix</label>
                        <input type="number" name="prixservice" id="prixservice" wire:model="prixservice"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>

                    <!-- Taxable -->
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="taxableservice" id="taxableservice" wire:model="taxableservice"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Service taxable</span>
                        </label>
                    </div>

                    <!-- Pause après rendez-vous -->
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="pauserdv" id="pauserdv" wire:model="pauserdv"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Je veux une pause après les rendez-vous</span>
                        </label>
                        <div class="mt-2" x-show="pauserdv">
                            <label for="dureepause" class="block text-sm font-medium text-gray-700">Durée de la pause (minutes)</label>
                            <input type="number" name="dureepause" id="dureepause" wire:model="dureepause"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Dernière minute -->
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="rdvderniereminute" id="rdvderniereminute" wire:model="rdvderniereminute"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Empêcher les rendez-vous de dernière minute</span>
                        </label>
                        <div class="mt-2" x-show="rdvderniereminute">
                            <label for="tempsavantrdv" class="block text-sm font-medium text-gray-700">Temps minimum avant rendez-vous (heures)</label>
                            <input type="number" name="tempsavantrdv" id="tempsavantrdv" wire:model="tempsavantrdv"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Personne à charge -->
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="personneacharge" id="personneacharge" wire:model="personneacharge"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="ml-2 text-gray-700">Permettre les rendez-vous pour une personne à charge</span>
                        </label>
                    </div>

                    <!-- Boutons -->
                    <div class="mt-6">
                        <button type="submit"
                                class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Confirmer
                        </button>
                        <input type="reset" value="Annuler"
                            class="w-full mt-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    </div>
                </form>
            </div>
        </x-modal>

        <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" x-data x-on:click="$dispatch('open-modal', { name : 'ajouterService' })">
            Ajouter
        </button>
    </div>
</div>
