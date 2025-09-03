<?php
require_once colocar_ruta_sistema('@modelo/paginas/InicioModelo.php');

class InicioServicio
{
    private $modelo_inicio;

    public function __construct()
    {
        $this->modelo_inicio = new InicioModelo();
    }

    public function obtenerDatosCarreras()
    {
        $carreras_lista = $this->modelo_inicio->obtenerCarrerasSimples();
        
        $carreras_array = [];

        foreach ($carreras_lista as $carrera) {

            $link_carrera = colocar_enlace('carrera', ['nombre' => $carrera['slug']]);

            $carreras_array[] = [
                "titulo"       => $carrera['titulo'],
                "descripcion"  => $carrera['descripcion'],
                "links"        => $link_carrera,
                "img"          => $carrera['imagen'],
            ];
        }

        return $carreras_array;
    }
}

