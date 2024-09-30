<div>
    <x-modal title="Ajouter une indisponibilité" name="ajouterIndisponibilite" :show="false">
        <form wire:submit.prevent="createIndisponibilite">
            <p class="font-bold">Date et heure sélectionnées:</p>  
            <p class="mb-5">{{$selectedTime}}</p>
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

    
    <x-modal title="Indisponible" name="consulterIndisponibilite" :show="false">
        <p>Du : {{$dateHeureDebut}}</p>
        <p class="mb-4">au : {{$dateHeureFin}}</p>
        <div x-data="{ editable: false }" @reset-editable.window="editable = false">
            <form wire:submit.prevent="modifierIndisponibilite" >
                <div>
                    <label class="block" for="note">Note :</label>
                    <input type="text" name="note" wire:model="tempNote" placeholder="Note" required :readonly="!editable"
                        x-bind:class="editable ? 'bg-white' : 'bg-gray-200 text-gray-500 cursor-not-allowed'" 
                        class="w-full border rounded py-2 px-3 transition duration-150 ease-in-out">
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
                    <button type="button" @click="editable = !editable" x-show="!editable" class="px-4 py-2 text-white rounded bg-orange-500 hover:bg-orange-700">
                        Modifier
                    </button>
                    <button type="button" @click="$dispatch('open-modal', { name: 'confirmDeleteModal' });" x-show="!editable" class="ml-4 px-4 py-2 bg-blue-500 text-white rounded bg-red-500 hover:bg-red-700">
                        Supprimer
                    </button>
                </div>

            </form>

        </div>
    </x-modal>

    <x-modal title="Confirmer la Suppression" name="confirmDeleteModal" :show="false">
        <p>Êtes-vous sûr de vouloir supprimer cette indisponibilité ?</p>
        <div class="flex mt-8">
            <button wire:click="deleteIndispo" class="mr-4 px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded">Supprimer</button>
            <button @click="$dispatch('open-modal', { name: 'consulterIndisponibilite' });" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">Annuler</button>
        </div>
    </x-modal>
  

</div>
