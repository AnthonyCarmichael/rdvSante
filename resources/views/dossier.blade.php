<x-admin-layout>
    <div class="py-12">
        <div class="ml-2 sm:px-6 lg:px-8">
            @if (isset($dossierClient))
                @livewire('Dossier', ['dossierClient' => $dossierClient])
            @else
                @livewire('Dossier')
            @endif

        </div>
    </div>
</x-admin-layout>
