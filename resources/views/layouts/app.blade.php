<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIPERA') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

            <aside class="absolute z-20 flex flex-col w-64 h-screen overflow-y-auto bg-slate-900 border-r border-slate-800 md:relative md:flex transition-transform duration-300 ease-in-out"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

                <div class="flex items-center justify-center h-20 border-b border-slate-800 bg-slate-900 shadow-sm">
                    <h1 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 tracking-wider">
                        SIPERA
                    </h1>
                </div>

                <div class="flex flex-col flex-1 px-4 py-6 space-y-2">

                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>

                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-slate-300 rounded-xl transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span class="mx-3 font-medium">Dashboard</span>
                    </a>

                    <a href="{{ route('items.index') }}" class="flex items-center px-4 py-3 text-slate-300 rounded-xl transition-colors duration-200 {{ request()->routeIs('items.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="mx-3 font-medium">Data Inventaris</span>
                    </a>

                </div>

                <div class="p-4 border-t border-slate-800 bg-slate-900/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-white">{{ Auth::user()->name }}</h4>
                            <p class="text-xs text-slate-400">Admin</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-400 transition" title="Logout">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="flex flex-col flex-1 overflow-hidden">
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b md:hidden">
                    <div class="text-xl font-semibold text-gray-700">SIPERA</div>
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>