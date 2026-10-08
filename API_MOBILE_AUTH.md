# API de autenticación móvil

## Alcance

API JSON v1 para registrar usuarios en `users`, iniciar sesión con email y
contraseña, consultar el usuario autenticado y revocar el token actual.
Implementada con Laravel Sanctum, sin dependencias nuevas.

- El registro crea una cuenta activa con `users.role = web` y sin escuela.
  También asigna el rol Spatie `web` (guard `web`), sin permisos añadidos.
- El móvil no puede establecer el rol, escuela, estado ni fecha de verificación.
- El login acepta cuentas existentes y conserva sus datos, rol y escuela.
  No crea cuentas cuando las credenciales no son válidas.
- Las escuelas favoritas y Google **no están implementados** en esta versión.
- No se envía correo de verificación ni se marca el email como verificado.
  No debe usarse este registro como prueba de titularidad del email.
- Las cuentas con doble factor confirmado deben usar el acceso web. Este
  login básico no omite ni desactiva el segundo factor.

## Despliegue

Usar un host HTTPS del backend, no el host de una web externa que consuma la
API pública. La API móvil no utiliza `domain`, `Referer` ni API keys de escuelas.

Con la base de datos existente al día, hacer copia de seguridad y aplicar:

```bash
php artisan migrate --path=database/migrations/2026_10_08_180000_add_web_role_to_users.php --force
php artisan optimize:clear
```

En MySQL/MariaDB, la migración lee el enum real `users.role` y añade `web` al final, conservando
todos los roles existentes (incluidos roles añadidos directamente en el servidor),
su orden, valor predeterminado, nulabilidad, collation y comentario. Crea también
el rol Spatie `web`; no cambia roles de usuarios existentes. En instalaciones nuevas, aplicar las migraciones
habituales del proyecto. El seeder de roles también incluye `web`.
La reversión se bloquea mientras existan usuarios con ese rol para evitar pérdida
de datos o conversión accidental de permisos.

Si una versión anterior falló con `1265 Data truncated for column 'role'`,
subir la versión corregida de esta misma migración y volver a ejecutar el comando
anterior. No eliminar usuarios ni cambiar sus roles, no hacer rollback de otras
migraciones y no desactivar el modo estricto de MySQL. La versión corregida
conserva los valores del enum real en lugar de imponer una lista fija.

Antes de publicar:

- HTTPS obligatorio, certificados válidos y HTTP redirigido/rechazado.
- `APP_DEBUG=false`, clave de aplicación configurada y secretos solo en servidor.
- Configurar correctamente los proxies de confianza para que el rate limiter
  obtenga la IP real. No confiar indiscriminadamente en cabeceras de clientes.
- Usar una caché persistente y compartida entre instancias para los límites
  (no `array` en producción).
- No registrar cuerpos de login/registro, contraseñas, tokens ni `Authorization`
  en Laravel, proxy, herramientas de monitorización o clientes móviles.
- Aplicar autorización y aislamiento por escuela en cualquier futura API de
  negocio. Un token válido no concede acceso administrativo.

No se han ejecutado migraciones sobre la base de datos real desde esta tarea.

## Transporte y sesión

Cabeceras de todos los requests:

```http
Accept: application/json
Content-Type: application/json
```

Para `me` y `logout`, añadir:

```http
Authorization: Bearer TOKEN_RECIBIDO
```

El token es opaco, **no es un JWT**, se entrega únicamente al registrar/iniciar
sesión y se almacena hasheado en servidor. Cada login crea un token independiente
con capacidad `mobile:profile` y caducidad fija de **30 días**.
`device_name` es una etiqueta, no una prueba de identidad ni un identificador
único: repetirla no revoca tokens anteriores.

Usar `/me` para restaurar la sesión al abrir la app. No guardar la contraseña
ni volver a enviarla automáticamente. Consultar `/me` no prolonga la caducidad.
No existe un endpoint de refresh; al caducar se solicita de nuevo la contraseña.
Las cookies de sesión web no sustituyen al Bearer en los endpoints protegidos.

Las respuestas de esta API incluyen `Cache-Control: no-store`.

## Endpoints

| Método | Ruta | Autenticación | Resultado |
|---|---|---|---|
| POST | `/api/v1/auth/register` | Ninguna | `201`, usuario y token |
| POST | `/api/v1/auth/login` | Ninguna | `200`, usuario y token |
| GET | `/api/v1/auth/me` | Bearer | `200`, usuario actualizado |
| POST | `/api/v1/auth/logout` | Bearer | `200`, token actual revocado |

### Registro

```json
{
  "name": "María García",
  "email": "maria@example.com",
  "password": "una-clave-larga-123",
  "password_confirmation": "una-clave-larga-123",
  "device_name": "Android"
}
```

Reglas:

- `name`: obligatorio, texto no vacío, hasta 255 caracteres; se recortan extremos.
- `email`: obligatorio, formato válido, hasta 255 caracteres, único; se recortan
  extremos y se convierte a minúsculas. Se comprueban también emails existentes
  con diferente capitalización.
- `password`: obligatorio, mínimo 12 caracteres, máximo 72 caracteres **y 72
  bytes UTF-8**, sin recortar. El límite de bytes evita truncamiento con bcrypt.
- `password_confirmation`: obligatorio, idéntico a `password`.
- `device_name`: obligatorio, texto no vacío, hasta 100 caracteres.
- `role`, `sports_school_id`, `is_active` y `email_verified_at`: prohibidos si
  contienen un valor. Los otros campos desconocidos no se guardan.

Respuesta `201` (el login devuelve esta misma estructura con `200`):

```json
{
  "token": "123|TOKEN_OPACO_DE_EJEMPLO",
  "token_type": "Bearer",
  "expires_at": "2026-11-07T16:00:00.000000Z",
  "user": {
    "id": 42,
    "name": "María García",
    "email": "maria@example.com",
    "role": "web",
    "sports_school_id": null,
    "is_active": true,
    "email_verified_at": null,
    "created_at": "2026-10-08T16:00:00.000000Z"
  }
}
```

El registro inicia la sesión móvil. Usuario, asignación de rol y token se crean
en una transacción: si falla alguno, no se conserva una cuenta incompleta.
Un email ya registrado devuelve `422`; nunca entrega un token de esa cuenta.

### Login

```json
{
  "email": "maria@example.com",
  "password": "una-clave-larga-123",
  "device_name": "Android"
}
```

Los tres campos son obligatorios. El email se normaliza igual que en registro.
Para mantener compatibilidad con usuarios existentes, el login no impone el
mínimo de 12 caracteres del nuevo registro; admite contraseñas de hasta 4096
caracteres y comprueba su hash.

Credenciales incorrectas y email inexistente reciben el mismo error `401`.
Una cuenta desactivada recibe `403`, después de validar la contraseña.
Una cuenta con doble factor confirmado recibe `403`, también tras comprobarla.
Estos casos no emiten tokens.

### Usuario actual

`GET /api/v1/auth/me` devuelve:

```json
{
  "user": {
    "id": 42,
    "name": "María García",
    "email": "maria@example.com",
    "role": "web",
    "sports_school_id": null,
    "is_active": true,
    "email_verified_at": null,
    "created_at": "2026-10-08T16:00:00.000000Z"
  }
}
```

No hay envoltorio `data`. Los campos son una lista explícita: no se devuelven
contraseñas, documentos, secretos 2FA, objetos de escuela ni credenciales de
escuelas. La respuesta de `/api/user` existente se ha limitado a esa misma lista
de campos, manteniendo allí su estructura de usuario **sin** envoltorio `user`.
La app nueva debe usar `/api/v1/auth/me`, no el endpoint antiguo.

En los endpoints móviles protegidos se comprueba que la cuenta siga activa.
Si se desactiva o activa el doble factor, se rechaza y elimina el token utilizado.
Los tokens caducados/revocados reciben `401`; los tokens sin la capacidad
necesaria reciben `403`.

### Cierre de sesión

Enviar `POST /api/v1/auth/logout`, cuerpo `{}`, con Bearer:

```json
{
  "message": "Sesión cerrada correctamente."
}
```

Solo se revoca el token utilizado, no las sesiones de otros dispositivos.
Una segunda llamada con ese mismo token recibe `401`.
No afirmar que se ha revocado en servidor si falla la red: se puede borrar
la sesión local, pero el token remoto conserva su validez hasta revocación o
caducidad. Para revocación administrativa de todos los dispositivos puede
usarse la relación `tokens()` del usuario; no hay endpoint móvil para ello.

## Errores y límites

No interpretar mensajes como identificadores de error: pueden variar por idioma.

| HTTP | Significado | Acción Android |
|---|---|---|
| 401 | Credenciales incorrectas o token ausente/inválido/caducado | En login, mostrar error; en sesión existente, borrar token y pedir login |
| 403 | Cuenta inactiva, doble factor o capacidad insuficiente | Mostrar motivo y no acceder; no reintentar en bucle |
| 422 | Validación o email duplicado | Mostrar `errors` junto a los campos |
| 429 | Límite de peticiones | Respetar `Retry-After`; conservar sesión |
| 500/503 | Fallo del servidor | Mostrar error recuperable, sin simular éxito |

Ejemplo de credenciales incorrectas:

```json
{
  "message": "El correo o la contraseña no son correctos.",
  "code": "invalid_credentials"
}
```

Otros códigos explícitos: `account_inactive`, `two_factor_required`,
`token_forbidden`, `unauthenticated` (cuando se rechaza una sesión sin Bearer).
Los errores `401` generados por Sanctum pueden incluir solo `message`.
Los errores de validación tienen `message` y `errors`, por ejemplo:

```json
{
  "message": "Este correo ya está registrado.",
  "errors": {
    "email": ["Este correo ya está registrado."]
  }
}
```

Límites, incluyendo peticiones correctas e incorrectas:

- Login: 5/minuto por combinación email normalizado + IP, y 20/minuto por IP.
- Registro: 5/minuto y 20/hora por IP.
- Endpoints autenticados: 60/minuto por usuario, compartido entre dispositivos.

Los límites por IP pueden afectar a usuarios que comparten una conexión.
No exponer nuevos endpoints que acepten `mobile:profile` sin revisar sus permisos.
Las capacidades Sanctum solo protegen rutas que las comprueban explícitamente.
La API pública de partidos/equipos y las rutas web conservan sus mecanismos.

## Pruebas y mantenimiento

```bash
php vendor/bin/phpunit tests/Feature/MobileAuthenticationTest.php
```

Las pruebas usan SQLite en memoria con las migraciones reales de autenticación;
no necesitan ni modifican la base de datos de producción. Cubren registro,
normalización y duplicados, permisos, transacción, datos expuestos, login,
cuentas desactivadas, doble factor, caducidad exacta, cookies, logout y límites.

Los tokens caducados ya no autentican aunque permanezcan en la tabla.
Programar periódicamente `php artisan sanctum:prune-expired --hours=24` para
limpiar los registros caducados, según las tareas del despliegue.

## Google: siguiente fase

No es especialmente complicado, pero no basta con enviar el email de Google.
El flujo recomendado:

1. Configurar Google Cloud: cliente Android (paquete y huellas de firma para
   desarrollo/producción) y cliente web para la audiencia del ID token.
2. Usar Android Credential Manager con Sign in with Google para obtener un
   **ID token** destinado al cliente web configurado.
3. Enviar ese ID token por HTTPS a un nuevo endpoint del backend.
4. Validarlo en servidor con una biblioteca mantenida: firma y claves de Google,
   `iss`, `aud`, caducidad y estado de verificación del email. No confiar en
   claims decodificados sin validar, ni en un email enviado por Android.
5. Identificar la cuenta mediante el `sub` estable de Google, guardado en una
   relación/campo único; no usar el email como identificador permanente.
6. Crear cuentas nuevas con el mismo rol `web`, sin escuela, o recuperar una
   vinculación ya existente y emitir el mismo tipo de token Sanctum.
7. No vincular silenciosamente una cuenta local existente por coincidencia de
   email: diseñar una vinculación con reautenticación del titular. Mantener
   controles de cuenta activa, doble factor y rate limiting.

La selección automática de una cuenta Google depende del consentimiento, las
credenciales disponibles y la configuración de Credential Manager; no se puede
garantizar un acceso silencioso en todos los casos. Restaurar el token Sanctum
durante sus 30 días evita solicitar Google o contraseña en cada apertura.
No guardar un secreto de cliente Google en el APK.

## Fichero para el equipo Android

Entregar [GEMINI_ANDROID_AUTH.md](GEMINI_ANDROID_AUTH.md) a Gemini en Android
Studio. Es autónomo: contiene el contrato y los requisitos de seguridad para
implementar el cliente sin acceso al código Laravel.
