<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $campaign->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Budget: ${{ number_format($campaign->budget, 2) }} | Model: {{ strtoupper($campaign->model) }} | Status: {{ ucfirst($campaign->status) }}
                            </p>
                        </div>
                        <a href="{{ route('creatives.create', ['campaign_id' => $campaign->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Add Creative') }}
                        </a>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Creatives in this Campaign') }}</h3>
                        <div class="mt-2 space-y-4">
                            @forelse ($campaign->creatives as $creative)
                                <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                                    <p class="text-gray-800 dark:text-gray-200">{{ $creative->file_url }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $creative->type }} - {{ $creative->width }}x{{ $creative->height }}
                                    </p>
                                </div>
                            @empty
                                <p>{{ __("This campaign doesn't have any creatives yet.") }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
