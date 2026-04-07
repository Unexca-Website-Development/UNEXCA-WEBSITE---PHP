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

const inicializarBoton = (boton) => {
  if (boton.dataset.listened === 'true') return;

  boton.addEventListener('mousedown', () => {
    const currentItem = boton.parentElement;
    const activo = currentItem.classList.toggle('activo');
    boton.setAttribute('aria-expanded', activo ? 'true' : 'false');
  });

  boton.dataset.listened = 'true';
};

const observer = new MutationObserver((mutations) => {
  mutations.forEach(() => {
    const botonesNuevos = document.querySelectorAll('.desplegable__titulo');
    botonesNuevos.forEach(boton => inicializarBoton(boton));
  });
});

observer.observe(document.body, {
  childList: true,
  subtree: true
});

// Ejecución inicial por si algunos ya existen al cargar
document.querySelectorAll('.desplegable__titulo').forEach(boton => inicializarBoton(boton));
