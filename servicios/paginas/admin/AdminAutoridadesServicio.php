<?php
namespace Servicios\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/paginas/AutoridadesModelo.php');

/**
 * Servicio para la gestión administrativa de Autoridades.
 */
class AdminAutoridadesServicio
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new \Modelo\Paginas\AutoridadesModelo();
    }

    public function obtenerListado()
    {
        return $this->modelo->obtenerAutoridadesOrdenadas();
    }

    public function guardarAutoridad($datos, $archivo_imagen)
    {
        // 1. Manejo de la imagen
        $ruta_imagen = $this->procesarImagen($archivo_imagen);
        if ($ruta_imagen) {
            $datos['imagen'] = $ruta_imagen;
        } else {
            $datos['imagen'] = 'autoridades/default_autoridad.jpg';
        }

        // 2. Asignar orden (último + 1)
        // $datos['orden'] = ... (pendiente de implementación en BD)

        return $this->modelo->insertar('autoridades_academicas', $datos);
    }

    public function actualizarAutoridad($id, $datos, $archivo_imagen)
    {
        // 1. Manejo de imagen si se subió una nueva
        if ($archivo_imagen && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            $ruta_imagen = $this->procesarImagen($archivo_imagen);
            if ($ruta_imagen) {
                $datos['imagen'] = $ruta_imagen;
            }
        }

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

    private function procesarImagen($archivo)
    {
        if (!$archivo || $archivo['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        // Definir directorio de destino (publico/imagenes/autoridades/)
        $directorio_destino = __DIR__ . '/../../../publico/imagenes/autoridades/';
        
        // Asegurar que el nombre sea único
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombre_archivo = 'aut_' . time() . '.' . $extension;
        $ruta_destino = $directorio_destino . $nombre_archivo;

        if (move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
            return 'autoridades/' . $nombre_archivo; // Ruta relativa para guardar en BD
        }

        return null;
    }
}
