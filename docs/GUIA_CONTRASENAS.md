# Guía para la Gestión de Usuarios y Contraseñas

Esta guía detalla el procedimiento profesional para crear, actualizar y gestionar los usuarios administrativos y sus permisos en el Portal UNEXCA, utilizando las herramientas automatizadas del proyecto.

## Principio Fundamental de Seguridad

El sistema utiliza el algoritmo **BCRYPT** para el hash de contraseñas. Por seguridad, las contraseñas nunca se almacenan en texto plano. La gestión debe realizarse siempre a través de los scripts de la aplicación para garantizar la integridad de los datos y el sistema de roles (RBAC).

---

## 1. La Herramienta de Gestión (CLI)

Se ha creado un script especializado en `scripts/gestionar_usuario.php` que automatiza el hasheo, la creación del registro y la asignación de roles.

**Parámetros requeridos:**
`php gestionar_usuario.php <usuario> <password> <nombre_completo> <rol_id>`

---

## 2. Uso en Entorno de Desarrollo (Docker)

Para crear o actualizar un usuario en tu computadora local:

```bash
docker-compose exec app php scripts/gestionar_usuario.php admin admin123 "Administrador Principal" 1
```

*   **admin**: El nombre de usuario para el login.
*   **admin123**: La contraseña (el script se encargará de hashearla).
*   **"Administrador Principal"**: Nombre que se mostrará en el panel.
*   **1**: ID del rol (Normalmente 1 es Super Administrador).

---

## 3. Uso en Entorno de Producción (Debian)

1.  Conéctate a tu servidor vía SSH.
2.  Ve a la carpeta del proyecto.
3.  Ejecuta el script directamente con PHP:

```bash
php scripts/gestionar_usuario.php coordinador clave_segura "Nombre del Coordinador" 3
```

---

## 4. Gestión de Roles y Permisos (RBAC)

El sistema ahora soporta múltiples roles por usuario. El script de gestión asignará el rol indicado al usuario. Los IDs de roles por defecto son:

1.  **Super Administrador**: Acceso total.
2.  **Editor de Contenido**: Noticias y Autoridades.
3.  **Coordinador**: Gestión de contactos.

> **Nota:** Si un usuario ya existe, el script actualizará su contraseña, nombre y rol al ejecutar el comando con el mismo nombre de usuario.

---

## Notas Importantes de Seguridad

*   **Tabla Usuarios**: La columna `password` debe ser siempre `VARCHAR(255)`.
*   **Mínimo Privilegio**: No asigne el rol ID 1 (Super Admin) a menos que sea estrictamente necesario.
*   **Entorno**: Siempre genere los usuarios dentro del entorno donde residirá la base de datos (Docker para local, PHP nativo para producción).
