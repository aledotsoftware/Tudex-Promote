<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Site Stats for') }} {{ $site->domain }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Performance Overview') }}</h3>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Impressions') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['impressions'] }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Total Clicks') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['clicks'] }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Click-Through Rate (CTR)') }}</p>
                            <p class="mt-1 text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['ctr'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
