# Widget de Partidos - Sistema de Plantillas

## 📋 Descripción

El widget utiliza un sistema de plantillas HTML organizadas que facilita la gestión y modificación del diseño. Las plantillas están incluidas en el archivo JavaScript en el objeto `TEMPLATES` al inicio del código.

## 📁 Archivos

- **`matches.js`** - Código JavaScript + Plantillas HTML (todo en uno)
- **`README-TEMPLATES.md`** - Esta documentación

## 🎨 Cómo Editar las Plantillas

### Ubicación de las Plantillas

Las plantillas están al inicio del archivo `matches.js` en el objeto `TEMPLATES`:

```javascript
const TEMPLATES = {
    'loading': `<div>...</div>`,
    'error': `<div>...</div>`,
    'team': `<div>...</div>`,
    // ... más plantillas
};
```

Cada plantilla puede contener:
- **HTML** normal
- **Variables** en formato `{{nombreVariable}}`
- **Estilos** inline o CSS

### Ejemplo de Plantilla

En el archivo `matches.js`, busca el objeto `TEMPLATES`:

```javascript
const TEMPLATES = {
    'team': `
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 60px; height: 60px;">
                {{logo}}
            </div>
            <div style="text-align: center;">
                <div>{{teamName}}</div>
                {{category}}
            </div>
        </div>
    `,
    // ... más plantillas
};
```

### Variables Disponibles por Plantilla

#### `template-loading`
- `{{loading}}` - Texto "Cargando partidos..."

#### `template-error`
- `{{error}}` - Título del error
- `{{message}}` - Mensaje de error específico

#### `template-no-matches`
- `{{noMatches}}` - Texto "No hay partidos disponibles"

#### `template-logo`
- `{{logoUrl}}` - URL del logo de la escuela deportiva
- `{{schoolName}}` - Nombre de la escuela

#### `template-team-filter`
- `{{allTeams}}` - Texto del selector "Todos los equipos"
- `{{teams}}` - Opciones del select (generadas dinámicamente)

#### `template-match-card`
- `{{header}}` - Header del partido (fecha, hora, jornada)
- `{{content}}` - Contenido principal (equipos, marcador)
- `{{footer}}` - Footer (ubicación, descripción)

#### `template-match-header`
- `{{date}}` - Fecha formateada del partido
- `{{hour}}` - Hora del partido (opcional)
- `{{matchday}}` - Número de jornada (opcional)

#### `template-team`
- `{{logo}}` - Logo del equipo (HTML)
- `{{teamName}}` - Nombre del equipo
- `{{category}}` - Categoría del equipo (opcional)

#### `template-score-result`
- `{{goalsLeft}}` - Goles del equipo izquierdo
- `{{goalsRight}}` - Goles del equipo derecho
- `{{colorLeft}}` - Color del marcador izquierdo (#10b981 = verde, #ef4444 = rojo, #64748b = gris)
- `{{colorRight}}` - Color del marcador derecho

#### `template-score-upcoming`
- `{{hour}}` - Hora del partido (opcional)

#### `template-site-info`
- `{{siteName}}` - Nombre del lugar
- `{{badge}}` - Badge "Local" o "Visitante" (opcional)

#### `template-site-badge`
- `{{bgColor}}` - Color de fondo del badge
- `{{textColor}}` - Color del texto del badge
- `{{label}}` - Texto "Local" o "Visitante"

#### `template-description`
- `{{marginTop}}` - Margen superior (10px si hay site, 0 si no)
- `{{description}}` - Descripción del partido

## 🔧 Cómo Modificar el Diseño

### 1. Cambiar Colores

Encuentra `'match-header'` en el objeto `TEMPLATES`:

```javascript
'match-header': `
    <!-- Original: gradiente púrpura -->
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); ...">
    
    <!-- Modificado: gradiente azul -->
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); ...">
`,
```

### 2. Cambiar Tamaños

Encuentra `'team'` en el objeto `TEMPLATES`:

```javascript
'team': `
    <!-- Original: 60x60px -->
    <div style="width: 60px; height: 60px; ...">
    
    <!-- Modificado: 80x80px -->
    <div style="width: 80px; height: 80px; ...">
`,
```

### 3. Añadir Nuevos Elementos

Modifica cualquier plantilla para añadir íconos, textos o HTML:

```javascript
'match-header': `
    <div style="...">
        <!-- Añadir un ícono personalizado -->
        <div style="display: flex; align-items: center;">
            <img src="/tu-icono.svg" style="width: 20px; margin-right: 8px;">
            <span>{{date}}</span>
        </div>
    </div>
`,
```

## 🚀 Aplicar Cambios

1. Abre el archivo `matches.js`
2. Busca el objeto `TEMPLATES` al inicio del archivo  
3. Edita la plantilla que necesites modificar
4. Guarda los cambios
5. **IMPORTANTE:** Ejecuta `npm run build` para recompilar
6. Recarga la página donde está el widget

## 💡 Consejos

### Mantener la Consistencia
- Usa las mismas unidades (px, rem) en toda la plantilla
- Mantén los mismos espaciados y márgenes
- Usa variables de color coherentes

### Testing
- Prueba con partidos con resultado y sin resultado
- Prueba con partidos locales y visitantes
- Verifica que funcione en móvil y desktop

### Backup
Antes de hacer cambios grandes, guarda una copia del archivo `matches.js`

### Edición Organizada
Las plantillas están agrupadas al inicio del archivo. Busca:
```javascript
const TEMPLATES = {
```

## 🐛 Solución de Problemas

### Las variables no se reemplazan
- Asegúrate de usar la sintaxis correcta: `{{variable}}`
- Verifica que el nombre de la variable coincida con el código JavaScript

### El diseño se rompe
- Verifica que todos los tags HTML estén correctamente cerrados
- Comprueba que los estilos inline tengan comillas correctas (`"` no `'` dentro del template)
- Usa las herramientas de desarrollador del navegador para inspeccionar

### Los cambios no se ven
- **Ejecuta `npm run build` después de editar** - Este es el paso más importante
- Limpia la caché del navegador (Ctrl+F5)
- Verifica que estés editando el archivo correcto
- Comprueba la consola del navegador por errores

### Error de sintaxis JavaScript
- Si modificaste el objeto TEMPLATES, asegúrate de que cada plantilla termine con una coma
- Verifica que las comillas inversas (\`) estén correctamente balanceadas
- Comprueba que no haya comillas inversas dentro del template string (usa `'` o `"` en su lugar)

## 📞 Soporte

Si tienes dudas sobre cómo modificar las plantillas, contacta al equipo de desarrollo.
