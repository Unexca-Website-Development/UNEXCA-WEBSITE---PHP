<?php
/**
 * Obtiene el array de rutas del proyecto, cargándolo solo una vez.
 *
 * @return array Array de rutas organizadas por tipo.
 */
function obtener_rutas(){
    static $rutas = null;

    if ($rutas === null) {
        $rutas = require __DIR__ . '/alias_rutas.php'; 
    }

    return $rutas;
};

/**
 * Convierte un alias en la ruta absoluta del sistema.
 *
 * @param string $alias Alias con prefijo de ruta.
 * @return string Ruta absoluta correspondiente.
 * @throws Exception Si el alias no concuerda con ninguna ruta.
 */
function colocar_ruta_sistema(string $alias): string{
    $rutas = obtener_rutas()['sistema'];

    foreach ($rutas as $clave => $ruta){
        if (strpos($alias, $clave) === 0){
            return $ruta . substr($alias, strlen($clave));
        }
    }
    throw new Exception("Ruta de sistema no encontrada para '$alias'");
};

/**
 * Convierte un alias en la ruta de recursos HTML.
 *
 * @param string $alias Alias con prefijo de ruta.
 * @return string Ruta HTML correspondiente.
 * @throws Exception Si el alias no concuerda con ninguna ruta.
 */
function colocar_ruta_html(string $alias): string{
    $rutas = obtener_rutas()['html'];

    foreach ($rutas as $clave => $ruta){
        if (strpos($alias, $clave) === 0){
            return $ruta . substr($alias, strlen($clave));
        }
    }

    throw new Exception("Ruta de HTML no encontrada para '$alias'");
};

/**
 * Obtiene el contenido de un archivo SVG a partir de un alias.
 *
 * @param string $alias Alias con prefijo de ruta.
 * @return string Contenido SVG o mensaje de error.
 * @throws Exception Si el alias no concuerda con ninguna ruta.
 */
function colocar_svg(string $alias): string {
    $rutas = obtener_rutas()['sistema'];

    foreach ($rutas as $clave => $base) {
        if (strpos($alias, $clave) === 0) {
            $archivo = $base . substr($alias, strlen($clave));
            if (file_exists($archivo)) {
                return file_get_contents($archivo);
            } else {
                return "<!-- SVG '$alias' no encontrado en '$archivo' -->";
            }
        }
    }

    throw new Exception("Ruta de sistema no encontrada para '$alias'");
};

/**
 * Construye un enlace HTML con parámetros opcionales.
 *
 * @param string $pagina Nombre de la página.
 * @param array $params Parámetros opcionales.
 * @return string URL generada.
 */
// function colocar_enlace(string $pagina, array $params = []): string {
//     $url = '/' . $pagina;
//     if (!empty($params)) {
//         $url .= '/' . implode('/', array_map('urlencode', $params));
//     }
//     return $url;
// };

function colocar_enlace(string $pagina, array $params = []): string {
    $query = http_build_query(array_merge(['pagina' => $pagina], $params));
    return "index.php?$query";
}

/**
 * Devuelve el array de páginas permitidas.
 *
 * @return array Lista blanca de páginas.
 * @throws Exception Si el archivo no existe o no retorna un array.
 */
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

/**
 * Procesa un enlace convirtiéndolo a URL absoluta o relativa según corresponda.
 *
 * @param string|null $url URL o slug a procesar.
 * @return string URL procesada.
 */
function procesar_enlace(?string $url): string {
    $url = trim($url ?? '');
    if ($url === '' || $url === '#') return '#';
    if (preg_match('/^https?:\/\//i', $url)) return $url;
    return colocar_enlace($url);
}

/**
 * Ordena un array asociativo por clave numérica ascendente.
 *
 * @param array $items Array a ordenar.
 * @return array Array ordenado.
 */
function ordenar_por_id_asc(array $items): array {
    ksort($items);
    return $items;
}

/**
 * Ordena un array asociativo por clave numérica descendente.
 *
 * @param array $items Array a ordenar.
 * @return array Array ordenado.
 */
function ordenar_por_id_desc(array $items): array {
    krsort($items);
    return $items;
}

/**
 * Normaliza un texto eliminando acentos y caracteres especiales.
 *
 * @param string $texto Texto original.
 * @param string $reemplazo Caracter de reemplazo para espacios y símbolos.
 * @return string Texto normalizado.
 */
function normalizar_texto(string $texto, string $reemplazo = '-') : string {
    $mapa = [
        'á'=>'a','à'=>'a','ä'=>'a','â'=>'a',
        'é'=>'e','è'=>'e','ë'=>'e','ê'=>'e',
        'í'=>'i','ì'=>'i','ï'=>'i','î'=>'i',
        'ó'=>'o','ò'=>'o','ö'=>'o','ô'=>'o',
        'ú'=>'u','ù'=>'u','ü'=>'u','û'=>'u',
        'ñ'=>'n','ç'=>'c'
    ];

    // $texto = mb_strtolower($texto, 'UTF-8');
    $texto = strtr($texto, $mapa);
    $texto = preg_replace('/[^a-z0-9]+/', $reemplazo, $texto);
    $texto = trim($texto, $reemplazo);
    return $texto;
}

/**
 * Convierte un slug en formato snake_case.
 *
 * @param string $slug Slug en formato kebab-case.
 * @return string Slug en snake_case.
 */
function convertir_slug_a_snake(string $slug): string {
    $slug = strtolower(trim($slug));
    return str_replace('-', '_', $slug);
}

/**
 * Convierte un texto en snake_case a camelCase.
 *
 * @param string $snake Texto en snake_case.
 * @return string Texto en camelCase.
 */
function convertir_snake_a_camel(string $snake): string {
    $partes = explode('_', strtolower($snake));
    $primera = array_shift($partes);
    return $primera . implode('', array_map('ucfirst', $partes));
}