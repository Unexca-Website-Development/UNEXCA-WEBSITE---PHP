<?php
function obtener_rutas(){
    // La primera vez, $rutas es null, asi que se carga el archivo
    static $rutas = null;

    if ($rutas === null) {
        // Aqui se carga
        $rutas = require __DIR__ . '/alias_rutas.php'; 
    }

    // $rutas ya tiene el archivo asi que no tendra que volver hacer el require gracias al static
    return $rutas;
};

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
};

// Rutas para elementos html como por ejemplo -> src=""
function colocar_ruta_html(string $alias): string{
    $rutas = obtener_rutas()['html'];

    foreach ($rutas as $clave => $ruta){

        if (strpos($alias, $clave) === 0){
            return $ruta . substr($alias, strlen($clave));
        }
    }

    throw new Exception("Ruta de HTML no encontrada para '$alias'");
};

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
};

// Funcion para colocar enlaces en elementos <a>
function colocar_enlace(string $pagina, array $params = []): string {
    $url = '/' . $pagina;
    if (!empty($params)) {
        $url .= '/' . implode('/', array_map('urlencode', $params));
    }
    return $url;
}

// Devuelve el array de páginas permitidas (lista blanca)
function obtener_paginas_permitidas(): array {
	$archivo = colocar_ruta_sistema('@servicios/paginas_permitidas.php');
	if (!file_exists($archivo)) {
		throw new Exception('Archivo de paginas_permitidas.php no encontrado');
	}
	$resultado = require $archivo; // retorna el array
	if (!is_array($resultado)) {
		throw new Exception('El archivo paginas_permitidas.php no retornó un array');
	}
	return $resultado;
}

function procesar_enlace(?string $url): string {
    $url = trim($url ?? '');

    // Si está vacia o es un ancla, devolver #
    if ($url === '' || $url === '#') {
        return '#';
    }

    // Si ya es una URL absoluta, devolverla tal cual
    if (preg_match('/^https?:\/\//i', $url)) {
        return $url;
    }

    // De lo contrario, usar colocar_enlace
    return colocar_enlace($url);
}

// Ordena un array asociativo por clave numérica ascendente (ID).
function ordenar_por_id_asc(array $items): array {
    ksort($items);
    return $items;
}

// Ordena un array asociativo por clave numérica descendente (ID).
function ordenar_por_id_desc(array $items): array {
    krsort($items);
    return $items;
}

function normalizar_texto(string $texto, string $reemplazo = '-') : string {
	$mapa = [
		'á'=>'a','à'=>'a','ä'=>'a','â'=>'a',
		'é'=>'e','è'=>'e','ë'=>'e','ê'=>'e',
		'í'=>'i','ì'=>'i','ï'=>'i','î'=>'i',
		'ó'=>'o','ò'=>'o','ö'=>'o','ô'=>'o',
		'ú'=>'u','ù'=>'u','ü'=>'u','û'=>'u',
		'ñ'=>'n','ç'=>'c'
	];

	$texto = mb_strtolower($texto, 'UTF-8');
	$texto = strtr($texto, $mapa);
	$texto = preg_replace('/[^a-z0-9]+/', $reemplazo, $texto);
	$texto = trim($texto, $reemplazo);
	return $texto;
}

function convertir_slug_a_snake(string $slug): string {
	$slug = strtolower(trim($slug));
	return str_replace('-', '_', $slug);
}

function convertir_snake_a_camel(string $snake): string {
	$partes = explode('_', strtolower($snake));
	$primera = array_shift($partes);
	return $primera . implode('', array_map('ucfirst', $partes));
}

