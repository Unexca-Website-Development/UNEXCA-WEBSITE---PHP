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

1.  **Acceso a PostgreSQL**:
    ```bash
    sudo -i -u postgres psql
    ```
2.  **Crear base de datos y configurar usuario**:
    ```sql
    CREATE DATABASE unexcadb;
    ALTER USER postgres WITH PASSWORD '1234';
    \q
    ```
3.  **Importar estructura y datos**:
    Asegúrese de que el archivo `respaldo.sql` esté accesible (ej: en `/tmp/`):
    ```bash
    sudo -u postgres psql unexcadb < /tmp/respaldo.sql
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
3.  **Importar Base de Datos**:
    ```bash
    docker-compose exec -T db psql -U unexca_user -d unexcadb < "respaldo.sql"
    ```

Acceso: **http://localhost:8080**

---

## 4. Acceso al Panel Administrativo (Paso Crítico)

Una vez instalada la aplicación, no existen usuarios por defecto por razones de seguridad. Debe crearlos manualmente utilizando las herramientas en la carpeta `scripts/`.

### A. Aplicar Capa de Seguridad (Opcional pero recomendado)
Antes de crear usuarios, puede blindar la base de datos para que el usuario de la web no tenga permisos de borrado de tablas (solo manipulación de datos):
```bash
# Docker
docker-compose exec -T db psql -U unexca_user -d unexcadb < "scripts/db_security_setup.sql"

# Nativo
psql -U unexca_user -d unexcadb < scripts/db_security_setup.sql
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
