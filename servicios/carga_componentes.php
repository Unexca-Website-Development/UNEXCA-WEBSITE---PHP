<?php
// Carga centralizada de funciones y componentes reutilizables
// Aquí se incluyen todos los archivos con funciones auxiliares y componentes PHP
// que estarán disponibles en todo el proyecto al incluir este archivo.
require_once colocar_ruta_sistema('@componentes/renderizar_links_header.php');
require_once colocar_ruta_sistema('@componentes/renderizar_links_footer.php');
require_once colocar_ruta_sistema('@componentes/renderizar_boton.php');
require_once colocar_ruta_sistema('@componentes/renderizar_carreras.php');
require_once colocar_ruta_sistema('@componentes/renderizar_noticias.php');
require_once colocar_ruta_sistema('@componentes/renderizar_autoridades.php');
require_once colocar_ruta_sistema('@componentes/renderizar_lista_desplegable.php');
require_once colocar_ruta_sistema('@componentes/renderizar_detalle_carrera.php');

require_once colocar_ruta_sistema('@componentes/renderizar_head.php');
require_once colocar_ruta_sistema('@componentes/renderizar_header.php');
require_once colocar_ruta_sistema('@componentes/renderizar_footer.php');