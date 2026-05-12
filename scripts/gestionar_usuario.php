<?php
/**
 * CLI Tool: Gestionar Usuarios Administrativos
 * 
 * Permite crear o actualizar usuarios y asignarles roles desde la terminal.
 * Uso: php scripts/gestionar_usuario.php <usuario> <password> <nombre> <rol_id>
 */

// Cargar entorno y utilidades
require_once __DIR__ . '/../servicios/cargar_env.php';
cargar_env(__DIR__ . '/../.env');

require_once __DIR__ . '/../servicios/alias_rutas.php';
require_once __DIR__ . '/../servicios/utilidades.php';
require_once colocar_ruta_sistema('@modelo/ConexionDB.php');

use Modelo\ConexionDB;

if ($argc < 5) {
    echo "\nUso: php scripts/gestionar_usuario.php <usuario> <password> <nombre> <rol_id>\n";
    echo "Ejemplo: php scripts/gestionar_usuario.php admin admin123 \"Super Admin\" 1\n\n";
    exit(1);
}

$usuario_slug = $argv[1];
$password = $argv[2];
$nombre = $argv[3];
$rol_id = (int)$argv[4];

try {
    $pdo = ConexionDB::obtenerInstancia()->obtenerConexion();
    $pdo->beginTransaction();

    // 1. Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :u");
    $stmt->execute(['u' => $usuario_slug]);
    $user = $stmt->fetch();

    $hash = password_hash($password, PASSWORD_BCRYPT);

    if ($user) {
        // Actualizar existente
        $id = $user['id'];
        $stmt = $pdo->prepare("UPDATE usuarios SET password = :p, nombre = :n WHERE id = :id");
        $stmt->execute(['p' => $hash, 'n' => $nombre, 'id' => $id]);
        echo "✅ Usuario '$usuario_slug' actualizado.\n";
    } else {
        // Crear nuevo
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, password) VALUES (:n, :u, :p) RETURNING id");
        $stmt->execute(['n' => $nombre, 'u' => $usuario_slug, 'p' => $hash]);
        $id = $stmt->fetch()['id'];
        echo "✅ Usuario '$usuario_slug' creado con ID $id.\n";
    }

    // 2. Asignar el Rol en la tabla intermedia (usuario_roles)
    // Primero limpiamos roles antiguos si los hubiera
    $stmt = $pdo->prepare("DELETE FROM usuario_roles WHERE usuario_id = :id");
    $stmt->execute(['id' => $id]);

    // Insertamos el nuevo rol
    $stmt = $pdo->prepare("INSERT INTO usuario_roles (usuario_id, rol_id) VALUES (:uid, :rid)");
    $stmt->execute(['uid' => $id, 'rid' => $rol_id]);
    echo "✅ Rol ID $rol_id asignado al usuario.\n";

    $pdo->commit();
    echo "\n🚀 ¡Proceso completado con éxito!\n";

} catch (Exception $e) {
    if (isset($pdo)) $pdo->rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
