<div class="container m-auto mt-16 w-full text-gray-800">

    <div class="m-8">
        <nav class="text-white bg-darker-green">
            <ul class="flex">
                <li
                    class="block {{ Route::is('profil') ? 'text-white bg-green pointer-events-none' : 'hover:bg-blue-400' }} nav-item">
                    <a href="{{ route('profil') }}" class="p-4">Compte</a>
                </li>

                <li
                    class="block {{ Route::is('services') ? 'text-white bg-green pointer-events-none' : 'hover:bg-blue-400' }} nav-item">
                    <a href="{{ route('services') }}" class="p-4">Services</a>
                </li>

                <li
                    class="block {{ Route::is('disponibilites') ? 'text-white bg-green pointer-events-none' : 'hover:bg-blue-400' }} nav-item">
                    <a href="{{ route('disponibilites') }}" class="p-4">Disponibilités</a>
                </li>

                <li
                    class="block {{ Route::is('professions') ? 'text-white bg-green pointer-events-none' : 'hover:bg-blue-400' }} nav-item">
                    <a href="{{ route('professions') }}" class="p-4">Professions</a>
                </li>
            </ul>
        </nav>

        <div class="content bg-white pt-4 ">
            {{ $slot }}
        </div>
    </div>

</div>
