import { CONFIG_RUTAS } from './configRutas.js';

export const CONFIG_MENU_LATERAL = [
	{
		id: 'btn-menu-abrir',
		rutaIcono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.menuAbrir,
		clase: 'menu-editor__boton'
	},
	{
		id: 'btn-nueva-noticia',
		rutaIcono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.nuevaNoticia,
		texto: 'Nueva noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	},
	{
		id: 'btn-buscar-noticia',
		rutaIcono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.buscarNoticia,
		texto: 'Buscar noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	},
	{
		id: 'btn-guardar-noticia',
		rutaIcono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.guardarNoticia,
		texto: 'Guardar noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	},
	{
		id: 'btn-publicar-noticia',
		rutaIcono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.publicarNoticia,
		texto: 'Publicar noticia',
		clase: 'menu-editor__boton',
		claseSpan: 'menu-editor__texto'
	}
]

export const CONFIG_MENU_RECIENTES = {
	id: 'btn-noticias-recientes',
	rutaIcono: CONFIG_RUTAS.rutaIconos + CONFIG_RUTAS.iconos.noticiasRecientes,
	texto: 'Noticias recientes',
	clase: 'menu-editor__boton menu-editor__boton--recientes',
	claseSpan: 'menu-editor__texto'
}
