import { CONFIG_BLOQUES } from '../config/configBloques.js'

export function bloqueAUI(bloque, config) {
	const ui = config[bloque.tipo]?.ui || {}
	return {
		id: bloque.id,
		tipo: bloque.tipo,
		texto: config[bloque.tipo]?.texto || '',
		icono: ui.icono || '',
		inputs: ui.inputs || [],
		contenido: { ...bloque.contenido }
	}
}

export function bloqueAModelo(bloqueUI) {
	const config = CONFIG_BLOQUES[bloqueUI.tipo] || {}
	const campos = config.campos || {}
	const datos = Object.keys(campos).reduce((acc, key) => {
		acc[key] = bloqueUI.contenido?.[key] ?? ''
		return acc
	}, {})
	return {
		tipo_bloque: bloqueUI.tipo,
		datos
	}
}