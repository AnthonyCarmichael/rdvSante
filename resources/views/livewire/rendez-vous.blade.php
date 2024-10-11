<div>
    <x-modal title="Ajouter un rendez-vous" name="ajouterRdv" :show="false">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form wire:submit.prevent="createRdv">
                <p class="block text-sm font-medium text-gray-700">Date et heure sélectionnées:</p>
                <p class="mb-5">{{$selectedTime}}</p>

                <div>
                    <label class="block text-sm font-medium text-gray-700" for="client">Choisir un client :</label>
                    <input type="text" wire:model.live="filter" name="recherche" id="recherche" placeholder="Recherche" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <select required id="client" name="client" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" size="5">
                        <option class="font-bold" value="" disabled>Sélectionnez un client</option>
                        @if (!is_null($clients))
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->prenom." ".$client->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="service">Service :</label>
                    <select required id="service" name="service" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option class="font-bold" value="" disabled>Sélectionnez un service</option>
                        @if (!is_null($services))
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>


                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="clinique">Clinique :</label>
                    <select required id="clinique" name="clinique" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option class="font-bold" value="" disabled>Sélectionnez une clinique</option>
                        @if (!is_null($cliniques))
                            @foreach($cliniques as $clinique)
                                <option value="{{ $clinique->id }}">{{ $clinique->nom }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700" for="raison">Raison du rendez-vous :</label>
                    <textarea name="raison" id="raison" wire:model="raison"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                rows="4"></textarea>
                </div>

                <div class="mt-8">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                </div>
            </form>
        </div>
    </x-modal>

</div>
