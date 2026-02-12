#!/bin/bash

# Script para desplegar y verificar la API en producción
# Ejecutar este script en el servidor de producción

echo "================================"
echo "Deployment Script - API Pública"
echo "================================"
echo ""

# 1. Limpiar cachés de Laravel
echo "1. Limpiando cachés..."
php artisan config:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear

# 2. Cache de configuración optimizada (para producción)
echo ""
echo "2. Optimizando configuración para producción..."
php artisan config:cache
php artisan route:cache

# 3. Verificar que las rutas API existen
echo ""
echo "3. Verificando rutas API..."
php artisan route:list --path=api/v1/public

# 4. Verificar permisos
echo ""
echo "4. Verificando permisos..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 5. Verificar middlewares
echo ""
echo "5. Verificando middleware CORS..."
if [ -f "app/Http/Middleware/ValidatePublicApiCors.php" ]; then
    echo "✓ Middleware CORS existe"
else
    echo "✗ ERROR: Middleware CORS no encontrado"
fi

echo ""
echo "================================"
echo "Deployment completado"
echo "================================"
echo ""
echo "Ahora prueba la API en:"
echo "https://vaed.es/api/v1/public/matches?domain=cdpuebla.es&limit=5"
