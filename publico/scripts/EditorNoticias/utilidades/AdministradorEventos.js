class AdministradorEventos {
	constructor() {
		this.eventos = {};
		console.log('AdministradorEventos inicializado');
	}

	suscrito(evento, callback) {
		if (!this.eventos[evento]) {
			this.eventos[evento] = [];
			console.log(`Creado nuevo grupo de suscriptores para evento: ${evento}`);
		}
		this.eventos[evento].push(callback);
		console.log(`Suscrito callback al evento: ${evento}. Total suscriptores: ${this.eventos[evento].length}`);
	}

	cancelarSuscripcion(evento, callback) {
		if (!this.eventos[evento]) {
			console.log(`Intento de cancelar suscripción a evento inexistente: ${evento}`);
			return;
		}
		this.eventos[evento] = this.eventos[evento].filter(cb => cb !== callback);
		console.log(`Cancelada suscripción al evento: ${evento}. Restantes: ${this.eventos[evento].length}`);
	}

	notificar(evento, data = null) {
		if (!this.eventos[evento]) {
			console.log(`No hay suscriptores para el evento: ${evento}`);
			return;
		}
		console.log(`Notificando evento: ${evento} con data:`, data);
		this.eventos[evento].forEach((callback, i) => {
			console.log(`Ejecutando callback #${i + 1} para evento: ${evento}`);
			callback(data);
		});
	}
}

export const administradorEventos = new AdministradorEventos();
