<?php
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