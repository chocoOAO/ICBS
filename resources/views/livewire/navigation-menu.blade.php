{{-- <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('contracts') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                    {{--
                    <a href="{{ route('dashboard') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>

                </div>

                <!-- Navigation Links -->
                @php
                    $user = Auth::user();
                    $auth_type = $user->getAuth_type();
                @endphp

                <div class="hidden space-x-5 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('contracts') }}" :active="request()->routeIs('contracts')">
                        合約管理
                    </x-jet-nav-link>

                    <select class="form-select" aria-label="Default select example" wire:model="contract_id"
                        wire:change="selectContract">
                        @if ($contract_id == -1)
                            <option selected>沒有合約</option>
                        @else
                            @foreach ($contracts as $contract => $value)
                                <option value="{{ $value->id }}">{{ $value->m_NAME }}</option>
                            @endforeach
                        @endif
                    </select>

                    <x-jet-nav-link href=" {{ route('chicken-import.create', ['contract' => $contract_id]) }} "
                        :active="request()->routeIs('chicken-import.create')">
                        飼養入雛表
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('growth-record.create', ['contract' => $contract_id]) }} "
                        :active="request()->routeIs('growth-record.create')">
                        農戶飼養紀錄表
                    </x-jet-nav-link>
                    <x-jet-nav-link href="{{ route('schedule') }}" :active="request()->routeIs('schedule')">
                        標準生長預估
                    </x-jet-nav-link>

                    <x-jet-nav-link href="{{ route('slaughter') }}" :active="request()->routeIs('slaughter')">
                        預估屠宰排程表
                    </x-jet-nav-link>

                    <x-jet-nav-link href=" {{ route('chicken-out.create', ['contract' => $contract_id]) }} "
                        :active="request()->routeIs('chicken-out')">
                        抓雞派車單
                    </x-jet-nav-link>

                    <x-jet-nav-link href=" {{ route('traceability', ['contract' => $contract_id]) }} "
                        :active="request()->routeIs('traceability')">
                        產銷履歷
                    </x-jet-nav-link>
                    <x-jet-nav-link href="  {{ route('settlement', ['contract' => $contract_id]) }}  "
                        :active="request()->routeIs('settlement')">
                        毛雞結款單
                    </x-jet-nav-link>


                    <x-jet-nav-link href="line-chart">
                        飼養折線圖
                    </x-jet-nav-link>

                </div>
            </div>



            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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



</nav> --}}

@php
    $user = Auth::user();
    $auth_type = $user->getAuth_type();
@endphp

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        {{-- 圖片返回 contracts --}}
        <a href="/contracts" class="flex items-center">
            <img src="{{ asset('images/hen.png') }}" class="h-10 mr-3" alt="Hen Logo" style="transform: scaleX(-1);" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">福壽－飼育平台</span>
        </a>

        <nav x-data="{ open: false }" class="bg-white  border-gray-100 rounded-lg">
            <!-- Hamburger -->
            <div class=" flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-jet-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <div class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </div>
                        @endif

                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <!-- Account Management -->
                        <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                            {{ __('Profile') }}
                        </x-jet-responsive-nav-link>

                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                                {{ __('API Tokens') }}
                            </x-jet-responsive-nav-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" x-data>
                            @csrf

                            <x-jet-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                {{ __('Log Out') }}
                            </x-jet-responsive-nav-link>
                        </form>

                        <!-- Team Management -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Team') }}
                            </div>

                            <!-- Team Settings -->
                            <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}"
                                :active="request()->routeIs('teams.show')">
                                {{ __('Team Settings') }}
                            </x-jet-responsive-nav-link>

                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                    {{ __('Create New Team') }}
                                </x-jet-responsive-nav-link>
                            @endcan

                            <div class="border-t border-gray-200"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Switch Teams') }}
                            </div>

                            @foreach (Auth::user()->allTeams() as $team)
                                <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        {{-- 原先 Hamburger，我把上面那層的移過來 --}}
        {{-- <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button> --}}

        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8  md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="/contracts"
                        class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500"
                        aria-current="page">首頁</a>
                </li>
                <x-jet-nav-link href="{{ route('contracts') }}" :active="request()->routeIs('contracts')">
                    合約管理
                </x-jet-nav-link>

                <select class="form-select" aria-label="Default select example" wire:model="contract_id"
                    wire:change="selectContract">
                    @if ($contract_id == -1)
                        <option selected>沒有合約</option>
                    @else
                        @foreach ($contracts as $contract => $value)
                            <option value="{{ $value->id }}">{{ $value->name_b }}</option>
                        @endforeach
                    @endif
                </select>

                <li>
                    <a href=" {{ route('chicken-import.create', ['contract' => $contract_id]) }} "
                        :active="request() - > routeIs('chicken-import.create')"
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">飼養入雛表</a>
                </li>
                <li>
                    @php
                        // 還沒有填入雛資訊，就不能填寫飼養紀錄表
                        use App\Models\ChickenImport;
                        if (ChickenImport::where('contract_id', $contract_id)->get()->count() == 0) {
                            $route = route('chicken-import.create', ['contract' => $contract_id, 'alert' => '逆還沒有填入雛資訊。']);
                        } else {
                            $route = route('growth-record.create', ['contract' => $contract_id]);
                        }
                    @endphp
                    <a href="{{ $route }}" :active="request() - > routeIs('growth-record.create')"
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        農戶飼養紀錄表
                    </a>
                </li>

                {{-- <x-jet-nav-link href="{{ route('schedule') }}" :active="request()->routeIs('schedule')">
                    標準生長預估
                </x-jet-nav-link>

                <x-jet-nav-link href="{{ route('slaughter') }}" :active="request()->routeIs('slaughter')">
                    預估屠宰排程表
                </x-jet-nav-link>

                <x-jet-nav-link href=" {{ route('chicken-out.create', ['contract' => $contract_id]) }} "
                    :active="request()->routeIs('chicken-out')">
                    抓雞派車單
                </x-jet-nav-link> --}}
                <div class="relative inline-block" wire:mouseover="showDropdown" wire:mouseout="hideDropdown">
                    <a href="#"
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                        預測列 <i class="fas fa-caret-down"></i>
                    </a>
                    @if ($isDropdownVisible)
                        <ul class="absolute mt-2 py-2 bg-white dark:bg-gray-800 rounded shadow-md z-10">
                            <li>
                                <a href="{{ route('schedule') }}"
                                    class="block px-4 py-2 text-gray-900 hover:text-blue-700 dark:text-white dark:hover:text-blue-500">預估屠宰排程表</a>
                            </li>
                        </ul>
                    @endif
                </div>

                <li>
                    <a href=" {{ route('chicken-out.create', ['contract' => $contract_id]) }} "
                        :active="request() - > routeIs('chicken-out')"
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">抓雞派車單</a>
                </li>

                <li>
                    <a href=" {{ route('traceability', ['contract' => $contract_id]) }} "
                        :active="request() - > routeIs('traceability')"
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">產銷履歷</a>
                </li>
                <li>
                    <a href="  {{ route('settlement', ['contract' => $contract_id]) }}  "
                        :active="request() - > routeIs('settlement')"
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">毛雞結款單</a>
                </li>
                <li>
                    <a href="  {{ route('lineChart', ['contract' => $contract_id]) }}  "
                        class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">生長預估</a>
                </li>
                <li>
                    <div class="hidden sm:flex sm:items-center pl-4">
                        <!-- Teams Dropdown -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                            <div class="ml-3 relative">
                                <x-jet-dropdown align="right" width="60">
                                    <x-slot name="trigger">
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ Auth::user()->currentTeam->name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
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
                                            <x-jet-dropdown-link
                                                href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                {{ __('Team Settings') }}
                                            </x-jet-dropdown-link>

                                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                <x-jet-dropdown-link href="{{ route('teams.create') }}">
                                                    {{ __('Create New Team') }}
                                                </x-jet-dropdown-link>
                                            @endcan

                                            <div class="border-t border-gray-100"></div>

                                            <!-- Team Switcher -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>

                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-jet-switchable-team :team="$team" />
                                            @endforeach
                                        </div>
                                    </x-slot>
                                </x-jet-dropdown>
                            </div>
                        @endif

                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                        <button
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="{{ Auth::user()->profile_photo_url }}"
                                                alt="{{ Auth::user()->name }}" />
                                        </button>
                                    @else
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ Auth::user()->name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    @endif
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Account') }}
                                    </div>

                                    <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                        {{ __('Profile') }}
                                    </x-jet-dropdown-link>

                                    <!-- 如果當下使用者是adm -->
                                    @if ($auth_type == 'admin' || Auth::user()->permissions[8] > 1)
                                        <x-jet-dropdown-link href="{{ route('user-permission-management') }}">
                                            {{ __('Auth Management') }}
                                        </x-jet-dropdown-link>
                                    @endif

                                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                        <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                            {{ __('API Tokens') }}
                                        </x-jet-dropdown-link>
                                    @endif

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-jet-dropdown-link href="{{ route('logout') }}"
                                            @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-jet-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</nav>
