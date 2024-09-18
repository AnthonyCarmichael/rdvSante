<x-admin-layout>
    <div class="container mx-auto p-4">
        <h2 class="text-4xl font-bold mb-6">Gestion des clients</h2>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    @foreach ($clients as $client)
                        <div>
                            <p class="font-semibold text-lg">{{ $client->nom }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
