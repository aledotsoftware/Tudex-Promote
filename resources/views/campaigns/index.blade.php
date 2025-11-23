<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.my_campaigns') }}
            </h2>
            <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-500 active:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                {{ __('messages.add_new_campaign') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mt-2 space-y-4">
                        @forelse ($campaigns as $campaign)
                        <div class="flex items-center justify-between p-4 bg-gray-100 dark:bg-gray-900 rounded-lg hover:shadow-lg transition-shadow">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="block flex-1 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg p-2 transition-colors">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $campaign->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('messages.budget') }}: ${{ number_format($campaign->budget, 2) }} | 
                                    {{ __('messages.payment_model') }}: {{ strtoupper($campaign->model) }} | 
                                    {{ __('messages.status') }}: {{ $campaign->is_active ? __('messages.active') : __('messages.paused') }}
                                </p>
                            </a>
                            <div class="flex items-center gap-3">
                                <form method="POST" action="{{ route('campaigns.toggle-status', $campaign) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg text-sm font-semibold transition-colors {{ $campaign->is_active ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 hover:bg-yellow-200 dark:hover:bg-yellow-900/50' : 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 hover:bg-green-200 dark:hover:bg-green-900/50' }}">
                                        {{ $campaign->is_active ? __('messages.pause') : __('messages.resume') }}
                                    </button>
                                </form>
                                <a href="{{ route('campaigns.stats', $campaign) }}" class="px-3 py-1 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-sm font-semibold transition-colors">
                                    {{ __('messages.stats') }}
                                </a>
                                <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}" onsubmit="return confirm('{{ __('messages.are_you_sure') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 text-sm font-semibold transition-colors">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('messages.no_campaigns_yet') }}</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.get_started_creating_campaign') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-500 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    {{ __('messages.add_new_campaign') }}
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
