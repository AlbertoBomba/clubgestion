# Sesiones de Entrenamiento - Documentación

## Descripción General
La funcionalidad de Sesiones de Entrenamiento permite a los entrenadores crear, gestionar y organizar sesiones de entrenamiento para sus equipos. Cada sesión puede incluir ejercicios de la biblioteca existente o ejercicios personalizados/libres.

## Características Principales

### 1. Gestión de Sesiones
- **Crear sesiones**: Los entrenadores pueden crear sesiones para los equipos que entrenan
- **Editar sesiones**: Modificar sesiones existentes, agregar o quitar ejercicios
- **Duplicar sesiones**: Copiar sesiones existentes para reutilizarlas
- **Eliminar sesiones**: Borrado suave de sesiones

### 2. Información de la Sesión
Cada sesión incluye:
- Título y descripción
- Equipo asignado
- Fecha y hora de inicio
- Duración en minutos
- Día de la semana
- Notas adicionales
- Estado (completada/pendiente)

### 3. Ejercicios
Dos tipos de ejercicios:
- **Ejercicios de biblioteca**: Selección desde la base de datos de ejercicios existentes
- **Ejercicios libres**: Creación de ejercicios personalizados directamente en la sesión

### 4. Búsqueda de Ejercicios
Sistema de búsqueda con filtros:
- Búsqueda por nombre
- Filtro por tipo de ejercicio
- Filtro por categoría
- Filtro por dificultad

### 5. Organización de Ejercicios
- Ordenamiento mediante botones arriba/abajo
- Edición de duración individual
- Notas personalizadas por ejercicio
- Visualización del orden numérico

### 6. Resumen Visual
- Contador de ejercicios totales
- Suma automática de duración total
- Indicadores visuales por tipo de ejercicio
- Estados y etiquetas de categorización

## Estructura de Base de Datos

### Tabla: training_sessions
```sql
- id
- team_id (FK -> teams)
- user_id (FK -> users) // Entrenador creador
- title
- description
- session_date
- start_time
- duration_minutes
- day_of_week
- is_completed
- notes
- timestamps
- soft_deletes
```

### Tabla: training_session_exercises
```sql
- id
- training_session_id (FK -> training_sessions)
- exercise_id (FK -> exercises, nullable)
- order // Orden en la sesión
- custom_title // Para ejercicios libres
- custom_description
- duration_minutes
- recommended_players
- notes
- timestamps
```

## Modelos

### TrainingSession
Relaciones:
- `belongsTo(Team::class)`
- `belongsTo(User::class)` // Creador
- `hasMany(TrainingSessionExercise::class)`

Atributos calculados:
- `total_exercises_duration`
- `exercises_count`

### TrainingSessionExercise
Relaciones:
- `belongsTo(TrainingSession::class)`
- `belongsTo(Exercise::class)` // Nullable

Métodos:
- `isCustom()`: Verifica si es un ejercicio personalizado
- `getTitleAttribute()`: Obtiene el título (custom o del ejercicio)
- `getDescriptionAttribute()`: Obtiene la descripción

## Componentes Livewire

### Index
**Ruta**: `/training-sessions`
**Funcionalidades**:
- Listado de sesiones con paginación
- Búsqueda por título/descripción
- Filtro por equipo
- Acciones: Editar, Duplicar, Eliminar
- Visualización de resumen (ejercicios, duración)

### Create
**Ruta**: `/training-sessions/create`
**Funcionalidades**:
- Formulario de información básica
- Buscador de ejercicios con filtros
- Formulario de ejercicio libre
- Gestión de lista de ejercicios (agregar, ordenar, eliminar)
- Resumen en tiempo real

### Edit
**Ruta**: `/training-sessions/{id}/edit`
**Funcionalidades**:
- Similar a Create pero con datos precargados
- Opción de marcar como completada
- Mantiene todas las funcionalidades de edición

## Permisos
Acceso permitido para roles:
- `master`
- `school_admin`
- `coach`

Los entrenadores solo pueden:
- Ver sesiones de sus equipos
- Editar/eliminar sesiones que ellos crearon

## Interfaz de Usuario

### Diseño Visual
- **Layout de 2 columnas**: Información de sesión (izquierda) y ejercicios (derecha)
- **Sticky sidebar**: El formulario principal permanece visible al hacer scroll
- **Tarjetas de ejercicios**: Diseño tipo card con información destacada
- **Indicadores de color**: Diferentes colores para tipos, categorías y dificultad
- **Iconografía clara**: SVG icons para cada acción y tipo de información

### Experiencia de Usuario
1. **Búsqueda intuitiva**: Panel desplegable con filtros múltiples
2. **Drag-like ordering**: Botones arriba/abajo para reordenar fácilmente
3. **Feedback visual**: Estados hover, colores de acción, badges
4. **Resumen en tiempo real**: Actualización automática de totales
5. **Confirmaciones**: Diálogos de confirmación para acciones destructivas

## Rutas

```php
Route::get('/training-sessions', Index::class)
    ->name('training-sessions.index');

Route::get('/training-sessions/create', Create::class)
    ->name('training-sessions.create');

Route::get('/training-sessions/{session}/edit', Edit::class)
    ->name('training-sessions.edit');
```

## Uso Típico

1. **Crear una sesión**:
   - Ir a "Sesiones de Entrenamiento"
   - Clic en "Nueva Sesión"
   - Completar información básica (equipo, título, fecha)
   - Buscar ejercicios existentes o crear ejercicios libres
   - Agregar ejercicios a la sesión
   - Ordenar ejercicios según preferencia
   - Ajustar duración y notas de cada ejercicio
   - Guardar sesión

2. **Duplicar una sesión**:
   - Desde el listado, clic en "Duplicar"
   - Se crea una copia con "(Copia)" en el título
   - Fecha automática al día siguiente
   - Redirige a edición para ajustes

3. **Preparar entrenamiento**:
   - Abrir sesión programada
   - Revisar ejercicios y orden
   - Verificar duración total
   - Marcar como completada al finalizar

## Mejoras Futuras Sugeridas
- Plantillas de sesiones reutilizables
- Exportación a PDF para imprimir
- Compartir sesiones entre entrenadores
- Estadísticas de ejercicios más utilizados
- Calendario mensual de sesiones
- Asistencia de jugadores por sesión
- Feedback y evaluación post-sesión
- Integración con aplicación móvil

## Archivos Creados/Modificados

### Nuevos Archivos
- `database/migrations/2025_12_15_000001_create_training_sessions_table.php`
- `database/migrations/2025_12_15_000002_create_training_session_exercises_table.php`
- `app/Models/TrainingSession.php`
- `app/Models/TrainingSessionExercise.php`
- `app/Livewire/TrainingSessions/Index.php`
- `app/Livewire/TrainingSessions/Create.php`
- `app/Livewire/TrainingSessions/Edit.php`
- `resources/views/livewire/training-sessions/index.blade.php`
- `resources/views/livewire/training-sessions/create.blade.php`
- `resources/views/livewire/training-sessions/edit.blade.php`

### Archivos Modificados
- `routes/web.php` - Agregadas rutas para training-sessions
- `app/Models/Team.php` - Agregada relación trainingSessions()
- `app/Models/Exercise.php` - Agregada relación trainingSessionExercises()
- `resources/views/navigation-menu.blade.php` - Agregado enlace en menú

## Mantenimiento

### Verificar Migraciones
```bash
php artisan migrate:status
```

### Rollback (si es necesario)
```bash
php artisan migrate:rollback --step=2
```

### Cache de Rutas
```bash
php artisan route:cache
```

### Limpiar Vistas
```bash
php artisan view:clear
```
