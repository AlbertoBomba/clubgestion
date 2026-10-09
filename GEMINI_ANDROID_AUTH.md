# Instrucciones para Gemini en Android Studio

Implementa el registro e inicio de sesión de mi app Android contra la API
Laravel existente que se describe aquí. No necesitas modificar el backend.
Respeta la arquitectura, lenguaje y librerías ya presentes en el proyecto
Android; si no existen, propón Kotlin, coroutines y Retrofit con un repositorio.
No inventes endpoints ni campos. No implementes Google ni escuelas favoritas
en esta fase.

## Configuración

- El propietario debe proporcionar el host HTTPS real del backend.
- Base URL Retrofit: `https://HOST_REAL/api/v1/auth/` (con `/` final).
- No sustituir ese host por un dominio inventado ni poner credenciales en código.
- Todos los requests: `Accept: application/json`.
- Los POST: `Content-Type: application/json`.
- Los endpoints protegidos: `Authorization: Bearer {token}`.
- No hace falta API key, `domain`, `Referer`, cookies ni token CSRF.
- El token es opaco de Sanctum: no es JWT ni se debe decodificar.

## Contrato exacto

### POST register

Sin autenticación, cuerpo:

```json
{
  "name": "María García",
  "email": "maria@example.com",
  "password": "una-clave-larga-123",
  "password_confirmation": "una-clave-larga-123",
  "device_name": "Android"
}
```

Campos obligatorios:

- Nombre: no vacío, máximo 255 caracteres.
- Email: válido, máximo 255 caracteres. El servidor recorta extremos y lo
  convierte a minúsculas; también recorta extremos del nombre.
- Contraseña: al menos 12 caracteres, máximo 72 caracteres y 72 bytes UTF-8.
  No recortarla ni modificarla. Comprobar `toByteArray(Charsets.UTF_8).size`.
- Confirmación: idéntica a contraseña.
- Nombre del dispositivo: texto no vacío, máximo 100 caracteres; puede ser
  `"Android"`. No necesita permisos del teléfono ni identificadores sensibles.

No enviar `role`, `sports_school_id`, `is_active`, `email_verified_at`,
documentos ni otros campos. El servidor crea una cuenta activa con rol `web`,
sin escuela y email aún no verificado.

Respuesta de éxito `201`:

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

Guardar el token y abrir la pantalla autenticada: el registro ya inicia sesión.
Un email existente recibe `422`, nunca un token de esa cuenta.

### POST login

Sin autenticación, cuerpo:

```json
{
  "email": "maria@example.com",
  "password": "una-clave-larga-123",
  "device_name": "Android"
}
```

Los tres campos son obligatorios. No aplicar el mínimo de 12 caracteres del
registro a este formulario: hay cuentas existentes con contraseñas más cortas.
El servidor admite hasta 4096 caracteres para validar contraseñas existentes.

Respuesta `200`: misma estructura que `register` (`token`, `token_type`,
`expires_at`, `user`). Las cuentas existentes pueden tener otro rol y una
escuela: no suponer que todos los logins devuelven `web` y `null`.

El login NO registra usuarios automáticamente. Un email inexistente o una
contraseña incorrecta recibe `401`. Mostrar error y una opción explícita de
registro; no llamar a `register` como fallback del login.

### GET me

Con Bearer, sin cuerpo. Respuesta `200`:

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

No existe envoltorio `data`. Usar este endpoint al abrir la app si hay token
guardado. Actualizar el usuario local solo tras una respuesta correcta.
No utilizar el endpoint antiguo `/api/user`.

### POST logout

Con Bearer, cuerpo `{}`. Respuesta `200`:

```json
{
  "message": "Sesión cerrada correctamente."
}
```

Revoca solo el token actual. Borrar token y usuario local al cerrar sesión.
Si falla la red, informar de que no se pudo confirmar la revocación remota;
no afirmar éxito en servidor. Puede cerrarse la sesión local igualmente.
Una llamada posterior con el token revocado recibe `401`.

## Modelos de datos

Crear DTOs acordes a la librería de serialización del proyecto:

- `AuthResponse`: token String, token_type String, expires_at String, user UserDto.
- `MeResponse`: user UserDto.
- `UserDto`: id Long, name String, email String, role String,
  sports_school_id Long?, is_active Boolean, email_verified_at String?,
  created_at String? (fechas ISO-8601 UTC).
- `ApiError`: message String, code String?, errors Map<String, List<String>>?.
- Mapear los nombres snake_case explícitamente si Kotlin usa camelCase.
- Admitir campos JSON adicionales sin fallar para mantener compatibilidad.

No hay contraseñas, documentos ni objetos completos de escuela en UserDto.
No basar la autorización en un rol modificado/guardado localmente: el servidor
es quien decide permisos.

## Errores

Usar HTTP y `code` si existe; no comparar el texto de `message`.

| HTTP | Tratamiento |
|---|---|
| 401 en login | Credenciales incorrectas, sin navegación ni creación automática |
| 401 en me/logout | Token inválido/caducado/revocado: borrar sesión y mostrar login |
| 403 | Mostrar motivo; no acceder ni reintentar automáticamente |
| 422 | Mostrar los mensajes de `errors` en sus campos |
| 429 | Respetar segundos de `Retry-After`; no borrar una sesión válida |
| 500/503 o fallo de red | Mostrar error recuperable; no simular éxito ni borrar el token automáticamente |

Ejemplo `401`:

```json
{
  "message": "El correo o la contraseña no son correctos.",
  "code": "invalid_credentials"
}
```

Ejemplo `422`:

```json
{
  "message": "Este correo ya está registrado.",
  "errors": {
    "email": ["Este correo ya está registrado."]
  }
}
```

Otros códigos: `account_inactive`, `two_factor_required`, `token_forbidden`,
`unauthenticated`. Sanctum puede emitir errores `401` con solo `message`.
Ante cuenta inactiva o doble factor, borrar la sesión móvil y mostrar la razón.
El doble factor no está implementado en Android: indicar que use el acceso web,
sin ofrecer desactivar la protección.

Límites: login 5/minuto por email + IP y 20/minuto por IP; registro 5/minuto y
20/hora por IP; me/logout 60/minuto por usuario entre todos sus dispositivos.
Evitar envíos duplicados y deshabilitar el botón durante la petición.

## Persistencia y seguridad

- Los tokens duran 30 días desde su emisión, no desde su último uso.
- No hay refresh token ni renovación automática. Al caducar, pedir login.
- Guardar token y caducidad cifrados con una clave protegida por Android
  Keystore; no guardar secretos en SharedPreferences/DataStore en texto plano.
- No guardar contraseñas ni incluir claves estáticas compartidas en el APK.
- Excluir credenciales de copias de seguridad/restauración del dispositivo.
  Si se pierde/invalida la clave Keystore, limpiar la sesión y pedir login.
- Añadir Bearer solo a requests protegidos del host configurado; no a
  login/register ni a otros servicios, descargas o hosts.
- HTTPS y validación TLS normales: nunca usar un TrustManager permisivo ni
  desactivar la comprobación del hostname. Desactivar cleartext en producción.
- No loguear passwords, token, cabecera Authorization, cuerpos de login/registro
  ni respuestas de autenticación. Redactar Authorization no basta si se
  mantiene logging de cuerpos.
- Evitar reintentos automáticos de registro/login en errores de red: pueden
  haber tenido éxito en servidor aunque la respuesta no llegase.
- Un fallo de red al restaurar sesión no equivale a sesión caducada. Mostrar
  estado recuperable y permitir reintentar, sin afirmar que el servidor validó.

## Entregables y pruebas Android

Implementar pantallas de login y registro, estados de carga/error, cliente API,
repositorio, almacenamiento seguro, restauración con `me` y logout. Añadir
pruebas con el mecanismo existente (por ejemplo MockWebServer) para:

1. Registro `201` y login `200`, guardar token y mapear datos/nullable.
2. Email duplicado y validación `422`; credenciales `401`.
3. Inicio de app con token válido, caducado y red indisponible.
4. Cuenta inactiva, doble factor y límites `429` con `Retry-After`.
5. Logout y revocación; fallo de red sin afirmar revocación remota.
6. No enviar Bearer a login/register ni fuera del host de la API.
7. Contraseñas multibyte mayores de 72 bytes.

Google queda para otra fase: Credential Manager obtiene un ID token de Google;
el backend deberá validar su firma, audiencia y caducidad y emitir un token
Sanctum. No existe aún un endpoint Google, por lo que no mostrar un botón
funcional ni simular esa autenticación.
