<?php

function generarNombreImagenUUIDv4($noticiaID, $extension) {
	$fecha = date('Ymd');

	$data = random_bytes(16);
	$data[6] = chr((ord($data[6]) & 0x0f) | 0x40); // versión 4
	$data[8] = chr((ord($data[8]) & 0x3f) | 0x80); // variante RFC 4122

	$uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

	return "{$noticiaID}_{$fecha}_{$uuid}.{$extension}";
}

function prepararBloquesJSON(array $bloques) {
	// Recibe array de bloques y devuelve array listo para insertar en DB
	$resultado = [];
	foreach ($bloques as $posicion => $bloque) {
		$resultado[] = [
			'tipo_bloque' => $bloque['tipo'],
			'datos'       => json_encode($bloque['datos'], JSON_UNESCAPED_UNICODE),
			'posicion'    => $posicion + 1
		];
	}
	return $resultado;
}

function crearCarpetaNoticia(string $fecha, int $noticiaID, string $slug): bool {
    $año = date('Y', strtotime($fecha));
    $mes = date('m', strtotime($fecha));
    $base = colocar_ruta_sistema('@imagenes'); // Ruta base para imágenes
    $ruta = "{$base}/noticias/{$año}/{$mes}/{$noticiaID}_{$slug}/";

    if (!is_dir($ruta)) {
        mkdir($ruta, 0755, true); // Crea la carpeta y los subdirectorios si no existen
    }

    return is_dir($ruta);
}

function eliminarCarpetaNoticia(string $fecha, int $noticiaID, string $slug): bool {
    $año = date('Y', strtotime($fecha));
    $mes = date('m', strtotime($fecha));
    $base = colocar_ruta_sistema('@imagenes'); 
    $ruta = "{$base}/noticias/{$año}/{$mes}/{$noticiaID}_{$slug}/";

    if (!is_dir($ruta)) return false;

    $archivos = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($ruta, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($archivos as $archivo) {
        if ($archivo->isDir()) rmdir($archivo->getPathname());
        else unlink($archivo->getPathname());
    }

    return rmdir($ruta);
}