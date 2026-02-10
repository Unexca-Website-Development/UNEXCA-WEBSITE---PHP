<?php
/**
 * Archivo de carga centralizada de componentes reutilizables.
 *
 * Este archivo incluye todos los componentes PHP que estarán disponibles
 * en todo el proyecto al ser incluido.
 * 
 * No contiene funciones ni clases propias, solo realiza inclusiones mediante require_once.
 */
require_once colocar_ruta_sistema('@componentes/links_header.php');
require_once colocar_ruta_sistema('@componentes/links_footer.php');
require_once colocar_ruta_sistema('@componentes/boton.php');
require_once colocar_ruta_sistema('@componentes/carreras.php');
require_once colocar_ruta_sistema('@componentes/noticias.php');
require_once colocar_ruta_sistema('@componentes/autoridades.php');
require_once colocar_ruta_sistema('@componentes/lista_desplegable.php');
require_once colocar_ruta_sistema('@componentes/detalle_carrera.php');
require_once colocar_ruta_sistema('@componentes/contactos_admin.php');
require_once colocar_ruta_sistema('@componentes/contactos_coords.php');
require_once colocar_ruta_sistema('@componentes/menu_control.php');

require_once colocar_ruta_sistema('@componentes/head.php');
require_once colocar_ruta_sistema('@componentes/cabecera.php');
require_once colocar_ruta_sistema('@componentes/footer.php');