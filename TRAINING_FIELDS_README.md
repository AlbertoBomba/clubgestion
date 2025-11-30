# Sistema de Gestión de Campos y Horarios de Entrenamiento

## 📋 Descripción General

Este sistema permite a las escuelas deportivas gestionar de manera visual e intuitiva sus campos de entrenamiento y asignar horarios a los diferentes equipos. La interfaz es altamente visual con representaciones gráficas de campos de fútbol y un calendario semanal interactivo.

## 🏗️ Estructura de Tablas

### training_fields (Campos de Entrenamiento)
Almacena la información de los espacios de entrenamiento:
- **name**: Nombre del campo (ej: "Campo Principal", "Pista Cubierta")
- **field_type**: Tipo de campo (futbol_11, futbol_7, futsal, polideportivo)
- **surface_type**: Tipo de superficie (cesped_natural, cesped_artificial, tierra, parquet)
- **description**: Descripción opcional del campo
- **capacity**: Capacidad máxima de jugadores
- **color**: Color hex para visualización (#10B981 por defecto - verde)
- **active**: Estado del campo (activo/inactivo)
- **sports_school_id**: Relación con la escuela deportiva

### training_schedules (Horarios de Entrenamiento)
Gestiona las asignaciones de equipos a campos:
- **team_id**: Equipo asignado
- **training_field_id**: Campo asignado
- **season_id**: Temporada a la que pertenece
- **day_of_week**: Día de la semana (lunes, martes, miércoles, jueves, viernes, sábado, domingo)
- **start_time**: Hora de inicio (formato HH:MM, cualquier hora permitida)
- **end_time**: Hora de fin (formato HH:MM, cualquier hora permitida)
- **notes**: Notas adicionales
- **active**: Estado del horario

**IMPORTANTE**: 
- ✅ **Múltiples equipos pueden compartir el mismo campo a la misma hora** (ideal para entrenamientos conjuntos)
- ✅ **Horarios completamente flexibles**: Puedes poner 10:30 a 11:30, 16:45 a 18:15, etc.
- ⚠️ No hay validación de solapamientos - el sistema permite total libertad en la asignación

## 🎨 Características Visuales

### 1. Gestión de Campos (`/training-fields`)
- **Lista de campos** con tabla visual
- **Indicador de color** personalizable para cada campo
- **Filtros**: por nombre, tipo de campo, estado
- **Modal CRUD**: Crear y editar campos con formulario completo
- **Información visible**: 
  - Tipo de campo (con nombres legibles)
  - Tipo de superficie
  - Capacidad
  - Estado (activo/inactivo)

### 2. Calendario de Horarios (`/training-schedule`)
**Vista principal:**
- **Calendario semanal** (Lunes a Domingo)
- **Slots de tiempo** cada hora (8:00 - 22:00)
- **Un campo por fila** con su representación visual

**Características del campo visual:**
- Mini dibujo del campo de fútbol con:
  - Línea central
  - Círculo central
  - Áreas de portería
- Color personalizado del campo
- Información: nombre, tipo, superficie, capacidad

**Interactividad:**
- **Slots vacíos**: Botón "+" al hacer hover (agregar horario)
- **Slots ocupados**: 
  - Muestra todos los equipos asignados a ese horario (apilados)
  - Cada equipo tiene su tarjeta con color de fondo del campo
  - Botón "X" en cada tarjeta para eliminar
  - Botón "+" al final para agregar más equipos al mismo horario
- **Modal de asignación**: 
  - Selección de equipo
  - Hora inicio/fin (totalmente flexible, ej: 10:30 - 11:30)
  - Notas opcionales
  - Sin restricciones de solapamiento

**Filtros:**
- Selector de temporada (auto-selecciona la activa)
- Badge verde para temporada en curso

## 🔄 Flujo de Trabajo

### Configuración Inicial:
1. **Crear Campos** (`/training-fields`):
   - Asignar nombre descriptivo
   - Seleccionar tipo y superficie
   - Elegir color para visualización
   - Indicar capacidad (opcional)

### Asignación de Horarios:
2. **Ir al Calendario** (`/training-schedule`):
   - Ver todos los campos con su diseño visual
   - Hacer clic en slots vacíos (botón +) para asignar
   - Seleccionar equipo de la temporada
   - Definir hora inicio y fin (totalmente flexible: 10:30, 16:45, etc.)
   - Añadir notas si es necesario
   - **Permitido**: Varios equipos en el mismo campo y horario (entrenamientos conjuntos)

### Gestión:
3. **Modificar/Eliminar**:
   - Clic en "X" de cada horario asignado para eliminar
   - Agregar más equipos al mismo horario con el botón "+" inferior
   - Total libertad en la organización

## 🎯 Validaciones

- **Horarios flexibles**: Cualquier hora permitida (10:30, 16:45, etc.)
- **Compartir campo**: Múltiples equipos pueden usar el mismo campo a la misma hora
- **Temporada activa**: Solo se muestran equipos de la temporada seleccionada
- **Campos activos**: Solo campos marcados como activos aparecen en el calendario
- **Horario válido**: La hora de fin debe ser posterior a la hora de inicio

## 👥 Permisos

- **Gestión de Campos**: Solo `school_admin`
- **Gestión de Horarios**: Solo `school_admin`
- **Visualización**: Según roles configurados

## 🎨 Personalización Visual

Cada campo tiene un color asignado que se usa en:
- Borde de la cabecera del campo
- Fondo degradado de la cabecera
- Mini representación del campo de fútbol
- Horarios asignados (fondo con transparencia)

Colores recomendados:
- Verde: #10B981 (default)
- Azul: #3B82F6
- Naranja: #F59E0B
- Rojo: #EF4444
- Morado: #8B5CF6

## 📱 Responsive

El sistema es completamente responsive:
- Tabla de campos adaptativa
- Calendario con scroll horizontal en móviles
- Modales optimizados para pantallas pequeñas

## 🔧 Modelos y Relaciones

### TrainingField
```php
- sportsSchool() // BelongsTo
- schedules() // HasMany
- createdBy() // BelongsTo User
- updatedBy() // BelongsTo User
```

### TrainingSchedule
```php
- team() // BelongsTo
- trainingField() // BelongsTo
- season() // BelongsTo
- createdBy() // BelongsTo User
- updatedBy() // BelongsTo User
```

### Team (actualizado)
```php
- trainingSchedules() // HasMany
```

## 🚀 Mejoras Futuras Sugeridas

1. **Drag & Drop**: Arrastrar horarios entre días/campos
2. **Vista de equipo**: Ver todos los entrenamientos de un equipo
3. **Exportar PDF**: Calendario imprimible por equipo o global
4. **Notificaciones**: Avisos de cambios de horario
5. **Recurrencia**: Plantillas de horarios semanales
6. **Ocupación**: Estadísticas de uso de campos
7. **Conflictos**: Alertas de equipos con horarios muy cercanos
8. **Vista mensual**: Calendario mensual complementario

## 📊 Ejemplo de Uso

1. **Escuela crea campos**:
   - Campo Principal (Fútbol 11, Césped Natural, Verde)
   - Pista Cubierta (Fútsal, Parquet, Azul)
   - Campo Secundario (Fútbol 7, Césped Artificial, Naranja)

2. **Asigna horarios**:
   - Lunes 16:00-17:30: Benjamín A → Campo Principal
   - Lunes 17:30-19:00: Alevín A → Campo Principal
   - Martes 18:00-19:30: Infantil A → Pista Cubierta

3. **Visual resultante**:
   - Calendario con 3 campos con colores distintivos
   - Cada slot muestra el equipo y categoría
   - Fácil identificación de huecos disponibles

---

**Desarrollado por**: Trevion APP
**Fecha**: Noviembre 2025
**Versión**: 1.0
