# 🚀 Guía Rápida - API Pública

## ⚡ Inicio Rápido (2 minutos)

### API Pública v1

Los endpoints `/api/v1/public/*` están diseñados para:
- **Web pública que muestra información de múltiples escuelas**
- Identificación mediante parámetro `domain`
- **No requiere API Keys**
- Throttling: 60 peticiones por minuto

---

## 📋 Endpoints Disponibles

| Endpoint | Descripción | Parámetros |
|----------|-------------|------------|
| `GET /api/v1/public/matches` | Lista de partidos | **domain** (requerido), limit, team_id, upcoming, past |
| `GET /api/v1/public/matches/{id}` | Detalles de partido | **domain** (requerido) |
| `GET /api/v1/public/teams` | Lista de equipos | **domain** (requerido) |

---

## 💻 Ejemplos de Uso

### JavaScript/Fetch

```javascript
// Obtener partidos de una escuela
fetch('https://tudominio.com/api/v1/public/matches?domain=escueladeportiva.com')
    .then(response => response.json())
    .then(data => {
        console.log('Partidos:', data.data);
        console.log('Total:', data.meta.total);
    });

// Con filtros
const params = new URLSearchParams({
    domain: 'escueladeportiva.com',
    upcoming: true,
    limit: 5,
    team_id: 123
});

fetch(`https://tudominio.com/api/v1/public/matches?${params}`)
    .then(response => response.json())
    .then(data => console.log(data));

// Detalles de un partido
fetch('https://tudominio.com/api/v1/public/matches/456?domain=escueladeportiva.com')
    .then(response => response.json())
    .then(data => {
        console.log('Formación:', data.data.formation);
        console.log('Alineación:', data.data.lineup);
    });
```

### jQuery

```javascript
$.ajax({
    url: 'https://tudominio.com/api/v1/public/matches',
    data: {
        domain: 'escueladeportiva.com',
        upcoming: true,
        limit: 10
    },
    success: function(data) {
        console.log('Partidos:', data.data);
    }
});
```

### PHP/Guzzle

```php
$client = new \GuzzleHttp\Client();

$response = $client->get('https://tudominio.com/api/v1/public/matches', [
    'query' => [
        'domain' => 'escueladeportiva.com',
        'upcoming' => true,
        'limit' => 10
    ]
]);

$data = json_decode($response->getBody(), true);
print_r($data);
```

---

## 🚦 Límites y Restricciones

- **Rate Limit:** 60 peticiones por minuto (global)
- **Validación:** El dominio debe estar registrado en la base de datos
- **CORS:** El referer debe coincidir con el dominio solicitado
- **Published:** Solo se muestran equipos y partidos marcados como publicados

---

## ❌ Errores Comunes

### Error 400: "Domain parameter is required"
**Causa:** No enviaste el parámetro `domain`  
**Solución:** Añade `?domain=tuescuela.com` a la URL

### Error 404: "Sports school not found"
**Causa:** El dominio no está registrado en la base de datos  
**Solución:** 
- Verifica que el dominio esté correctamente escrito
- Comprueba en admin que la escuela tiene configurado ese dominio

### Error 403: "Unauthorized domain"
**Causa:** El referer no coincide con el dominio solicitado  
**Solución:** 
- Asegúrate de que la petición viene del mismo dominio
- En desarrollo local, esto puede causar problemas (desactiva CORS temporalmente)

### Error 429: Too Many Requests
**Causa:** Más de 60 peticiones en 1 minuto  
**Solución:** 
- Implementa caché en tu aplicación
- Espacía las peticiones
- Espera 1 minuto antes de reintentar

---

## 💡 Ejemplo Completo: Widget de Partidos

```javascript
class PartidosWidget {
    constructor(domain) {
        this.domain = domain;
        this.baseUrl = 'https://tudominio.com/api/v1/public';
    }

    async getProximosPartidos(limit = 5) {
        const params = new URLSearchParams({
            domain: this.domain,
            upcoming: true,
            limit: limit
        });

        const response = await fetch(`${this.baseUrl}/matches?${params}`);
        
        if (!response.ok) {
            throw new Error(`API Error: ${response.status}`);
        }

        return await response.json();
    }

    async getPartido(id) {
        const response = await fetch(
            `${this.baseUrl}/matches/${id}?domain=${this.domain}`
        );

        if (!response.ok) {
            throw new Error(`API Error: ${response.status}`);
        }

        return await response.json();
    }

    async getEquipos() {
        const response = await fetch(
            `${this.baseUrl}/teams?domain=${this.domain}`
        );

        if (!response.ok) {
            throw new Error(`API Error: ${response.status}`);
        }

        return await response.json();
    }

    renderPartidos(containerId) {
        this.getProximosPartidos()
            .then(data => {
                const container = document.getElementById(containerId);
                container.innerHTML = data.data.map(match => `
                    <div class="partido">
                        <h3>${match.team.name} vs ${match.opponent}</h3>
                        <p>Fecha: ${match.date} ${match.hour_match || ''}</p>
                        <p>Lugar: ${match.site}</p>
                    </div>
                `).join('');
            })
            .catch(error => console.error('Error:', error));
    }
}

// Uso
const widget = new PartidosWidget('miescuela.com');
widget.renderPartidos('partidos-container');
```

---

## 📱 Widget Público Integrado

El widget `public/widget/matches.js` ya está configurado para usar esta API:
- Detecta automáticamente el dominio del sitio
- Realiza peticiones con el parámetro `domain`
- Muestra partidos con modal responsive
- **No requiere configuración adicional**

### Integración en HTML

```html
<!-- En tu página web -->
<div id="matches-widget"></div>

<script src="https://tuapi.com/widget/matches.js"></script>
<script>
    // El widget detecta el dominio automáticamente
    const widget = new MatchesWidget({
        container: '#matches-widget',
        limit: 10
    });
</script>
```

---

## 🛡️ Buenas Prácticas

### ✅ Hacer:
- Implementar caché en tu aplicación (reduce peticiones)
- Usar parámetros `limit` apropiados
- Manejar errores correctamente
- Validar el dominio antes de hacer peticiones
- Usar HTTPS siempre

### ❌ No hacer:
- Hacer peticiones en bucles sin control
- Ignorar los códigos de error
- Hardcodear el dominio (obtenerlo dinámicamente)
- Hacer polling constante sin caché

---

## 🔐 Componentes de Seguridad Avanzada

### Sistema de API Keys (Para Futuras APIs Privadas)

Si necesitas crear endpoints privados con autenticación por escuela, el sistema incluye:
- Generación de API Keys únicas con prefijo `sk_`
- Rate limiting personalizado (100 req/min por escuela)
- Audit logs de peticiones
- Interfaz de administración completa

Ver documentación completa en: [API_SECURITY_IMPLEMENTATION.md](API_SECURITY_IMPLEMENTATION.md)

---

## 📞 ¿Problemas?

### Verificar estado de la API
```bash
# Test rápido
curl "https://tudominio.com/api/v1/public/matches?domain=test.com"

# Ver logs del servidor
tail -f storage/logs/laravel.log
```

### Contacto
- Revisa la documentación técnica completa
- Verifica que el dominio esté configurado en admin
- Comprueba el rate limiting con herramientas de desarrollo

---

**Implementado el:** 12 de Febrero de 2026  
**Versión:** 2.0  
**Tipo:** API Pública con Validación por Dominio 🌐  

---

## 📖 Documentación Adicional

- **[API_SECURITY_IMPLEMENTATION.md](API_SECURITY_IMPLEMENTATION.md)** - Documentación técnica completa
- **Widget:** `public/widget/matches.js` - Widget JavaScript pre-configado
