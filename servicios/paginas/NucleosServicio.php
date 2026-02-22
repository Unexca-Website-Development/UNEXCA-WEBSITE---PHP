<?php
namespace Servicios\Paginas;
require_once colocar_ruta_sistema('@modelo/paginas/NucleosModelo.php');
/**
 * Servicio para la gestión de Núcleos y Extensiones Institucionales.
 *
 * Contiene la lógica de negocio para crear, editar, eliminar y listar núcleos,
 * así como la subida de imágenes.
 */
class NucleosServicio
{
    private $modelo_nucleos;
    public function __construct()
    {
        $this->modelo_nucleos = new \Modelo\Paginas\NucleosModelo();
    }
    /**
     * Obtiene el listado completo de núcleos
     *
     * @return array
     */
    public function obtenerTodos()
    {
        return $this->modelo_nucleos->obtenerNucleos();
    }
    /**
     * Obtiene un núcleo específico
     *
     * @param int $id
     * @return array|false
     */
    public function obtenerPorId($id)
    {
        return $this->modelo_nucleos->obtenerNucleoPorId($id);
    }
    /**
     * Guarda un nuevo núcleo
     *
     * @param array $datos
     * @param array|null $archivo_imagen
     * @return bool|string ID insertado o false
     * @throws \Exception
     */
    public function guardar($datos, $archivo_imagen = null)
    {
        $nombre = trim($datos['nombre'] ?? '');
        $direccion = trim($datos['direccion'] ?? '');
        
        if (empty($nombre) || empty($direccion)) {
            throw new \Exception("El nombre y la dirección son obligatorios.");
        }
        $imagen_url = 'default_nucleo.jpg';
        
        if ($archivo_imagen && isset($archivo_imagen['error']) && $archivo_imagen['error'] === UPLOAD_ERR_OK) {
            $imagen_url = ltrim($this->subirImagen($archivo_imagen), '/');
        }
        $nuevo_nucleo = [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'imagen' => ltrim($imagen_url, '/')
        ];
        return $this->modelo_nucleos->agregarNucleo($nuevo_nucleo);
    }
    /**
     * Actualiza un núcleo existente
     *
     * @param int $id
     * @param array $datos
     * @param array|null $archivo_imagen
     * @return int
     * @throws \Exception
     */
    public function actualizar($id, $datos, $archivo_imagen = null)
    {
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
            // Eliminar imagen anterior si no es la default
            if (!empty($imagen_url) && $imagen_url !== 'default_nucleo.jpg') {
                $ruta_sistema_anterior = colocar_ruta_sistema(' @imagenes/nucleos/') . basename($imagen_url);
                if (file_exists($ruta_sistema_anterior)) {
                    unlink($ruta_sistema_anterior);
                }
            }
            $imagen_url = $this->subirImagen($archivo_imagen);
        }
        $datos_actualizados = [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'imagen' => ltrim($imagen_url, '/')
        ];
        return $this->modelo_nucleos->editarNucleo($datos_actualizados, $id);
    }
    /**
     * Elimina un núcleo y su imagen
     *
     * @param int $id
     * @return int
     */
    public function eliminar($id)
    {
        $nucleo = $this->obtenerPorId($id);
        if ($nucleo) {
            // Eliminar la imagen si no es la default
            if (!empty($nucleo['imagen']) && $nucleo['imagen'] !== 'default_nucleo.jpg') {
                $ruta_sistema = colocar_ruta_sistema(' @imagenes/nucleos/') . basename($nucleo['imagen']);
                if (file_exists($ruta_sistema)) {
                    unlink($ruta_sistema);
                }
            }
            return $this->modelo_nucleos->borrarNucleo($id);
        }
        return false;
    }
    /**
     * Procesa la subida de la imagen y retorna la ruta en el servidor (HTML)
     *
     * @param array $archivo
     * @return string
     * @throws \Exception
     */
    private function subirImagen($archivo)
    {
        $directorio_sistema = colocar_ruta_sistema(' @imagenes/nucleos/');
        
        if (!file_exists($directorio_sistema)) {
            if (!mkdir($directorio_sistema, 0755, true)) {
                throw new \Exception("No se pudo crear el directorio para imágenes de núcleos.");
            }
        }
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        // Validar extension
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];
        if (!in_array(strtolower($extension), $extensiones_permitidas)) {
            throw new \Exception("Tipo de imagen no permitido.");
        }
        $nombre_archivo = uniqid('nucleo_') . '.' . $extension;
        $destino = $directorio_sistema . $nombre_archivo;
        if (move_uploaded_file($archivo['tmp_name'], $destino)) {
            return colocar_ruta_html(' @imagenes/nucleos/') . '/' . $nombre_archivo;
        }
        throw new \Exception("Error al subir la imagen al servidor.");
    }
}