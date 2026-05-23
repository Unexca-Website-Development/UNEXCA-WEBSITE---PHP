<?php

namespace Servicios\Nucleo;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');
require_once colocar_ruta_sistema('@servicios/nucleo/Logger.php');

use Modelo\BaseModelo;
use Servicios\Nucleo\Logger;

class AuthServicio 
{
    private $modelo;

    public function __construct() {
        $this->modelo = new BaseModelo();
        $this->inicializarSesion();
    }

    /**
     * Configura e inicia la sesión si no está iniciada.
     * Utiliza la carpeta /tmp del proyecto para mayor control.
     */
    private function inicializarSesion(): void 
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Intentar usar la carpeta tmp del proyecto, pero validar permisos primero
            $rutaTmp = colocar_ruta_sistema('@tmp');
            
            if (is_dir($rutaTmp) && is_writable($rutaTmp)) {
                ini_set('session.save_path', $rutaTmp);
            } else {
                // Si no es escribible, dejamos que PHP use la ruta por defecto del sistema
                // y registramos un aviso para el administrador.
                Logger::registrar('WARNING', "La ruta de sesión personalizada no es escribible o no existe: $rutaTmp. Se usará la ruta por defecto del servidor.");
            }

            if (!session_start()) {
                Logger::registrar('ERROR', "Fallo crítico: No se pudo iniciar la sesión de PHP.");
            }
        }

        $this->verificarInactividad();
    }

    /**
     * Verifica si la sesión ha expirado por inactividad.
     */
    private function verificarInactividad(): void
    {
        if (!isset($_SESSION['usuario_id'])) return;

        $tiempoInactividadMax = 15 * 60; // 15 minutos en segundos
        $ahora = time();

        if (isset($_SESSION['ultima_actividad'])) {
            $transcurrido = $ahora - $_SESSION['ultima_actividad'];
            if ($transcurrido > $tiempoInactividadMax) {
                Logger::registrar('INFO', "Sesión expirada por inactividad del usuario ID: " . $_SESSION['usuario_id']);
                $this->logout();
                header('Location: ' . colocar_enlace('login', ['timeout' => 1]));
                exit;
            }
        }

        $_SESSION['ultima_actividad'] = $ahora;
    }

    /**
     * Intenta autenticar a un usuario.
     * 
     * @param string $usuario
     * @param string $password
     * @return bool True si es exitoso, false de lo contrario.
     */
    public function login(string $usuario, string $password): bool 
    {
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1";
        $resultado = $this->modelo->consultar($sql, ['usuario' => $usuario]);

        if (empty($resultado)) {
            return false;
        }

        $usuarioData = $resultado[0];

        // Verificar la contraseña usando BCRYPT
        if (password_verify($password, $usuarioData['password'])) {
            $_SESSION['usuario_id'] = $usuarioData['id'];
            $_SESSION['usuario_nombre'] = $usuarioData['nombre'];
            
            // Cargar todos los roles y permisos del usuario
            $rolesData = $this->cargarRolesYPermisos($usuarioData['id']);
            $_SESSION['usuario_roles_ids'] = $rolesData['roles_ids'];
            $_SESSION['usuario_permisos'] = $rolesData['permisos'];
            
            // Actualizar último login
            $this->modelo->actualizar('usuarios', ['ultimo_login' => date('Y-m-d H:i:s')], $usuarioData['id']);
            
            Logger::registrar('INFO', "Login exitoso para usuario: $usuario");
            return true;
        }

        Logger::registrar('WARNING', "Contraseña incorrecta para usuario: $usuario");
        return false;
    }

    /**
     * Obtiene todos los IDs de roles y la suma de permisos para un usuario.
     * Incluye permisos heredados de roles y permisos específicos asignados al usuario.
     * 
     * @param int $usuarioId
     * @return array ['roles_ids' => [...], 'permisos' => [...]]
     */
    private function cargarRolesYPermisos(int $usuarioId): array
    {
        // 1. Obtener IDs de los roles asignados
        $sqlRoles = "SELECT rol_id FROM usuario_roles WHERE usuario_id = :usuario_id";
        $resRoles = $this->modelo->consultar($sqlRoles, ['usuario_id' => $usuarioId]);
        $rolesIds = array_column($resRoles, 'rol_id');

        // 2. Obtener permisos de los roles
        $permisosRoles = [];
        if (!empty($rolesIds)) {
            $placeholders = implode(',', array_fill(0, count($rolesIds), '?'));
            $sqlPermisosRoles = "SELECT DISTINCT p.clave 
                            FROM permisos p
                            JOIN rol_permisos rp ON p.id = rp.permiso_id
                            WHERE rp.rol_id IN ($placeholders)";
            $resPermisosRoles = $this->modelo->consultar($sqlPermisosRoles, $rolesIds);
            $permisosRoles = array_column($resPermisosRoles, 'clave');
        }

        // 3. Obtener permisos específicos del usuario (Overrides)
        $sqlPermisosUser = "SELECT p.clave 
                            FROM permisos p
                            JOIN usuario_permisos up ON p.id = up.permiso_id
                            WHERE up.usuario_id = :usuario_id";
        $resPermisosUser = $this->modelo->consultar($sqlPermisosUser, ['usuario_id' => $usuarioId]);
        $permisosUser = array_column($resPermisosUser, 'clave');

        // Combinar y eliminar duplicados
        $todosLosPermisos = array_unique(array_merge($permisosRoles, $permisosUser));

        return [
            'roles_ids' => $rolesIds,
            'permisos' => array_values($todosLosPermisos)
        ];
    }

    public function logout(): void 
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public function estaAutenticado(): bool 
    {
        return isset($_SESSION['usuario_id']);
    }

    /**
     * Verifica si el usuario actual tiene un permiso específico.
     * 
     * @param string $clavePermiso
     * @return bool
     */
    public function tienePermiso(string $clavePermiso): bool
    {
        if (!$this->estaAutenticado()) return false;
        
        $permisos = $_SESSION['usuario_permisos'] ?? [];
        return in_array($clavePermiso, $permisos);
    }

    public function obtenerUsuarioActual(): ?array 
    {
        if (!$this->estaAutenticado()) {
            return null;
        }

        return [
            'id' => $_SESSION['usuario_id'],
            'nombre' => $_SESSION['usuario_nombre'],
            'roles_ids' => $_SESSION['usuario_roles_ids'] ?? [],
            'permisos' => $_SESSION['usuario_permisos'] ?? []
        ];
    }
}
