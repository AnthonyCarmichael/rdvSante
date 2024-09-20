<nav class ="">
    <div class="">
        <div class="relative flex items-center justify-between">
            <div :class="{ 'hidden': open, 'ml-0': !open }" class="absolute inset-y-0 left-0 flex item-center transition-all duration-300">
                <button type="button" @click="open = !open" @click.away="open = false" class="inline-flex rounded-md bg-mid-green m-4 p-1 absolute text-darker-green hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="block size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>

                </button>
            </div>
        </div>
    </div>
</nav>
