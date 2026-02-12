# 🚀 Despliegue de API Pública en Producción

## Error 404 en vaed.es/api/v1/public/matches

Si recibes un error 404, sigue estos pasos:

## Paso 1: Verificar que el código está desplegado

Asegúrate de que estos archivos existen en el servidor:

```bash
# Conéctate al servidor por SSH
ssh usuario@vaed.es

# Ve al directorio del proyecto
cd /ruta/a/tu/proyecto

# Verifica que los archivos existen
ls -la app/Http/Controllers/Api/V1/PublicMatchController.php
ls -la app/Http/Middleware/ValidatePublicApiCors.php
ls -la routes/api.php
```

## Paso 2: Ejecutar script de verificación

Sube el archivo `api-check.php` a tu servidor y accede desde el navegador:

```
https://vaed.es/api-check.php
```

Este script te dirá exactamente qué falta o está mal configurado.

**IMPORTANTE:** Elimina el archivo después de usarlo:
```bash
rm public/api-check.php
```

## Paso 3: Limpiar cachés

Ejecuta estos comandos en el servidor:

```bash
cd /ruta/a/tu/proyecto

# Limpiar cachés
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# Cachear para producción (opcional pero recomendado)
php artisan config:cache
php artisan route:cache
```

## Paso 4: Verificar rutas

```bash
php artisan route:list --path=api/v1/public
```

Deberías ver:
```
GET|HEAD  api/v1/public/matches ... PublicMatchController@index
GET|HEAD  api/v1/public/teams ... PublicMatchController@teams
```

## Paso 5: Verificar permisos

```bash
# Dar permisos correctos
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# O el usuario de tu servidor web
chown -R tu-usuario:tu-usuario storage bootstrap/cache
```

## Paso 6: Configurar dominio en la base de datos

Accede a tu panel de administración en vaed.es y:

1. Ve a la gestión de escuelas deportivas
2. Edita "CD Puebla" (o la escuela correspondiente)
3. En el campo **domain** pon: `cdpuebla.es`
4. Guarda

O por línea de comandos:

```bash
php artisan tinker

# Dentro de tinker:
$school = App\Models\SportsSchool::where('name', 'LIKE', '%Puebla%')->first();
$school->domain = 'cdpuebla.es';
$school->save();
exit
```

## Paso 7: Probar la API

```bash
# Desde línea de comandos
curl "https://vaed.es/api/v1/public/matches?domain=cdpuebla.es&limit=5"

# O desde el navegador
https://vaed.es/api/v1/public/matches?domain=cdpuebla.es&limit=5
```

Deberías recibir un JSON con:
- `{"success": true, "data": [...]}` si hay partidos
- `{"success": false, "message": "Sports school not found..."}` si no existe el dominio

## Paso 8: Configuración Apache/Nginx

### Si usas Apache

Verifica que `mod_rewrite` está habilitado:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Si usas Nginx

Tu configuración debe incluir:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location /api {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## 🐛 Debugging

Si sigue sin funcionar, revisa los logs:

```bash
# Logs de Laravel
tail -f storage/logs/laravel.log

# Logs de Apache
tail -f /var/log/apache2/error.log

# Logs de Nginx
tail -f /var/log/nginx/error.log
```

## 📞 Checklist Final

- [ ] Código desplegado en producción
- [ ] Cachés limpiados
- [ ] Rutas visibles con `route:list`
- [ ] Permisos correctos en storage
- [ ] Dominio configurado en sports_schools
- [ ] Partidos publicados (published=true)
- [ ] CORS funcionando (sin errores en consola)
- [ ] Widget cargándose correctamente

## 🎯 Integración en cdpuebla.es

Una vez que la API funcione, en cdpuebla.es añade:

```html
<script>
    window.CLUB_PORTAL_API_URL = 'https://vaed.es';
</script>
<div id="club-matches"></div>
<script src="https://vaed.es/widget/matches.js"></script>
```
