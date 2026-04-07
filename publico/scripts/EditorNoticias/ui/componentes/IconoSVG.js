export default class IconoSVG {
	constructor(ruta, clase = '') {
		this.ruta = ruta
		this.clase = clase
		this.elemento = null
	}

	async cargar() {
		const respuesta = await fetch(this.ruta)
		const svgTexto = await respuesta.text()
		const contenedor = document.createElement('div')
		contenedor.innerHTML = svgTexto.trim()
		this.elemento = contenedor.firstChild
		if (this.clase) this.elemento.classList.add(this.clase)
		return this.elemento
	}

	renderizar() {
		return this.elemento
	}
}
