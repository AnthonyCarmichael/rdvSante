<div>
    <x-modal title="Ajouter un rendez-vous" name="ajouterRdv" :show="false">
        <form wire:submit.prevent="createRdv">
            <p class="font-bold">Date et heure sélectionnées:</p>  
            <p class="mb-5">{{$selectedTime}}</p>
    

            @if (!is_null($clients))
                <div>
                <label class="block" for="client">Choisir un client :</label>
                    <select id="item">
                        <option value="">Sélectionnez un item</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->nom }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

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
