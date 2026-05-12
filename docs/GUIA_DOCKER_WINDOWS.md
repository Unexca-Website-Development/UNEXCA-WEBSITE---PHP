# Guía de Instalación y Configuración (Docker en Windows)

Esta guía unificada te permitirá levantar el entorno de desarrollo completo con los nuevos estándares de seguridad, importar la base de datos e implementar el sistema de roles en pocos minutos.

## 1. Prerrequisitos

*   **Docker Desktop para Windows**: [Descargar aquí](https://www.docker.com/products/docker-desktop/).
*   **Terminal**: Se recomienda **Git Bash** o **PowerShell**.

## 2. Preparación del Entorno

1.  **Clonar el repositorio**:
    ```bash
    git clone https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP.git
    cd UNEXCA-WEBSITE---PHP
    ```

2.  **Configurar variables de entorno**:
    *   Copia el archivo base: `cp .env.default .env`
    *   Asegúrate de que `DB_USER=unexca_user` y `DB_PASS=1234` estén configurados.

3.  **Iniciar Docker**:
    ```bash
    docker-compose up -d --build
    ```
    El sitio estará disponible en: **[http://localhost:8080](http://localhost:8080)**

---

## 3. Configuración de la Base de Datos (Paso Crítico)

Para que el sistema funcione correctamente con el nuevo esquema de seguridad, debes seguir estos tres pasos en tu terminal (Git Bash o PowerShell):

### A. Importar Datos y Estructura RBAC
Este comando crea todas las tablas y el sistema de roles:
```bash
docker-compose exec -T db psql -U unexca_user -d unexcadb < "respaldo.sql"
```

### B. Aplicar Blindaje de Seguridad
Este comando limita los permisos del usuario web para que no pueda borrar tablas, solo manejar datos:
```bash
docker-compose exec -T db psql -U unexca_user -d unexcadb < "scripts/db_security_setup.sql"
```

---

## 4. Gestión de Usuarios Administrativos

Ya no es necesario usar scripts de cambio de contraseña manuales. Utiliza la nueva herramienta CLI que gestiona nombres, claves y roles al mismo tiempo:

```bash
docker-compose exec app php scripts/gestionar_usuario.php admin admin123 "Administrador UNEXCA" 1
```

*   **1**: ID para el rol de Super Administrador.
*   **2**: ID para el rol de Editor.
*   **3**: ID para el rol de Coordinador.

---

## 5. Comandos de Mantenimiento

*   **Reset Completo (Borrón y cuenta nueva):**
    ```bash
    docker-compose down -v && docker-compose up -d
    ```
    *(Recuerda repetir el Paso 3 tras un reset).*

*   **Ver logs de errores:**
    ```bash
    docker-compose logs -f app
    ```

*   **Acceso a consola SQL:**
    ```bash
    docker-compose exec db psql -U unexca_user -d unexcadb
    ```

---
*Nota: Para despliegue en producción (Debian), consulta la documentación específica del manual de integración migración en la carpeta `docs/`.*
