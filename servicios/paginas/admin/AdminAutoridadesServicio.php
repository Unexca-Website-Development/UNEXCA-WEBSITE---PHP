<?php
namespace Servicios\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/paginas/AutoridadesModelo.php');

require_once colocar_ruta_sistema('@servicios/paginas/admin/ImagenesServicio.php');

/**
 * Servicio para la gestión administrativa de Autoridades.
 */
class AdminAutoridadesServicio
{
    private $modelo;
    private $imagenesServicio;

    public function __construct()
    {
        $this->modelo = new \Modelo\Paginas\AutoridadesModelo();
        $this->imagenesServicio = new \Servicios\Paginas\Admin\ImagenesServicio();
    }

    public function obtenerListado()
    {
        return $this->modelo->obtenerAutoridadesOrdenadas();
    }

    public function guardarAutoridad($datos, $archivo_imagen)
    {
        // 1. Insertar primero para obtener el ID
        // Asignar orden (último + 1)
        $max_orden = $this->modelo->ejecutarYRetornarValor("SELECT COALESCE(MAX(orden), 0) FROM autoridades_academicas");
        $datos['orden'] = $max_orden + 1;
        
        // Imagen por defecto inicialmente
        $datos['imagen'] = 'autoridades/default_autoridad.jpg';

        $id = $this->modelo->insertar('autoridades_academicas', $datos);

        // 2. Si hay imagen, procesarla con ImagenesServicio (que actualizará la BD)
        if ($id && $archivo_imagen && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            try {
                $this->imagenesServicio->subirImagen($archivo_imagen, 'autoridad', $id);
            } catch (\Exception $e) {
                // El error ya se loguea en ImagenesServicio
            }
        }

        return $id;
    }

    public function actualizarAutoridad($id, $datos, $archivo_imagen)
    {
        // 1. Manejo de imagen si se subió una nueva
        if ($archivo_imagen && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            try {
                $this->imagenesServicio->subirImagen($archivo_imagen, 'autoridad', $id);
            } catch (\Exception $e) {
                // El error ya se loguea en ImagenesServicio
            }
        }

        // 2. Actualizar el resto de los datos
        return $this->modelo->actualizar('autoridades_academicas', $datos, $id);
    }

    public function eliminarAutoridad($id)
    {
        return $this->modelo->eliminar('autoridades_academicas', $id);
    }

    public function reordenar($id, $direccion)
    {
        $autoridades = $this->modelo->obtenerAutoridadesOrdenadas();
        $indice = -1;

        // Encontrar el índice actual
        foreach ($autoridades as $key => $aut) {
            if ($aut['id'] == $id) {
                $indice = $key;
                break;
            }
        }

        if ($indice === -1) return false;

        $otroIndice = ($direccion === 'subir') ? $indice - 1 : $indice + 1;

        // Verificar si existe un vecino en esa dirección
        if (isset($autoridades[$otroIndice])) {
            $actual = $autoridades[$indice];
            $vecino = $autoridades[$otroIndice];

            // Intercambiar valores de orden
            $this->modelo->actualizar('autoridades_academicas', ['orden' => $vecino['orden']], $actual['id']);
            $this->modelo->actualizar('autoridades_academicas', ['orden' => $actual['orden']], $vecino['id']);
            return true;
        }

        return false;
    }
}
