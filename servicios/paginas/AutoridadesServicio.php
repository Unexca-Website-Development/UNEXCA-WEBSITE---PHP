<?php
require_once colocar_ruta_sistema('@modelo/paginas/AutoridadesModelo.php');

class AutoridadesServicio
{
    private $modelo_autoridades;

    public function __construct()
    {
        $this->modelo_autoridades = new AutoridadesModelo();
    }

    public function obtenerDatosAutoridades()
    {
        $autoridades_lista = $this->modelo_autoridades->obtenerAutoridades();
        $autoridades_array = [];

        foreach ($autoridades_lista as $autoridad) {
            $autoridades_array[] = [
                "nombre" => $autoridad['nombre'],
                "cargo" => $autoridad['cargo'],
                "imagen" => $autoridad['imagen'],
            ];
        }
    }
}