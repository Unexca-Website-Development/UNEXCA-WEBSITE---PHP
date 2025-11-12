import { administradorEventos } from '../patrones/AdministradorEventos.js'

class MenuLateral {
    constructor() {
        this.menu = document.querySelector('.menu-editor')
        this.botones = {
            abrir: document.getElementById('btn-menu-abrir'),
            nueva: document.getElementById('btn-nueva-noticia'),
            buscar: document.getElementById('btn-buscar-noticia'),
            recientes: document.getElementById('btn-noticias-recientes'),
            guardar: document.getElementById('btn-guardar-noticia'),
            publicar: document.getElementById('btn-publicar-noticia')
        }
        this.estadoAbierto = false
    }

    inicializar() {
        this.botones.abrir.addEventListener('click', () => this.toggleMenu())
        this.botones.nueva.addEventListener('click', () => this.seleccionarOpcion('nueva'))
        this.botones.buscar.addEventListener('click', () => this.seleccionarOpcion('buscar'))
        this.botones.recientes.addEventListener('click', () => this.seleccionarOpcion('recientes'))
        this.botones.guardar.addEventListener('click', () => this.seleccionarOpcion('guardar'))
        this.botones.publicar.addEventListener('click', () => this.seleccionarOpcion('publicar'))

        administradorEventos.suscrito('cerrarMenu', () => this.cerrar())
    }

    toggleMenu() {
        this.estadoAbierto = !this.estadoAbierto
        this.menu.classList.toggle('menu-editor--abierto', this.estadoAbierto)
        administradorEventos.notificar(this.estadoAbierto ? 'menuAbierto' : 'menuCerrado', this.estadoAbierto)
    }

    abrir() {
        this.estadoAbierto = true
        this.menu.classList.add('menu-editor--abierto')
        administradorEventos.notificar('menuAbierto', true)
    }

    cerrar() {
        this.estadoAbierto = false
        this.menu.classList.remove('menu-editor--abierto')
        administradorEventos.notificar('menuCerrado', false)
    }

    seleccionarOpcion(opcion) {
        administradorEventos.notificar('opcionMenuSeleccionada', opcion)
    }
}

export const menuLateral = new MenuLateral()
