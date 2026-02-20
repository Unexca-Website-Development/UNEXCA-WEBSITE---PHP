
//const ruta = window.location.pathname.split("/")[1];
const ruta = "prueba";
const URL_BASE = `/${ruta}/publico/imagenes/iconos/`;

export const CONFIG_RUTAS = {
    rutaIconos: URL_BASE,
    iconos : {
        //Bloques
        titulo: 'icon_h1.svg',
        subtitulo: 'icon_h2.svg',
        fechas: 'icon_calendario.svg',
        parrafo: 'icon_parrafo.svg',
        cita: 'icon_cita.svg',
        lista: 'icon_lista.svg',
        imagen: 'icon_imagen.svg',

        //Menu lateral
        menuAbrir: 'icon_menu_open.svg',
        nuevaNoticia: 'icon_nueva.svg',
        buscarNoticia: 'icon_buscar.svg',
        guardarNoticia: 'icon_guardar.svg',
        publicarNoticia: 'icon_publicar.svg',
        noticiasRecientes: 'flecha.svg'
    }
};