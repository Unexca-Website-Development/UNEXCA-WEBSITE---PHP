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
            // Configurar la ruta de guardado a la carpeta tmp del proyecto
            $rutaTmp = colocar_ruta_sistema('@tmp');
            ini_set('session.save_path', $rutaTmp);
            session_start();
        }
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
            $_SESSION['usuario_rol'] = $usuarioData['rol'];
            
            // Actualizar último login
            $this->modelo->actualizar('usuarios', ['ultimo_login' => date('Y-m-d H:i:s')], $usuarioData['id']);
            
            Logger::registrar('INFO', "Login exitoso para usuario: $usuario");
            return true;
        }

        Logger::registrar('WARNING', "Contraseña incorrecta para usuario: $usuario");
        return false;
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

    public function obtenerUsuarioActual(): ?array 
    {
        if (!$this->estaAutenticado()) {
            return null;
        }

        return [
            'id' => $_SESSION['usuario_id'],
            'nombre' => $_SESSION['usuario_nombre'],
            'rol' => $_SESSION['usuario_rol']
        ];
    }
}
