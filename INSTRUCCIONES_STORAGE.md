# Configuración de Storage para Imágenes

## Problema
Las imágenes de los logos de las escuelas no se muestran en el navegador.

## Solución

### 1. Crear el enlace simbólico en el servidor

Conéctate al servidor y ejecuta:

```bash
cd /var/www/sites/clubsportal
php artisan storage:link
```

Este comando creará un enlace simbólico desde `public/storage` hacia `storage/app/public`, permitiendo que las imágenes sean accesibles desde el navegador.

### 2. Verificar permisos

Asegúrate de que los permisos sean correctos:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache
```

### 3. Verificar la configuración de .env

Asegúrate de que en tu archivo `.env` tengas:

```
APP_URL=http://tu-dominio.com
```

O la URL correcta de tu aplicación.

### 4. Verificar que el enlace simbólico funciona

Después de ejecutar `php artisan storage:link`, verifica que exista:

```bash
ls -la public/storage
```

Deberías ver que `public/storage` es un enlace simbólico que apunta a `../storage/app/public`

### 5. Estructura de archivos

Las imágenes se guardan en:
```
/var/www/sites/clubsportal/storage/app/public/schools/logos/nombre-archivo.jpg
```

Y son accesibles en:
```
http://tu-dominio.com/storage/schools/logos/nombre-archivo.jpg
```

## Cambios realizados en el código

He actualizado todas las referencias de `Storage::url()` a `asset('storage/' . $path)` en:

- `resources/views/livewire/sports-schools/index.blade.php`
- `resources/views/livewire/sports-schools/edit.blade.php`
- `resources/views/navigation-menu.blade.php`
- `resources/views/dashboard.blade.php`

Esto asegura que las URLs de las imágenes se generen correctamente.
