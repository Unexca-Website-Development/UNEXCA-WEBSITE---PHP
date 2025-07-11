<?php

function obtenerRutas(){
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
function obtenerRutaSistema(string $alias): string{
    $rutas = obtenerRutas()['sistema'];

    foreach ($rutas as $clave => $ruta){

        // Si el alias comienza con el prefijo 
        // -> @ejemplo/footer.php -> @ejemplo
        if (strpos($alias, $clave) === 0){

            // resultado final /ruta/ejemplo + /footer.p
            return $ruta . substr($alias, strlen($clave));
        }
    }
    // Si el alias no concuerda con ninguna ruta, arroja este mensaje
    throw new Exception("Ruta de sistema no encontrada para '$alias'");
}

// Rutas para elementos html como por ejemplo -> src=""
function obtenerRutaHTML(string $alias): string{
    $rutas = obtenerRutas()['html'];

    foreach ($rutas as $clave => $ruta){

        // Si el alias comienza con el prefijo 
        // -> @ejemplo/footer.php -> @ejemplo 
        if (strpos($alias, $clave) === 0){

            // resultado final /ruta/ejemplo + /footer.php
            return $ruta . substr($alias, strlen($clave));
        }
    }
    // Si el alias no concuerda con ninguna ruta, arroja este mensaje
    throw new Exception("Ruta de HTML no encontrada para '$alias'");
}


// function resolvePath($ruta) {
//     static $rutas = null;

//     if ($rutas === null) {
//         $rutas = require __DIR__ . '/alias_rutas.php';
//     }

//     foreach ($rutas as $prefijo => $base) {
//         if (strpos($ruta, $prefijo) === 0) {
//             $relativa = substr($ruta, strlen($prefijo));
//             return $base . $relativa;
//         }
//     }

//     // Si no encuentra coincidencias, devuelve tal cual
//     return $ruta;
// }