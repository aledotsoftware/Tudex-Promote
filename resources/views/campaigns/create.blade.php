<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Campaign') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Status -->
            @if (session('info'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('campaigns.store') }}">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Campaign Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Budget -->
                        <div class="mt-4">
                            <x-input-label for="budget" :value="__('Budget')" />
                            <x-text-input id="budget" class="block mt-1 w-full" type="number" name="budget" :value="old('budget')" required />
                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>

                        <!-- Model -->
                        <div class="mt-4">
                            <x-input-label for="model" :value="__('Payment Model')" />
                            <select id="model" name="model" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="cpc">{{ __('CPC (Cost Per Click)') }}</option>
                                <option value="cpm">{{ __('CPM (Cost Per Mille)') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <!-- Start At -->
                            <div>
                                <x-input-label for="start_at" :value="__('Start Date')" />
                                <x-text-input id="start_at" class="block mt-1 w-full" type="date" name="start_at" :value="old('start_at')" />
                                <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                            </div>

                            <!-- End At -->
                            <div>
                                <x-input-label for="end_at" :value="__('End Date')" />
                                <x-text-input id="end_at" class="block mt-1 w-full" type="date" name="end_at" :value="old('end_at')" />
                                <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Create Campaign') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
