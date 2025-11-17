<?php
/**
 * Función para cargar variables de entorno desde un archivo tipo .env
 *
 * @param string $ruta Ruta del archivo de entorno.
 * 
 * Lee cada línea del archivo, ignora comentarios y líneas vacías,
 * y asigna las variables al arreglo global $_ENV y al entorno de PHP con putenv().
 * No sobrescribe variables ya definidas en $_ENV.
 */
function cargar_env($ruta) {
    if (!file_exists($ruta)) return;

    $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lineas as $linea) {
        if (strpos(trim($linea), '#') === 0) continue;
        [$clave, $valor] = explode('=', $linea, 2);
        $clave = trim($clave);
        $valor = trim($valor);

        if (!array_key_exists($clave, $_ENV)) {
            $_ENV[$clave] = $valor;
            putenv("$clave=$valor");
        }
    }
}