<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Creative') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('creatives.store') }}">
                        @csrf

                        <!-- Campaign -->
                        <div class="mt-4">
                            <x-input-label for="campaign_id" :value="__('Campaign')" />
                            <select id="campaign_id" name="campaign_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach ($campaigns as $campaign)
                                    <option value="{{ $campaign->id }}" @if(request('campaign_id') == $campaign->id) selected @endif>{{ $campaign->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('campaign_id')" class="mt-2" />
                        </div>

                        <!-- HTML Content -->
                        <div class="mt-4">
                            <x-input-label for="html_content" :value="__('HTML Content')" />
                            <textarea id="html_content" name="html_content" rows="10" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('html_content') }}</textarea>
                            <x-input-error :messages="$errors->get('html_content')" class="mt-2" />
                        </div>

                        <!-- Click URL -->
                        <div class="mt-4">
                            <x-input-label for="click_url" :value="__('Click URL')" />
                            <x-text-input id="click_url" class="block mt-1 w-full" type="url" name="click_url" :value="old('click_url')" required />
                            <x-input-error :messages="$errors->get('click_url')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <!-- Width -->
                            <div>
                                <x-input-label for="width" :value="__('Width')" />
                                <x-text-input id="width" class="block mt-1 w-full" type="number" name="width" :value="old('width')" required />
                                <x-input-error :messages="$errors->get('width')" class="mt-2" />
                            </div>

                            <!-- Height -->
                            <div>
                                <x-input-label for="height" :value="__('Height')" />
                                <x-text-input id="height" class="block mt-1 w-full" type="number" name="height" :value="old('height')" required />
                                <x-input-error :messages="$errors->get('height')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Add Creative') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
