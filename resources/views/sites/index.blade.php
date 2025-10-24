<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Sites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Add a new site') }}</h3>
                        <form method="POST" action="{{ route('sites.store') }}" class="mt-2">
                            @csrf
                            <div>
                                <x-input-label for="domain" :value="__('Domain')" />
                                <x-text-input id="domain" class="block mt-1 w-full" type="text" name="domain" :value="old('domain')" required autofocus />
                                <x-input-error :messages="$errors->get('domain')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button>
                                    {{ __('Add Site') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Your Sites') }}</h3>
                        <div class="mt-2 space-y-4">
                            @forelse ($sites as $site)
                                <div class="p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                                    <p class="text-gray-800 dark:text-gray-200">{{ $site->domain }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $site->verified ? __('Verified') : __('Not Verified') }}
                                    </p>
                                </div>
                            @empty
                                <p>{{ __("You haven't added any sites yet.") }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
