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
