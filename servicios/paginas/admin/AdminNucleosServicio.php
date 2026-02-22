<?php
namespace Servicios\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/paginas/NucleosModelo.php');

/**
 * Servicio para la gestión de Núcleos en el panel de administración.
 */
class AdminNucleosServicio {
    private $modelo_nucleos;

    public function __construct() {
        $this->modelo_nucleos = new \Modelo\Paginas\NucleosModelo();
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

        $imagen_url = 'publico/imagenes/nucleos/default_nucleo.jpg';
        if ($archivo_imagen && isset($archivo_imagen['error']) && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            $imagen_url = $this->subirImagen($archivo_imagen);
        }

        $nuevo_nucleo = [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'imagen' => $imagen_url
        ];
        return $this->modelo_nucleos->agregarNucleo($nuevo_nucleo);
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

        $imagen_url = $nucleo_existente['imagen'];
        if ($archivo_imagen && isset($archivo_imagen['error']) && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            if (!empty($imagen_url) && strpos($imagen_url, 'default_nucleo.jpg') === false) {
                $ruta_sistema_anterior = colocar_ruta_sistema('@') . $imagen_url;
                if (file_exists($ruta_sistema_anterior)) {
                    unlink($ruta_sistema_anterior);
                }
            }
            $imagen_url = $this->subirImagen($archivo_imagen);
        }

        $datos_actualizados = [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'imagen' => $imagen_url
        ];
        return $this->modelo_nucleos->editarNucleo($datos_actualizados, $id);
    }

    public function eliminar($id) {
        $nucleo = $this->obtenerPorId($id);
        if ($nucleo) {
            if (!empty($nucleo['imagen']) && strpos($nucleo['imagen'], 'default_nucleo.jpg') === false) {
                $ruta_sistema = colocar_ruta_sistema('@') . $nucleo['imagen'];
                if (file_exists($ruta_sistema)) {
                    unlink($ruta_sistema);
                }
            }
            return $this->modelo_nucleos->borrarNucleo($id);
        }
        return false;
    }

    private function subirImagen($archivo) {
        $directorio_destino = 'publico/imagenes/nucleos/';
        $ruta_directorio_sistema = colocar_ruta_sistema('@' . $directorio_destino);

        if (!file_exists($ruta_directorio_sistema)) {
            if (!mkdir($ruta_directorio_sistema, 0755, true)) {
                throw new \Exception("No se pudo crear el directorio para imágenes de núcleos.");
            }
        }

        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array(strtolower($extension), $extensiones_permitidas)) {
            throw new \Exception("Tipo de imagen no permitido.");
        }

        $nombre_archivo = uniqid('nucleo_') . '.' . $extension;
        $ruta_completa_destino = $ruta_directorio_sistema . $nombre_archivo;

        if (move_uploaded_file($archivo['tmp_name'], $ruta_completa_destino)) {
            return $directorio_destino . $nombre_archivo;
        }

        throw new \Exception("Error al subir la imagen al servidor.");
    }
}
