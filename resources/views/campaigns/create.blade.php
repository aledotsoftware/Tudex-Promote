<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.add_new_campaign') }}
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
                            <x-input-label for="name" :value="__('messages.campaign_name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Budget -->
                        <div class="mt-4">
                            <x-input-label for="budget" :value="__('messages.budget')" />
                            <x-text-input id="budget" class="block mt-1 w-full" type="number" name="budget" :value="old('budget')" required />
                            <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                        </div>

                        <!-- Model -->
                        <div class="mt-4">
                            <x-input-label for="model" :value="__('messages.payment_model')" />
                            <select id="model" name="model" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="cpc">{{ __('messages.cpc') }}</option>
                                <option value="cpm">{{ __('messages.cpm') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <!-- Start At -->
                            <div>
                                <x-input-label for="start_at" :value="__('messages.start_date')" />
                                <x-text-input id="start_at" class="block mt-1 w-full" type="date" name="start_at" :value="old('start_at')" />
                                <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                            </div>

                            <!-- End At -->
                            <div>
                                <x-input-label for="end_at" :value="__('messages.end_date')" />
                                <x-text-input id="end_at" class="block mt-1 w-full" type="date" name="end_at" :value="old('end_at')" />
                                <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                            </div>
                        </div>
                        
                        <!-- Ad Style Settings -->
                        <div class="mt-8 border-t pt-6 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.ad_appearance') }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="title_color" :value="__('messages.title_color')" />
                                    <div class="flex items-center mt-1">
                                        <input type="color" id="title_color" name="title_color" value="#1a0dab" class="h-10 w-10 rounded border border-gray-300 cursor-pointer">
                                        <x-text-input class="ml-2 block w-full" type="text" name="title_color_text" value="#1a0dab" onchange="document.getElementById('title_color').value = this.value" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="description_color" :value="__('messages.description_color')" />
                                    <div class="flex items-center mt-1">
                                        <input type="color" id="description_color" name="description_color" value="#3c4043" class="h-10 w-10 rounded border border-gray-300 cursor-pointer">
                                        <x-text-input class="ml-2 block w-full" type="text" name="description_color_text" value="#3c4043" onchange="document.getElementById('description_color').value = this.value" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="accent_color" :value="__('messages.accent_color')" />
                                    <div class="flex items-center mt-1">
                                        <input type="color" id="accent_color" name="accent_color" value="#1a73e8" class="h-10 w-10 rounded border border-gray-300 cursor-pointer">
                                        <x-text-input class="ml-2 block w-full" type="text" name="accent_color_text" value="#1a73e8" onchange="document.getElementById('accent_color').value = this.value" />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="font_family" :value="__('messages.font_family')" />
                                    <select id="font_family" name="font_family" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="Roboto, sans-serif">Roboto (Default)</option>
                                        <option value="'Open Sans', sans-serif">Open Sans</option>
                                        <option value="'Lato', sans-serif">Lato</option>
                                        <option value="'Montserrat', sans-serif">Montserrat</option>
                                        <option value="Arial, sans-serif">Arial</option>
                                        <option value="Helvetica, sans-serif">Helvetica</option>
                                        <option value="Georgia, serif">Georgia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('messages.create_campaign') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
