<?php
require_once colocar_ruta_sistema('@modelo/paginas/ContactosModelo.php');

class ContactosServicio
{
    private $modelo_contactos;

    public function __construct()
    {
        $this->modelo_contactos = new ContactosModelo();
    }

    public function obtenerContactosDirectivos()
    {
        $contactos_directivos_data = $this->modelo_contactos->obtenerContactosDirectivos();
        $contactos_directivos_array = [];

        foreach ($contactos_directivos_data as $fila) {
            $nucleo = $fila["nombre_nucleo"] ?? "Sin Núcleo";

            if (!isset($contactos_directivos_array[$nucleo])) {
                $contactos_directivos_array[$nucleo] = [];
            }

            $contactos_directivos_array[$nucleo][] = [
                "id" => $fila["id"],
                "nombre" => $fila["nombre_completo"],
                "cargo" => $fila["cargo"],
                "telefono" => $fila["telefono"],
                "email" => $fila["email"],
                "oficina" => $fila["oficina"]
            ];
        }

        return $contactos_directivos_array;
    }


    public function obtenerContactosCoordinadores()
    {
        $contactos_coordinadores_data = $this->modelo_contactos->obtenerContactosCoordinadores();
        $contactos_coordinadores_array = [];

        foreach ($contactos_coordinadores_data as $fila) {
            $carrera = $fila["nombre_carrera"] ?? "Sin Carrera";

            $contactos_coordinadores_array[$carrera][] = [
                "id" => $fila["id"],
                "nombre" => $fila["nombre_completo"],
                "titulo_academico" => $fila["titulo_academico"],
                "telefono" => $fila["telefono"],
                "email" => $fila["email"],
                "oficina" => $fila["oficina"],
                "horario_atencion" => $fila["horario_atencion"]
            ];
        }

        return $contactos_coordinadores_array;
    }

}