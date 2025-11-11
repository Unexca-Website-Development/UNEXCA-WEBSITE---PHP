import IconoSVG from "./componentes/IconoSVG.js"
import LabelBloque from "./componentes/LabelBloque.js"

export async function crearIcono(ruta, clase) {
	const icono = new IconoSVG(ruta, clase)
	await icono.cargar()
	return icono
}

export async function crearLabelBloque(id, texto, rutaIcono) {
	const label = new LabelBloque(id, texto, rutaIcono)
	return await label.renderizar()
}
