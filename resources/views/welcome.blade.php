<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tudex Promote</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <header class="bg-white dark:bg-gray-900 shadow-md">
            <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">Tudex Promote</a>
                <div>
                    <a href="#" class="px-4">Blog</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-4">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="px-4">Iniciar sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md">Regístrese</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>
        </header>

        <main>
            <section class="bg-blue-700 text-white text-center py-20">
                <div class="container mx-auto px-6">
                    <h1 class="text-4xl font-bold mb-4">La mejor red publicitaria y plataforma de monetización de tráfico</h1>
                    <p class="text-xl mb-8">La mejor red publicitaria para anunciantes y editores, con una plataforma autoservicio fácil de usar, soporte personalizado y alcance global.</p>
                    <div>
                        <a href="{{ route('register') }}" class="bg-white text-blue-700 font-bold py-3 px-6 rounded-md mr-4">Ejecutar campañas publicitarias</a>
                        <a href="{{ route('register') }}" class="bg-gray-800 text-white font-bold py-3 px-6 rounded-md">Monetizar tráfico</a>
                    </div>
                </div>
            </section>

            <section class="py-20">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold mb-8">La mejor red publicitaria para anunciantes, editores y agencias</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-4xl mx-auto">
                        Tudex Promote es una plataforma de publicidad en línea líder, con miles de millones de impresiones de alta calidad, opciones de segmentación basadas en rendimiento y soluciones antifraude, que conecta marcas con sus clientes potenciales en todo el mundo y ayuda a los editores a ganar dinero en línea.
                    </p>
                </div>
            </section>

            <section class="bg-gray-100 dark:bg-gray-800 py-20">
                <div class="container mx-auto px-6">
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full md:w-1/2 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8">
                                <h3 class="text-2xl font-bold mb-4">Anunciantes</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">Tudex Promote es la mejor red publicitaria para anunciantes de todo el mundo.</p>
                                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                                    <li>Opciones avanzadas de segmentación</li>
                                    <li>Fuentes de tráfico directo</li>
                                    <li>Plataforma de autoservicio</li>
                                    <li>Servicio totalmente gestionado</li>
                                </ul>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-900 rounded-lg shadow-lg p-8">
                                <h3 class="text-2xl font-bold mb-4">Editores</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">Tudex Promote es la red publicitaria que mejor paga a webmasters y bloggers.</p>
                                <ul class="list-disc list-inside text-gray-600 dark:text-gray-400">
                                    <li>Soluciones Anti AdBlock</li>
                                    <li>Herramientas avanzadas de API</li>
                                    <li>Pagos semanales</li>
                                    <li>Sólo anuncios limpios preaprobados</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold mb-12">6 formatos publicitarios que mejor convierten</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h4 class="text-xl font-bold mb-4">Popunder</h4>
                                <p>Basado en CPM, un anuncio popunder o popup es un tipo de anuncio que aparece en una nueva ventana o pestaña detrás de la actual.</p>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h4 class="text-xl font-bold mb-4">In-Page</h4>
                                <p>Basado en CPM o CPC, In-Page es un formato publicitario que se parece a una notificación push en un sitio web.</p>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h4 class="text-xl font-bold mb-4">Vídeo VAST</h4>
                                <p>Un enlace con un feed de anuncios que se coloca en un reproductor de vídeo de un sitio web. Los anuncios se mostrarán antes del vídeo principal.</p>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h4 class="text-xl font-bold mb-4">Vídeo slider</h4>
                                <p>Cuando los visitantes visiten un sitio web, el anuncio en vídeo aparecerá en la esquina inferior derecha.</p>
                            </div>
                        </div>
                         <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h4 class="text-xl font-bold mb-4">Banner</h4>
                                <p>Basado en CPM o CPC, el banner es uno de los formatos publicitarios más atractivos, se coloca en una página del sitio web.</p>
                            </div>
                        </div>
                         <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <h4 class="text-xl font-bold mb-4">MultiTag</h4>
                                <p>MultiTag es una potente función que permite a los webmasters mostrar varios formatos de anuncios en su sitio web simultáneamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-blue-700 text-white py-20">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold mb-8">¡Únete a Tudex Promote ahora!</h2>
                    <p class="text-xl mb-8">La mejor red publicitaria para potenciar tus resultados en publicidad online.</p>
                    <a href="{{ route('register') }}" class="bg-white text-blue-700 font-bold py-3 px-6 rounded-md">Crear una cuenta</a>
                </div>
            </section>

            <section class="py-20">
                <div class="container mx-auto px-6">
                    <h2 class="text-3xl font-bold text-center mb-12">Nuestros clientes disfrutaron con Tudex Promote</h2>
                    <div class="flex flex-wrap -mx-4">
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <p class="text-gray-600 dark:text-gray-400 mb-4">"Tudex Promote es una plataforma fantástica con una interfaz de usuario agradable. Ofrecen una amplia gama de opciones de segmentación."</p>
                                <p class="font-bold">- Luke, Co-founder Afflift.com</p>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <p class="text-gray-600 dark:text-gray-400 mb-4">"¡Una fuente de tráfico sólida! No solo cumple, sino que supera nuestras expectativas. Ofrece precios de puja competitivos."</p>
                                <p class="font-bold">- Mobidea, Affiliate network</p>
                            </div>
                        </div>
                        <div class="w-full md:w-1/3 px-4 mb-8">
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                                <p class="text-gray-600 dark:text-gray-400 mb-4">"Tudex Promote ha demostrado ser un socio publicitario fiable y eficiente. Sus características avanzadas y su tráfico de alta calidad son de primera categoría."</p>
                                <p class="font-bold">- PIN-UP Partners, affiliate network</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white py-12">
            <div class="container mx-auto px-6">
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/4 mb-8">
                        <h4 class="font-bold mb-4">Empezar</h4>
                        <ul>
                            <li><a href="{{ route('register') }}">Crear una cuenta</a></li>
                            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/4 mb-8">
                        <h4 class="font-bold mb-4">Recursos</h4>
                        <ul>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Historias de éxito</a></li>
                            <li><a href="#">Preguntas frecuentes</a></li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/4 mb-8">
                        <h4 class="font-bold mb-4">Empresa</h4>
                        <ul>
                            <li><a href="#">Quiénes somos</a></li>
                            <li><a href="#">Carreras profesionales</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                    <div class="w-full md:w-1/4 mb-8">
                        <h4 class="font-bold mb-4">Contacto</h4>
                        <p>support@tudexpromote.com</p>
                    </div>
                </div>
                <div class="text-center pt-8 border-t border-gray-700">
                    <p>&copy; 2025 Tudex Promote. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
