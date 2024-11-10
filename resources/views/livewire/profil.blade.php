<div class="py-12">
    <div class="max-w-7xl ml-20 sm:px-6 lg:px-8 bg-white">
        <div class="flex space-x-4 mb-4 bg-green">
            <button wire:click="setView('Compte')" class="btn">Compte</button>
            <button wire:click="setView('AjouterService')" class="btn">Services</button>
            <button wire:click="setView('GestionProfessionnel')" class="btn">Gestion Professionnel</button>
            <button wire:click="setView('Disponibilite')" class="btn">Disponibilités</button>
            <button wire:click="setView('Profession')" class="btn">Professions</button>
        </div>

        @if ($view === 'AjouterService')
            @livewire('AjouterService')
        @elseif ($view === 'GestionProfessionnel')
            @livewire('GestionProfessionnel')
        @elseif ($view === 'Compte')
            @livewire('Compte')
        @elseif ($view === 'Disponibilite')
            @livewire('GestionDispo')
        @elseif ($view === 'Profession')
            @livewire('GestionProfession')
        @endif
    </div>
</div>
