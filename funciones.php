<?php
// Carga centralizada de funciones y componentes reutilizables
// Aquí se incluyen todos los archivos con funciones auxiliares y componentes PHP
// que estarán disponibles en todo el proyecto al incluir este archivo.
require_once colocar_ruta_sistema('@componentes/header_links.php');
require_once colocar_ruta_sistema('@componentes/footer_links.php');
require_once colocar_ruta_sistema('@componentes/botones.php');


function obtener_rutas(){
    // La primera vez, $rutas es null, asi que se carga el archivo
    static $rutas = null;

    if ($rutas === null) {
        // Aqui se carga
        $rutas = require __DIR__ . '/alias_rutas.php'; 
    }

    // $rutas ya tiene el archivo asi que no tendra que volver hacer el require gracias al static
    return $rutas;
}

// Rutas de raiz del proyecto para php, como por ejemplo -> include obteneRutasSistema(@ejemplo/footer.php)
function colocar_ruta_sistema(string $alias): string{
    $rutas = obtener_rutas()['sistema'];

    foreach ($rutas as $clave => $ruta){

        // Condicion si el alias comienza con el prefijo 
        // -> @ejemplo/footer.php -> @ejemplo
        if (strpos($alias, $clave) === 0){

            // Resultado final /ruta/ejemplo + /footer.p
            return $ruta . substr($alias, strlen($clave));
        }
    }
    // Si el alias no concuerda con ninguna ruta, arroja este mensaje
    throw new Exception("Ruta de sistema no encontrada para '$alias'");
}

// Rutas para elementos html como por ejemplo -> src=""
function colocar_ruta_html(string $alias): string{
    $rutas = obtener_rutas()['html'];

    foreach ($rutas as $clave => $ruta){

        if (strpos($alias, $clave) === 0){
            return $ruta . substr($alias, strlen($clave));
        }
    }

    throw new Exception("Ruta de HTML no encontrada para '$alias'");
}

// Rutas para elementos svg como por ejemplo los iconos en formato svg
function colocar_svg(string $alias): string {
    $rutas = obtener_rutas()['sistema'];

    foreach ($rutas as $clave => $base) {
        if (strpos($alias, $clave) === 0) {
            $archivo = $base . substr($alias, strlen($clave));
            // Verificar si el archivo existe
            if (file_exists($archivo)) {
                return file_get_contents($archivo);
            } else {
                return "<!-- SVG '$alias' no encontrado en '$archivo' -->";
            }
        }
    }

    throw new Exception("Ruta de sistema no encontrada para '$alias'");
}