<?php

use Servicios\Nucleo\AuthServicio;
use Servicios\Nucleo\ControladorErroresHTTP;

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/nucleo/AuthServicio.php');

class AuthControlador extends BaseControlador {

    private $authServicio;

    public function __construct() {
        $this->authServicio = new AuthServicio();
    }

    public function mostrarLogin(): void {
        if ($this->authServicio->estaAutenticado()) {
            header('Location: index.php?pagina=admin&seccion=noticias');
            exit;
        }

        $this->establecerHead([
            "title" => "Iniciar Sesión - UNEXCA",
            "styles" => ["@estilos/paginas/general.css"] // Deberías crear un login.css después
        ]);

        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/login.php'));
        $this->renderizar();
    }

    public function login(array $datos): void {
        $usuario = $datos['usuario'] ?? '';
        $password = $datos['password'] ?? '';

        if ($this->authServicio->login($usuario, $password)) {
            header('Location: index.php?pagina=admin&seccion=noticias');
            exit;
        } else {
            // Aquí podrías pasar un mensaje de error a la vista
            $this->establecerHead([
                "title" => "Error de Inicio de Sesión - UNEXCA",
                "styles" => ["@estilos/paginas/general.css"]
            ]);
            $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/login.php'));
            $this->renderizar(['error' => 'Usuario o contraseña incorrectos']);
        }
    }

    public function logout(): void {
        $this->authServicio->logout();
        header('Location: index.php?pagina=inicio');
        exit;
    }
}
