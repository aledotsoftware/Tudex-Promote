<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Sites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Session Status -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

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
                                <a href="{{ route('sites.show', $site) }}" class="block p-4 bg-gray-100 dark:bg-gray-900 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-gray-800 dark:text-gray-200 font-semibold">{{ $site->domain }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                @if ($site->verified && $site->verification_expires_at > now())
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ __('Verified until') }} {{ $site->verification_expires_at->format('M d, Y') }}
                                                    </span>
                                                @elseif ($site->verified && $site->verification_expires_at <= now())
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ __('Verification Expired') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ __('Not Verified') }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                        @if ($site->verified && $site->verification_expires_at > now())
                                            <a href="{{ route('sites.stats', $site) }}" class="mr-4 text-sm text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Stats') }}</a>
                                            <button @click="open = !open" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Show Ad Code') }}</button>
                                        @else
                                            <div>
                                                <button @click="open = !open" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">{{ __('Show Instructions') }}</button>
                                                <a href="{{ route('sites.verify', $site) }}" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">{{ __('Verify Now') }}</a>
                                            </div>
                                        @endif
                                    </div>
                                    <div x-show="open" class="mt-4 p-4 bg-gray-200 dark:bg-gray-700 rounded-lg">
                                        @if ($site->verified && $site->verification_expires_at > now())
                                            <h4 class="font-semibold">{{ __('Ad Code Installation') }}</h4>
                                            <p class="mt-2">{{ __('Follow these steps to display ads on your site:') }}</p>
                                            <div class="mt-4">
                                                <h5 class="font-semibold">{{ __('Step 1: Add the Ad Tag to Your Head') }}</h5>
                                                <p>{{ __('Copy and paste this script tag into the `<head>` section of your website.') }}</p>
                                                <div class="mt-2 p-2 bg-gray-100 dark:bg-gray-800 rounded">
                                                    <code class="text-sm">&lt;script src="{{ route('ad-tag.js') }}" defer&gt;&lt;/script&gt;</code>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="font-semibold">{{ __('Step 2: Place the Ad Code on Your Site') }}</h5>
                                                <p>{{ __('Copy and paste this div tag where you want the ad to appear. You can customize the `data-type` (e.g., banner, square).') }}</p>
                                                <div class="mt-2 p-2 bg-gray-100 dark:bg-gray-800 rounded">
                                                    <code class="text-sm">&lt;div class="ad-server-placeholder" data-site-id="{{ $site->id }}" data-type="banner"&gt;&lt;/div&gt;</code>
                                                </div>
                                            </div>
                                        @else
                                            <h4 class="font-semibold">{{ __('Verification Instructions') }}</h4>
                                            <p class="mt-2">{{ __('Choose one of the following methods to verify your domain:') }}</p>
                                            @php
                                                $cleanDomain = str_replace(['http://', 'https://'], '', $site->domain);
                                            @endphp
                                            <div class="mt-4">
                                                <h5 class="font-semibold">{{ __('Method 1: DNS TXT Record') }}</h5>
                                                <p>{{ __("Add a TXT record to your domain's DNS settings with the following values:") }}</p>
                                                <div class="mt-2 p-2 bg-gray-100 dark:bg-gray-800 rounded">
                                                    <code class="text-sm">adverify.{{ $cleanDomain }} IN TXT "{{ $site->verification_token }}"</code>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="font-semibold">{{ __('Method 2: ads.txt File') }}</h5>
                                                <p>{{ __('Add the following line to the `ads.txt` file at the root of your domain (e.g., `https://' . $cleanDomain . '/ads.txt`):') }}</p>
                                                <div class="mt-2 p-2 bg-gray-100 dark:bg-gray-800 rounded">
                                                    <code class="text-sm">your-ad-network.com, {{ $site->verification_token }}, DIRECT</code>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
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
