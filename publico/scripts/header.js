class Header {
	constructor({ selectorContenedor = '.header', selectorBotonPrincipal = '.header__boton-menu', selectorSubmenu = '.header__link-boton', claseActiva = 'activo', umbralScroll = 10 } = {}) {
		// Contenedor principal del header
		this.contenedor = document.querySelector(selectorContenedor);
		if (!this.contenedor) return;

		this.claseActiva = claseActiva;
		this.umbralScroll = umbralScroll;
		this.ultimoScrollY = window.pageYOffset;
		this.enEspera = false;

		// Botones principales del header (menú hamburguesa)
		this.botonesPrincipales = Array.from(this.contenedor.querySelectorAll(selectorBotonPrincipal));
		// Botones de submenú dentro del header
		this.botonesSubmenu = Array.from(this.contenedor.querySelectorAll(selectorSubmenu));

		// Inicializar eventos de botones
		this.inicializarBotones(this.botonesPrincipales, selectorContenedor);
		this.inicializarBotones(this.botonesSubmenu, '.header__menu-item--con-submenu');

		// Inicializar comportamiento al hacer scroll
		this.inicializarScroll();
	}

	// Agrega eventos a los botones para abrir/cerrar menú o submenú
	inicializarBotones(botones, selectorContenedor) {
		botones.forEach(boton => {
			// Click o presionar Enter/Espacio
			boton.addEventListener('mousedown', e => {
				e.preventDefault();
				this.alternar(boton, selectorContenedor);
			});

			boton.addEventListener('keydown', e => {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					this.alternar(boton, selectorContenedor);
				}
			});
		});
	}

	// Alterna la visibilidad del menú/submenú
	alternar(boton, selectorContenedor) {
		const contenedor = boton.closest(selectorContenedor);
		if (!contenedor) return;

		const estaActivo = contenedor.classList.toggle(this.claseActiva);
		boton.setAttribute('aria-expanded', estaActivo ? 'true' : 'false');

		const nav = contenedor.querySelector('.header__nav');
		const overlay = contenedor.querySelector('.overlay');

		if (estaActivo) {
			// Cerrar al hacer click fuera
			if (overlay) overlay.addEventListener('click', () => this.cerrar(contenedor, boton), { once: true });
			// Agregar control de teclado
			this.agregarManejadorTeclas(contenedor, boton, nav);
		} else {
			this.removerManejadorTeclas(contenedor);
		}
	}

	// Cierra menú y remueve eventos de teclado
	cerrar(contenedor, boton) {
		contenedor.classList.remove(this.claseActiva);
		boton.setAttribute('aria-expanded', 'false');
		this.removerManejadorTeclas(contenedor);
	}

	// Agrega eventos de teclado para accesibilidad (Escape y Tab)
	agregarManejadorTeclas(contenedor, boton, nav) {
		const manejador = e => {
			if (e.key === 'Escape') this.cerrar(contenedor, boton);

			if (e.key === 'Tab') {
				const elementos = [contenedor.querySelector('.header__boton-menu'), ...Array.from(nav.querySelectorAll('a, button')).filter(el => el.offsetParent !== null)];
				if (elementos.length === 0) return;

				const primero = elementos[0];
				const ultimo = elementos[elementos.length - 1];

				// Ciclar foco si se pasa del primer o último elemento
				if (e.shiftKey && document.activeElement === primero) e.preventDefault(), ultimo.focus();
				else if (!e.shiftKey && document.activeElement === ultimo) e.preventDefault(), primero.focus();
			}
		};
		document.addEventListener('keydown', manejador);
		contenedor._manejadorTeclas = manejador;
	}

	// Remueve el manejador de teclado agregado
	removerManejadorTeclas(contenedor) {
		if (contenedor._manejadorTeclas) {
			document.removeEventListener('keydown', contenedor._manejadorTeclas);
			delete contenedor._manejadorTeclas;
		}
	}

	// Inicializa evento para ocultar/mostrar header al hacer scroll
	inicializarScroll() {
		window.addEventListener('scroll', () => this.alHacerScroll());
	}

	// Controla la ejecución eficiente con requestAnimationFrame
	alHacerScroll() {
		if (!this.enEspera) {
			window.requestAnimationFrame(() => this.actualizarScroll());
			this.enEspera = true;
		}
	}

	// Actualiza la posición del header según la dirección del scroll
	actualizarScroll() {
		const scrollY = window.pageYOffset;

		// Ignorar scroll pequeño
		if (Math.abs(scrollY - this.ultimoScrollY) < this.umbralScroll) {
			this.enEspera = false;
			return;
		}

		// Ocultar si se baja, mostrar si se sube
		if (scrollY > this.ultimoScrollY) this.contenedor.classList.add('header--oculto');
		else this.contenedor.classList.remove('header--oculto');

		this.ultimoScrollY = scrollY > 0 ? scrollY : 0;
		this.enEspera = false;
	}
}

// Crear instancia del header
new Header({
	selectorContenedor: '.header',
	selectorBotonPrincipal: '.header__boton-menu',
	selectorSubmenu: '.header__link-boton',
	umbralScroll: 10
});
