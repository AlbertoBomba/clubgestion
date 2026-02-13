# 🚀 Guía Rápida de Implementación Multi-Tenant

## ✅ ¿Qué se ha implementado?

Se ha creado un sistema **Domain-Based Multi-Tenancy** que permite:

1. **Cada escuela tiene su propio dominio/subdominio**
   - `madrid.vaed.es` → Escuela de Madrid
   - `www.clubdeportivo.com` → Club con dominio propio
   - `vaed.es` → Panel Master

2. **Detección automática del tenant por dominio**
3. **Filtrado automático de datos por escuela**
4. **Home y vistas personalizadas por escuela**
5. **Plantillas compartidas para todas las escuelas**

---

## 🎯 Pasos para Activar el Sistema

### 1. Limpiar caché y optimizar

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan optimize
```

### 2. Añadir el Trait a tus modelos

**Modelos que DEBEN usar el trait:**

#### Player.php
```php
use App\Models\Traits\BelongsToTenant;

class Player extends Model
{
    use BelongsToTenant;
    // ... resto del código
}
```

#### Team.php
```php
use App\Models\Traits\BelongsToTenant;

class Team extends Model
{
    use BelongsToTenant;
    // ... resto del código
}
```

#### Training.php
```php
use App\Models\Traits\BelongsToTenant;

class Training extends Model
{
    use BelongsToTenant;
    // ... resto del código
}
```

**Lista completa de modelos:**
- ✅ Player
- ✅ Team
- ✅ Category
- ✅ Exercise
- ✅ TrainingSession
- ✅ Training
- ✅ TrainingField
- ✅ Season
- ✅ SeasonMatch
- ✅ PaymentTeam
- ✅ PaymentPlayer
- ✅ InscriptionTeam
- ✅ Product
- ✅ ProductStock

### 3. Configurar dominios en la base de datos

```sql
-- Para subdominios
UPDATE sports_schools 
SET domain = 'madrid.vaed.es', slug = 'madrid' 
WHERE id = 1;

UPDATE sports_schools 
SET domain = 'barcelona.vaed.es', slug = 'barcelona' 
WHERE id = 2;

-- Para dominios propios
UPDATE sports_schools 
SET domain = 'www.clubdeportivo.com', slug = 'club-deportivo' 
WHERE id = 3;
```

### 4. Configurar hosts locales (solo para desarrollo)

**Windows:** Edita `C:\Windows\System32\drivers\etc\hosts`

```
127.0.0.1 madrid.vaed.es
127.0.0.1 barcelona.vaed.es
127.0.0.1 vaed.es
```

**Mac/Linux:** Edita `/etc/hosts`

```
127.0.0.1 madrid.vaed.es
127.0.0.1 barcelona.vaed.es
127.0.0.1 vaed.es
```

### 5. Probar el sistema

```bash
# Iniciar servidor
php artisan serve --host=0.0.0.0

# Visitar:
# http://madrid.vaed.es:8000 → Home de Madrid
# http://barcelona.vaed.es:8000 → Home de Barcelona
# http://vaed.es:8000 → Home Master
```

---

## 🔧 Uso en el Código

### En Controladores

```php
// Obtener datos del tenant actual
$school = currentSchool();
$schoolId = currentSchoolId();
$schoolName = tenantName();

// Todos los queries se filtran automáticamente
$players = Player::all(); // Solo de la escuela actual

// Ver todas las escuelas (solo master)
$allPlayers = Player::withoutTenant()->get();

// Ver de una escuela específica
$madridPlayers = Player::forSchool(1)->get();
```

### En Vistas Blade

```blade
{{-- Logo personalizado --}}
<img src="{{ tenantLogo() }}" alt="{{ tenantName() }}">

{{-- Nombre --}}
<h1>{{ tenantName() }}</h1>

{{-- Datos de contacto --}}
@if($school = currentSchool())
    <p>{{ $school->email }}</p>
    <p>{{ $school->phone }}</p>
@endif

{{-- Verificar contexto --}}
@if(isTenantContext())
    <p>Vista de la escuela</p>
@else
    <p>Panel Master</p>
@endif
```

### Estructura de Vistas Web Pública

Las vistas de las webs públicas de los clubes están en:
```
resources/views/webclubs/
├── layouts/
│   └── app.blade.php          # Layout compartido
├── home.blade.php             # Home del club
├── about.blade.php            # Sobre nosotros
├── contact.blade.php          # Contacto
└── registration.blade.php     # Inscripción de jugadores
```

### En Livewire

```php
public function render()
{
    // Automáticamente filtra por tenant
    $players = Player::paginate(10);
    
    return view('livewire.players.index', [
        'players' => $players,
    ]);
}

public function create()
{
    // sports_school_id se asigna automáticamente
    Player::create([
        'name' => $this->name,
        // No necesitas añadir sports_school_id
    ]);
}
```

---

## 🌐 Configuración en Producción

### DNS

Para subdominios:
```
Registro A: *.vaed.es → IP_DEL_SERVIDOR
```

Para dominios propios (el cliente lo configura):
```
Registro A: clubdeportivo.com → IP_DEL_SERVIDOR
Registro CNAME: www.clubdeportivo.com → clubdeportivo.com
```

### Nginx

```nginx
server {
    listen 80;
    server_name vaed.es *.vaed.es;
    
    root /var/www/SVAclubsportal/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        include fastcgi_params;
    }
}
```

---

## 🧪 Testing Rápido

```bash
# Test 1: Crear jugador en contexto de tenant
php artisan tinker

$school = App\Models\SportsSchool::first();
tenantService()->setCurrentSchool($school);
$player = App\Models\Player::create(['name' => 'Test Player', 'email' => 'test@test.com']);
echo $player->sports_school_id; // Debe mostrar el ID de la escuela

# Test 2: Verificar filtrado
tenantService()->setCurrentSchool($school);
$count1 = App\Models\Player::count();
tenantService()->clearCurrentSchool();
$count2 = App\Models\Player::withoutTenant()->count();
echo "Con tenant: $count1, Sin tenant: $count2";
```

---

## 📋 Checklist Final

- [ ] Ejecutar `php artisan config:clear`
- [ ] Añadir `use BelongsToTenant;` a todos los modelos necesarios
- [ ] Configurar dominios en tabla `sports_schools`
- [ ] Configurar DNS (o hosts para desarrollo)
- [ ] Probar acceso a subdominios
- [ ] Verificar que datos se filtran correctamente
- [ ] Personalizar vistas en webclubs/ según necesidades
- [ ] Testing completo

---

## ⚠️ Importante

- ❌ **NO** uses `BelongsToTenant` en:
  - User (tiene lógica especial)
  - SportsSchool (es el tenant)
  - Brand, Size, Section (son globales)

- ✅ **SÍ** usa `BelongsToTenant` en:
  - Cualquier modelo que tenga `sports_school_id`
  - Modelos que deben filtrarse por escuela

---

## 🆘 Problemas Comunes

**Error: "Call to undefined function tenantService()"**
- Ejecuta: `composer dump-autoload`

**No detecta el tenant**
- Verifica que el dominio esté en la BD
- Verifica que `is_active = 1`
- Revisa logs: `tail -f storage/logs/laravel.log`

**Ve datos de otras escuelas**
- Verifica que el modelo use `BelongsToTenant`
- Verifica que no uses `withoutTenant()`

---

## 📞 Soporte

Para más detalles consulta: `MULTI_TENANT_IMPLEMENTATION.md`

**¡Todo listo para usar! 🎉**
