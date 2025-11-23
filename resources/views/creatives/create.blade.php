<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.add_new_creative') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Form Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">{{ __('messages.creative_details') }}</h3>
                        
                        <form method="POST" action="{{ route('creatives.store') }}" id="creativeForm">
                            @csrf

                            <!-- Campaign -->
                            <div class="mt-4">
                                <x-input-label for="campaign_id" :value="__('messages.campaign')" />
                                <select id="campaign_id" name="campaign_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach ($campaigns as $campaign)
                                        <option value="{{ $campaign->id }}" @if(request('campaign_id') == $campaign->id) selected @endif>{{ $campaign->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('campaign_id')" class="mt-2" />
                            </div>

                            <!-- Title -->
                            <div class="mt-4">
                                <x-input-label for="title" :value="__('messages.title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('messages.description')" />
                                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Click URL -->
                            <div class="mt-4">
                                <x-input-label for="click_url" :value="__('messages.click_url')" />
                                <x-text-input id="click_url" class="block mt-1 w-full" type="url" name="click_url" :value="old('click_url')" required />
                                <x-input-error :messages="$errors->get('click_url')" class="mt-2" />
                            </div>

                            <!-- Type (Optional - for organization only) -->
                        <div class="mt-4">
                            <x-input-label for="type" :value="__('messages.ad_type')" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="wide">{{ __('messages.wide_banner') }} (Horizontal)</option>
                                <option value="tall">{{ __('messages.tall_skyscraper') }} (Vertical)</option>
                                <option value="square">{{ __('messages.square_ad') }}</option>
                                <option value="popup">{{ __('messages.popup_ad') }}</option>
                                <option value="interstitial">{{ __('messages.interstitial_ad') }}</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('messages.ad_type_note') }}
                            </p>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                            <!-- Color Customization Section -->
                            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.color_customization') }}</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Background Color -->
                                    <div>
                                        <x-input-label for="bg_color" :value="__('messages.background_color')" />
                                        <div class="flex items-center gap-2 mt-1">
                                            <input type="color" id="bg_color" name="bg_color" value="{{ old('bg_color', '#ffffff') }}" class="h-10 w-20 rounded border-gray-300 dark:border-gray-700 cursor-pointer">
                                            <input type="text" id="bg_color_text" value="{{ old('bg_color', '#ffffff') }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" readonly>
                                        </div>
                                        <x-input-error :messages="$errors->get('bg_color')" class="mt-2" />
                                    </div>

                                    <!-- Title Color -->
                                    <div>
                                        <x-input-label for="title_color" :value="__('messages.title_color')" />
                                        <div class="flex items-center gap-2 mt-1">
                                            <input type="color" id="title_color" name="title_color" value="{{ old('title_color', '#0f172a') }}" class="h-10 w-20 rounded border-gray-300 dark:border-gray-700 cursor-pointer">
                                            <input type="text" id="title_color_text" value="{{ old('title_color', '#0f172a') }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" readonly>
                                        </div>
                                        <x-input-error :messages="$errors->get('title_color')" class="mt-2" />
                                    </div>

                                    <!-- Text/Description Color -->
                                    <div>
                                        <x-input-label for="text_color" :value="__('messages.description_color')" />
                                        <div class="flex items-center gap-2 mt-1">
                                            <input type="color" id="text_color" name="text_color" value="{{ old('text_color', '#64748b') }}" class="h-10 w-20 rounded border-gray-300 dark:border-gray-700 cursor-pointer">
                                            <input type="text" id="text_color_text" value="{{ old('text_color', '#64748b') }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" readonly>
                                        </div>
                                        <x-input-error :messages="$errors->get('text_color')" class="mt-2" />
                                    </div>

                                    <!-- Button Color -->
                                    <div>
                                        <x-input-label for="button_color" :value="__('messages.button_color')" />
                                        <div class="flex items-center gap-2 mt-1">
                                            <input type="color" id="button_color" name="button_color" value="{{ old('button_color', '#3b82f6') }}" class="h-10 w-20 rounded border-gray-300 dark:border-gray-700 cursor-pointer">
                                            <input type="text" id="button_color_text" value="{{ old('button_color', '#3b82f6') }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" readonly>
                                        </div>
                                        <x-input-error :messages="$errors->get('button_color')" class="mt-2" />
                                    </div>

                                    <!-- Border Color -->
                                    <div>
                                        <x-input-label for="border_color" :value="__('messages.border_color')" />
                                        <div class="flex items-center gap-2 mt-1">
                                            <input type="color" id="border_color" name="border_color" value="{{ old('border_color', '#e2e8f0') }}" class="h-10 w-20 rounded border-gray-300 dark:border-gray-700 cursor-pointer">
                                            <input type="text" id="border_color_text" value="{{ old('border_color', '#e2e8f0') }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" readonly>
                                        </div>
                                        <x-input-error :messages="$errors->get('border_color')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6 gap-3">
                                <a href="{{ route('creatives.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                                    {{ __('messages.cancel') }}
                                </a>
                                <x-primary-button>
                                    {{ __('messages.add_creative') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Live Preview Section -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sticky top-8 self-start">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">{{ __('messages.live_preview') }}</h3>
                        
                        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-4">
                            <div id="adPreview" class="bg-white rounded-lg shadow-lg overflow-hidden" style="max-width: 600px; margin: 0 auto;">
                                <!-- Ad Preview will be rendered here -->
                                <div class="p-6 text-center text-gray-400">
                                    <svg class="mx-auto h-12 w-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <p class="text-sm">{{ __('messages.preview_will_appear_here') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-blue-700 dark:text-blue-300">
                                    <p class="font-semibold">{{ __('messages.preview_tip') }}</p>
                                    <p class="mt-1">{{ __('messages.preview_tip_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sync color pickers with text inputs
        ['bg_color', 'title_color', 'text_color', 'button_color', 'border_color'].forEach(field => {
            const colorInput = document.getElementById(field);
            const textInput = document.getElementById(field + '_text');
            
            colorInput.addEventListener('input', (e) => {
                textInput.value = e.target.value;
                updatePreview();
            });
        });

        // Live preview update
        function updatePreview() {
            const title = document.getElementById('title').value || 'Your Ad Title';
            const description = document.getElementById('description').value || 'Your ad description will appear here. Make it compelling!';
            const clickUrl = document.getElementById('click_url').value || 'https://example.com';
            const bgColor = document.getElementById('bg_color').value;
            const titleColor = document.getElementById('title_color').value;
            const textColor = document.getElementById('text_color').value;
            const buttonColor = document.getElementById('button_color').value;
            const borderColor = document.getElementById('border_color').value;

            let domain = 'example.com';
            try {
                if (clickUrl) {
                    domain = new URL(clickUrl).hostname;
                }
            } catch (e) {
                domain = 'example.com';
            }

            const previewHTML = `
                <div style="background-color: ${bgColor}; border: 2px solid ${borderColor}; border-radius: 8px; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    <h3 style="color: ${titleColor}; font-size: 20px; font-weight: 700; margin: 0 0 12px 0;">${title}</h3>
                    <p style="color: ${textColor}; font-size: 14px; line-height: 1.5; margin: 0 0 16px 0;">${description}</p>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <span style="color: ${textColor}; font-size: 12px; opacity: 0.7;">${domain}</span>
                        <a href="#" style="background-color: ${buttonColor}; color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block;">Learn More</a>
                    </div>
                </div>
            `;

            document.getElementById('adPreview').innerHTML = previewHTML;
        }

        // Update preview on input change
        ['title', 'description', 'click_url'].forEach(field => {
            document.getElementById(field).addEventListener('input', updatePreview);
        });

        // Initial preview
        updatePreview();
    </script>
</x-app-layout>
