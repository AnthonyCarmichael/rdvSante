<div>
    <h3>Indisponibilités</h3>
    <ul>
        @foreach($indisponibilites as $indisponibilite)
            <li>{{ $indisponibilite->note }} ({{ $indisponibilite->dateHeureDebut }} - {{ $indisponibilite->dateHeureFin }})</li>
        @endforeach
    </ul>


    <x-modal title="Ajouter une indisponibilité" name="ajouterIndisponibilite" :show="false">
        <!-- Contenu du modal -->
        <form wire:submit.prevent="createIndisponibilite">
            <input type="text" wire:model="note" placeholder="Note" required>
            <input type="datetime-local" wire:model="dateHeureDebut" required>
            <input type="datetime-local" wire:model="dateHeureFin" required>


            <div class="">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirmer</button>
            </div>
        </form>
    </x-modal>

    <button x-data x-on:click="$dispatch('open-modal', { name : 'ajouterIndisponibilite'  })" class="px-3 py-1 bg-teal-500 text-white rounded">
        Ajouter une indisponibilité
    </button>
</div>
