# Guía para la Gestión de Contraseñas de Usuarios

Esta guía detalla el procedimiento correcto para crear y actualizar las contraseñas de los usuarios administrativos, tanto en el entorno de desarrollo local (Windows con Docker) como en el de producción (servidor Debian). El objetivo es asegurar la compatibilidad de los hashes de contraseña y prevenir errores de autenticación.

## Principio Fundamental

La función `password_hash()` de PHP genera un hash diferente cada vez, incluso para la misma contraseña, debido a que incorpora una "sal" (salt) aleatoria. Por ello, es **CRÍTICO** que el hash de la contraseña de un usuario se genere **EN EL MISMO ENTORNO PHP** donde se va a verificar.

## 1. Entorno de Desarrollo (Windows con Docker)

### 1.1. Generar el Hash de la Contraseña

Para generar un hash válido para una contraseña (ej. `admin123`) desde el contenedor PHP de Docker:

```bash
docker-compose exec app php -r "echo password_hash('tu_contraseña_aqui', PASSWORD_BCRYPT);"
```

**Ejemplo:** Para la contraseña `admin123`:
```bash
docker-compose exec app php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"
```
Copia la cadena completa que aparecerá en tu terminal (empezará por `$2y$10$...`).

### 1.2. Actualizar la Contraseña en la Base de Datos

Una vez que tengas el hash generado, debes actualizarlo en la tabla `usuarios` de tu base de datos PostgreSQL.

1.  **Accede a la consola de PostgreSQL de Docker:**
    ```bash
    docker-compose exec db psql -U postgres -d unexcadb
    ```

2.  **Ejecuta el comando SQL `UPDATE`** (reemplaza `TU_HASH_GENERADO` con la cadena que copiaste):
    ```sql
    UPDATE usuarios
    SET password = 'TU_HASH_GENERADO'
    WHERE usuario = 'admin'; -- O el nombre de usuario que quieras actualizar
    ```

3.  **Sal de la consola de `psql`:**
    ```sql
    \q
    ```

## 2. Entorno de Producción (Debian con PHP)

### 2.1. Generar el Hash de la Contraseña

Para generar un hash válido para una contraseña (ej. `admin123`) en tu servidor de producción:

1.  **Conéctate a tu servidor Debian vía SSH.**

2.  **Ejecuta el siguiente comando** en la terminal del servidor. Asegúrate de que `php` esté disponible en la ruta (es lo habitual en instalaciones de PHP en Debian):

    ```bash
    php -r "echo password_hash('tu_contraseña_aqui', PASSWORD_BCRYPT);"
    ```
    **Ejemplo:** Para la contraseña `admin123`:
    ```bash
    php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"
    ```
    Copia la cadena completa que aparecerá en tu terminal (empezará por `$2y$10$...`).

### 2.2. Actualizar la Contraseña en la Base de Datos

Una vez que tengas el hash generado en producción, actualízalo en la tabla `usuarios` de tu base de datos PostgreSQL de producción.

1.  **Accede a la consola de PostgreSQL:**
    *   Si usas el usuario `postgres`:
        ```bash
        sudo -u postgres psql unexcadb
        ```
    *   Si usas otro usuario de base de datos (ej. `unexca_user`):
        ```bash
        psql -U unexca_user -d unexcadb
        ```

2.  **Ejecuta el comando SQL `UPDATE`** (reemplaza `TU_HASH_GENERADO` con la cadena que copiaste):
    ```sql
    UPDATE usuarios
    SET password = 'TU_HASH_GENERADO'
    WHERE usuario = 'admin'; -- O el nombre de usuario que quieras actualizar
    ```

3.  **Sal de la consola de `psql`:**
    ```sql
    \q
    ```

## Notas Importantes de Seguridad

*   **Nunca hardcodees contraseñas** directamente en el código o en scripts de instalación permanentes.
*   Asegúrate de que la columna `password` en tu tabla `usuarios` sea de tipo **`VARCHAR(255)`** para que pueda almacenar correctamente el hash completo sin truncamientos.
*   Siempre usa contraseñas fuertes, únicas y complejas para los entornos de producción.
*   En entornos de producción, considera la gestión de secretos (por ejemplo, con HashiCorp Vault o Kubernetes Secrets) para cualquier credencial sensible.
