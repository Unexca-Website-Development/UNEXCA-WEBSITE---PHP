# Portal Web UNEXCA

Este repositorio contiene el código fuente del portal web de la Universidad Nacional Experimental de la Gran Caracas (UNEXCA). El proyecto está desarrollado en PHP puro, sin el uso de frameworks, pero sigue una estructura de software robusta y organizada, inspirada en el patrón **Modelo-Vista-Controlador-Servicio (MVC-S)**.

## Documentación Detallada

Para entender a fondo el funcionamiento del proyecto, consulta los siguientes documentos en el directorio `/docs`:

-   [**Arquitectura del Software**](./docs/ARQUITECTURA.md): Explicación de la estructura MVC-S, el flujo de las peticiones y la responsabilidad de cada directorio.
-   [**Base de Datos**](./docs/BASE_DE_DATOS.md): Esquema de la base de datos (PostgreSQL), descripción de las tablas y detalles sobre la conexión.
-   [**Sistema de Enrutamiento**](./docs/ENRUTAMIENTO.md): Guía sobre el sistema de enrutamiento, cómo se gestionan las URLs y cómo añadir nuevas páginas.
-   [**Frontend**](./docs/FRONTEND.md): Documentación sobre la organización de los archivos CSS y JavaScript.
-   [**Guía de Contribuciones**](./docs/CONTRIBUCIONES.md): Guía para desarrolladores que deseen contribuir al proyecto, incluyendo estándares de código y flujo de trabajo con Git.

## Guía de Instalación Rápida

Esta guía te ayudará a configurar tu entorno de desarrollo para trabajar en el proyecto.

### Requisitos

-   El servidor web Apache.
-   PHP 7.4 o superior.
-   PostgreSQL.
-   Git.

### Pasos

1.  **Clonar el Repositorio**:
    - Clona el proyecto en el directorio de tu servidor web (ej: `C:\xampp\htdocs` en XAMPP(Windows) y `/var/www/html` en Linux).
    - ```bash
      git clone https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP.git
      ```
    - Cambiar el nombre de la carpeta del proyecto a `unexca`
3. **Configuración de entorno**
   - xampp(Windows):
     - En la ubicación `C:\xampp\php\php.ini` descomentar las lineas `;extension=pdo_odbc` y `;extension=pdo_pgsql` (quitando el punto y coma), y guardar
     - En la ubicación `C:\xampp\apache\conf\extra\httpd-vhosts.conf` agregar el siguiente codigo
       ```bash
        <VirtualHost *:80>
            ServerName localhost
            DocumentRoot C:\xampp\htdocs\unexca\publico
            <Directory C:\xampp\htdocs\unexca\publico>
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>    
        ```
    - Linux:
       - En la ubicación `/etc/apache2/sites-available/000-default.conf` Agregar el siguiente codigo
         ```bash
          <VirtualHost *:80>
              ServerName localhost
              DocumentRoot /var/www/html/unexca/publico
              <Directory /var/www/html/unexca/publico>
                  AllowOverride All
                  Require all granted
              </Directory>
          </VirtualHost>  
          ```
    ### Nota: En caso de que ya exista un `<VirtualHost *:80>` borrar o comentar todo y pegar el codigo

5. **Verificar estado de los servicios requeridos**
    - Linux: 
      -   `systemctl status postgresql`
      -   `systemctl status apache2 `
      -   `systemctl status php7.4-fpm `
    - Windows:
      - `sc query "postgresql-x64-18"` el 18 se debe cambiar por la versión instalada de postgres
      - En xampp habilitar el servicio apache
   
2.  **Base de Datos**:
    -   Asegúrate de que tu servidor de PostgreSQL esté en ejecución.
    -   Crear la base de datos unexca con el comando `createdb -U postgres unexca`
    -   Restaurar la base de datos:
        - Descargar la base de datos actualizada y descomprimirla
        - Acceder a la nueva carpeta y abrir una terminal
        - Ingresar el comando `pg_restore -U postgres -d unexca "UNEXCA - DB RESPALDO OCTUBRE.sql" `
      
3.  **Configurar la Conexión**:
    -   Abre el archivo `modelo/conexiondb.php`.
    -   Actualiza las credenciales (`$host`, `$puerto`, `$nombredb`, `$usuario`, `$clave`) para que coincidan con la configuración de tu base de datos PostgreSQL.

    > **⚠️ Advertencia de Inconsistencia:**
    > El archivo `modelo/conexiondb.php` en la rama actual podría estar usando `mysqli` (para MySQL) en lugar de `pgsql` (para PostgreSQL). Esto es un error conocido. Asegúrate de que el código de conexión utilice **PDO con el driver `pgsql`** como se documenta en `docs/BASE_DE_DATOS.md` para que el sistema funcione correctamente.

4.  **Acceder al Proyecto**: Abre tu navegador y visita la URL `http://127.0.0.1/` 

## Recursos Adicionales

-   **Repositorio en GitHub:** [https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP](https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP)
-   **Diseño en Figma:** [https://www.figma.com/design/KzSglgJztrNkANfjoNDBPn/Pagina-de-la-UNEXCA--2025-](https://www.figma.com/design/KzSglgJztrNkANfjoNDBPn/Pagina-de-la-UNEXCA--2025-)

---
*Por el amor a la automatización y al código limpio.* :heart: :computer: