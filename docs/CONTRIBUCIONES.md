[< Volver al README principal](../README.md)

# Guía de Contribuciones

¡Gracias por tu interés en contribuir al proyecto del Portal Web de la UNEXCA! Toda contribución es bienvenida. Para asegurar un proceso fluido y consistente, por favor sigue las siguientes directrices.

## Reporte de Bugs

Si encuentras un bug, por favor, crea un "Issue" en el repositorio de GitHub y proporciona la siguiente información:

-   **Título claro y descriptivo**.
-   **Pasos para reproducir el bug** de la forma más detallada posible.
-   **Comportamiento esperado**: ¿Qué debería haber pasado?
-   **Comportamiento actual**: ¿Qué pasó en realidad?
-   **Capturas de pantalla o videos** si son relevantes.
-   **Entorno**: Navegador, sistema operativo, etc.

## Sugerencias de Mejoras

Si tienes una idea para una nueva funcionalidad o una mejora, crea un "Issue" con la etiqueta `enhancement` y describe tu propuesta en detalle.

## Proceso de Desarrollo (Pull Requests)

Todo el desarrollo debe realizarse en ramas separadas y luego ser integrado a la rama principal (`main` o `develop`) a través de un **Pull Request (PR)**.

1.  **Clona el repositorio y crea una rama**:

    ```bash
    git clone https://github.com/STON3E187/UNEXCA.git
    cd UNEXCA
    git checkout -b nombre-de-tu-funcionalidad
    ```

2.  **Nombra tu rama correctamente**: Usa un prefijo según el tipo de cambio:
    -   `feature/`: para nuevas funcionalidades (ej: `feature/portal-de-pagos`).
    -   `fix/`: para corrección de bugs (ej: `fix/error-en-formulario-contacto`).
    -   `docs/`: para mejoras en la documentación (ej: `docs/actualizar-readme`).

3.  **Escribe código limpio**: Asegúrate de que tu código sigue las convenciones y el estilo del proyecto, como se describe en la [documentación de Arquitectura](./ARQUITECTURA.md).

4.  **Actualiza la documentación**: Si tus cambios lo requieren, actualiza los archivos de documentación correspondientes. Por ejemplo, si añades una nueva página, debes actualizar el [Sistema de Enrutamiento](./ENRUTAMIENTO.md).

5.  **Haz commits atómicos**: Realiza commits pequeños y enfocados en un solo cambio. Escribe mensajes de commit claros y descriptivos.

    **Formato de Mensajes de Commit:**

    Usa el formato [Conventional Commits](https://www.conventionalcommits.org/).

    ```
    <tipo>[ámbito opcional]: <descripción>

    [cuerpo opcional]

    [pie opcional]
    ```

    **Ejemplos:**

    ```
    feat(carreras): añade el campo de "modalidad" a las carreras

    Se ha modificado el modelo, la vista y el controlador para incluir la modalidad de estudio (presencial, semi-presencial) en la información de cada carrera.
    ```

    ```
    fix(header): corrige el z-index del menú desplegable en móviles
    ```

6.  **Envía tu Pull Request**: Una vez que termines, sube tu rama a GitHub y crea un Pull Request. En la descripción del PR, explica qué problema resuelves y cómo lo hiciste.

7.  **Revisión de código**: Tu PR será revisado por al menos un miembro del equipo. Prepárate para recibir feedback y realizar cambios si es necesario.

¡Gracias por hacer de este un mejor proyecto!