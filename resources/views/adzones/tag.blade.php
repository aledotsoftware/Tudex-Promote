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
                    <textarea class="w-full h-64 p-4 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl font-mono text-sm text-gray-600 dark:text-gray-300 focus:ring-brand-500 focus:border-brand-500" readonly><!-- Ad Server Tag -->
<div class="ad-server-placeholder"
     data-adzone-id="{{ $adZone->id }}"
     @if($adZone->width) data-width="{{ $adZone->width }}" @endif
     @if($adZone->height) data-height="{{ $adZone->height }}" @endif
     data-font-family="inherit"
     data-bg-color="transparent"
     data-title-color="#1a0dab"
     data-desc-color="#4d5156">
</div>
<script src="{{ asset('js/ad-tag.js') }}" async defer></script>
<!-- End Ad Server Tag --></textarea>
                    <p class="mt-4 text-sm text-gray-500">
                        You can customize the <code>data-*</code> attributes to match your site's design.
                    </p>
                                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
