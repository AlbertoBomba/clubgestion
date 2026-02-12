# Sistema de Logging de API

## Descripción

Sistema completo de logging para la API pública que registra todas las peticiones en base de datos.

## Características

- ✅ Registro automático de todas las peticiones a la API
- ✅ Logging asíncrono (no afecta al rendimiento)
- ✅ Panel de administración con filtros
- ✅ Estadísticas en tiempo real
- ✅ Información detallada de cada petición

## Información Registrada

Cada petición registra:

- **Escuela deportiva** (sports_school_id)
- **Endpoint** (/api/v1/public/matches, etc.)
- **Método HTTP** (GET, POST, etc.)
- **Código de estado** (200, 400, 403, 404, 500)
- **IP del cliente**
- **User Agent** (navegador/dispositivo)
- **Referer** (de dónde viene la petición)
- **Parámetros de la petición** (JSON)
- **Tiempo de respuesta** (en milisegundos)
- **Mensaje de error** (si aplica)
- **Fecha y hora**

## Acceso al Panel de Logs

**URL:** `/api-logs`

**Acceso:** Solo usuarios con rol **Master**

**Ruta en el navegador:**
```
https://tudominio.com/api-logs
```

## Filtros Disponibles

El panel permite filtrar por:

1. **Escuela deportiva** - Ver logs de una escuela específica
2. **Código de estado** - Filtrar por éxitos (200), errores (400, 403, 404, 500)
3. **Endpoint** - Ver peticiones a un endpoint específico
4. **Fecha desde** - Fecha inicial del rango
5. **Fecha hasta** - Fecha final del rango

## Estadísticas

El panel muestra 4 tarjetas con estadísticas:

- **Total hoy** - Peticiones del día actual
- **Errores hoy** - Peticiones fallidas del día actual
- **Total semana** - Peticiones de los últimos 7 días
- **Tiempo promedio** - Tiempo de respuesta promedio (ms)

## Detalles de las Peticiones

Cada fila de la tabla muestra:

- Fecha y hora
- Escuela (nombre)
- Endpoint completo
- Método HTTP (badge de color)
- Estado HTTP (badge de color según resultado)
- Dirección IP
- Tiempo de respuesta

Al hacer clic en una fila, se expanden los **detalles adicionales**:

- User Agent completo
- Referer
- Parámetros enviados (formato JSON)
- Mensaje de error (si hubo error)

## Códigos de Color

### Métodos HTTP
- 🔵 **GET** - Azul
- 🟢 **POST** - Verde
- 🔴 **DELETE** - Rojo

### Códigos de Estado
- 🟢 **2xx** - Verde (éxito)
- 🟡 **3xx** - Amarillo (redirección)
- 🟠 **4xx** - Naranja (error del cliente)
- 🔴 **5xx** - Rojo (error del servidor)

### Tiempos de Respuesta
- 🟢 **< 1000ms** - Verde (rápido)
- 🔴 **≥ 1000ms** - Rojo (lento)

## Limpieza de Logs Antiguos

El panel incluye un botón para **limpiar logs antiguos**.

Por defecto elimina logs de más de **90 días**.

**Proceso:**
1. Clic en "Limpiar logs antiguos"
2. Confirmar en el diálogo
3. Se eliminan registros antiguos
4. Se muestra mensaje con cantidad eliminada

También puedes limpiar manualmente desde consola:

```php
use App\Models\ApiLog;

// Eliminar logs de más de 30 días
$deleted = ApiLog::cleanup(30);
echo "Eliminados: $deleted registros";
```

## Uso Programático

### Registrar una petición manualmente

```php
use App\Models\ApiLog;

ApiLog::logRequest(
    endpoint: '/api/v1/public/matches',
    method: 'GET',
    statusCode: 200,
    ipAddress: request()->ip(),
    userAgent: request()->userAgent(),
    referer: request()->header('referer'),
    requestParams: request()->all(),
    responseTime: 150, // milisegundos
    sportsSchoolId: 1,
    errorMessage: null
);
```

### Obtener logs recientes

```php
use App\Models\ApiLog;

// Últimos 10 logs
$logs = ApiLog::getRecent(10);

// Últimos 10 logs de una escuela específica
$logs = ApiLog::getRecent(10, $sportsSchoolId = 1);
```

### Obtener estadísticas

```php
use App\Models\ApiLog;

// Estadísticas generales de los últimos 30 días
$stats = ApiLog::getStats();

// Estadísticas de una escuela específica
$stats = ApiLog::getStats($sportsSchoolId = 1, $days = 30);

/*
Array devuelto:
[
    'total_requests' => 1500,
    'successful_requests' => 1420,
    'failed_requests' => 80,
    'avg_response_time' => 245.5,
    'by_endpoint' => [
        '/api/v1/public/matches' => 800,
        '/api/v1/public/teams' => 700,
    ],
    'by_status' => [
        200 => 1420,
        403 => 50,
        404 => 30,
    ]
]
*/
```

## Logging Automático

El sistema registra **automáticamente** todas las peticiones a:

- `GET /api/v1/public/matches` - Lista de partidos
- `GET /api/v1/public/matches/teams` - Lista de equipos
- `GET /api/v1/public/matches/{id}` - Detalle de partido

**¿Qué se registra?**

- ✅ Peticiones exitosas (200)
- ✅ Errores de validación (400 - no se envió dominio)
- ✅ Errores de autorización (403 - dominio no autorizado)
- ✅ Errores de no encontrado (404 - escuela o partido no existe)
- ✅ Errores del servidor (500)

## Rendimiento

El logging es **asíncrono** mediante `dispatch()->afterResponse()`:

- ✅ No bloquea la respuesta de la API
- ✅ El registro se hace después de enviar la respuesta al cliente
- ✅ No afecta al tiempo de respuesta
- ✅ Incluye try-catch para evitar errores que afecten la API

## Tablas de Base de Datos

### Tabla: `api_logs`

```sql
CREATE TABLE `api_logs` (
    `id` bigint unsigned AUTO_INCREMENT PRIMARY KEY,
    `sports_school_id` bigint unsigned NULL,
    `endpoint` varchar(255) NOT NULL,
    `method` varchar(10) NOT NULL,
    `status_code` int NOT NULL,
    `ip_address` varchar(45) NULL,
    `user_agent` text NULL,
    `referer` text NULL,
    `request_params` json NULL,
    `response_time` int NULL COMMENT 'En milisegundos',
    `error_message` varchar(500) NULL,
    `created_at` timestamp NOT NULL,
    
    KEY `idx_sports_school_id` (`sports_school_id`),
    KEY `idx_created_at` (`created_at`),
    KEY `idx_status_code` (`status_code`),
    KEY `idx_endpoint` (`endpoint`),
    
    FOREIGN KEY (`sports_school_id`) 
        REFERENCES `sports_schools`(`id`) 
        ON DELETE CASCADE
);
```

## Archivos del Sistema

### Backend

- `database/migrations/2026_02_12_120000_create_api_logs_table.php` - Migración
- `app/Models/ApiLog.php` - Modelo Eloquent
- `app/Http/Controllers/Api/V1/PublicMatchController.php` - Controlador con logging
- `app/Livewire/ApiLogs/Index.php` - Componente Livewire

### Frontend

- `resources/views/livewire/api-logs/index.blade.php` - Vista del componente
- `resources/views/api-logs/index.blade.php` - Vista de la página

### Rutas

- `routes/web.php` - Ruta `/api-logs` (requiere rol Master)

## Mantenimiento

### Limpieza automática recomendada

Puedes crear un comando artisan para limpiar logs antiguos automáticamente:

```bash
php artisan make:command CleanApiLogs
```

Luego programa en el scheduler (app/Console/Kernel.php):

```php
protected function schedule(Schedule $schedule)
{
    // Limpiar logs de más de 90 días, cada domingo a las 2 AM
    $schedule->call(function () {
        ApiLog::cleanup(90);
    })->weekly()->sundays()->at('02:00');
}
```

### Monitoreo recomendado

1. **Revisar errores frecuentes** - Si hay muchos 403, revisar configuración de dominios
2. **Tiempos de respuesta** - Si aumentan, puede haber problemas de rendimiento
3. **Picos de tráfico** - Identificar horas punta
4. **Escuelas con más peticiones** - Ver cuáles son las más activas

## Troubleshooting

### No se están guardando logs

1. Verificar que la tabla `api_logs` existe:
```bash
php artisan migrate
```

2. Verificar que la base de datos está conectada:
```bash
php artisan tinker
DB::connection()->getPdo();
```

3. Verificar logs de Laravel:
```bash
tail -f storage/logs/laravel.log
```

### Los logs se guardan pero no aparecen en el panel

1. Limpiar cachés:
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

2. Verificar que tienes rol Master asignado

3. Verificar que la ruta está registrada:
```bash
php artisan route:list | findstr api-logs
```

### El panel es muy lento

Si tienes muchos registros (>100,000), considera:

1. Limpiar logs antiguos regularmente
2. Añadir más índices a la tabla si filtras por otros campos
3. Reducir el rango de fechas en los filtros
4. Aumentar la paginación (perPage)

## Seguridad

- ✅ Solo usuarios Master pueden ver los logs
- ✅ Las contraseñas/tokens NO se registran (evita enviarlos en query params)
- ✅ Los errores se registran pero no exponen información sensible
- ✅ Las IPs se almacenan para fines de auditoría

## Siguiente Pasos Recomendados

1. ☐ Añadir enlace en el menú de navegación principal
2. ☐ Configurar limpieza automática de logs antiguos
3. ☐ Crear alertas para errores frecuentes (opcional)
4. ☐ Exportar logs a CSV/Excel (opcional)
5. ☐ Añadir gráficas de estadísticas (opcional)

---

**Versión:** 1.0  
**Fecha:** Febrero 2026  
**Sistema:** Laravel 12.39.0 + Livewire 3.x
