<?php
require_once 'servicios/cargar_env.php';
cargar_env('.env');
require_once 'servicios/utilidades.php';
require_once 'servicios/alias_rutas.php';
require_once 'modelo/ConexionDB.php';

use Modelo\ConexionDB;

try {
    $db = ConexionDB::obtenerInstancia()->obtenerConexion();
    
    // Contar noticias por estado
    $sql = "SELECT estado, COUNT(*) as total FROM noticias GROUP BY estado";
    $stmt = $db->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Resumen de noticias en la base de datos:\n";
    if (empty($resultados)) {
        echo "- No hay noticias registradas en la tabla.\n";
    } else {
        foreach ($resultados as $fila) {
            echo "- Estado '{$fila['estado']}': {$fila['total']} noticia(s)\n";
        }
    }

    // Ver las últimas 5 noticias (cualquier estado)
    $sql = "SELECT noticia_id, titulo_principal, estado, fecha_publicacion FROM noticias ORDER BY noticia_id DESC LIMIT 5";
    $stmt = $db->query($sql);
    $ultimas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "\nÚltimas 5 noticias registradas:\n";
    foreach ($ultimas as $n) {
        echo "[ID: {$n['noticia_id']}] '{$n['titulo_principal']}' | Estado: {$n['estado']} | Fecha: {$n['fecha_publicacion']}\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
