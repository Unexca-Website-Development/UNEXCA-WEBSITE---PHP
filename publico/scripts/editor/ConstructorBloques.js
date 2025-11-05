import { BloqueTexto, BloqueLista, BloqueImagen, BloqueCita, BloqueFechas } from './Bloques.js'

// Mapeo de tipos a clases de bloques
const TIPOS_BLOQUES = {
	'subtitulo': BloqueTexto,
	'parrafo': BloqueTexto,
	'lista': BloqueLista,
	'imagen': BloqueImagen,
	'cita': BloqueCita,
	'fechas': BloqueFechas
}

// Mapeo de tipos a iconos
const ICONOS_BLOQUES = {
	'subtitulo': '/imagenes/iconos/icon_h2.svg',
	'parrafo': '/imagenes/iconos/icon_parrafo.svg',
	'lista': '/imagenes/iconos/icon_lista.svg',
	'imagen': '/imagenes/iconos/icon_imagen.svg',
	'cita': '/imagenes/iconos/icon_cita.svg',
	'fechas': '/imagenes/iconos/icon_calendario.svg'
}

// Mapeo de tipos a textos de etiqueta
const TEXTOS_BLOQUES = {
	'subtitulo': 'Subtítulo',
	'parrafo': 'Párrafo',
	'lista': 'Lista',
	'imagen': 'Imagen',
	'cita': 'Cita',
	'fechas': 'Información de la noticia'
}

export function crearBloque(tipo, texto, icono, editor, controles = true) {
	const ClaseBloque = TIPOS_BLOQUES[tipo] || BloqueTexto
	
	if (!ClaseBloque) {
		console.warn(`Tipo de bloque desconocido: ${tipo}. Usando BloqueTexto por defecto.`)
		return new BloqueTexto(tipo, texto, icono, editor, controles)
	}
	
	return new ClaseBloque(tipo, texto, icono, editor, controles)
}

export function obtenerIcono(tipo) {
	return ICONOS_BLOQUES[tipo] || '/imagenes/iconos/icon_parrafo.svg'
}

export function obtenerTexto(tipo) {
	return TEXTOS_BLOQUES[tipo] || tipo
}

export function crearBloquePorDefecto(tipo, editor, controles = true) {
	const texto = obtenerTexto(tipo)
	const icono = obtenerIcono(tipo)
	return crearBloque(tipo, texto, icono, editor, controles)
}


export function esTipoValido(tipo) {
	return tipo in TIPOS_BLOQUES
}

export function obtenerTiposDisponibles() {
	return Object.keys(TIPOS_BLOQUES)
}

