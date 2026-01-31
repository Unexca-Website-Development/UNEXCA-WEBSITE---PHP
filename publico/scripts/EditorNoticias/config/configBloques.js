const CONFIG_BLOQUES = {
	titulo: {
		tipo: 'titulo',
		texto: 'Título',
		campos: { texto: '' },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_h1.svg',
			inputs: [
				{ tipo: 'textarea', key: 'texto', requerido: true, placeholder: 'Escribe el título aquí...', className: 'editor-noticia__campo-texto' }
			]
		}
	},
	subtitulo: {
		tipo: 'subtitulo',
		texto: 'Subtítulo',
		campos: { texto: '' },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_h2.svg',
			inputs: [
				{ tipo: 'textarea', key: 'texto', requerido: true, placeholder: 'Escribe el Subtítulo aquí...', className: 'editor-noticia__campo-texto' }
			]
		}
	},
	fechas: {
		tipo: 'fechas',
		texto: 'Información de la noticia',
		campos: { creacion: '', modificacion: '', publicacion: '' },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_calendario.svg',
			inputs: [
				{ tipo: 'date', key: 'creacion', requerido: true, className: 'editor-noticia__campo-fecha' },
				{ tipo: 'date', key: 'modificacion', requerido: true, className: 'editor-noticia__campo-fecha' },
				{ tipo: 'date', key: 'publicacion', requerido: true, className: 'editor-noticia__campo-fecha' }
			]
		}
	},
	parrafo: {
		tipo: 'parrafo',
		texto: 'Párrafo',
		campos: { texto: '' },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_parrafo.svg',
			inputs: [
				{ tipo: 'textarea', key: 'texto', requerido: true, placeholder: 'Escribe el párrafo aquí...', className: 'editor-noticia__campo-texto' }
			]
		}
	},
	cita: {
		tipo: 'cita',
		texto: 'Cita',
		campos: { texto: '', autor: '' },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_cita.svg',
			inputs: [
				{ tipo: 'textarea', key: 'texto', requerido: true, placeholder: 'Escribe la cita aquí...', className: 'editor-noticia__campo-texto' },
				{ tipo: 'textarea', key: 'autor', requerido: true, placeholder: 'Autor de la cita', className: 'editor-noticia__campo-texto' }
			]
		}
	},
	lista: {
		tipo: 'lista',
		texto: 'Lista',
		campos: { items: [] },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_lista.svg',
			inputs: [
				{ tipo: 'textarea', key: 'items', requerido: true, placeholder: 'Agrega elementos de la lista...', className: 'editor-noticia__campo-texto' }
			]
		}
	},
	imagen: {
		tipo: 'imagenes',
		texto: 'Imagenes',
		campos: { archivo: '', descripcion: '' },
		ui: {
			icono: '/UNEXCA-WEBSITE---PHP/publico/imagenes/iconos/icon_imagen.svg',
			inputs: [
				{ tipo: 'file', key: 'archivo', aceptar: '.png,.jpg,.jpeg,.webp', requerido: true, className: 'editor-noticia__campo-archivo' },
				{ tipo: 'textarea', key: 'descripcion', requerido: true, placeholder: 'Descripción de la imagen...', className: 'editor-noticia__campo-texto' }
			]
		}
	}
}

export { CONFIG_BLOQUES };