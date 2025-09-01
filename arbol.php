<?php
/**
 * Genera una representación en árbol de los directorios y archivos.
 * Similar al comando `tree` de Linux, pero implementado en PHP.
 * 
 * - Omite archivos y carpetas ocultas (nombres que empiezan con ".").
 * - Usa símbolos └── y │── para dibujar la jerarquía.
 * - Se ejecuta recursivamente sobre todos los subdirectorios.
 */
function listarDirectorio($ruta, $prefijo = '', $esUltimo = true) {
  $contenido = array_diff(scandir($ruta), ['.', '..']);
  $total = count($contenido);
  $i = 0;
  foreach ($contenido as $elemento) {
    if (strpos($elemento, '.') === 0) continue;
    $i++;
    $esFinal = $i === $total;
    echo $prefijo.($esFinal ? '└── ' : '│── ').$elemento.PHP_EOL;
    if (is_dir($ruta.'/'.$elemento)) {
      listarDirectorio($ruta.'/'.$elemento, $prefijo.($esFinal ? '    ' : '│   '), $esFinal);
    }
  }
}

/**
 * Punto de entrada del script.
 * Imprime el nombre raíz "UNEXCA" y comienza a recorrer desde la ruta actual.
 */
echo 'UNEXCA'.PHP_EOL;
listarDirectorio(__DIR__);