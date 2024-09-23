<div>
    <h3>Indisponibilités</h3>
    <ul>
        @foreach($indisponibilites as $indisponibilite)
            <li>{{ $indisponibilite->note }} ({{ $indisponibilite->dateHeureDebut }} - {{ $indisponibilite->dateHeureFin }})</li>
        @endforeach
    </ul>


    <x-modal name="ajouterIndisponibilite" :show="false">
        <!-- Contenu du modal -->
        <h2 class="text-xl font-bold mb-4">Ajouter Indisponibilité</h2>
        <form wire:submit.prevent="createIndisponibilite">
            <input type="text" wire:model="note" placeholder="Note" required>
            <input type="datetime-local" wire:model="dateHeureDebut" required>
            <input type="datetime-local" wire:model="dateHeureFin" required>
            

            <div class="flex justify-end mt-4">
                <button type="button" onclick="dispatchEvent(new CustomEvent('close-modal', { detail: 'ajouterIndisponibilite' }))" class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded mr-2">Annuler</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
            </div>
        </form>
    </x-modal>

    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'ajouterIndisponibilite' }))">
        Ajouter une indisponibilité
    </button>
</div>