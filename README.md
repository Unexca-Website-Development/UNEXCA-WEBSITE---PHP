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

-   Un servidor web como Apache o Nginx.
-   PHP 7.4 o superior.
-   PostgreSQL.
-   Git.

### Pasos

1.  **Clonar el Repositorio**: Clona el proyecto en el directorio de tu servidor web (ej: `htdocs` en XAMPP).

    ```bash
    git clone https://github.com/STON3E187/UNEXCA.git
    ```

2.  **Base de Datos**:
    -   Asegúrate de que tu servidor de PostgreSQL esté en ejecución.
    -   Crea una nueva base de datos (ej: `unexca`).
    -   Importa la estructura de las tablas usando el script que se encuentra en `docs/BASE_DE_DATOS.md`.

3.  **Configurar la Conexión**:
    -   Abre el archivo `modelo/conexiondb.php`.
    -   Actualiza las credenciales (`$host`, `$puerto`, `$nombredb`, `$usuario`, `$clave`) para que coincidan con la configuración de tu base de datos PostgreSQL.

    > **⚠️ Advertencia de Inconsistencia:**
    > El archivo `modelo/conexiondb.php` en la rama actual podría estar usando `mysqli` (para MySQL) en lugar de `pgsql` (para PostgreSQL). Esto es un error conocido. Asegúrate de que el código de conexión utilice **PDO con el driver `pgsql`** como se documenta en `docs/BASE_DE_DATOS.md` para que el sistema funcione correctamente.

4.  **Acceder al Proyecto**: Abre tu navegador y visita la URL correspondiente a la carpeta `publico` de tu proyecto (ej: `http://localhost/UNEXCA/publico/`).

## Recursos Adicionales

-   **Repositorio en GitHub:** [https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP](https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP)
-   **Diseño en Figma:** [https://www.figma.com/design/KzSglgJztrNkANfjoNDBPn/Pagina-de-la-UNEXCA--2025-](https://www.figma.com/design/KzSglgJztrNkANfjoNDBPn/Pagina-de-la-UNEXCA--2025-)

---
*Por el amor a la automatización y al código limpio.* :heart: :computer: