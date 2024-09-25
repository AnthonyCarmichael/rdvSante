<div>
    <table class="table-auto z-0">
        <tr>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Nom</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Description</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Prix</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Pause</th>
            <th class="border-solid border-b-2 border-black bg-mid-green text-left">Actions</th>
        </tr>

    </table>

    <div class="flex justify-end z-0">
        <!--<button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" type="button"
            wire:click=ajouterClient()>Ajouter</button>-->

        <x-modal title="Ajouter un service" name="ajouterService" :show="false">
            <!-- Contenu du modal -->
            <form wire:submit.prevent="createService">
                <input type="text" wire:model="note" placeholder="Note" required>
                <input type="datetime-local" wire:model="dateHeureDebut" required>
                <input type="datetime-local" wire:model="dateHeureFin" required>


                <div class="">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
                </div>
            </form>
        </x-modal>

        <button class="w-2/12 bg-selected-green mx-1 my-2 rounded p-0.5 hide" x-data x-on:click="$dispatch('open-modal', { name : 'ajouterService' })">
            Ajouter
        </button>
    </div>
</div>
