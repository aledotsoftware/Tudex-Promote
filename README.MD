# AdServer Laravel: Red Publicitaria Centralizada

**Una plataforma autogestionada para servir anuncios, conectar anunciantes y monetizar sitios web de forma sencilla y eficiente.**

---

## Visión del Proyecto

El objetivo de **AdServer Laravel** es construir una red publicitaria centralizada y de marca blanca que permita a los operadores de la plataforma gestionar sus propios ecosistemas de publicidad digital. La solución conecta a **anunciantes** que desean promocionar sus productos con **publishers** (sitios web asociados) que buscan monetizar su tráfico.

El sistema está diseñado para ser robusto, escalable y fácil de integrar, utilizando un stack tecnológico moderno basado en Laravel.

---

## Tabla de Contenidos

1.  [Características Principales](#1-características-principales)
2.  [Stack Tecnológico](#2-stack-tecnológico)
3.  [Módulos Funcionales](#3-módulos-funcionales)
    *   [Panel de Administración](#31-panel-de-administración)
    *   [Panel de Publisher](#32-panel-de-publisher)
    *   [Panel de Anunciante](#33-panel-de-anunciante)
    *   [Servidor de Anuncios (Ad Server)](#34-servidor-de-anuncios-ad-server)
4.  [Instalación y Puesta en Marcha](#4-instalación-y-puesta-en-marcha)
5.  [Modelo de Datos](#5-modelo-de-datos)
6.  [Seguridad](#6-seguridad)
7.  [Roadmap del Proyecto](#7-roadmap-del-proyecto)
    *   [Producto Mínimo Viable (MVP)](#71-producto-mínimo-viable-mvp)
    *   [Escalabilidad Futura](#72-escalabilidad-futura)

---

## 1. Características Principales

*   **Gestión Centralizada**: Administra sitios, campañas, usuarios y creativos desde un único panel.
*   **Roles de Usuario**: Perfiles definidos para Administradores, Publishers y Anunciantes.
*   **Verificación de Dominios**: Sistema seguro para validar la propiedad de los sitios mediante DNS o `ads.txt`.
*   **Servidor de Anuncios Ligero**: Entrega de anuncios de baja latencia con un script `tag.js` asíncrono.
*   **Seguimiento de Rendimiento**: Tracking de impresiones y clics con reportes detallados.
*   **Seguridad Integrada**: Protección contra ataques comunes y entrega segura de anuncios en iframes.

---

## 2. Stack Tecnológico

| Componente | Tecnología |
| :--- | :--- |
| **Backend** | Laravel 11 |
| **Frontend** | Blade + Bootstrap 5 |
| **Base de Datos** | MySQL / MariaDB |
| **Infraestructura** | Servidor web estándar (ej. Nginx), CDN (Cloudflare recomendado) |
| **Autenticación** | Laravel Breeze o Jetstream |
| **API Pública** | Laravel Sanctum (para `tag.js` y tracking) |
| **Cache** | Redis (recomendado para producción) |
| **Jobs y Colas** | Laravel Queues para tracking asíncrono |

---

## 3. Módulos Funcionales

### 3.1. Panel de Administración

El administrador tiene control total sobre la plataforma:
*   **Gestión Integral**: Crear, editar y suspender sitios, campañas y usuarios.
*   **Moderación de Contenido**: Aprobar o rechazar creativos publicitarios.
*   **Estadísticas Globales**: Visualizar el rendimiento general de la red.
*   **Configuración de Precios**: Definir los modelos y precios base (CPC, CPM).

### 3.2. Panel de Publisher

Los dueños de sitios web pueden monetizar su contenido:
*   **Registro de Sitios**: Añadir nuevos dominios a la plataforma.
*   **Verificación de Propiedad**:
    *   **Registro DNS (TXT)**: `adverify.tured.com IN TXT "pub-12345"`
    *   **Archivo `ads.txt`**: `tu-dominio.com, pub-12345, DIRECT`
*   **Creación de Zonas Publicitarias**: Definir los espacios (slots) donde se mostrarán los anuncios.
*   **Obtención de Código**: Generar el `tag.js` para insertar en el sitio.
*   **Reportes de Ganancias**: Consultar ingresos estimados, impresiones y clics.

### 3.3. Panel de Anunciante

Permite a los clientes promocionar sus productos o servicios:
*   **Gestión de Campañas**: Crear y administrar campañas publicitarias.
*   **Subida de Creativos**: Cargar imágenes, banners o fragmentos HTML.
*   **Configuración de Presupuesto**: Establecer límites diarios, fechas y modelos de pago (CPC/CPM).
*   **Segmentación Básica**: Seleccionar los sitios o categorías donde se mostrarán los anuncios.
*   **Estadísticas de Rendimiento**: Medir el impacto de las campañas.

### 3.4. Servidor de Anuncios (Ad Server)

El motor principal de la plataforma, responsable de la entrega y seguimiento:
*   **API de Entrega**: Un endpoint (`GET /api/serve`) que devuelve el anuncio correcto en formato JSON.
*   **API de Tracking**: Endpoints para registrar impresiones (`POST /api/impression`) y clics (`GET /redirect/:id`).
*   **Script `tag.js`**: Carga asíncrona y no bloqueante que renderiza los anuncios en un `iframe` aislado por seguridad.
*   **Optimización de Latencia**: Sistema de caché para acelerar la entrega de campañas activas.

---

## 4. Instalación y Puesta en Marcha

> **Nota:** Esta sección es una guía básica. Asegúrate de configurar las variables de entorno (`.env`) correctamente.

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/tu-usuario/adserver-laravel.git
    cd adserver-laravel
    ```
2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install && npm run build
    ```
3.  **Configurar el entorno:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Actualiza las credenciales de la base de datos en el archivo `.env`.*

4.  **Ejecutar migraciones y seeders:**
    ```bash
    php artisan migrate --seed
    ```
5.  **Iniciar el servidor local:**
    ```bash
    php artisan serve
    ```

---

## 5. Modelo de Datos

El esquema de la base de datos está diseñado para ser relacional y escalable.

*   `users` (id, name, email, role)
*   `sites` (id, user_id, domain, verified, verification_token)
*   `ad_zones` (id, site_id, name, width, height, type)
*   `campaigns` (id, advertiser_id, name, budget, start_at, end_at, model, status)
*   `creatives` (id, campaign_id, file_url, click_url, width, height, type)
*   `placements` (relación entre `creative_id`, `site_id`, `zone_id`)
*   `ad_impressions` (id, creative_id, site_id, timestamp, ip_hash)
*   `ad_clicks` (id, impression_id, creative_id, site_id, timestamp)

---

## 6. Seguridad

La seguridad es un pilar fundamental del proyecto:

*   **Aislamiento de Anuncios**: Los creativos se sirven en un `iframe` con el atributo `sandbox` para prevenir scripts maliciosos.
*   **CORS**: Las peticiones a la API están restringidas únicamente a los dominios verificados.
*   **Validación de Archivos**: Se valida el tipo MIME y el tamaño de los creativos subidos.
*   **Protección Estándar de Laravel**: CSRF, inyección SQL y XSS mitigados por el framework.
*   **Rate Limiting**: Protección contra peticiones masivas para evitar abusos.
*   **HTTPS**: Se recomienda encarecidamente el uso de SSL (gestionado fácilmente con Cloudflare).

---

## 7. Roadmap del Proyecto

### 7.1. Producto Mínimo Viable (MVP)

La primera versión se centrará en las funcionalidades esenciales para validar el modelo:
*   **Formatos Soportados**: Solo banners estáticos (JPG, PNG, GIF).
*   **Modelo de Entrega**: Asignación directa de anuncios (sin subastas o bidding).
*   **Pagos**: Gestión manual de la facturación y los pagos.
*   **Targeting**: Segmentación básica por sitio o categoría, sin geolocalización.
*   **Infraestructura**: Despliegue en un único servidor central.

### 7.2. Escalabilidad Futura

Una vez validado el MVP, el proyecto podrá crecer con nuevas funcionalidades:
*   **Sistema de Créditos**: Implementación de un sistema de saldo recargable para anunciantes.
*   **Nuevos Formatos**: Soporte para anuncios HTML5, video y formatos intersticiales.
*   **Targeting Avanzado**: Segmentación por geolocalización, dispositivo o comportamiento del usuario (retargeting).
*   **API Extendida**: Permitir la integración con aplicaciones móviles y otras plataformas.
*   **Reporting Mejorado**: Paneles de control con métricas en tiempo real y gráficos avanzados.
