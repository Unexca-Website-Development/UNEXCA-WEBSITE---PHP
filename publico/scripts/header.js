class Header {
		constructor({ selectorContenedor = '.header', selectorBotonPrincipal = '.header__boton-menu', selectorSubmenu = '.header__link-boton', claseActiva = 'activo', umbralScroll = 10 } = {}) {
				this.contenedor = document.querySelector(selectorContenedor);
				if (!this.contenedor) return;

				this.claseActiva = claseActiva;
				this.umbralScroll = umbralScroll;
				this.ultimoScrollY = window.pageYOffset;
				this.enEspera = false;

				this.botonesPrincipales = Array.from(this.contenedor.querySelectorAll(selectorBotonPrincipal));
				this.botonesSubmenu = Array.from(this.contenedor.querySelectorAll(selectorSubmenu));

				this.inicializarBotones(this.botonesPrincipales, selectorContenedor);
				this.inicializarBotones(this.botonesSubmenu, '.header__menu-item--con-submenu');

				this.inicializarScroll();
		}

		inicializarBotones(botones, selectorContenedor) {
				botones.forEach(boton => {
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

		alternar(boton, selectorContenedor) {
				const contenedor = boton.closest(selectorContenedor);
				if (!contenedor) return;

				const estaActivo = contenedor.classList.toggle(this.claseActiva);
				boton.setAttribute('aria-expanded', estaActivo ? 'true' : 'false');

				const nav = contenedor.querySelector('.header__nav');
				const overlay = contenedor.querySelector('.overlay');

				if (estaActivo) {
						if (overlay) overlay.addEventListener('click', () => this.cerrar(contenedor, boton), { once: true });
						this.agregarManejadorTeclas(contenedor, boton, nav);
				} else {
						this.removerManejadorTeclas(contenedor);
				}
		}

		cerrar(contenedor, boton) {
				contenedor.classList.remove(this.claseActiva);
				boton.setAttribute('aria-expanded', 'false');
				this.removerManejadorTeclas(contenedor);
		}

		agregarManejadorTeclas(contenedor, boton, nav) {
				const manejador = e => {
						if (e.key === 'Escape') this.cerrar(contenedor, boton);
						if (e.key === 'Tab') {
								const elementos = [contenedor.querySelector('.header__boton-menu'), ...Array.from(nav.querySelectorAll('a, button')).filter(el => el.offsetParent !== null)];
								if (elementos.length === 0) return;

								const primero = elementos[0];
								const ultimo = elementos[elementos.length - 1];

								if (e.shiftKey && document.activeElement === primero) e.preventDefault(), ultimo.focus();
								else if (!e.shiftKey && document.activeElement === ultimo) e.preventDefault(), primero.focus();
						}
				};
				document.addEventListener('keydown', manejador);
				contenedor._manejadorTeclas = manejador;
		}

		removerManejadorTeclas(contenedor) {
				if (contenedor._manejadorTeclas) {
						document.removeEventListener('keydown', contenedor._manejadorTeclas);
						delete contenedor._manejadorTeclas;
				}
		}

		inicializarScroll() {
				window.addEventListener('scroll', () => this.alHacerScroll());
		}

		alHacerScroll() {
				if (!this.enEspera) {
						window.requestAnimationFrame(() => this.actualizarScroll());
						this.enEspera = true;
				}
		}

		actualizarScroll() {
				const scrollY = window.pageYOffset;
				if (Math.abs(scrollY - this.ultimoScrollY) < this.umbralScroll) {
						this.enEspera = false;
						return;
				}

				if (scrollY > this.ultimoScrollY) this.contenedor.classList.add('header--oculto');
				else this.contenedor.classList.remove('header--oculto');

				this.ultimoScrollY = scrollY > 0 ? scrollY : 0;
				this.enEspera = false;
		}
}

// Instancia
new Header({
		selectorContenedor: '.header',
		selectorBotonPrincipal: '.header__boton-menu',
		selectorSubmenu: '.header__link-boton',
		umbralScroll: 10
});
