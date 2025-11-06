import { administradorEventos } from '../patrones/AdministradorEventos.js'

export class ControladorMenu {
    constructor(editorNoticias, menuLateral) {
        this.editorNoticias = editorNoticias
        this.menuLateral = menuLateral
    }

    inicializar() {
        this.menuLateral.inicializar()
        administradorEventos.suscribir('opcionMenuSeleccionada', (opcion) => {
            switch(opcion) {
                case 'nueva':
                    this.nuevaNoticia()
                    break
                case 'buscar':
                    this.buscarNoticia()
                    break
                case 'recientes':
                    this.mostrarNoticiasRecientes()
                    break
                case 'guardar':
                    this.guardarNoticia()
                    break
                case 'publicar':
                    this.publicarNoticia()
                    break
                default:
                    console.warn(`Opción de menú desconocida: ${opcion}`)
            }
        })
        administradorEventos.suscribir('menuAbierto', () => this.menuAbierto())
        administradorEventos.suscribir('menuCerrado', () => this.menuCerrado())
    }

    nuevaNoticia() {
        this.editorNoticias.cargarNoticia({})
    }

    buscarNoticia() {
        console.log('Abrir buscador de noticias')
    }

    mostrarNoticiasRecientes() {
        console.log('Mostrar noticias recientes en el menú')
    }

    guardarNoticia() {
        const data = this.editorNoticias.obtenerJSON()
        console.log('Guardar noticia:', data)
    }

    publicarNoticia() {
        const publicada = this.editorNoticias.publicarNoticia()
        console.log('Publicación realizada:', publicada)
    }

    menuAbierto() {
        console.log('Menú lateral abierto')
    }

    menuCerrado() {
        console.log('Menú lateral cerrado')
    }
}