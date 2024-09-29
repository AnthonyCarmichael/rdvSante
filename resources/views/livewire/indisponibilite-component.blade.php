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

    
    <x-modal title="Consulter l'indisponibilité du {{$dateHeureDebut}} au {{$dateHeureFin}}" name="consulterIndisponibilite" :show="false">
        <div x-data="{ editable: false }" @reset-editable.window="editable = false">
            <form wire:submit.prevent="modifierIndisponibilite" >
                <div>
                    <label class="block" for="note">Note :</label>
                    <input type="text" name="note" wire:model="tempNote" placeholder="Note" required :readonly="!editable"
                        x-bind:class="editable ? 'bg-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed'" 
                        class="border rounded py-2 px-3 transition duration-150 ease-in-out">
                </div>

                <div class="my-4">
                    <label class="block" for="dateFin">Date et heure de la fin de l'indisponibilité :</label>
                    <input type="datetime-local" wire:model="tempDateHeureFin" min="{{$dateHeureDebut }}"required :readonly="!editable"
                        x-bind:class="editable ? 'bg-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed'" 
                        class="border rounded py-2 px-3 transition duration-150 ease-in-out">
                </div>

                <div class="flex">
                    <div x-show="editable">
                        <button type="submit" class="mr-4 bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                    </div>
                    <button type="button" @click="editable = false; @this.annuler()" x-show="editable" class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">
                        Annuler
                    </button>
                    <button type="button" @click="editable = !editable" x-show="!editable" class="px-4 py-2 bg-blue-500 text-white rounded bg-orange-500">
                        Modifier
                    </button>
                </div>

            </form>

        </div>
    </x-modal>

  

</div>
