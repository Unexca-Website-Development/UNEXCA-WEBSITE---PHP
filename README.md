# Portal Web UNEXCA

Este repositorio contiene el código fuente del portal web de la Universidad Nacional Experimental de la Gran Caracas (UNEXCA). El proyecto está desarrollado en PHP puro, sin el uso de frameworks, pero sigue una estructura de software robusta y organizada, inspirada en el patrón **Modelo-Vista-Controlador-Servicio (MVC-S)**.

## Documentación Detallada

Para entender a fondo el funcionamiento del proyecto, consulta los siguientes documentos en el directorio `/docs`:

-   [**Instalación y Configuración**](./docs/INSTALACION.md): Guía completa para levantar el entorno (Docker, VM o Nativo).
-   [**Arquitectura del Software**](./docs/ARQUITECTURA.md): Explicación de la estructura MVC-S y el flujo de peticiones.
-   [**Base de Datos**](./docs/BASE_DE_DATOS.md): Esquema detallado, tablas y sistema de persistencia.
-   [**Frontend**](./docs/FRONTEND.md): Organización de archivos CSS y JavaScript.
-   [**Guía del Administrador**](./docs/GUIA_ADMINISTRACION.md): Manual para la gestión de contenidos y usuarios.
-   [**Guía del Desarrollador**](./docs/GUIA_DESARROLLADOR.md): Estándares de código y cómo extender el sistema.
-   [**Guía de Contribuciones**](./docs/CONTRIBUCIONES.md): Flujo de trabajo con Git y Pull Requests.

## Guía de Inicio Rápido (Docker)

La forma más rápida y recomendada de levantar el proyecto es utilizando **Docker**.

### Prerrequisitos
- Docker Desktop instalado.
- Terminal (PowerShell, Bash o similar).

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

El portal estará disponible en: **[http://localhost:8080](http://localhost:8080)**

---

## Otras Opciones de Instalación

Si prefieres instalar el proyecto de forma manual (XAMPP, Apache nativo o Máquina Virtual), consulta la **[Guía Completa de Instalación](./docs/INSTALACION.md)**, donde encontrarás instrucciones detalladas para:
- Configuración de Virtual Hosts en Apache.
- Habilitación de extensiones de PostgreSQL en PHP.
- Ajuste de permisos en sistemas Linux/Debian.
- Gestión de usuarios administrativos vía CLI.

## Recursos Adicionales

-   **Repositorio en GitHub:** [https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP](https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP)
-   **Diseño en Figma:** [https://www.figma.com/design/KzSglgJztrNkANfjoNDBPn/Pagina-de-la-UNEXCA--2025-](https://www.figma.com/design/KzSglgJztrNkANfjoNDBPn/Pagina-de-la-UNEXCA--2025-)

---
*Por el amor a la automatización y al código limpio.* :heart: :computer: