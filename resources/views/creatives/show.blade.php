<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Creative Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p><strong>{{ __('Campaign') }}:</strong> {{ $creative->campaign->name }}</p>
                    <p><strong>{{ __('Type') }}:</strong> {{ $creative->type }}</p>
                    <p><strong>{{ __('Dimensions') }}:</strong> {{ $creative->width }}x{{ $creative->height }}</p>
                    <p><strong>{{ __('Click URL') }}:</strong> <a href="{{ $creative->click_url }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $creative->click_url }}</a></p>

                    <hr class="my-6 border-gray-200 dark:border-gray-700">

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Preview') }}</h3>
                    <div class="mt-4">
                        @if ($creative->type === 'html')
                            <iframe srcdoc="{{ Storage::disk('public')->get($creative->file_url) }}" width="{{ $creative->width }}" height="{{ $creative->height }}" class="border"></iframe>
                        @else
                            <p>{{ __("Preview is not available for this creative type.") }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
