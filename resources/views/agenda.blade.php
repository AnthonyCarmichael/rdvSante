<x-admin-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-4xl font-bold mb-6">Agenda</h2>
        @livewire('agenda')
    </div>

    <x-modal name="ajouterIndisponibilite" :show="false">
    <!-- Contenu du modal -->
    <h2 class="text-xl font-bold mb-4">Ajouter Indisponibilité</h2>
    <form wire:submit.prevent="createIndisponibilite">
        <input type="text" wire:model="note" placeholder="Note" required>
        <input type="datetime-local" wire:model="dateHeureDebut" required>
        <input type="datetime-local" wire:model="dateHeureFin" required>
        <button type="submit">Confirmer</button>
    </form>
</x-modal>

<button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'ajouterIndisponibilite' }))">
    Ajouter une indisponibilité
</button>

</x-admin-layout>
