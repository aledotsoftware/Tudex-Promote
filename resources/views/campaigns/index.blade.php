<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Campaigns') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-end mb-4">
                        <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Add Campaign') }}
                        </a>
                    </div>

                    <div class="mt-2 space-y-4">
                        @forelse ($campaigns as $campaign)
                            <a href="{{ route('campaigns.show', $campaign) }}" class="block p-4 bg-gray-100 dark:bg-gray-900 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                                <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $campaign->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Budget: ${{ number_format($campaign->budget, 2) }} | Model: {{ strtoupper($campaign->model) }} | Status: {{ ucfirst($campaign->status) }}
                                </p>
                            </a>
                        @empty
                            <p>{{ __("You haven't added any campaigns yet.") }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
