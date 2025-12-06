<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('creatives.index') }}" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detalles del Creativo') }}
                </h2>
            </div>
            <div class="flex items-center gap-2">
                @if($creative->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                        <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                        Activo
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                        <span class="w-2 h-2 mr-2 bg-yellow-500 rounded-full"></span>
                        Pausado
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Details Section -->
                <div class="space-y-6">
                    <!-- Basic Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Información del Anuncio
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Campaña</label>
                                <p class="mt-1 text-gray-900 dark:text-gray-100 font-medium">{{ $creative->campaign->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Título</label>
                                <p class="mt-1 text-gray-900 dark:text-gray-100 font-medium">{{ $creative->title }}</p>
                            </div>
                            
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Descripción</label>
                                <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $creative->description }}</p>
                            </div>
                            
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Texto del Botón</label>
                                <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $creative->button_text ?? 'Learn More' }}</p>
                            </div>
                            
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">URL de Destino</label>
                                <a href="{{ $creative->click_url }}" target="_blank" class="mt-1 text-brand-600 dark:text-brand-400 hover:underline flex items-center">
                                    {{ $creative->click_url }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>

                            @if($creative->image_url)
                            <div>
                                <label class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Imagen</label>
                                <img src="{{ $creative->image_url }}" alt="" class="mt-2 rounded-lg max-h-32 object-cover">
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Colors Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                            </svg>
                            Configuración de Colores
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg shadow-inner border" style="background-color: {{ $creative->bg_color ?? '#ffffff' }}"></div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Fondo</p>
                                    <p class="text-sm font-mono">{{ $creative->bg_color ?? '#ffffff' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg shadow-inner border" style="background-color: {{ $creative->title_color ?? '#0f172a' }}"></div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Título</p>
                                    <p class="text-sm font-mono">{{ $creative->title_color ?? '#0f172a' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg shadow-inner border" style="background-color: {{ $creative->text_color ?? '#64748b' }}"></div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Texto</p>
                                    <p class="text-sm font-mono">{{ $creative->text_color ?? '#64748b' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg shadow-inner border" style="background-color: {{ $creative->button_color ?? '#3b82f6' }}"></div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Botón</p>
                                    <p class="text-sm font-mono">{{ $creative->button_color ?? '#3b82f6' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg shadow-inner border" style="background-color: {{ $creative->border_color ?? '#e2e8f0' }}"></div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Borde</p>
                                    <p class="text-sm font-mono">{{ $creative->border_color ?? '#e2e8f0' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Acciones</h3>
                        <div class="flex flex-wrap gap-3">
                            <form method="POST" action="{{ route('creatives.toggle-status', $creative) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 {{ $creative->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} rounded-lg transition-colors font-medium">
                                    @if($creative->is_active)
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Pausar
                                    @else
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Activar
                                    @endif
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('creatives.duplicate', $creative) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Duplicar
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('creatives.destroy', $creative) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este creativo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 sticky top-8">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Vista Previa
                            </h3>
                            <select id="formatSelector" class="text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                                <option value="wide">Wide (Horizontal)</option>
                                <option value="square">Square</option>
                                <option value="tall">Tall (Vertical)</option>
                                <option value="native">Native</option>
                            </select>
                        </div>
                        
                        <div class="bg-gray-100 dark:bg-gray-900 rounded-lg p-6">
                            <div id="previewContainer" class="flex justify-center">
                                <!-- Preview will be loaded here -->
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex">
                                <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-blue-700 dark:text-blue-300">
                                    <p class="font-semibold">Formatos Adaptativos</p>
                                    <p class="mt-1">Este anuncio se adaptará automáticamente al formato del espacio publicitario donde se muestre. Usa el selector arriba para ver cómo se verá en diferentes formatos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const creative = {
            title: @json($creative->title),
            description: @json($creative->description),
            buttonText: @json($creative->button_text ?? 'Learn More'),
            clickUrl: @json($creative->click_url),
            imageUrl: @json($creative->image_url),
            bgColor: @json($creative->bg_color ?? '#ffffff'),
            titleColor: @json($creative->title_color ?? '#0f172a'),
            textColor: @json($creative->text_color ?? '#64748b'),
            buttonColor: @json($creative->button_color ?? '#3b82f6'),
            borderColor: @json($creative->border_color ?? '#e2e8f0'),
        };

        function getDomain(url) {
            try {
                return new URL(url).hostname;
            } catch {
                return 'promoted';
            }
        }

        function renderPreview(format) {
            const domain = getDomain(creative.clickUrl);
            const imageHtml = creative.imageUrl ? `<img src="${creative.imageUrl}" alt="" style="width: 100%; max-height: 100px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;">` : '';
            
            let html = '';
            
            if (format === 'wide') {
                html = `
                    <div style="background-color: ${creative.bgColor}; border: 1px solid ${creative.borderColor}; border-radius: 12px; padding: 20px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; max-width: 500px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        <h3 style="color: ${creative.titleColor}; font-size: 18px; font-weight: 700; margin: 0 0 8px 0;">${creative.title}</h3>
                        <p style="color: ${creative.textColor}; font-size: 14px; line-height: 1.4; margin: 0 0 12px 0;">${creative.description}</p>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                            <span style="color: ${creative.textColor}; font-size: 11px; opacity: 0.6;">Ad · ${domain}</span>
                            <button style="background-color: ${creative.buttonColor}; color: white; padding: 8px 20px; border-radius: 6px; border: none; font-weight: 600; font-size: 13px; cursor: pointer;">${creative.buttonText}</button>
                        </div>
                    </div>
                `;
            } else if (format === 'square') {
                html = `
                    <div style="background-color: ${creative.bgColor}; border: 1px solid ${creative.borderColor}; border-radius: 12px; padding: 18px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; width: 260px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        ${imageHtml}
                        <h3 style="color: ${creative.titleColor}; font-size: 16px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">${creative.title}</h3>
                        <p style="color: ${creative.textColor}; font-size: 13px; line-height: 1.4; margin: 0 0 12px 0;">${creative.description}</p>
                        <button style="background-color: ${creative.buttonColor}; color: white; padding: 10px 20px; border-radius: 6px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; width: 100%;">${creative.buttonText}</button>
                        <span style="display: block; color: ${creative.textColor}; font-size: 10px; opacity: 0.5; margin-top: 8px; text-align: center;">Ad · ${domain}</span>
                    </div>
                `;
            } else if (format === 'tall') {
                html = `
                    <div style="background-color: ${creative.bgColor}; border: 1px solid ${creative.borderColor}; border-radius: 12px; padding: 16px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; width: 180px; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                        ${imageHtml}
                        <h3 style="color: ${creative.titleColor}; font-size: 15px; font-weight: 700; margin: 0 0 8px 0; line-height: 1.3;">${creative.title}</h3>
                        <p style="color: ${creative.textColor}; font-size: 12px; line-height: 1.4; margin: 0 0 12px 0;">${creative.description}</p>
                        <button style="background-color: ${creative.buttonColor}; color: white; padding: 10px 16px; border-radius: 6px; border: none; font-weight: 600; font-size: 12px; cursor: pointer; width: 100%;">${creative.buttonText}</button>
                        <span style="display: block; color: ${creative.textColor}; font-size: 10px; opacity: 0.5; margin-top: 8px; text-align: center;">Ad · ${domain}</span>
                    </div>
                `;
            } else if (format === 'native') {
                html = `
                    <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; padding: 12px 0; border-bottom: 1px solid ${creative.borderColor}; max-width: 400px;">
                        <h4 style="color: ${creative.titleColor}; font-size: 15px; font-weight: 600; margin: 0 0 4px 0;">${creative.title}</h4>
                        <p style="color: ${creative.textColor}; font-size: 13px; line-height: 1.4; margin: 0 0 6px 0;">${creative.description}</p>
                        <span style="color: ${creative.buttonColor}; font-size: 12px; font-weight: 500;">${creative.buttonText} →</span>
                        <span style="color: ${creative.textColor}; font-size: 10px; opacity: 0.5; margin-left: 8px;">Ad</span>
                    </div>
                `;
            }
            
            document.getElementById('previewContainer').innerHTML = html;
        }

        document.getElementById('formatSelector').addEventListener('change', (e) => {
            renderPreview(e.target.value);
        });

        // Initial render
        renderPreview('wide');
    </script>
</x-app-layout>
