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
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required maxlength="100" />
                                <p class="mt-1 text-xs text-gray-500">Máximo 100 caracteres</p>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <x-input-label for="description" :value="__('messages.description')" />
                                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3" maxlength="300">{{ old('description') }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Máximo 300 caracteres</p>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Button Text -->
                            <div class="mt-4">
                                <x-input-label for="button_text" :value="__('Texto del Botón')" />
                                <x-text-input id="button_text" class="block mt-1 w-full" type="text" name="button_text" :value="old('button_text', 'Learn More')" maxlength="30" />
                                <p class="mt-1 text-xs text-gray-500">Ej: "Comprar Ahora", "Más Info", "Registrarse"</p>
                                <x-input-error :messages="$errors->get('button_text')" class="mt-2" />
                            </div>

                            <!-- Click URL -->
                            <div class="mt-4">
                                <x-input-label for="click_url" :value="__('messages.click_url')" />
                                <x-text-input id="click_url" class="block mt-1 w-full" type="url" name="click_url" :value="old('click_url')" required />
                                <x-input-error :messages="$errors->get('click_url')" class="mt-2" />
                            </div>

                            <!-- Image URL (Optional) -->
                            <div class="mt-4">
                                <x-input-label for="image_url" :value="__('URL de Imagen (Opcional)')" />
                                <x-text-input id="image_url" class="block mt-1 w-full" type="url" name="image_url" :value="old('image_url')" placeholder="https://example.com/image.jpg" />
                                <p class="mt-1 text-xs text-gray-500">Imagen promocional (recomendado: 400x300px)</p>
                                <x-input-error :messages="$errors->get('image_url')" class="mt-2" />
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
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">{{ __('messages.live_preview') }}</h3>
                            <select id="previewFormat" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="wide">Wide (Horizontal)</option>
                                <option value="square">Square</option>
                                <option value="tall">Tall (Vertical)</option>
                                <option value="native">Native</option>
                            </select>
                        </div>
                        
                        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-4">
                            <div id="adPreview" style="max-width: 600px; margin: 0 auto;">
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
                                    <p class="font-semibold">Formatos Adaptativos</p>
                                    <p class="mt-1">Tu anuncio se adaptará automáticamente al formato del espacio publicitario donde se muestre.</p>
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
            const format = document.getElementById('previewFormat').value;
            const title = document.getElementById('title').value || 'Your Ad Title';
            const description = document.getElementById('description').value || 'Your ad description will appear here. Make it compelling!';
            const buttonText = document.getElementById('button_text').value || 'Learn More';
            const clickUrl = document.getElementById('click_url').value || 'https://example.com';
            const imageUrl = document.getElementById('image_url').value || '';
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

            const imageHtml = imageUrl ? `<img src="${imageUrl}" alt="" style="width: 100%; max-height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;">` : '';

            let previewHTML = '';
            
            if (format === 'wide') {
                previewHTML = `
                    <div style="background-color: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 12px; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; display: flex; align-items: center; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <div style="flex: 1; min-width: 0;">
                            ${imageUrl ? `<img src="${imageUrl}" alt="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; float: left; margin-right: 16px;">` : ''}
                            <h3 style="color: ${titleColor}; font-size: 18px; font-weight: 700; margin: 0 0 8px 0;">${title}</h3>
                            <p style="color: ${textColor}; font-size: 14px; line-height: 1.4; margin: 0 0 12px 0;">${description}</p>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; clear: both;">
                                <span style="color: ${textColor}; font-size: 11px; opacity: 0.6;">Ad · ${domain}</span>
                                <button style="background-color: ${buttonColor}; color: white; padding: 8px 20px; border-radius: 6px; border: none; font-weight: 600; font-size: 13px; cursor: pointer;">${buttonText}</button>
                            </div>
                        </div>
                    </div>
                `;
            } else if (format === 'square') {
                previewHTML = `
                    <div style="background-color: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 12px; padding: 18px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 280px; margin: 0 auto;">
                        ${imageHtml}
                        <h3 style="color: ${titleColor}; font-size: 16px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">${title}</h3>
                        <p style="color: ${textColor}; font-size: 13px; line-height: 1.4; margin: 0 0 12px 0;">${description}</p>
                        <button style="background-color: ${buttonColor}; color: white; padding: 10px 20px; border-radius: 6px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; width: 100%;">${buttonText}</button>
                        <span style="display: block; color: ${textColor}; font-size: 10px; opacity: 0.5; margin-top: 8px; text-align: center;">Ad · ${domain}</span>
                    </div>
                `;
            } else if (format === 'tall') {
                previewHTML = `
                    <div style="background-color: ${bgColor}; border: 1px solid ${borderColor}; border-radius: 12px; padding: 16px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08); max-width: 180px; margin: 0 auto;">
                        ${imageHtml}
                        <h3 style="color: ${titleColor}; font-size: 15px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">${title}</h3>
                        <p style="color: ${textColor}; font-size: 12px; line-height: 1.4; margin: 0 0 12px 0;">${description}</p>
                        <button style="background-color: ${buttonColor}; color: white; padding: 10px 16px; border-radius: 6px; border: none; font-weight: 600; font-size: 12px; cursor: pointer; width: 100%;">${buttonText}</button>
                        <span style="display: block; color: ${textColor}; font-size: 10px; opacity: 0.5; margin-top: 8px; text-align: center;">Ad · ${domain}</span>
                    </div>
                `;
            } else if (format === 'native') {
                previewHTML = `
                    <a href="#" style="display: block; text-decoration: none; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 12px 0; border-bottom: 1px solid ${borderColor};">
                        <h4 style="color: ${titleColor}; font-size: 15px; font-weight: 600; margin: 0 0 4px 0;">${title}</h4>
                        <p style="color: ${textColor}; font-size: 13px; line-height: 1.4; margin: 0 0 6px 0;">${description}</p>
                        <span style="color: ${buttonColor}; font-size: 12px; font-weight: 500;">${buttonText} →</span>
                        <span style="color: ${textColor}; font-size: 10px; opacity: 0.5; margin-left: 8px;">Ad</span>
                    </a>
                `;
            }

            document.getElementById('adPreview').innerHTML = previewHTML;
        }

        // Update preview on input change
        ['title', 'description', 'click_url', 'button_text', 'image_url'].forEach(field => {
            document.getElementById(field).addEventListener('input', updatePreview);
        });
        
        document.getElementById('previewFormat').addEventListener('change', updatePreview);

        // Initial preview
        updatePreview();
    </script>
</x-app-layout>
