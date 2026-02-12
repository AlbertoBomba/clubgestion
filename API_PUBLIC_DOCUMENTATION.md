# API Pública de Partidos - Documentación

## Descripción General

Esta API permite a las escuelas deportivas mostrar sus partidos en sus propias webs externas. La API identifica automáticamente la escuela por el dominio desde donde se realiza la petición.

---

## 🔐 Seguridad

- **Rate Limiting**: 60 peticiones por minuto por IP
- **CORS**: Solo dominios registrados en la base de datos
- **Validación de Referer**: Verifica que la petición viene del dominio correcto
- **Solo datos públicos**: Solo se devuelven partidos marcados como `published=true`

---

## 📡 Endpoints Disponibles

### 1. Obtener Partidos

**Endpoint**: `GET /api/v1/public/matches`

**Parámetros**:
- `domain` (opcional): Dominio de la escuela. Si no se proporciona, se detecta del referer
- `limit` (opcional): Número máximo de partidos a devolver (1-100, default: 10)
- `team_id` (opcional): Filtrar por ID de equipo específico
- `upcoming` (opcional): `true` para solo partidos futuros
- `past` (opcional): `true` para solo partidos pasados

**Ejemplo de petición**:
```javascript
fetch('https://tu-portal.com/api/v1/public/matches?domain=cdpuebla.es&limit=5')
  .then(response => response.json())
  .then(data => console.log(data));
```

**Respuesta exitosa**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "date": "2026-02-15",
      "hour_match": "10:00",
      "hour_meeting": "09:30",
      "opponent": "Real Madrid CF",
      "site": "Estadio Municipal",
      "sites": "home",
      "goals_team": 2,
      "goals_oponent": 1,
      "escudo_team_oponent": "https://tu-portal.com/storage/escudos/realmadrid.png",
      "matchday": 5,
      "web_description": "<p>Gran victoria en casa...</p>",
      "team": {
        "id": 10,
        "name": "Juvenil A",
        "category": "Juvenil"
      },
      "season": {
        "id": 3,
        "name": "2025/2026"
      }
    }
  ],
  "meta": {
    "total": 1,
    "sports_school": {
      "name": "CD Puebla",
      "logo": "https://tu-portal.com/storage/logos/cdpuebla.png"
    }
  }
}
```

**Errores**:
- `400`: Domain parameter is required
- `403`: Unauthorized domain (referer no coincide)
- `404`: Sports school not found for this domain

---

### 2. Obtener Equipos

**Endpoint**: `GET /api/v1/public/teams`

**Parámetros**:
- `domain` (opcional): Dominio de la escuela

**Ejemplo de petición**:
```javascript
fetch('https://tu-portal.com/api/v1/public/teams?domain=cdpuebla.es')
  .then(response => response.json())
  .then(data => console.log(data));
```

**Respuesta**:
```json
{
  "success": true,
  "data": [
    {
      "id": 10,
      "name": "Juvenil A",
      "category": "Juvenil"
    },
    {
      "id": 11,
      "name": "Infantil B",
      "category": "Infantil"
    }
  ]
}
```

---

## 🎨 Widget JavaScript (Opción Fácil)

Para escuelas sin conocimientos técnicos, puedes usar el widget JavaScript que renderiza automáticamente los partidos.

### Instalación Básica

⚠️ **IMPORTANTE**: El widget necesita saber dónde está tu API. Debes configurar la URL del portal antes de cargar el widget.

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuestros Partidos</title>
</head>
<body>
    <h1>Calendario de Partidos</h1>
    
    <!-- 1. IMPORTANTE: Configurar URL del portal API -->
    <script>
        window.CLUB_PORTAL_API_URL = 'https://tu-portal.com';
    </script>
    
    <!-- 2. Contenedor donde se mostrarán los partidos -->
    <div id="club-matches"></div>
    
    <!-- 3. Cargar el widget -->
    <script src="https://tu-portal.com/widget/matches.js"></script>
</body>
</html>
```

**Reemplaza `https://tu-portal.com` con la URL real de tu servidor portal** (donde está alojado Laravel con la API).

### Opciones de Configuración

Puedes personalizar el widget usando atributos `data-*` en el contenedor:

```html
<!-- 1. Configurar URL del portal -->
<script>
    window.CLUB_PORTAL_API_URL = 'https://tu-portal.com';
</script>

<!-- 2. Contenedor con opciones personalizadas -->
<div id="club-matches" 
     data-limit="20"
     data-team-id="10"
     data-upcoming="true"
     data-show-team-filter="true"
     data-show-logo="true">
</div>

<!-- 3. Script del widget -->
<script src="https://tu-portal.com/widget/matches.js"></script>
```

**Atributos disponibles**:
- `data-limit`: Número de partidos a mostrar (default: 10)
- `data-team-id`: ID de equipo específico
- `data-upcoming`: `"true"` para solo partidos futuros
- `data-past`: `"true"` para solo partidos pasados
- `data-show-team-filter`: `"false"` para ocultar filtro de equipos (default: true)
- `data-show-logo`: `"false"` para ocultar logo de la escuela (default: true)

---

## 🛠️ Uso Directo de la API (Opción Avanzada)

Si prefieres control total del diseño, puedes consumir la API directamente:

### Ejemplo con JavaScript Vanilla

```javascript
async function loadMatches() {
    try {
        const response = await fetch('https://tu-portal.com/api/v1/public/matches?limit=10');
        const data = await response.json();
        
        if (data.success) {
            renderMatches(data.data);
        }
    } catch (error) {
        console.error('Error loading matches:', error);
    }
}

function renderMatches(matches) {
    const container = document.getElementById('matches-container');
    
    matches.forEach(match => {
        const matchElement = document.createElement('div');
        matchElement.innerHTML = `
            <h3>${match.team.name} vs ${match.opponent}</h3>
            <p>Fecha: ${match.date} - ${match.hour_match || 'Hora por confirmar'}</p>
            ${match.goals_team !== null ? `<p>Resultado: ${match.goals_team} - ${match.goals_oponent}</p>` : ''}
        `;
        container.appendChild(matchElement);
    });
}

loadMatches();
```

### Ejemplo con jQuery

```javascript
$.ajax({
    url: 'https://tu-portal.com/api/v1/public/matches',
    method: 'GET',
    data: {
        limit: 10,
        upcoming: true
    },
    success: function(response) {
        if (response.success) {
            response.data.forEach(function(match) {
                $('#matches-container').append(`
                    <div class="match-card">
                        <h3>${match.team.name} vs ${match.opponent}</h3>
                        <p>${match.date} - ${match.hour_match}</p>
                    </div>
                `);
            });
        }
    }
});
```

---

## ⚙️ Configuración en el Portal

### 1. Añadir dominio a la escuela

En el panel de administración, cada escuela debe tener configurado su dominio en el campo `domain`:

```
Ejemplo: cdpuebla.es
O subdomain: escuela.midominio.com
```

**IMPORTANTE**: No incluir `http://` ni `https://`, solo el dominio.

### 2. Publicar partidos

Solo los partidos marcados como `published = true` serán visibles en la API pública.

---

## 🔍 Testing

### Test desde línea de comandos (curl)

```bash
# Obtener partidos
curl "https://tu-portal.com/api/v1/public/matches?domain=cdpuebla.es&limit=5"

# Obtener equipos
curl "https://tu-portal.com/api/v1/public/teams?domain=cdpuebla.es"
```

### Test desde navegador

Abre la consola del navegador (F12) en la web de la escuela y ejecuta:

```javascript
fetch('https://tu-portal.com/api/v1/public/matches?limit=5')
  .then(r => r.json())
  .then(console.log);
```

---

## 🚀 Caché

La API utiliza caché para mejorar el rendimiento:
- Datos de escuelas: 1 hora
- Orígenes permitidos (CORS): 1 hora

---

## 📞 Soporte

Para cualquier problema o consulta, contacta con el administrador del sistema.
