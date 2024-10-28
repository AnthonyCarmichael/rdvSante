<div class="container m-auto mt-16 w-full text-gray-800">

    <div class="m-8">
        <nav class="text-white bg-darker-green">
            <ul class="flex">
                <li class="block {{ (Route::is('paiements')) ? 'text-white bg-green pointer-events-none' : 'hover:bg-blue-400'}} nav-item">
                    <a href="{{ route('paiements') }}" class="p-4">Factures</a>
                </li>

                <li class="block {{ (Route::is('transactions')) ? 'text-white bg-green pointer-events-none' : 'hover:bg-blue-400'}} nav-item">
                    <a href="{{ route('transactions')}}" class="p-4">Paiements</a>
                </li>

            </ul>
        </nav>

        <div class="content bg-white pt-4 ">
            {{ $slot }}
        </div>
    </div>

</div>