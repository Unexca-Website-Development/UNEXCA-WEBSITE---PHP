<?php
namespace Servicios\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/paginas/admin/AdminNucleosModelo.php');
require_once colocar_ruta_sistema('@servicios/paginas/admin/ImagenesServicio.php');

/**
 * Servicio para la gestión de Núcleos en el panel de administración.
 */
class AdminNucleosServicio {
    private $modelo_nucleos;
    private $imagenesServicio;

    public function __construct() {
        $this->modelo_nucleos = new \Modelo\Paginas\Admin\AdminNucleosModelo();
        $this->imagenesServicio = new \Servicios\Paginas\Admin\ImagenesServicio();
    }

    public function obtenerTodos() {
        return $this->modelo_nucleos->obtenerNucleos();
    }

    public function obtenerPorId($id) {
        return $this->modelo_nucleos->obtenerNucleoPorId($id);
    }

    public function guardar($datos, $archivo_imagen = null) {
        $nombre = trim($datos['nombre'] ?? '');
        $direccion = trim($datos['direccion'] ?? '');

        if (empty($nombre) || empty($direccion)) {
            throw new \Exception("El nombre y la dirección son obligatorios.");
        }

        $nuevo_nucleo = [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'imagen' => null
        ];
        
        $id = $this->modelo_nucleos->agregarNucleo($nuevo_nucleo);

        if ($id && $archivo_imagen && isset($archivo_imagen['error']) && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            try {
                $this->imagenesServicio->subirImagen($archivo_imagen, 'nucleo', $id);
            } catch (\Exception $e) {
                // Logueado en ImagenesServicio
            }
        }

        return $id;
    }

    public function actualizar($id, $datos, $archivo_imagen = null) {
        $nucleo_existente = $this->obtenerPorId($id);
        if (!$nucleo_existente) {
            throw new \Exception("El núcleo a editar no existe.");
        }

        $nombre = trim($datos['nombre'] ?? '');
        $direccion = trim($datos['direccion'] ?? '');

        if (empty($nombre) || empty($direccion)) {
            throw new \Exception("El nombre y la dirección son obligatorios.");
        }

        if ($archivo_imagen && isset($archivo_imagen['error']) && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            // Borrar imagen anterior si existe y no es la de por defecto
            $imagen_url = $nucleo_existente['imagen'];
            if (!empty($imagen_url) && strpos($imagen_url, 'default_') === false) {
                $nombre_archivo_anterior = basename($imagen_url);
                $ruta_sistema_anterior = colocar_ruta_sistema('@imagenes') . '/nucleos/' . $nombre_archivo_anterior;
                if (file_exists($ruta_sistema_anterior)) {
                    unlink($ruta_sistema_anterior);
                }
            }
            
            try {
                $this->imagenesServicio->subirImagen($archivo_imagen, 'nucleo', $id);
            } catch (\Exception $e) {
                // Logueado en ImagenesServicio
            }
        }

        $datos_actualizados = [
            'nombre' => $nombre,
            'direccion' => $direccion
        ];
        return $this->modelo_nucleos->editarNucleo($datos_actualizados, $id);
    }

    public function eliminar($id) {
        $nucleo = $this->obtenerPorId($id);
        if ($nucleo) {
            // Borrar imagen si existe y no es la de por defecto
            if (!empty($nucleo['imagen']) && strpos($nucleo['imagen'], 'default_') === false) {
                $nombre_archivo = basename($nucleo['imagen']);
                $ruta_sistema = colocar_ruta_sistema('@imagenes') . '/nucleos/' . $nombre_archivo;
                if (file_exists($ruta_sistema)) {
                    unlink($ruta_sistema);
                }
            }
            return $this->modelo_nucleos->borrarNucleo($id);
        }
        return false;
    }
}
