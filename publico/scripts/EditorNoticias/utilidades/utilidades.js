export function generarId(tipo) {
	return `${tipo}_${crypto.randomUUID()}`
}

export function asignarDatosBloque(bloque, datos) {
    if (!bloque || !bloque.campos || typeof bloque.campos !== 'object') return

    if (typeof datos === 'object' && datos !== null) {
        for (const key in bloque.campos) {
            if (datos.hasOwnProperty(key)) {
                bloque.campos[key] = datos[key]
            }
        }
    } else if (typeof datos === 'string') {
        if ('texto' in bloque.campos) {
            bloque.campos['texto'] = datos
        }
    }
}