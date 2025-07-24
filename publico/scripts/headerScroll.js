function iniciarDireccionScroll({ direccionInicial = "arriba", umbralPixeles = 0, desactivado = false } = {}) {
  let ultimoScrollY = window.pageYOffset;
  let direccionScroll = direccionInicial;
  let enEspera = false;

  const SCROLL_ARRIBA = "arriba";
  const SCROLL_ABAJO = "abajo";

  const header = document.querySelector(".header");

  const actualizarDireccionScroll = () => {
    const scrollY = window.pageYOffset;

    if (Math.abs(scrollY - ultimoScrollY) < umbralPixeles) {
      enEspera = false;
      return;
    }

    direccionScroll = scrollY > ultimoScrollY ? SCROLL_ABAJO : SCROLL_ARRIBA;

    if (direccionScroll === SCROLL_ABAJO) {
      header.classList.add("header--oculto");
    } else {
      header.classList.remove("header--oculto");
    }

    ultimoScrollY = scrollY > 0 ? scrollY : 0;
    enEspera = false;
  };

  const alHacerScroll = () => {
    if (!enEspera) {
      window.requestAnimationFrame(actualizarDireccionScroll);
      enEspera = true;
    }
  };

  if (!desactivado) {
    window.addEventListener("scroll", alHacerScroll);
  }
}

iniciarDireccionScroll({ umbralPixeles: 10 });