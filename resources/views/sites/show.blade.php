<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $site->domain }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Add a new ad zone') }}</h3>
                        <form method="POST" action="{{ route('ad-zones.store') }}" class="mt-2">
                            @csrf
                            <input type="hidden" name="site_id" value="{{ $site->id }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                                </div>
                                <div>
                                    <x-input-label for="width" :value="__('Width')" />
                                    <x-text-input id="width" class="block mt-1 w-full" type="number" name="width" required />
                                </div>
                                <div>
                                    <x-input-label for="height" :value="__('Height')" />
                                    <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" required />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Add Ad Zone') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Your Ad Zones') }}</h3>
                        <div class="mt-2 space-y-4">
                            @forelse ($site->adZones as $adZone)
                                <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg flex items-center justify-between">
                                    <div>
                                        <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $adZone->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $adZone->width }}x{{ $adZone->height }}
                                        </p>
                                    </div>
                                    <a href="{{ route('sites.tag', $adZone) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Get Tag') }}</a>
                                </div>
                            @empty
                                <p>{{ __("This site doesn't have any ad zones yet.") }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
