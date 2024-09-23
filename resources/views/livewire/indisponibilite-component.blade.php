<div>
    <form wire:submit.prevent="createIndisponibilite">
        <input type="text" wire:model="note" placeholder="Note" required>
        <input type="datetime-local" wire:model="dateHeureDebut" required>
        <input type="datetime-local" wire:model="dateHeureFin" required>
        <button type="submit">Ajouter Indisponibilité</button>
    </form>

    <h3>Indisponibilités</h3>
    <ul>
        @foreach($indisponibilites as $indisponibilite)
            <li>{{ $indisponibilite->note }} ({{ $indisponibilite->dateHeureDebut }} - {{ $indisponibilite->dateHeureFin }})</li>
        @endforeach
    </ul>
</div>