# Guía de Instalación y Despliegue - Portal UNEXCA

Esta guía detalla los pasos para poner en marcha el portal en diferentes entornos. Para un despliegue rápido en desarrollo, se recomienda **Docker**. Para servidores de prueba o producción, se detallan los pasos para **Debian 12**.

---

## 1. Despliegue en Servidor Linux (Debian 12 / VM)

Esta es la configuración recomendada para entornos de certificación o producción.

### Requisitos del Sistema
- **SO**: Debian 12
- **Servidor Web**: Apache 2.4
- **Backend**: PHP 7.4 (con extensiones `pdo_pgsql`, `mbstring`, `xml`, `curl`)
- **Base de Datos**: PostgreSQL

### Configuración de la Base de Datos

Para garantizar la seguridad del portal, el usuario de conexión de la aplicación web (`unexca_user`) debe ser diferente al propietario de las tablas (`postgres`). Así, la aplicación web tendrá permisos limitados de manipulación de datos (DML) y no podrá borrar ni modificar la estructura de las tablas (DDL).

1.  **Acceso a PostgreSQL**:
    ```bash
    sudo -i -u postgres psql
    ```
2.  **Crear base de datos y usuario de la aplicación**:
    En la consola de PostgreSQL (`psql`):
    ```sql
    -- Crear la base de datos
    CREATE DATABASE unexcadb;

    -- Crear el usuario limitado para la aplicación web (use una contraseña segura)
    CREATE USER unexca_user WITH PASSWORD 'tu_contrasena_segura_aqui';

    \q
    ```
3.  **Importar estructura y datos**:
    Importe el respaldo como superusuario `postgres` para que las tablas sean de su propiedad. Asegúrese de que el archivo `respaldo.sql` esté accesible (ej: en `/tmp/`):
    ```bash
    sudo -u postgres psql unexcadb < /tmp/respaldo.sql
    ```
4.  **Aplicar Capa de Seguridad (Privilegios Limitados)**:
    Ejecute el script de seguridad como superusuario `postgres` para restringir los permisos de `unexca_user` únicamente a DML (SELECT, INSERT, UPDATE, DELETE):
    ```bash
    sudo -u postgres psql -d unexcadb < /var/www/html/portal_unexca/scripts/db_security_setup.sql
    ```

### Despliegue de la Aplicación

1.  **Copiar archivos al servidor**:
    Traslade el contenido del repositorio al directorio del servidor web:
    ```bash
    sudo cp -r /ruta/del/proyecto/* /var/www/html/portal_unexca/
    ```
2.  **Configurar Variables de Entorno**:
    ```bash
    cd /var/www/html/portal_unexca/
    sudo cp .env.default .env
    sudo nano .env
    ```
    *Nota: Asegúrese de que las credenciales coincidan con las configuradas en el paso anterior.*

3.  **Ajustar Propietario (Owner)**:
    Cambie el propietario de las carpetas críticas al usuario del servidor web (`www-data`):
    ```bash
    sudo chown -R www-data:www-data publico/imagenes
    sudo chown -R www-data:www-data logs
    sudo chown -R www-data:www-data tmp
    ```
4.  **Asignar Permisos (775)**:
    Permita lectura, escritura y ejecución para el dueño y el grupo:
    ```bash
    sudo chmod -R 775 publico/imagenes
    sudo chmod -R 775 logs
    sudo chmod -R 775 tmp
    ```
5.  **Heredar permisos de grupo (Opcional)**:
    Útil para evitar conflictos de permisos al subir archivos vía FTP o Git:
    ```bash
    sudo chmod g+s publico/imagenes
    sudo chmod g+s logs
    sudo chmod g+s tmp
    ```

---

## 2. Instalación Rápida con Docker (Recomendado Desarrollo)

### Pasos
1.  **Preparar el entorno**:
    ```bash
    cp .env.default .env
    ```
2.  **Levantar servicios**:
    ```bash
    docker-compose up -d --build
    ```
3.  **Importar Base de Datos y Configurar Seguridad**:
    Dado que Docker inicia PostgreSQL con el superusuario `postgres` como dueño de las tablas, importaremos el respaldo con este superusuario y luego crearemos el usuario limitado de desarrollo:
    ```bash
    # A. Importar el respaldo como superusuario postgres
    docker-compose exec -T db psql -U postgres -d unexcadb < "respaldo.sql"

    # B. Crear el usuario limitado para la aplicación en desarrollo (coincidiendo con el .env)
    docker-compose exec -T db psql -U postgres -d unexcadb -c "CREATE USER unexca_user WITH PASSWORD '1234';"

    # C. Aplicar la capa de seguridad para restringir los permisos de unexca_user
    docker-compose exec -T db psql -U postgres -d unexcadb < "scripts/db_security_setup.sql"
    ```

Acceso: **http://localhost:8080**

---

## 4. Acceso al Panel Administrativo (Paso Crítico)

Una vez instalada la aplicación, no existen usuarios por defecto por razones de seguridad. Debe crearlos manualmente utilizando las herramientas en la carpeta `scripts/`.

### A. Aplicar Capa de Seguridad (Ya realizado en pasos previos)
Este paso ya fue completado durante la configuración inicial de la base de datos (Secciones 1 y 2). Si en el futuro necesita re-aplicar esta capa (por ejemplo, tras crear nuevas tablas), puede ejecutar:
```bash
# Docker
docker-compose exec -T db psql -U postgres -d unexcadb < "scripts/db_security_setup.sql"

# Nativo (Debian)
sudo -u postgres psql -d unexcadb < scripts/db_security_setup.sql
```

### B. Crear su Primer Usuario Admin
Utilice el script CLI para generar su cuenta de acceso. Este script se encarga de hashear la contraseña automáticamente (BCRYPT).

**Sintaxis:**
`php scripts/gestionar_usuario.php <usuario> <password> <nombre_completo> <rol_id>`

**Ejemplos:**
```bash
# Crear un Super Administrador (Rol ID 1) en Docker
docker-compose exec app php scripts/gestionar_usuario.php admin admin123 "Administrador Principal" 1

# En entorno Linux nativo/VM
php scripts/gestionar_usuario.php editor clave_segura "Juan Pérez" 2
```

**Roles Disponibles:**
1.  **Super Administrador**: Acceso total.
2.  **Editor de Contenido**: Noticias y Autoridades.
3.  **Coordinador**: Gestión de contactos.

---
