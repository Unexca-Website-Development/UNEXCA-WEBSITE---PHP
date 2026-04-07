<?php
/**
 * Script de utilidad para actualizar contraseñas de forma segura desde Docker.
 */
require_once __DIR__ . '/../servicios/cargar_env.php';
require_once __DIR__ . '/../servicios/alias_rutas.php';
require_once __DIR__ . '/../servicios/utilidades.php';
require_once __DIR__ . '/../modelo/ConexionDB.php';

if ($argc < 3) {
    echo "Uso: php cambiar_pass.php <usuario> <nueva_clave>\n";
    exit(1);
}

$usuario = $argv[1];
$password = $argv[2];
$hash = password_hash($password, PASSWORD_BCRYPT);

try {
    $pdo = \Modelo\ConexionDB::obtenerInstancia()->obtenerConexion();
    $stmt = $pdo->prepare("UPDATE usuarios SET password = :hash WHERE usuario = :usuario");
    $stmt->execute(['hash' => $hash, 'usuario' => $usuario]);
    
    if ($stmt->rowCount() > 0) {
        echo "✅ EXITO: La clave de '$usuario' ha sido actualizada a '$password'.\n";
    } else {
        echo "❌ ERROR: No se encontró al usuario '$usuario' en la base de datos.\n";
    }
} catch (\Exception $e) {
    echo "❌ ERROR DE BD: " . $e->getMessage() . "\n";
}
