/**
 * desplegables.js
 *
 * Controla la apertura y cierre de los elementos desplegables de la interfaz.
 *
 * Funcionamiento:
 * - Selecciona todos los botones con clase `.desplegable__titulo`.
 * - Al hacer clic (mousedown) en un botón:
 *    1. Alterna la clase `activo` en su contenedor padre (`.desplegable__item`), mostrando u ocultando el contenido.
 *    2. Actualiza el atributo `aria-expanded` a "true" o "false" para accesibilidad.
 *
 * Nota:
 * - El código comentado permite cerrar otros desplegables automáticamente, pero actualmente está desactivado.
 * - Cada bloque desplegable funciona de manera independiente.
 */

const botones = document.querySelectorAll('.desplegable__titulo');

botones.forEach(boton => {
  boton.addEventListener('mousedown', () => {
    const currentItem = boton.parentElement;

    // // Cerrar otros
    // botones.forEach(b => {
    //   if (b !== boton) {
    //     b.parentElement.classList.remove('activo');
    //     b.setAttribute('aria-expanded', 'false');
    //   }
    // });

    // Alternar actual
    const activo = currentItem.classList.toggle('activo');
    boton.setAttribute('aria-expanded', activo ? 'true' : 'false');
  });
});
