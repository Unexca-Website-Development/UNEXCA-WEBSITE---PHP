<?php
/**
 * CLI Tool: Gestionar Usuarios Administrativos
 * 
 * Permite crear o actualizar usuarios, asignarles múltiples roles y permisos específicos.
 * Uso: php scripts/gestionar_usuario.php <usuario> <password> <nombre> <roles_ids> [permisos_claves]
 * 
 * <roles_ids>: IDs de roles separados por comas (ej: 1,2)
 * [permisos_claves]: Opcional, claves de permisos separadas por comas (ej: noticias.borrar,autoridades.crear)
 */

// Cargar entorno y utilidades
require_once __DIR__ . '/../servicios/cargar_env.php';
cargar_env(__DIR__ . '/../.env');

require_once __DIR__ . '/../servicios/alias_rutas.php';
require_once __DIR__ . '/../servicios/utilidades.php';
require_once colocar_ruta_sistema('@modelo/ConexionDB.php');

use Modelo\ConexionDB;

try {
    $pdo = ConexionDB::obtenerInstancia()->obtenerConexion();

    if ($argc < 2) {
        mostrarAyuda($pdo);
        exit(0);
    }

    if ($argc < 5) {
        echo "\n❌ ERROR: Faltan argumentos obligatorios.\n";
        mostrarAyuda($pdo);
        exit(1);
    }

    $usuario_slug = $argv[1];
    $password = $argv[2];
    $nombre = $argv[3];
    $roles_input = explode(',', $argv[4]);
    $permisos_input = isset($argv[5]) ? explode(',', $argv[5]) : [];

    $pdo->beginTransaction();

    // 1. Verificar si el usuario ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :u");
    $stmt->execute(['u' => $usuario_slug]);
    $user = $stmt->fetch();

    $hash = password_hash($password, PASSWORD_BCRYPT);

    if ($user) {
        $id = $user['id'];
        $stmt = $pdo->prepare("UPDATE usuarios SET password = :p, nombre = :n WHERE id = :id");
        $stmt->execute(['p' => $hash, 'n' => $nombre, 'id' => $id]);
        echo "✅ Usuario '$usuario_slug' (ID $id) actualizado.\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, password) VALUES (:n, :u, :p) RETURNING id");
        $stmt->execute(['n' => $nombre, 'u' => $usuario_slug, 'p' => $hash]);
        $id = $stmt->fetch()['id'];
        echo "✅ Usuario '$usuario_slug' creado con ID $id.\n";
    }

    // 2. Gestionar Roles (Tabla usuario_roles)
    $stmt = $pdo->prepare("DELETE FROM usuario_roles WHERE usuario_id = :id");
    $stmt->execute(['id' => $id]);

    foreach ($roles_input as $rol_id) {
        $rol_id = (int)trim($rol_id);
        if ($rol_id > 0) {
            $stmt = $pdo->prepare("INSERT INTO usuario_roles (usuario_id, rol_id) VALUES (:uid, :rid)");
            $stmt->execute(['uid' => $id, 'rid' => $rol_id]);
            echo "   - Rol ID $rol_id asignado.\n";
        }
    }

    // 3. Gestionar Permisos Específicos (Tabla usuario_permisos)
    $stmt = $pdo->prepare("DELETE FROM usuario_permisos WHERE usuario_id = :id");
    $stmt->execute(['id' => $id]);

    foreach ($permisos_input as $clave) {
        $clave = trim($clave);
        if (empty($clave)) continue;

        $stmt = $pdo->prepare("SELECT id FROM permisos WHERE clave = :c");
        $stmt->execute(['c' => $clave]);
        $p = $stmt->fetch();

        if ($p) {
            $stmt = $pdo->prepare("INSERT INTO usuario_permisos (usuario_id, permiso_id) VALUES (:uid, :pid)");
            $stmt->execute(['uid' => $id, 'pid' => $p['id']]);
            echo "   - Permiso '$clave' asignado.\n";
        } else {
            echo "   ⚠️ Advertencia: El permiso '$clave' no existe en la base de datos.\n";
        }
    }

    $pdo->commit();
    echo "\n🚀 ¡Proceso completado con éxito!\n";

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

/**
 * Muestra la ayuda y los roles/permisos disponibles.
 */
function mostrarAyuda($pdo) {
    echo "\n==========================================================\n";
    echo "GESTIÓN DE USUARIOS - PANEL ADMINISTRATIVO UNEXCA\n";
    echo "==========================================================\n";
    echo "Uso: php scripts/gestionar_usuario.php <usuario> <password> <nombre> <roles_ids> [permisos_claves]\n";
    echo "Ejemplo: php scripts/gestionar_usuario.php admin admin123 \"Super Admin\" 1\n";
    echo "Ejemplo: php scripts/gestionar_usuario.php editor 1234 \"Juan Perez\" 4 noticias.borrar\n";

    echo "\n--- ROLES DISPONIBLES ---\n";
    $roles = $pdo->query("SELECT id, nombre, descripcion FROM roles ORDER BY id ASC")->fetchAll();
    foreach ($roles as $r) {
        echo "ID {$r['id']}: {$r['nombre']} ({$r['descripcion']})\n";
    }

    echo "\n--- ALGUNOS PERMISOS DISPONIBLES ---\n";
    $permisos = $pdo->query("SELECT clave, nombre_amigable FROM permisos ORDER BY clave ASC LIMIT 15")->fetchAll();
    foreach ($permisos as $p) {
        echo "- {$p['clave']} ({$p['nombre_amigable']})\n";
    }
    echo "... (Hay más permisos en la DB)\n";
}
