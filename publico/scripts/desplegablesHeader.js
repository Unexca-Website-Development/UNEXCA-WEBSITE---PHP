function activarBotones({selectorBoton, selectorContenedor, claseActiva = 'activo'}) {
  const botones = document.querySelectorAll(selectorBoton);

  botones.forEach(boton => {
    const alternar = () => {
      const contenedor = boton.closest(selectorContenedor);
      if (!contenedor) return;
      const activo = contenedor.classList.toggle(claseActiva);
      boton.setAttribute('aria-expanded', activo ? 'true' : 'false');
    };

    boton.addEventListener('mousedown', evento => {
      evento.preventDefault();
      alternar();
    });

    boton.addEventListener('keydown', evento => {
      if (evento.key === 'Enter' || evento.key === ' ' || evento.key === 'Spacebar') {
        evento.preventDefault();
        alternar();
      }
    });
  });
}

activarBotones({
  selectorBoton: '.header__boton-menu',
  selectorContenedor: '.header',
});

activarBotones({
  selectorBoton: '.header__link-boton',
  selectorContenedor: '.header__menu-item--con-submenu',
});
