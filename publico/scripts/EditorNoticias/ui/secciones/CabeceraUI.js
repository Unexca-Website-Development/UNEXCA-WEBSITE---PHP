import EditorControlador from '../../controladores/EditorControlador.js'
import { crearLabelBloque, crearTextareaBloque, crearInputBloque } from '../utilidadesUI.js'
import { administradorEventos } from '../../utilidades/AdministradorEventos.js'
import { CONFIG_RUTAS } from '../../config/configRutas.js'

export default class CabeceraUI {
	constructor() {
		this.controlador = new EditorControlador()
		this.elemento = null
		this.campos = {}
	}

	async renderizar() {
		const form = document.createElement('form')
		form.className = 'editor-noticia__seccion'

		const boton = document.createElement('button')
		boton.type = 'button'
		boton.className = 'editor-noticia__boton-desplegable'
		boton.innerHTML = '<span class="editor-noticia__titulo-seccion">Titular de la noticia</span>'

		const desplegable = document.createElement('div')
		desplegable.className = 'editor-noticia__contenido-desplegable'

		const contenedorBloques = document.createElement('div')
		contenedorBloques.className = 'editor-noticia__contenido-bloques -estaticos'

		contenedorBloques.appendChild(await this._crearBloqueCampo({
			id: 'titulo_principal',
			label: 'Título',
			icono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.titulo,
			campos: [
				{ tipo: 'textarea', key: 'titulo_principal', placeholder: 'Escribe el título aquí...', requerido: true }
			]
		}))

		contenedorBloques.appendChild(await this._crearBloqueCampo({
			id: 'descripcion_corta',
			label: 'Descripción Corta',
			icono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.parrafo,
			campos: [
				{ tipo: 'textarea', key: 'descripcion_corta', placeholder: 'Escribe la descripción corta aquí...', requerido: true }
			]
		}))

		contenedorBloques.appendChild(await this._crearBloqueCampo({
			id: 'imagen_principal',
			label: 'Imagen Principal',
			icono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.imagen,
			campos: [
				{ tipo: 'file', key: 'imagen_principal', aceptar: '.png,.jpg,.jpeg,.webp', requerido: true },
				{ tipo: 'textarea', key: 'descripcion_imagen', placeholder: 'Descripción de la imagen...', requerido: false }
			]
		}))

		contenedorBloques.appendChild(await this._crearBloqueExtras())

		desplegable.appendChild(contenedorBloques)
		form.appendChild(boton)
		form.appendChild(desplegable)

		this.elemento = form

		administradorEventos.suscrito('cabeceraActualizada', (datos) => {
			this._sincronizar(datos)
		})

		administradorEventos.suscrito('estadoActualizado', (estado) => {
			if (this.campos['estado']) this.campos['estado'].value = estado
		})

		return form
	}

	_sincronizar(datos) {
		for (const key in datos) {
			const el = this.campos[key]
			if (!el) continue
			if (el.type === 'file') continue
			el.value = datos[key] ?? ''
		}
	}

	async _crearBloqueCampo({ id, label, icono, campos }) {
		const bloque = document.createElement('div')
		bloque.className = 'editor-noticia__bloque'

		const labelEl = await crearLabelBloque(id, label, icono)
		bloque.appendChild(labelEl)

		for (const campo of campos) {
			if (campo.tipo === 'textarea') {
				const el = crearTextareaBloque(campo.key, campo.key, campo.placeholder, campo.requerido)
				el.name = campo.key
				this.campos[campo.key] = el
				bloque.appendChild(el)
				el.addEventListener('input', () => {
					this.controlador.actualizarCabecera(campo.key, el.value)
				})
			}

			if (campo.tipo === 'file') {
				const el = crearInputBloque(campo.key, campo.key, 'file', campo.requerido, campo.aceptar)
				el.name = campo.key
				this.campos[campo.key] = el
				bloque.appendChild(el)
				el.addEventListener('change', async () => {
					const archivo = el.files[0]
					if (!archivo) return
					const formData = new FormData()
					formData.append('imagen', archivo)
					const resp = await fetch('/api/subir-imagen.php', { method: 'POST', body: formData })
					const data = await resp.json()
					if (data.url) this.controlador.establecerImagenPrincipal(data.url)
				})
			}
		}

		return bloque
	}

	async _crearBloqueExtras() {
		const bloque = document.createElement('div')
		bloque.className = 'editor-noticia__bloque'

		const labelEl = await crearLabelBloque('fecha_publicacion', 'Información Adicional', CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.fechas)
		bloque.appendChild(labelEl)

		const fecha = crearInputBloque('fecha_publicacion', 'fecha_publicacion', 'date', true)
		fecha.name = 'fecha_publicacion'
		this.campos['fecha_publicacion'] = fecha
		bloque.appendChild(fecha)
		fecha.addEventListener('change', () => {
			this.controlador.actualizarCabecera('fecha_publicacion', fecha.value)
		})

		const select = document.createElement('select')
		select.name = 'estado'
		select.className = 'editor-noticia__campo-archivo'
		select.innerHTML = '<option value="borrador">Borrador</option><option value="publicado">Publicado</option>'
		this.campos['estado'] = select
		bloque.appendChild(select)
		select.addEventListener('change', () => {
			this.controlador.establecerEstado(select.value)
		})

		return bloque
	}
}