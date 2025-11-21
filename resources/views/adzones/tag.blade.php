<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ad Tag for') }} {{ $adZone->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Ad Tag') }}</h3>
                    <p class="mt-2">{{ __('Copy and paste this code into your website where you want the ad to appear.') }}</p>

                    <div class="mt-4">
                    <textarea class="w-full h-48 p-2 border border-gray-300 rounded-md" readonly><!-- Ad Server Tag -->
                    <div class="ad-server-placeholder"
                        data-adzone-id="{{ $adZone->id }}"
                        @if($adZone->width) data-width="{{ $adZone->width }}" @endif
                        @if($adZone->height) data-height="{{ $adZone->height }}" @endif>
                    </div>
                    <script src="{{ asset('js/ad-tag.js') }}" async defer></script>
                    <!-- End Ad Server Tag -->
                    </textarea>
                                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
