<?php

use Servicios\Nucleo\AuthServicio;

require_once colocar_ruta_sistema('@controlador/BaseControlador.php');
require_once colocar_ruta_sistema('@servicios/nucleo/AuthServicio.php');

class AuthControlador extends BaseControlador {

    private $authServicio;

    public function __construct() {
        $this->authServicio = new AuthServicio();
    }

    public function mostrarLogin(): void {
        if ($this->authServicio->estaAutenticado()) {
            header('Location: ' . colocar_enlace('admin-noticias'));
            exit;
        }

        $this->establecerHead([
            "title" => "Iniciar Sesión - UNEXCA",
        ]);

        $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/login.php'));
        $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/vacia.php'));
        $this->renderizar();
    }

    public function login(array $datos): void {
        $usuario = $datos['usuario'] ?? '';
        $password = $datos['password'] ?? '';

        if ($this->authServicio->login($usuario, $password)) {
            header('Location: ' . colocar_enlace('admin-noticias'));
            exit;
        } else {
            $this->establecerHead([
                "title" => "Error de Inicio de Sesión - UNEXCA",
            ]);
            $this->establecerVista(colocar_ruta_sistema('@vista/paginas/admin/login.php'));
            $this->establecerPlantilla(colocar_ruta_sistema('@vista/plantilla/vacia.php'));
            $this->renderizar(['error' => 'Usuario o contraseña incorrectos']);
        }
    }

    public function logout(): void {
        $this->authServicio->logout();
        header('Location: ' . colocar_enlace('inicio'));
        exit;
    }
}