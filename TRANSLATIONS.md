# Sistema de Traducciones - Tudex Promote

## 📋 Resumen de Implementación

Se ha implementado exitosamente el sistema de traducciones de Laravel para soportar **Inglés** y **Español**.

## 🗂️ Estructura de Archivos

### Archivos de Traducción
- `resources/lang/en/messages.php` - Traducciones en inglés
- `resources/lang/es/messages.php` - Traducciones en español

### Middleware
- `app/Http/Middleware/LocaleMiddleware.php` - Maneja el cambio de idioma basado en la sesión

### Configuración
- `bootstrap/app.php` - Middleware registrado en el grupo web
- `routes/web.php` - Ruta `/locale-switch` para cambiar el idioma

## 🎯 Cómo Usar

### Para Usuarios
1. **Cambiar el idioma**: Usa el selector de idioma en la esquina superior derecha del header
2. El idioma seleccionado se guarda en la sesión y persiste durante toda la navegación

### Para Desarrolladores

#### Agregar nuevas traducciones
1. Abre los archivos de traducción:
   - `resources/lang/en/messages.php` (inglés)
   - `resources/lang/es/messages.php` (español)

2. Agrega la nueva clave y su traducción:
```php
// En resources/lang/en/messages.php
'my_new_key' => 'My new text in English',

// En resources/lang/es/messages.php
'my_new_key' => 'Mi nuevo texto en español',
```

#### Usar traducciones en las vistas Blade
```blade
<!-- Método 1: Función helper -->
{{ __('messages.my_new_key') }}

<!-- Método 2: Directiva Blade -->
@lang('messages.my_new_key')
```

#### Usar traducciones en controladores
```php
$message = __('messages.my_new_key');
```

## 🌍 Idiomas Soportados

| Código | Idioma   | Estado      |
|--------|----------|-------------|
| `en`   | English  | ✅ Completo |
| `es`   | Español  | ✅ Completo |

## 📝 Traducciones Disponibles

### Navegación
- `dashboard`, `profile`, `sign_out`, `account`
- `publisher_console`, `advertiser_console`
- `my_sites`, `ad_zones`, `campaigns`, `creatives`

### Sitios
- `add_a_new_site`, `domain`, `add_site`
- `verified_until`, `verification_expired`, `not_verified`
- `stats`, `show_ad_code`, `show_instructions`, `verify_now`
- `ad_code_installation`, `follow_these_steps`
- `step_1_add_ad_tag`, `step_2_place_ad_code`
- Opciones de tamaño de anuncios (wide, tall, square)
- Instrucciones de verificación (DNS TXT, ads.txt)

### Campañas
- `add_new_campaign`, `campaign_name`, `budget`
- `payment_model`, `cpc`, `cpm`
- `start_date`, `end_date`, `create_campaign`
- `ad_appearance`, `title_color`, `description_color`, `accent_color`, `font_family`

### Creativos
- `add_new_creative`, `creative_title`, `creative_description`
- `creative_image`, `creative_url`

### Perfil
- `update_password`, `current_password`, `new_password`, `confirm_password`
- `ensure_password_security`

### General
- `save`, `saved`, `cancel`, `delete`, `edit`, `create`, `update`
- `search`, `filter`, `actions`, `status`
- `active`, `inactive`, `yes`, `no`
- `error`, `success`, `notification`, `notifications`

## 🔧 Comandos Útiles

```bash
# Limpiar cache de configuración
php artisan config:clear

# Limpiar cache de aplicación
php artisan cache:clear

# Limpiar cache de vistas
php artisan view:clear

# Limpiar todos los caches
php artisan optimize:clear
```

## 🚀 Próximos Pasos (Opcional)

1. **Agregar más idiomas**: Crea nuevos directorios en `resources/lang/` (ej: `fr`, `pt`, `de`)
2. **Detección automática**: Implementar detección del idioma del navegador
3. **Traducciones de validación**: Crear archivos `validation.php` para mensajes de error
4. **Traducciones de autenticación**: Crear archivos `auth.php` y `passwords.php`

## 📌 Notas Importantes

- El idioma por defecto es **inglés** (`en`)
- El idioma se guarda en la **sesión del usuario**
- Si una clave no existe en el idioma actual, Laravel usa el idioma de respaldo (fallback)
- Todas las vistas principales ya están traducidas
- El selector de idioma está en el header de todas las páginas autenticadas

## 🐛 Solución de Problemas

### Las traducciones no aparecen
1. Verifica que los archivos de traducción existen en `resources/lang/{locale}/messages.php`
2. Limpia el cache: `php artisan optimize:clear`
3. Verifica que la clave existe en ambos archivos de idioma

### El idioma no cambia
1. Verifica que la sesión está funcionando correctamente
2. Revisa que el middleware `LocaleMiddleware` está registrado
3. Comprueba que la ruta `locale.switch` existe

### Errores de sintaxis
1. Verifica que todos los archivos PHP tienen la sintaxis correcta
2. Asegúrate de escapar comillas simples con `\'` dentro de las cadenas
