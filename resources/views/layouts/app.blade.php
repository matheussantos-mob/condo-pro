<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Portaria Pro') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="flex h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="fixed inset-y-0 left-0 z-50 transition-all duration-300 bg-gray-900 shadow-xl md:relative md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex flex-col items-center justify-center min-h-[4rem] bg-gray-800/50 text-white overflow-hidden px-4 border-b border-gray-700">
                <div x-show="sidebarOpen" class="w-full py-2">
                    @if(auth()->user()->role === 'admin')
                    <label class="block text-[10px] uppercase tracking-wider text-gray-500 font-bold mb-1 ml-1">Entidades</label>
                    @php $condominios = \App\Models\Condominio::all(); @endphp

                    <form action="{{ route('admin.alternar.condominio') }}" method="POST" id="form-contexto">
                        @csrf
                        <div class="relative">
                            <select name="condominio_id" onchange="this.form.submit()"
                                class="appearance-none w-full bg-gray-900 border border-gray-700 text-gray-300 text-xs rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 pr-8 cursor-pointer hover:bg-gray-800 transition-colors">
                                @foreach($condominios as $condo)
                                <option value="{{ $condo->id }}" {{ session('admin_condominio_id') == $condo->id ? 'selected' : '' }}>
                                    🏢 {{ $condo->nome }}
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="font-bold text-sm uppercase tracking-tight whitespace-nowrap text-indigo-400">
                            {{ auth()->user()->condominio->nome ?? 'Unidade Isolada' }}
                        </span>
                    </div>
                    @endif
                </div>

                <span x-show="!sidebarOpen" class="font-bold text-xl text-indigo-500">
                    {{ session('admin_condominio_id') ? '🏢' : '🌎' }}
                </span>
            </div>

            <nav class="mt-5 px-4 space-y-2">
                <x-nav-link-sidebar href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Dashboard</span>
                </x-nav-link-sidebar>

                <x-nav-link-sidebar href="{{ route('encomendas.index') }}" :active="request()->routeIs('encomendas.*')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span x-show="sidebarOpen" class="ml-3">Encomendas</span>
                </x-nav-link-sidebar>

                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'sindico')
                <div x-data="{ open: {{ request()->routeIs('apartamentos.*') || request()->routeIs('moradores.*') || request()->routeIs('condominio.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 text-gray-400 hover:bg-gray-800 hover:text-white rounded-lg transition-colors duration-200">
                        <div class="flex items-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="sidebarOpen" class="ml-3">Configurar</span>
                        </div>
                        <svg x-show="sidebarOpen" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open && sidebarOpen" x-transition class="mt-2 space-y-1 pl-10">
                        <a href="{{ route('condominio.edit') }}"
                            class="block py-2 text-sm {{ request()->routeIs('condominio.*') ? 'text-white font-bold' : 'text-gray-500 hover:text-white' }}">
                            Condomínio
                        </a>
                        <a href="{{ route('apartamentos.index') }}"
                            class="block py-2 text-sm {{ request()->routeIs('apartamentos.*') ? 'text-white font-bold' : 'text-gray-500 hover:text-white' }}">
                            Unidades
                        </a>
                        <a href="{{ route('moradores.index') }}"
                            class="block py-2 text-sm {{ request()->routeIs('moradores.*') ? 'text-white font-bold' : 'text-gray-500 hover:text-white' }}">
                            Moradores
                        </a>
                    </div>
                </div>
                @endif

                @if(auth()->user()->role === 'admin')
                <div class="pt-4 mt-4 border-t border-gray-800">
                    <x-nav-link-sidebar href="{{ route('admin.index') }}" :active="request()->routeIs('admin.*')">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span x-show="sidebarOpen" class="ml-3 font-bold text-yellow-500">Master Admin</span>
                    </x-nav-link-sidebar>
                </div>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-16 bg-white border-b flex items-center justify-between px-6 shadow-sm">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-red-600 hover:underline">Sair</button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>