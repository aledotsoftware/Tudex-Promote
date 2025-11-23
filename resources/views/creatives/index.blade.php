<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.creatives') }}
            </h2>
            <div class="flex items-center gap-3">
                <!-- Export Button -->
                @if($creatives->isNotEmpty())
                <a href="{{ route('creatives.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ __('messages.export_csv') }}
                </a>
                @endif
                
                <!-- Add Creative Button -->
                <a href="{{ route('creatives.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-500 active:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    {{ __('messages.add_new_creative') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg flex items-center" role="alert">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filters and Search -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-6 p-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="{{ __('messages.search') }}..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center gap-3">
                        <select id="statusFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-brand-500">
                            <option value="all">{{ __('messages.all_status') }}</option>
                            <option value="active">{{ __('messages.active') }}</option>
                            <option value="paused">{{ __('messages.paused') }}</option>
                        </select>

                        <select id="typeFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-brand-500">
                            <option value="all">{{ __('messages.all_types') }}</option>
                            <option value="wide">Wide Banner</option>
                            <option value="tall">Tall Skyscraper</option>
                            <option value="square">Square</option>
                            <option value="popup">Pop-up</option>
                            <option value="interstitial">Interstitial</option>
                        </select>

                        <select id="performanceFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-brand-500">
                            <option value="all">{{ __('messages.all_performance') }}</option>
                            <option value="high">{{ __('messages.high_performance') }} (CTR > 2%)</option>
                            <option value="medium">{{ __('messages.medium_performance') }} (CTR 0.5-2%)</option>
                            <option value="low">{{ __('messages.low_performance') }} (CTR < 0.5%)</option>
                            <option value="no_data">{{ __('messages.no_data') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            @if($creatives->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.total_creatives') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $creatives->count() }}</p>
                        </div>
                        <div class="p-3 bg-brand-100 dark:bg-brand-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.active') }}</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $creatives->where('is_active', true)->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.paused') }}</p>
                            <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $creatives->where('is_active', false)->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.total_impressions') }}</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($creatives->sum('impressions')) }}</p>
                        </div>
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Creatives Grid -->
            <div id="creativesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($creatives as $creative)
                @php
                    $ctr = $creative->impressions > 0 ? ($creative->clicks / $creative->impressions) * 100 : 0;
                @endphp
                <div class="creative-card bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-lg transition-shadow duration-200 overflow-hidden" 
                     data-status="{{ $creative->is_active ? 'active' : 'paused' }}" 
                     data-type="{{ $creative->type }}"
                     data-ctr="{{ $ctr }}"
                     data-search="{{ strtolower($creative->campaign->name ?? '') }}">
                    
                    <!-- Preview Section -->
                    <div class="relative bg-gray-50 dark:bg-gray-900 p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="aspect-video bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-inner flex items-center justify-center">
                            <iframe srcdoc="{{ htmlspecialchars($creative->html_content) }}" 
                                    class="w-full h-full border-0 pointer-events-none"
                                    style="transform: scale(0.8); transform-origin: center;">
                            </iframe>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            @if($creative->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    <span class="w-2 h-2 mr-1 bg-green-400 rounded-full animate-pulse"></span>
                                    {{ __('messages.active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    <span class="w-2 h-2 mr-1 bg-yellow-400 rounded-full"></span>
                                    {{ __('messages.paused') }}
                                </span>
                            @endif
                        </div>

                        <!-- Type Badge -->
                        <div class="absolute top-2 left-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-brand-100 text-brand-800 dark:bg-brand-900/30 dark:text-brand-400">
                                {{ ucfirst($creative->type) }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Section -->
                    <div class="p-4">
                        <!-- Campaign Name -->
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.campaign') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $creative->campaign->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-2 mb-4 p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.impressions') }}</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format($creative->impressions) }}</p>
                            </div>
                            <div class="text-center border-x border-gray-200 dark:border-gray-700">
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.clicks') }}</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format($creative->clicks) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500 dark:text-gray-400">CTR</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                    {{ $creative->impressions > 0 ? number_format(($creative->clicks / $creative->impressions) * 100, 2) : '0.00' }}%
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <a href="{{ route('creatives.show', $creative) }}" class="inline-flex items-center justify-center px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ __('messages.view') }}
                            </a>

                            <form method="POST" action="{{ route('creatives.toggle-status', $creative) }}">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 {{ $creative->is_active ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 hover:bg-yellow-200 dark:hover:bg-yellow-900/50' : 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/50' }} rounded-lg transition-colors text-sm font-medium">
                                    @if($creative->is_active)
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ __('messages.pause') }}
                                    @else
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ __('messages.resume') }}
                                    @endif
                                </button>
                            </form>
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <form method="POST" action="{{ route('creatives.duplicate', $creative) }}">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('messages.duplicate') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('creatives.destroy', $creative) }}" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    {{ __('messages.delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.no_creatives') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.get_started_creating_creative') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('creatives.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-500 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                {{ __('messages.add_new_creative') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Filter and Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const typeFilter = document.getElementById('typeFilter');
            const performanceFilter = document.getElementById('performanceFilter');
            const creativeCards = document.querySelectorAll('.creative-card');

            function filterCreatives() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const typeValue = typeFilter.value;
                const performanceValue = performanceFilter.value;

                creativeCards.forEach(card => {
                    const cardStatus = card.dataset.status;
                    const cardType = card.dataset.type;
                    const cardSearch = card.dataset.search;
                    const cardCtr = parseFloat(card.dataset.ctr);

                    const matchesSearch = cardSearch.includes(searchTerm);
                    const matchesStatus = statusValue === 'all' || cardStatus === statusValue;
                    const matchesType = typeValue === 'all' || cardType === typeValue;
                    
                    let matchesPerformance = true;
                    if (performanceValue === 'high') {
                        matchesPerformance = cardCtr > 2;
                    } else if (performanceValue === 'medium') {
                        matchesPerformance = cardCtr >= 0.5 && cardCtr <= 2;
                    } else if (performanceValue === 'low') {
                        matchesPerformance = cardCtr < 0.5 && cardCtr > 0;
                    } else if (performanceValue === 'no_data') {
                        matchesPerformance = cardCtr === 0;
                    }

                    if (matchesSearch && matchesStatus && matchesType && matchesPerformance) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterCreatives);
            statusFilter.addEventListener('change', filterCreatives);
            typeFilter.addEventListener('change', filterCreatives);
            performanceFilter.addEventListener('change', filterCreatives);
        });
    </script>
</x-app-layout>
