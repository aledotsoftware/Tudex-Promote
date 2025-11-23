<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Tudex Promote') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col md:flex-row">
            
            <!-- Mobile Header -->
            <div class="md:hidden flex items-center justify-between bg-brand-900 text-white p-4 shadow-md">
                <div class="font-display font-bold text-xl tracking-tight">Tudex<span class="text-brand-400">Promote</span></div>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md hover:bg-brand-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar -->
            <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-50 w-64 bg-brand-950 text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 shadow-2xl flex flex-col">
                <div class="p-6 border-b border-brand-800 hidden md:block">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="bg-brand-500 rounded-lg p-1.5">
                            <!-- <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> -->
                        </div>
                        <span class="font-display font-bold text-xl tracking-tight">Tudex<span class="text-brand-400">Promote</span></span>
                    </a>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <div class="px-2 mb-2 text-xs font-semibold text-brand-400 uppercase tracking-wider">
                        {{ Auth::user()->role === 'publisher' ? __('messages.publisher_console') : __('messages.advertiser_console') }}
                    </div>

                    @if (Auth::user()->role === 'publisher')
                        <a href="{{ route('sites.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('sites.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-brand-100 hover:bg-brand-900 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ __('messages.my_sites') }}
                        </a>
                        <a href="{{ route('adzones.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('adzones.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-brand-100 hover:bg-brand-900 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            {{ __('messages.ad_zones') }}
                        </a>
                    @elseif (Auth::user()->role === 'advertiser')
                        <a href="{{ route('campaigns.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('campaigns.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-brand-100 hover:bg-brand-900 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            {{ __('messages.campaigns') }}
                        </a>
                        <a href="{{ route('creatives.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('creatives.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-brand-100 hover:bg-brand-900 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {{ __('messages.creatives') }}
                        </a>
                    @endif

                    <div class="px-2 mt-6 mb-2 text-xs font-semibold text-brand-400 uppercase tracking-wider">
                        {{ __('messages.account') }}
                    </div>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('profile.edit') ? 'bg-brand-600 text-white shadow-lg shadow-brand-900/20' : 'text-brand-100 hover:bg-brand-900 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        {{ __('messages.profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-brand-100 hover:bg-brand-900 hover:text-white transition-colors">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            {{ __('messages.sign_out') }}
                        </button>
                    </form>
                </nav>
                
                <div class="p-4 border-t border-brand-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-brand-300 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto h-screen">
                <header class="hidden md:flex items-center justify-between bg-white dark:bg-gray-800 shadow-sm px-8 py-4 sticky top-0 z-40">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        @yield('header', __('messages.dashboard'))
                    </h2>
                    <div class="flex items-center gap-4">
                        <!-- Language Selector -->
                        <form method="POST" action="{{ route('locale.switch') }}" class="inline-block">
                            @csrf
                            <select name="locale" onchange="this.form.submit()" class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-brand-500 focus:border-brand-500 px-3 py-2 cursor-pointer">
                                <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                                <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>🇪🇸 Español</option>
                            </select>
                        </form>
                        
                        <button class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                    </div>
                </header>

                <div class="py-8 px-4 sm:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
