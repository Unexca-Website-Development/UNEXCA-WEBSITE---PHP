# Guía de Instalación y Configuración (Docker en Windows)

Esta guía unificada te permitirá levantar el entorno de desarrollo completo, importar la base de datos correctamente y configurar tu acceso administrativo en pocos minutos.

## 1. Prerrequisitos

*   **Docker Desktop para Windows**: [Descargar aquí](https://www.docker.com/products/docker-desktop/).
*   **Terminal**: Se recomienda **Git Bash** o **PowerShell**.

## 2. Preparación del Proyecto

1.  **Clonar el repositorio**:
    ```bash
    git clone https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP.git
    cd UNEXCA-WEBSITE---PHP
    ```

2.  **Crear el archivo de entorno (.env)**:
    *   **En Git Bash / PowerShell**: `cp .env.default .env`
    *   **En CMD**: `copy .env.default .env`

3.  **Verificar archivos**: Asegúrate de que el archivo `respaldo.sql` esté en la raíz del proyecto.

## 3. Iniciar el Entorno

Ejecuta el siguiente comando para construir y levantar los contenedores:

```bash
docker-compose up -d --build
```

Esto descargará las imágenes de PHP 7.4 y PostgreSQL 15, y levantará los servicios. Acceso: **[http://localhost:8080](http://localhost:8080)**.

## 4. Importar la Base de Datos (Sin errores de acentos)

Para garantizar que los acentos (UTF-8) se importen correctamente en Windows, utiliza estos comandos según tu terminal:

### Opción A: Desde Git Bash (Recomendado)
```bash
# Limpiar e importar
docker-compose exec -T db psql -U postgres -d postgres -c "DROP DATABASE IF EXISTS unexcadb WITH (FORCE);"
docker-compose exec -T db psql -U postgres -d postgres -c "CREATE DATABASE unexcadb;"
cat respaldo.sql | docker-compose exec -T db psql -U postgres -d unexcadb
```

### Opción B: Desde PowerShell (Más robusto)
```powershell
# Copiar el archivo al contenedor para evitar problemas de codificación de la terminal
docker cp respaldo.sql unexca-website---php-db-1:/tmp/respaldo.sql
docker-compose exec db psql -U postgres -d unexcadb -c "DROP SCHEMA public CASCADE; CREATE SCHEMA public;"
docker-compose exec db psql -U postgres -d unexcadb -f /tmp/respaldo.sql
```

## 5. Configuración del Acceso Administrativo

Las contraseñas en este proyecto usan `password_hash()` de PHP. Por seguridad, debes generar el hash dentro del mismo entorno donde se validará.

### 5.1. Generar el Hash de tu contraseña
Ejecuta esto para generar el hash de la contraseña que desees (ej: `admin123`):
```bash
docker-compose exec app php -r "echo password_hash('tu_contraseña_aqui', PASSWORD_BCRYPT);"
```
*Copia el código resultante (ej: `$2y$10$...`).*

### 5.2. Actualizar el usuario en la Base de Datos
Para evitar errores con caracteres especiales en la terminal de Windows, crea un archivo temporal `update_pass.sql` con el siguiente contenido:
```sql
UPDATE usuarios SET password = 'TU_HASH_COPIADO' WHERE usuario = 'admin';
```
Luego ejecútalo:
```powershell
docker cp update_pass.sql unexca-website---php-db-1:/tmp/update_pass.sql
docker-compose exec db psql -U postgres -d unexcadb -f /tmp/update_pass.sql
```

## 6. Comandos Útiles

*   **Acceder al Panel Admin:** `http://localhost:8080/?pagina=login`
*   **Reiniciar entorno (limpio):** `docker-compose down -v && docker-compose up -d`
*   **Ver errores en tiempo real:** `docker-compose logs -f app`
*   **Consola de Postgres:** `docker-compose exec db psql -U postgres -d unexcadb`

---
*Nota: Para entornos de producción (Debian), consulta el procedimiento de hash en el servidor destino para asegurar la compatibilidad del algoritmo.*
