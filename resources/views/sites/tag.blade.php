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
                    <p>{{ __("Copy and paste this code into your website's HTML where you want the ad to appear.") }}</p>

                    <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg">
                        <pre><code class="language-html">&lt;div id="ad-zone-{{ $adZone->id }}"&gt;&lt;/div&gt;
&lt;script src="{{ route('ad-tag.js') }}?zone_id={{ $adZone->id }}"&gt;&lt;/script&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
