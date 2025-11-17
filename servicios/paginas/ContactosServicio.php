<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/ContactosModelo.php');

/**
 * Servicio para la página de Contactos.
 *
 * Proporciona métodos para obtener y organizar los datos de contactos
 * de coordinadores y directivos desde el modelo, estructurados para la vista.
 */
class ContactosServicio
{
    /**
     * @var \Modelo\Paginas\ContactosModelo Instancia del modelo de Contactos.
     */
    private $modelo_contactos;

    /**
     * Constructor.
     *
     * Inicializa el modelo de Contactos.
     */
    public function __construct()
    {
        $this->modelo_contactos = new \Modelo\Paginas\ContactosModelo();
    }

    /**
     * Obtiene los contactos de directivos agrupados por núcleo.
     *
     * @return array Array asociativo donde la clave es el nombre del núcleo
     *               y el valor es un array de directivos con id, nombre, cargo,
     *               teléfono, email y oficina.
     */
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
                "id"       => $fila["id"],
                "nombre"   => $fila["nombre_completo"],
                "cargo"    => $fila["cargo"],
                "telefono" => $fila["telefono"],
                "email"    => $fila["email"],
                "oficina"  => $fila["oficina"]
            ];
        }

        return $contactos_directivos_array;
    }

    /**
     * Obtiene los contactos de coordinadores agrupados por carrera.
     *
     * @return array Array asociativo donde la clave es el nombre de la carrera
     *               y el valor es un array de coordinadores con id, nombre,
     *               título académico, teléfono, email, oficina y horario de atención.
     */
    public function obtenerContactosCoordinadores()
    {
        $contactos_coordinadores_data = $this->modelo_contactos->obtenerContactosCoordinadores();
        $contactos_coordinadores_array = [];

        foreach ($contactos_coordinadores_data as $fila) {
            $carrera = $fila["nombre_carrera"] ?? "Sin Carrera";

            $contactos_coordinadores_array[$carrera][] = [
                "id"                => $fila["id"],
                "nombre"            => $fila["nombre_completo"],
                "titulo_academico"  => $fila["titulo_academico"],
                "telefono"          => $fila["telefono"],
                "email"             => $fila["email"],
                "oficina"           => $fila["oficina"],
                "horario_atencion"  => $fila["horario_atencion"]
            ];
        }

        return $contactos_coordinadores_array;
    }
}