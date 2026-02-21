export function generarId(tipo) {
	return `${tipo}_${crypto.randomUUID()}`
}