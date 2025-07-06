<header class="flex w-full flex-wrap bg-orange-500 py-3 text-sm sm:flex-nowrap sm:justify-start">
    <nav class="mx-auto flex w-full max-w-[85rem] basis-full flex-wrap items-center justify-between px-4">
        <a class="focus:outline-hidden flex-none text-xl font-semibold text-gray-100 focus:opacity-80 sm:order-1"
            href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.svg') }}" class="size-12" alt="logo">
        </a>
        {{-- <img class="size-14" src="{{ asset('images/logo.png') }}" alt=""> --}}
        <div class="flex items-center gap-x-2 sm:order-3">
            <button type="button"
                class="hs-collapse-toggle shadow-2xs focus:outline-hidden relative flex size-9 items-center justify-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 sm:hidden"
                id="hs-navbar-alignment-collapse" aria-expanded="false" aria-controls="hs-navbar-alignment"
                aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-alignment">
                <svg class="hs-collapse-open:hidden size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg class="hs-collapse-open:block hidden size-4 shrink-0" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
                <span class="sr-only">Toggle</span>
            </button>
            @auth
                {{-- dropdown preline --}}
                <div x-data="{ open: false }" x-cloak class="relative">
                    <!-- Trigger Button -->
                    <button x-on:click="open = !open"
                        class="flex items-center gap-x-2 px-4 py-2 text-sm font-semibold text-white rounded-md">
                        <span class="capitalize">{{ auth()->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:leave="transition ease-in duration-75"
                        class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg" @click.stop>
                        <!-- Prevent the dropdown from closing when clicking inside -->
                        <ul>
                            <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My
                                    Profile</a></li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a></li>
                            <li><button type="button" wire:click="logout"
                                    class="text-start w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- <a class='focus:outline-hidden font-medium text-gray-300 hover:font-semibold hover:text-gray-200' href="#">Logout</a> --}}
            @endauth
            @guest
                <button type="button"
                    class="shadow-2xs focus:outline-hidden hidden items-center gap-x-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:bg-gray-50 disabled:pointer-events-none disabled:opacity-50 sm:inline-flex">
                    Login
                </button>
            @endguest
        </div>
        <div id="hs-navbar-alignment"
            class="hs-collapse hidden grow basis-full overflow-hidden transition-all duration-300 sm:order-2 sm:block sm:grow-0 sm:basis-auto"
            aria-labelledby="hs-navbar-alignment-collapse">
            <div class="mt-5 flex flex-col gap-5 sm:mt-0 sm:flex-row sm:items-center sm:ps-5">
                <a wire:navigate @class([
                    'focus:outline-hidden font-medium text-white hover:font-semibold hover:text-gray-200',
                    'border-b-2 border-white text-white' => request()->routeIs('dashboard'),
                ]) href="{{ route('dashboard') }}">Dashboard</a>
                @if (auth()->user()->hasAnyRole(['admin', 'super-admin']))
                    <a wire:navigate @class([
                        'focus:outline-hidden font-medium text-white hover:font-semibold hover:text-gray-200',
                        'border-b-2 border-white text-white' => request()->routeIs('supplies'),
                    ]) href="{{ route('supplies') }}">Supplies</a>
                @endif
                <a wire:navigate @class([
                    'focus:outline-hidden font-medium text-white hover:font-semibold hover:text-gray-200',
                    'border-b-2 border-white text-white' => request()->routeIs('stocks'),
                ]) wire:navigate href="{{ route('stocks') }}">Stocks</a>
                @if (auth()->user()->hasAnyRole(['admin', 'super-admin']))
                    <a wire:navigate @class([
                        'focus:outline-hidden font-medium text-white hover:font-semibold hover:text-gray-200',
                        'border-b-2 border-white text-white' => request()->routeIs('request-list'),
                    ]) wire:navigate
                        href="{{ route('request-list') }}">Requests</a>
                @endif
            </div>
        </div>
    </nav>
</header>

