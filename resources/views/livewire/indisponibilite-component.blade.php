<div>
    <x-modal title="Ajouter une indisponibilité le {{$selectedTime}}" name="ajouterIndisponibilite" :show="false">
        <form wire:submit.prevent="createIndisponibilite">
            <div>
                <label class="block" for="note">Note :</label> 
                <input type="text" name="note" wire:model="note" placeholder="Note" required>
            </div>
                
            <div class="my-4">
                <label class="block" for="dateFin">Date et heure de la fin de l'indisponibilité :</label>
                <input type="datetime-local" wire:model="dateHeureFin" min="{{$selectedTime }}"required>
            </div>

            <div class="">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
            </div>
        </form>
    </x-modal>


</div>
