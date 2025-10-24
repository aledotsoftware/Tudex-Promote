# Documento técnico: Red publicitaria centralizada (Ad Server) con Laravel

## 1. **Objetivo general**

Construir una red publicitaria centralizada que:

* Permita a **anunciantes** crear campañas y cargar creativos.
* Permita a **sitios asociados (publishers)** ofrecer y vender espacios publicitarios.
* Sirva anuncios mediante un **script JavaScript** estándar (`tag.js`) gestionado desde tu dominio.
* Verifique la **propiedad de los sitios** mediante DNS o archivo `ads.txt`.

---

## 2. **Stack tecnológico**

| Componente    | Tecnología                                                       |
| ------------- | ---------------------------------------------------------------- |
| Backend       | Laravel 11                                                       |
| Frontend      | Blade + Bootstrap 5                                              |
| Base de datos | MySQL (MariaDB en Hostinger)                                     |
| CDN / Proxy   | Cloudflare                                                       |
| Tracking      | Jobs + Logs en MySQL                                             |
| Autenticación | Laravel Breeze o Jetstream (roles: Admin, Publisher, Advertiser) |
| API pública   | Laravel Sanctum (para tag.js y tracking)                         |

---

## 3. **Módulos funcionales**

### 3.1. Panel de administración (tu cuenta principal)

* Crear, editar y suspender **sitios**, **campañas** y **usuarios**.
* Revisar estadísticas globales.
* Moderar anuncios.
* Generar reportes de rendimiento (impresiones, clics, CTR, ingresos).
* Controlar los precios base por CPC, CPM o fijo.

---

### 3.2. Panel de publisher (sitios asociados)

* Registrar nuevos sitios web.
* Verificar propiedad del dominio (2 métodos):

  * **DNS TXT record**: Ej. `adverify.tured.com  IN  TXT  "pub-12345"`
  * **Archivo ads.txt** con una línea específica:

    ```
    tu-dominio.com, pub-12345, DIRECT
    ```
* Definir zonas publicitarias (slots): tamaño, tipo, posición.
* Obtener código `tag.js` para cada zona.
* Ver estadísticas de impresiones y clics por zona.
* Recibir informes de ganancias estimadas (sin automatizar pagos al inicio).

---

### 3.3. Panel de anunciante

* Crear y administrar campañas publicitarias.
* Subir creativos (imágenes, HTML, links).
* Seleccionar sitios o categorías donde mostrar sus anuncios.
* Configurar presupuesto diario, fechas, y modelo (CPC o CPM).
* Ver estadísticas de rendimiento.
* (Etapa 2) Sistema de crédito recargable manual o automático.

---

### 3.4. Servidor de anuncios (ad server)

* Endpoint `GET /api/serve?site=xxx&slot=yyy` → devuelve JSON con URL del creative.
* Endpoint `GET /redirect/:id` → registra clic y redirige al destino.
* Endpoint `POST /api/impression` → registra impresión.
* Script `tag.js` carga asíncrono y muestra los anuncios en iframe sandbox.
* Cacheo de campañas activas por sitio en Redis o MySQL para baja latencia.

---

### 3.5. Sistema de verificación de dominio

**Proceso:**

1. Publisher registra su dominio.
2. Se genera un token único.
3. Debe agregar un registro DNS o subir un archivo `ads.txt` con su token.
4. Laravel corre una verificación (con `dns_get_record()` o `Http::get()`) y marca el dominio como **verificado**.

---

### 3.6. Tracking

* Impresiones y clics registrados vía AJAX o `fetch()` en el iframe.
* Tabla `ad_impressions` y `ad_clicks`.
* Identificador de impresión único (`imp_id`).
* Reporte diario por sitio y por campaña.
* Paneles resumen con gráficas simples (Chart.js).

---

## 4. **Modelo de datos base (simplificado)**

* `users` (id, name, email, role)
* `sites` (id, user_id, domain, verified, verification_token)
* `ad_zones` (id, site_id, name, width, height, type)
* `campaigns` (id, advertiser_id, budget, start_at, end_at, model, status)
* `creatives` (id, campaign_id, file_url, click_url, width, height)
* `placements` (id, creative_id, site_id, zone_id)
* `ad_impressions` (id, creative_id, site_id, zone_id, timestamp, ip_hash)
* `ad_clicks` (id, creative_id, site_id, zone_id, imp_id, timestamp)

---

## 5. **Seguridad**

* Anuncios solo en iframe con `sandbox="allow-scripts allow-popups allow-same-origin"`.
* CORS restringido a dominios verificados.
* Validación MIME y tamaño de archivos.
* CSRF protegido por Laravel nativo.
* Logs y rate limiting por IP.
* HTTPS obligatorio (Cloudflare).

---

## 6. **Límites iniciales (MVP)**

* Solo banners estáticos (JPG/PNG/GIF).
* Sin bidding o subastas.
* Sin automatizar pagos (liquidación manual).
* Sin targeting geográfico (solo por dominio o categoría).
* Un único servidor central (sin balanceo).

---

## 7. **Escalabilidad futura**

* Redis para cachear campañas.
* Sistema de créditos y pago automático.
* Soporte de anuncios HTML5 y videos.
* Geotargeting y retargeting.
* API para integrar apps móviles o terceros.
* Panel de reporting avanzado con métricas por hora.
