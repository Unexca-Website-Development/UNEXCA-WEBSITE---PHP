class AdministradorEventos {
	constructor() {
		this.eventos = {};
	}

	suscribir(evento, callback) {
		if (!this.eventos[evento]) {
			this.eventos[evento] = [];
		}
		this.eventos[evento].push(callback);
	}

	cancelarSuscripcion(evento, callback) {
		if (!this.eventos[evento]) return;
		this.eventos[evento] = this.eventos[evento].filter(cb => cb !== callback);
	}

	notificar(evento, data = null) {
		if (!this.eventos[evento]) return;
		this.eventos[evento].forEach(callback => callback(data));
	}
}

export const administradorEventos = new AdministradorEventos();