import IconoSVG from './componentes/IconoSVG.js'
import LabelBloque from './componentes/LabelBloque.js'
import TextareaBloque from './componentes/TextareaBloque.js'
import InputBloque from './componentes/InputBloque.js'
import Boton from './componentes/Boton.js'

export async function crearIcono(ruta, clase) {
	const icono = new IconoSVG(ruta, clase)
	await icono.cargar()
	return icono
}

export async function crearLabelBloque(id, texto, rutaIcono) {
	const label = new LabelBloque(id, texto, rutaIcono)
	return await label.renderizar()
}

export function crearTextareaBloque(id, key, placeholder = '', requerido = false) {
	const textarea = new TextareaBloque(id, key, placeholder, requerido)
	return textarea.renderizar()
}

export function crearInputBloque(id, key, tipo = '', requerido = false, aceptar = '') {
	const input = new InputBloque(id, key, tipo, requerido, aceptar)
	return input.renderizar()
}

export async function crearBoton({ rutaIcono = '', texto = '', clase = '', tipo = 'button', mostrarTexto = true, claseSpan = 'boton__texto' } = {}) {
	const boton = new Boton({ rutaIcono, texto, clase, tipo, mostrarTexto, claseSpan })
	return await boton.renderizar()
}