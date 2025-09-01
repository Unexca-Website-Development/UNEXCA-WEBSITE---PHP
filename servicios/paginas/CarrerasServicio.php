<?php
require_once colocar_ruta_sistema('@modelo/paginas/CarrerasModelo.php');

class CarrerasServicio
{
    private $modelo_carreras;

    public function __construct()
    {
        $this->modelo_carreras = new CarrerasModelo();
    }

    public function obtenerDatosCarrera($slug)
    {
        $carrera_data = $this->modelo_carreras->obtenerCarrerasPorSlug($slug);
        if (!$carrera_data) return null;

        $carrera = $carrera_data[0];
        $id = $carrera['id'];

        $parrafos = $this->modelo_carreras->obtenerParrafosPorCarrera($id);
        $turnos   = $this->modelo_carreras->obtenerTurnosPorCarrera($id);
        $niveles  = $this->modelo_carreras->obtenerNivelesPorCarrera($id);
        $nucleos  = $this->modelo_carreras->obtenerNucleosPorCarrera($id);

        $parrafos_array = [];
        foreach ($parrafos as $p) {
            $parrafos_array[] = [
                'numero_parrafo' => $p['numero_parrafo'],
                'contenido' => $p['parrafo_contenido']
            ];
        }

        $turnos_array = [];
        foreach ($turnos as $t) {
            $turnos_array[] = $t['turno'];
        }

        $niveles_array = [];
        foreach ($niveles as $n) {
            $niveles_array[] = [
                'nivel' => $n['nivel'],
                'duracion' => $n['duracion'],
                'diploma' => $n['diploma']
            ];
        }

        $nucleos_array = [];
        foreach ($nucleos as $n) {
            $nucleos_array[] = [
                'id' => $n['nucleo_id'],
                'nombre' => $n['nucleo_nombre']
            ];
        }

        $slug_generado = strtolower(
            preg_replace('/[^a-z0-9]+/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $carrera['carrera_titulo']))
        );
        $link_carrera  = colocar_enlace('carrera&nombre=' . $slug_generado);

        return [
            'id' => $id,
            'titulo' => $carrera['carrera_titulo'],
            'descripcion' => $carrera['carrera_descripcion'],
            'link_malla_curricular' => $carrera['link_malla_curricular'],
            'parrafos' => $parrafos_array,
            'turnos' => $turnos_array,
            'niveles' => $niveles_array,
            'nucleos' => $nucleos_array,
            'slug' => $slug_generado,
            'link' => $link_carrera
        ];
    }
}
