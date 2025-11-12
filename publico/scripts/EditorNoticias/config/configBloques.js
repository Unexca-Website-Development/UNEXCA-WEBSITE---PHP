const CONFIG_BLOQUES = {
	titulo: {
		tipo: 'titulo',
		texto: 'Título',
		campos: {
			texto: { valorInicial: '', requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_h1.svg',
			placeholder: 'Escribe el título aquí...',
			inputs: [
				{
					tipo: 'textarea',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				}
			]
		}
	},
	subtitulo: {
		tipo: 'subtitulo',
		texto: 'Subtítulo',
		campos: {
			texto: { valorInicial: '', requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_h2.svg',
			placeholder: 'Escribe el Subtítulo aquí...',
			inputs: [
				{
					tipo: 'textarea',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				}
			]
		}
	},
	fechas: {
		tipo: 'fechas',
		texto: 'Información de la noticia',
		campos: {
			creacion: { valorInicial: '', requerido: true },
			modificacion: { valorInicial: '', requerido: true },
			publicacion: { valorInicial: '', requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_calendario.svg',
			inputs: [
				{
					tipo: 'date',
					requerido: true,
					className: 'editor-noticia__campo-fecha'
				}
			]
		}
	},
	parrafo: {
		tipo: 'parrafo',
		texto: 'Párrafo',
		campos: {
			texto: { valorInicial: '', requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_parrafo.svg',
			placeholder: 'Escribe el párrafo aquí...',
			inputs: [
				{
					tipo: 'textarea',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				}
			]
		}
	},
	cita: {
		tipo: 'cita',
		texto: 'Cita',
		campos: {
			texto: { valorInicial: '', requerido: true },
			autor: { valorInicial: '', requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_cita.svg',
			placeholder: 'Escribe la cita aquí...',
			inputs: [
				{
					tipo: 'textarea',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				},
				{
					tipo: 'text',
					placeholder: 'Autor de la cita',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				}
			]
		}
	},
	lista: {
		tipo: 'lista',
		texto: 'Lista',
		campos: {
			items: { valorInicial: [], requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_lista.svg',
			placeholder: 'Agrega elementos de la lista...',
			inputs: [
				{
					tipo: 'textarea',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				}
			]
		}
	},
	imagen: {
		tipo: 'imagen',
		texto: 'Imagen',
		campos: {
			archivo: { valorInicial: null, requerido: true },
			descripcion: { valorInicial: '', requerido: true }
		},
		ui: {
			icono: '/imagen/iconos/icon_imagen.svg',
			inputs: [
				{
					tipo: 'file',
					aceptar: '.png,.jpg,.jpeg,.webp',
					requerido: true,
					className: 'editor-noticia__campo-archivo'
				},
				{
					tipo: 'textarea',
					placeholder: 'Descripción de la imagen...',
					requerido: true,
					className: 'editor-noticia__campo-texto'
				}
			]
		}
	}
}

export { CONFIG_BLOQUES };