function activarBotones({botonSelector, contenedorSelector, clase = 'activo'}) {
  const botones = document.querySelectorAll(botonSelector);

  botones.forEach(boton => {
    boton.addEventListener('mousedown', () => {
      const contenedor = boton.closest(contenedorSelector);
      if (!contenedor) return;
      const activo = contenedor.classList.toggle(clase);
      boton.setAttribute('aria-expanded', activo ? 'true' : 'false');
    });
  });
}

activarBotones({
  botonSelector: '.header__boton-menu',
  contenedorSelector: '.header',
});

activarBotones({
  botonSelector: '.header__link-boton',
  contenedorSelector: '.header__menu-item--con-submenu',
});