# 🔄 Migración del Trait Antiguo al Nuevo

## 📊 Comparación

### ❌ Trait Anterior: `BelongsToSportsSchool`
```php
// Basado en usuario autenticado
static::addGlobalScope('sports_school', function (Builder $builder) {
    if (auth()->check() && auth()->user()->sports_school_id) {
        $builder->where(..., auth()->user()->sports_school_id);
    }
});
```

**Limitaciones:**
- ❌ Solo funciona con usuarios autenticados
- ❌ No funciona para páginas públicas
- ❌ No detecta por dominio
- ❌ No auto-asigna `sports_school_id` al crear
- ❌ No hay servicio centralizado

### ✅ Trait Nuevo: `BelongsToTenant`
```php
// Basado en dominio + TenantService
static::addGlobalScope(new TenantScope());
```

**Ventajas:**
- ✅ Funciona con y sin autenticación
- ✅ Detecta automáticamente por dominio/subdominio
- ✅ Auto-asigna `sports_school_id` al crear
- ✅ Servicio centralizado (`TenantService`)
- ✅ Mejor para multi-tenant real

---

## 🚀 Cómo Migrar

### Opción 1: Reemplazar el Trait (Recomendado)

**ANTES:**
```php
<?php

namespace App\Models;

use App\Models\Traits\BelongsToSportsSchool;

class Player extends Model
{
    use BelongsToSportsSchool;
    
    // ...
}
```

**DESPUÉS:**
```php
<?php

namespace App\Models;

use App\Models\Traits\BelongsToTenant;

class Player extends Model
{
    use BelongsToTenant;
    
    // ...
}
```

### Opción 2: Mantener Compatibilidad

Si quieres mantener ambos sistemas durante la transición:

```php
<?php

namespace App\Models;

use App\Models\Traits\BelongsToSportsSchool;
use App\Models\Traits\BelongsToTenant;

class Player extends Model
{
    // Usar el nuevo basado en dominio
    use BelongsToTenant;
    
    // O comentar temporalmente el antiguo
    // use BelongsToSportsSchool;
    
    // ...
}
```

---

## 🔧 Actualización de Código

### Scopes

**Antes:**
```php
// Quitar scope de escuela
Player::withoutSchoolScope()->get();

// Filtrar por escuela
Player::forSchool($schoolId)->get();
```

**Después:**
```php
// Quitar scope de tenant
Player::withoutTenant()->get();

// Filtrar por escuela
Player::forSchool($schoolId)->get();

// Nueva funcionalidad
Player::allTenants()->get();
```

### En Controladores

**Antes (basado en usuario):**
```php
// Dependía del usuario autenticado
$players = Player::all(); // Filtraba por auth()->user()->sports_school_id
```

**Después (basado en dominio):**
```php
// Depende del dominio visitado
$players = Player::all(); // Filtra por currentSchool()

// Funciona incluso sin autenticación
// Ejemplo: página pública de inscripción
```

### Crear Registros

**Antes:**
```php
Player::create([
    'name' => 'Juan',
    'sports_school_id' => auth()->user()->sports_school_id, // Manual
]);
```

**Después:**
```php
Player::create([
    'name' => 'Juan',
    // sports_school_id se asigna automáticamente
]);
```

---

## 🧪 Testing de Migración

### Test 1: Verificar Filtrado por Dominio

```php
// En tinker o test
php artisan tinker

// Simular dominio
$school = App\Models\SportsSchool::where('domain', 'madrid.vaed.es')->first();
tenantService()->setCurrentSchool($school);

// Crear jugador
$player = App\Models\Player::create([
    'name' => 'Test Player',
    'email' => 'test@test.com',
]);

// Verificar que se asignó correctamente
echo $player->sports_school_id; // Debe ser el ID de madrid
```

### Test 2: Verificar Filtrado en Queries

```php
// Establecer escuela
$madrid = App\Models\SportsSchool::find(1);
tenantService()->setCurrentSchool($madrid);

$players = App\Models\Player::all();
echo $players->count(); // Solo jugadores de Madrid

// Sin tenant
$allPlayers = App\Models\Player::withoutTenant()->get();
echo $allPlayers->count(); // Todos los jugadores
```

### Test 3: Páginas Públicas (sin auth)

```bash
# Visitar sin estar autenticado
curl -H "Host: madrid.vaed.es" http://localhost:8000

# Debe mostrar home de Madrid, no error
```

---

## 📋 Checklist de Migración

### Preparación
- [ ] Backup de base de datos
- [ ] Commit de código actual
- [ ] Leer documentación completa

### Migración de Modelos
- [ ] Player: Cambiar a `BelongsToTenant`
- [ ] Team: Cambiar a `BelongsToTenant`
- [ ] Training: Cambiar a `BelongsToTenant`
- [ ] Exercise: Cambiar a `BelongsToTenant`
- [ ] TrainingSession: Cambiar a `BelongsToTenant`
- [ ] Season: Cambiar a `BelongsToTenant`
- [ ] Category: Cambiar a `BelongsToTenant`
- [ ] PaymentTeam: Cambiar a `BelongsToTenant`
- [ ] PaymentPlayer: Cambiar a `BelongsToTenant`
- [ ] InscriptionTeam: Cambiar a `BelongsToTenant`
- [ ] TrainingField: Cambiar a `BelongsToTenant`
- [ ] Product: Cambiar a `BelongsToTenant`
- [ ] ProductStock: Cambiar a `BelongsToTenant`

### Testing
- [ ] Ejecutar `php artisan config:clear`
- [ ] Ejecutar `composer dump-autoload`
- [ ] Probar login con diferentes usuarios
- [ ] Probar acceso por diferentes dominios
- [ ] Verificar creación de registros
- [ ] Verificar filtrado de datos
- [ ] Probar páginas públicas (sin auth)

### Actualización de Código
- [ ] Buscar `withoutSchoolScope()` → Cambiar a `withoutTenant()`
- [ ] Buscar asignaciones manuales de `sports_school_id`
- [ ] Actualizar controladores si es necesario
- [ ] Actualizar componentes Livewire si es necesario

---

## 🔍 Buscar y Reemplazar

### En VSCode

**Buscar:** `use App\\Models\\Traits\\BelongsToSportsSchool;`
**Reemplazar:** `use App\\Models\\Traits\\BelongsToTenant;`

**Buscar:** `use BelongsToSportsSchool;`
**Reemplazar:** `use BelongsToTenant;`

**Buscar:** `withoutSchoolScope()`
**Reemplazar:** `withoutTenant()`

**Buscar (regex):** `'sports_school_id' => auth\(\)->user\(\)->sports_school_id,?`
**Reemplazar:** (eliminar línea completa)

---

## ⚠️ Casos Especiales

### Usuario Master

**Antes:**
```php
// Master veía todo porque no tenía sports_school_id
if (!auth()->user()->sports_school_id) {
    $players = Player::withoutSchoolScope()->get();
}
```

**Después:**
```php
// Master necesita indicar explícitamente
if (auth()->user()->hasRole('master')) {
    $players = Player::withoutTenant()->get();
    // O ver una escuela específica
    $players = Player::forSchool($schoolId)->get();
}
```

### Middleware EnsureSchoolUser

**Actualizar:**

```php
public function handle(Request $request, Closure $next): Response
{
    // Master siempre tiene acceso
    if (auth()->user()->hasRole('master')) {
        return $next($request);
    }

    // Nuevo: Verificar tenant
    if (!tenantService()->userHasAccess(auth()->user())) {
        abort(403, 'No tienes acceso a esta escuela');
    }

    return $next($request);
}
```

---

## 🎯 Ventajas Post-Migración

1. **Páginas Públicas**: Funcionan sin autenticación
   ```php
   // Registro público de jugadores
   Route::post('/registro', function() {
       Player::create($data); // Funciona sin auth!
   });
   ```

2. **Multi-dominio Real**: Cada escuela en su dominio
   ```
   madrid.vaed.es → Datos de Madrid
   barcelona.vaed.es → Datos de Barcelona
   ```

3. **APIs Públicas**: Mejor para integraciones
   ```php
   // API pública de convocatorias
   Route::get('/api/matches', function() {
       return Match::all(); // Filtrado por tenant del dominio
   });
   ```

4. **Testing Más Fácil**:
   ```php
   tenantService()->setCurrentSchool($school);
   // Todo el código de test usa ese tenant
   ```

---

## 📞 Soporte

Si encuentras problemas durante la migración:

1. Revisa logs: `storage/logs/laravel.log`
2. Verifica configuración: `php artisan config:show`
3. Consulta documentación: `MULTI_TENANT_IMPLEMENTATION.md`

**¡Migración exitosa! 🎉**
