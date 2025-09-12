[< Volver al README principal](../README.md)

# Frontend

La capa de presentación del proyecto se compone de archivos CSS y JavaScript, organizados para facilitar su mantenimiento. Todos los recursos de frontend son servidos desde el directorio `/publico`, como se explica en la [documentación de Arquitectura](./ARQUITECTURA.md).

## Estilos (CSS)

La estructura de los estilos sigue una metodología de componentes, separando los estilos generales, de páginas y de componentes reutilizables.

-   **`publico/estilos/index.css`**: Es el punto de entrada principal para los estilos. Utiliza la directiva `@import` para incluir todos los demás archivos CSS necesarios. El orden de importación es crucial para la cascada de estilos.

-   **`publico/estilos/paginas/general.css`**: Contiene los estilos base de la aplicación, como la definición de variables de color (`:root`), estilos para el `body`, tipografías y clases de utilidad general.

-   **`publico/estilos/componentes/`**: Este directorio alberga los estilos para componentes de la interfaz que se repiten en varias páginas. Ejemplos:
    -   `header.css`: Estilos para la barra de navegación.
    -   `footer.css`: Estilos para el pie de página.
    -   `botones.css`: Estilos para los diferentes tipos de botones.
    -   `desplegable.css`: Estilos para los menús desplegables.

-   **`publico/estilos/paginas/`**: Contiene los estilos que son específicos de una página en particular. Ejemplos:
    -   `inicio.css`: Estilos para el "hero" y las secciones de la página de inicio.
    -   `carrera.css`: Estilos para la vista de detalle de una carrera.
    -   `contactos.css`: Estilos para las tarjetas de contacto.

## Scripts (JavaScript)

Los archivos JavaScript se encargan de añadir interactividad al sitio web. Cada archivo tiene una responsabilidad única.

-   **`publico/scripts/headerScroll.js`**: Añade un efecto visual al header. Cuando el usuario hace scroll vertical, este script añade la clase `header--scroll` al elemento `<header>`, permitiendo que los estilos cambien (por ejemplo, añadiendo un fondo de color).

-   **`publico/scripts/desplegables.js`**: Controla la lógica de los menús desplegables en la barra de navegación. Escucha los clics para mostrar u ocultar los sub-menús.

-   **`publico/scripts/slider.js`**: Implementa un carrusel o slider de imágenes simple. Este script cambia las imágenes en un intervalo de tiempo definido.

## Imágenes

Todas las imágenes y otros recursos visuales se encuentran en `publico/imagenes/`, organizados en subcarpetas según su contexto:

-   `autoridades/`: Fotos de las autoridades.
-   `carreras/`: Imágenes representativas de cada carrera.
-   `iconos/`: Iconos utilizados en toda la web (redes sociales, flechas, etc.).
-   `logos/`: Logos de la universidad.
-   `nucleos/`: Fotos de los diferentes núcleos de la universidad.