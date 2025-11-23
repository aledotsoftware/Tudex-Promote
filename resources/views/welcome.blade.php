<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tudex Promote - Premium Ad Network</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-gray-50 text-gray-900">
        <div class="relative min-h-screen flex flex-col">
            <!-- Navbar -->
            <nav class="absolute top-0 left-0 right-0 z-50 px-6 py-6">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="bg-brand-600 rounded-lg p-1.5">
                            <!-- Logo -->
                        </div>
                        <span class="font-display font-bold text-xl tracking-tight text-gray-900">Tudex<span class="text-brand-600">Promote</span></span>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Language Selector -->
                        <form method="POST" action="{{ route('locale.switch') }}" id="localeForm" class="inline-block">
                            @csrf
                            <select name="locale" onchange="document.getElementById('localeForm').submit()" class="px-3 py-1.5 border border-gray-300 rounded-lg bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-brand-500">
                                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                                <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>🇪🇸 Español</option>
                            </select>
                        </form>

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-brand-600">{{ __('messages.dashboard') }}</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-brand-600">{{ __('messages.log_in') }}</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm font-semibold hover:bg-brand-700 transition shadow-lg shadow-brand-600/20">{{ __('messages.get_started') }}</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden">
                <div class="absolute inset-0 -z-10">
                    <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>
                    <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/4 blur-3xl opacity-30">
                        <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-brand-200 to-brand-600 clip-path-polygon"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-1/4 blur-3xl opacity-30">
                        <div class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-tr from-accent-200 to-accent-600 clip-path-polygon"></div>
                    </div>
                </div>

                <div class="max-w-7xl mx-auto px-6 text-center">
                    <h1 class="text-5xl md:text-7xl font-display font-bold tracking-tight text-gray-900 mb-8 animate-slide-up">
                        {{ __('messages.welcome_headline') }} <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-500">{{ __('messages.welcome_with_intelligence') }}</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-10 animate-slide-up" style="animation-delay: 0.1s;">
                        {{ __('messages.welcome_subheadline') }}
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4 animate-slide-up" style="animation-delay: 0.2s;">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-brand-600 text-white rounded-xl font-semibold text-lg hover:bg-brand-700 transition shadow-xl shadow-brand-600/20 flex items-center justify-center gap-2">
                            {{ __('messages.get_started') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                        <a href="#features" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold text-lg hover:bg-gray-50 transition flex items-center justify-center">
                            {{ __('messages.view') }} {{ __('messages.stats') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div id="features" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-display font-bold text-gray-900 mb-4">¿Por qué elegir Tudex Promote?</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">{{ __('messages.welcome_subheadline') }}</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg transition duration-300">
                            <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600 mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('messages.adaptive_design') }}</h3>
                            <p class="text-gray-600">{{ __('messages.adaptive_design_desc') }}</p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg transition duration-300">
                            <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center text-accent-600 mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('messages.real_time_analytics') }}</h3>
                            <p class="text-gray-600">{{ __('messages.real_time_analytics_desc') }}</p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg transition duration-300">
                            <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center text-brand-600 mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ __('messages.high_cpms') }}</h3>
                            <p class="text-gray-600">{{ __('messages.high_cpms_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white py-12">
                <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center gap-2 mb-4 md:mb-0">
                        <div class="bg-brand-600 rounded-lg p-1.5">
                            <!-- Logo -->
                        </div>
                        <span class="font-display font-bold text-xl tracking-tight">Tudex<span class="text-brand-400">Promote</span></span>
                    </div>
                    <div class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Tudex Promote. All rights reserved.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
