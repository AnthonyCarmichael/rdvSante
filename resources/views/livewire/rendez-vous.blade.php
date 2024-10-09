<div>
    <x-modal title="Ajouter un rendez-vous" name="ajouterRdv" :show="false">
        <form wire:submit.prevent="createRdv">
            <p class="font-bold">Date et heure sélectionnées:</p>  
            <p class="mb-5">{{$selectedTime}}</p>
          
            <div>
                <label class="block font-bold" for="client">Choisir un client :</label>
                <input type="text" wire:model.live="filter" name="recherche" id="recherche" placeholder="Recherche" class="text-grey-400">
                <select required id="client" class="block w-full mt-2 border rounded" size="5">
                    <option class="font-bold" value="" disabled>Sélectionnez un client</option>
                    @if (!is_null($clients))
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->prenom." ".$client->nom }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            

            <div class="my-4">
                <label class="block" for="dateFin">Date et heure de la fin de l'indisponibilité :</label>
                <input type="datetime-local" min="{{$selectedTime }}"required>
            </div>

            <div class="">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
            </div>
        </form>
    </x-modal>

</div>
