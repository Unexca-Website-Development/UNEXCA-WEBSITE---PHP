<?php
/**
 * Archivo de carga centralizada de componentes reutilizables.
 *
 * Este archivo incluye todos los componentes PHP que estarán disponibles
 * en todo el proyecto al ser incluido.
 * 
 * No contiene funciones ni clases propias, solo realiza inclusiones mediante require_once.
 */
require_once colocar_ruta_sistema('@componentes/renderizar_links_header.php');
require_once colocar_ruta_sistema('@componentes/renderizar_links_footer.php');
require_once colocar_ruta_sistema('@componentes/renderizar_boton.php');
require_once colocar_ruta_sistema('@componentes/renderizar_carreras.php');
require_once colocar_ruta_sistema('@componentes/renderizar_noticias.php');
require_once colocar_ruta_sistema('@componentes/renderizar_autoridades.php');
require_once colocar_ruta_sistema('@componentes/renderizar_lista_desplegable.php');
require_once colocar_ruta_sistema('@componentes/renderizar_detalle_carrera.php');
require_once colocar_ruta_sistema('@componentes/renderizar_contactos_admin.php');
require_once colocar_ruta_sistema('@componentes/renderizar_contactos_coords.php');

require_once colocar_ruta_sistema('@componentes/renderizar_head.php');
require_once colocar_ruta_sistema('@componentes/renderizar_header.php');
require_once colocar_ruta_sistema('@componentes/renderizar_footer.php');