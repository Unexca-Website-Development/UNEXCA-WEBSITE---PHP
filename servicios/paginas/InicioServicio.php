<?php
require_once colocar_ruta_sistema('@modelo/paginas/InicioModelo.php');

class InicioServicio
{
    private $modelo_inicio;

    public function __construct()
    {
        $this->modelo_inicio = new inicioModelo();
    }

    public function obtenerDatosCarreras()
    {
        $carreras_lista = $this->modelo_inicio->obtenerCarrerasSimples();
        
        $carreras_array = [];

        foreach ($carreras_lista as $carrera) {

            $carreras_array[] = [
                "title"       => $carrera['titulo'],
                "descripcion" => $carrera['descripcion'],
                "links"       => $carrera['link_malla_curricular'],
                "img"         => $carrera['imagen'],
            ];
        }

        return $carreras_array;
    }
};
