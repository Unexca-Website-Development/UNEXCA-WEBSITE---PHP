# Guía de Instalación con Docker en Windows

Esta guía te permitirá levantar el entorno de desarrollo completo (Servidor Web PHP + Base de Datos PostgreSQL) en Windows utilizando Docker. Este método garantiza que todos los desarrolladores trabajen en el mismo entorno (PHP 7.4 + Apache).

## 1. Prerrequisitos

Antes de comenzar, asegúrate de tener instalado:

1.  **Docker Desktop para Windows**: [Descargar aquí](https://www.docker.com/products/docker-desktop/).
2.  **Una Terminal**: Puedes usar cualquiera de estas tres:
    *   **Git Bash** (Recomendado).
    *   **Símbolo del Sistema (CMD)**.
    *   **PowerShell**.

## 2. Preparación del Proyecto

1.  **Clonar el repositorio**:
    ```bash
    git clone https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP.git
    cd UNEXCA-WEBSITE---PHP
    ```

2.  **Crear el archivo de entorno (.env)**:
    Docker necesita un archivo `.env` para configurar las claves. Copia el archivo por defecto:
    *   **En Git Bash**: `cp .env.default .env`
    *   **En CMD**: `copy .env.default .env`
    *   **En PowerShell**: `copy .env.default .env`

3.  **Base de Datos de Respaldo**:
    Asegúrate de tener el archivo `respaldo.sql` en la carpeta raíz del proyecto. [Has click aquí para revisar el mensaje en discord](https://discord.com/channels/1374172077216501770/1376218116022993076/1460075897234391186) 

## 3. Iniciar el Entorno

En tu terminal, ejecuta:

```bash
docker-compose up -d --build
```

Esto descargará las imágenes de PHP 7.4 y PostgreSQL 15, y levantará los servicios. Acceso: **[http://localhost:8080](http://localhost:8080)**.

## 4. Importar la Base de Datos (Según tu terminal)

Ejecuta estos comandos para crear las tablas e importar los datos con los acentos correctos:

### Opción A: Desde Git Bash (Recomendado)
```bash
# 1. Recrear base de datos
docker-compose exec -T db psql -U postgres -d postgres -c "DROP DATABASE IF EXISTS unexcadb WITH (FORCE);"
docker-compose exec -T db psql -U postgres -d postgres -c "CREATE DATABASE unexcadb;"

# 2. Importar datos
cat respaldo.sql | docker-compose exec -T db psql -U postgres -d unexcadb
```

### Opción B: Desde el CMD (Símbolo del Sistema)
```cmd
:: 1. Recrear base de datos
docker-compose exec -T db psql -U postgres -d postgres -c "DROP DATABASE IF EXISTS unexcadb WITH (FORCE);"
docker-compose exec -T db psql -U postgres -d postgres -c "CREATE DATABASE unexcadb;"

:: 2. Importar datos
type respaldo.sql | docker-compose exec -T db psql -U postgres -d unexcadb
```

### Opción C: Desde PowerShell
```powershell
# 1. Recrear base de datos
docker-compose exec -T db psql -U postgres -d postgres -c "DROP DATABASE IF EXISTS unexcadb WITH (FORCE);"
docker-compose exec -T db psql -U postgres -d postgres -c "CREATE DATABASE unexcadb;"

# 2. Importar datos (UTF8)
Get-Content respaldo.sql -Encoding UTF8 | docker-compose exec -T db psql -U postgres -d unexcadb
```

## 5. Comandos Útiles

*   **Detener y borrar todo (Reset):** `docker-compose down -v`
*   **Ver logs:** `docker-compose logs -f app`
*   **Consola de BD:** `docker-compose exec db psql -U postgres -d unexcadb`
