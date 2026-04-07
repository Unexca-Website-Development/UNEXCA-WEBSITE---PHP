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

El sitio estará disponible en: **[http://localhost:8080](http://localhost:8080)**

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
docker-compose exec db psql -U postgres -d unexcadb -f //tmp/respaldo.sql
```

## 5. Configuración del Acceso Administrativo

Para configurar o resetear tu contraseña de administrador de forma segura en Windows, ejecuta este comando único en tu terminal (Git Bash o PowerShell):

```bash
docker-compose exec app php scripts/cambiar_pass.php admin admin123
```

*Puedes cambiar `admin123` por la clave que prefieras. El sistema se encargará de hashearla y guardarla correctamente en la base de datos sin errores de caracteres.*


## 6. Comandos Útiles

*   **Acceder al Panel Admin:** `http://localhost:8080/?pagina=login`
*   **Reiniciar entorno (limpio):** `docker-compose down -v && docker-compose up -d`
*   **Ver errores en tiempo real:** `docker-compose logs -f app`
*   **Consola de Postgres:** `docker-compose exec db psql -U postgres -d unexcadb`

---
*Nota: Para entornos de producción (Debian), consulta el procedimiento de hash en el servidor destino para asegurar la compatibilidad del algoritmo.*
