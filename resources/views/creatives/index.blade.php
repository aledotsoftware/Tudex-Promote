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

                        <select id="campaignFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-brand-500">
                            <option value="all">Todas las Campañas</option>
                            @foreach($creatives->groupBy('campaign_id') as $campaignId => $group)
                                @if($group->first()->campaign)
                                <option value="{{ $campaignId }}">{{ $group->first()->campaign->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            @if($creatives->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
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
            </div>
            @endif

            <!-- Creatives Grid -->
            <div id="creativesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($creatives as $creative)
                <div class="creative-card bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group" 
                     data-status="{{ $creative->is_active ? 'active' : 'paused' }}" 
                     data-campaign="{{ $creative->campaign_id }}"
                     data-search="{{ strtolower($creative->title . ' ' . $creative->description . ' ' . ($creative->campaign->name ?? '')) }}">
                    
                    <!-- Preview Section -->
                    <div class="relative p-4" style="background-color: {{ $creative->bg_color ?? '#f8fafc' }}">
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3 z-10">
                            @if($creative->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-500 text-white shadow-sm">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-white rounded-full animate-pulse"></span>
                                    {{ __('messages.active') }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-500 text-white shadow-sm">
                                    <span class="w-1.5 h-1.5 mr-1.5 bg-white rounded-full"></span>
                                    {{ __('messages.paused') }}
                                </span>
                            @endif
                        </div>

                        <!-- Ad Preview Card -->
                        <div class="rounded-lg p-4 border shadow-sm" style="background-color: {{ $creative->bg_color ?? '#ffffff' }}; border-color: {{ $creative->border_color ?? '#e2e8f0' }};">
                            @if($creative->image_url)
                            <img src="{{ $creative->image_url }}" alt="" class="w-full h-20 object-cover rounded-md mb-3">
                            @endif
                            <h4 class="font-bold text-sm mb-1 line-clamp-1" style="color: {{ $creative->title_color ?? '#0f172a' }};">
                                {{ $creative->title }}
                            </h4>
                            <p class="text-xs mb-2 line-clamp-2" style="color: {{ $creative->text_color ?? '#64748b' }};">
                                {{ $creative->description }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] opacity-50" style="color: {{ $creative->text_color ?? '#64748b' }};">
                                    Ad · {{ parse_url($creative->click_url, PHP_URL_HOST) ?? 'promoted' }}
                                </span>
                                <span class="text-[10px] px-2 py-0.5 rounded text-white" style="background-color: {{ $creative->button_color ?? '#3b82f6' }};">
                                    {{ $creative->button_text ?? 'Learn More' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Section -->
                    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                        <!-- Campaign Name -->
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">{{ __('messages.campaign') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-gray-100 text-sm">{{ $creative->campaign->name ?? 'N/A' }}</p>
                        </div>

                        <!-- Click URL -->
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">URL de destino</p>
                            <a href="{{ $creative->click_url }}" target="_blank" class="text-xs text-brand-600 dark:text-brand-400 hover:underline truncate block">
                                {{ Str::limit($creative->click_url, 40) }}
                            </a>
                        </div>

                        <!-- Format Preview Buttons -->
                        <div class="mb-4 p-2 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <p class="text-[10px] text-gray-500 dark:text-gray-400 mb-2 uppercase font-medium">Formatos disponibles</p>
                            <div class="flex flex-wrap gap-1">
                                <span class="text-[10px] px-2 py-1 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-400 rounded">Wide</span>
                                <span class="text-[10px] px-2 py-1 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-400 rounded">Square</span>
                                <span class="text-[10px] px-2 py-1 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-400 rounded">Tall</span>
                                <span class="text-[10px] px-2 py-1 bg-brand-100 dark:bg-brand-900/30 text-brand-700 dark:text-brand-400 rounded">Native</span>
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
                    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-brand-100 to-purple-100 dark:from-brand-900/30 dark:to-purple-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.no_creatives') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">Crea tu primer anuncio para comenzar a promocionar tu negocio</p>
                        <a href="{{ route('creatives.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-brand-600 to-purple-600 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-widest hover:from-brand-500 hover:to-purple-500 transition shadow-lg shadow-brand-500/25">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            {{ __('messages.add_new_creative') }}
                        </a>
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
            const campaignFilter = document.getElementById('campaignFilter');
            const creativeCards = document.querySelectorAll('.creative-card');

            function filterCreatives() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value;
                const campaignValue = campaignFilter.value;

                creativeCards.forEach(card => {
                    const cardStatus = card.dataset.status;
                    const cardCampaign = card.dataset.campaign;
                    const cardSearch = card.dataset.search;

                    const matchesSearch = cardSearch.includes(searchTerm);
                    const matchesStatus = statusValue === 'all' || cardStatus === statusValue;
                    const matchesCampaign = campaignValue === 'all' || cardCampaign === campaignValue;

                    if (matchesSearch && matchesStatus && matchesCampaign) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            searchInput.addEventListener('input', filterCreatives);
            statusFilter.addEventListener('change', filterCreatives);
            campaignFilter.addEventListener('change', filterCreatives);
        });
    </script>
</x-app-layout>
