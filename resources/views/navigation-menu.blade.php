<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50 ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center space-x-0">
                    <!-- Logo -->
                    <div class="shrink-0">
                        <a href="{{ route('dashboard') }}">
                            <x-application-mark class="block h-9 w-auto" />
                        </a>
                    </div>

                    <!-- Navigation Link -->
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Liquidation Loom') }}
                    </x-nav-link>

                    <div class="text-2xl font-semibold mt-4 text-center flex">
                        <h1 class="text-2xl font-semibold pl-20 mb-5">Welcome, {{ Auth::user()->name }}</h1>
                    </div>
























                    <!-- button modal calendar -->
                    <button id="openModal"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none  "
                        style="position: absolute; left: 80%;">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 22.6562C0 23.9502 1.19978 25 2.67857 25H22.3214C23.8002 25 25 23.9502 25 22.6562V9.375H0V22.6562ZM17.8571 13.0859C17.8571 12.7637 18.1585 12.5 18.5268 12.5H20.7589C21.1272 12.5 21.4286 12.7637 21.4286 13.0859V15.0391C21.4286 15.3613 21.1272 15.625 20.7589 15.625H18.5268C18.1585 15.625 17.8571 15.3613 17.8571 15.0391V13.0859ZM17.8571 19.3359C17.8571 19.0137 18.1585 18.75 18.5268 18.75H20.7589C21.1272 18.75 21.4286 19.0137 21.4286 19.3359V21.2891C21.4286 21.6113 21.1272 21.875 20.7589 21.875H18.5268C18.1585 21.875 17.8571 21.6113 17.8571 21.2891V19.3359ZM10.7143 13.0859C10.7143 12.7637 11.0156 12.5 11.3839 12.5H13.6161C13.9844 12.5 14.2857 12.7637 14.2857 13.0859V15.0391C14.2857 15.3613 13.9844 15.625 13.6161 15.625H11.3839C11.0156 15.625 10.7143 15.3613 10.7143 15.0391V13.0859ZM10.7143 19.3359C10.7143 19.0137 11.0156 18.75 11.3839 18.75H13.6161C13.9844 18.75 14.2857 19.0137 14.2857 19.3359V21.2891C14.2857 21.6113 13.9844 21.875 13.6161 21.875H11.3839C11.0156 21.875 10.7143 21.6113 10.7143 21.2891V19.3359ZM3.57143 13.0859C3.57143 12.7637 3.87277 12.5 4.24107 12.5H6.47321C6.84152 12.5 7.14286 12.7637 7.14286 13.0859V15.0391C7.14286 15.3613 6.84152 15.625 6.47321 15.625H4.24107C3.87277 15.625 3.57143 15.3613 3.57143 15.0391V13.0859ZM3.57143 19.3359C3.57143 19.0137 3.87277 18.75 4.24107 18.75H6.47321C6.84152 18.75 7.14286 19.0137 7.14286 19.3359V21.2891C7.14286 21.6113 6.84152 21.875 6.47321 21.875H4.24107C3.87277 21.875 3.57143 21.6113 3.57143 21.2891V19.3359ZM22.3214 3.125H19.6429V0.78125C19.6429 0.351562 19.2411 0 18.75 0H16.9643C16.4732 0 16.0714 0.351562 16.0714 0.78125V3.125H8.92857V0.78125C8.92857 0.351562 8.52679 0 8.03571 0H6.25C5.75893 0 5.35714 0.351562 5.35714 0.78125V3.125H2.67857C1.19978 3.125 0 4.1748 0 5.46875V7.8125H25V5.46875C25 4.1748 23.8002 3.125 22.3214 3.125Z"
                                fill="#7166F9" />
                        </svg>
                    </button>


                </div>
            </div>

            <dialog id="my_modal_4" class="modal">
                <div class="modal-box w-11/12 max-w-5xl">
                    <h3 class="text-lg font-bold">My Calendar</h3>
                    <div class="container mx-auto mt-10">

                        <div id='calendar' class="bg-white shadow-lg rounded-lg p-4"></div>
                    </div>
                    <div class="modal-action">
                        <form method="dialog">
                            <!-- if there is a button, it will close the modal -->
                            <button class="btn">Close</button>
                        </form>
                    </div>

            </dialog>



            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

            <script>
                document.getElementById('openModal').addEventListener('click', function() {
                    const modal = document.getElementById('my_modal_4');
                    modal.showModal(); // Opens the modal

                    // Initialize FullCalendar once the modal is opened
                    $(document).ready(function() {
                        $('#calendar').fullCalendar({
                            header: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'month,agendaWeek,agendaDay'
                            },
                            editable: true,
                            events: [] // Add your events here
                        });
                    });
                });

                // Close modal event
                document.querySelectorAll('form[method="dialog"] button').forEach(button => {
                    button.addEventListener('click', function() {
                        const modal = document.getElementById('my_modal_4');
                        modal.close(); // Closes the modal
                    });
                });
            </script>


            <x-notification-dropdown-admin />









            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <!-- Team Switcher -->
                                    @if (Auth::user()->allTeams()->count() > 1)
                                        <div class="border-t border-gray-200"></div>

                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Switch Teams') }}
                                        </div>

                                        @foreach (Auth::user()->allTeams() as $team)
                                            <x-switchable-team :team="$team" />
                                        @endforeach
                                    @endif
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="size-8 rounded-full object-cover"
                                        src="{{ asset(Auth::user()->profile_photo_path) }}"
                                        alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>
                        <script>
                            console.log({
                                photo_path: '{{ Auth::user()->profile_photo_path }}'
                            });
                        </script>


                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>




        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                        :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>
