<?php

namespace Servicios\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/paginas/AutoridadesModelo.php');
require_once colocar_ruta_sistema('@modelo/paginas/NucleosModelo.php');
require_once colocar_ruta_sistema('@modelo/paginas/admin/NoticiasEditorModelo.php');

class ImagenesServicio 
{
    private $autoridadesModelo;
    private $nucleosModelo;
    private $noticiasModelo;

    public function __construct() {
        $this->autoridadesModelo = new \Modelo\Paginas\AutoridadesModelo();
        $this->nucleosModelo = new \Modelo\Paginas\NucleosModelo();
        $this->noticiasModelo = new \Modelo\Paginas\Admin\NoticiasEditorModelo();
    }

    /**
     * Procesa la subida de una imagen, la guarda y actualiza la BD.
     *
     * @param array $archivo El array $_FILES['nombre_input'].
     * @param string $tipoEntidad 'autoridad', 'nucleo' o 'noticia'.
     * @param int $idEntidad El ID del registro a actualizar.
     * @return string La ruta pública de la imagen guardada.
     * @throws \Exception Si ocurre un error.
     */
    public function subirImagen(array $archivo, string $tipoEntidad, int $idEntidad): string 
    {
        $this->validarArchivoSubido($archivo);

        $rutas = $this->obtenerRutas($tipoEntidad);
        $directorioDestino = $rutas['directorio'];
        
        $nombreArchivo = $this->generarNombreUnico($archivo['name']);
        $rutaDestinoFinal = $directorioDestino . $nombreArchivo;

        if (!move_uploaded_file($archivo['tmp_name'], $rutaDestinoFinal)) {
            throw new \Exception('Error al mover el archivo subido a su destino final.');
        }

        $rutaParaBD = $rutas['publica'] . $nombreArchivo;
        $this->actualizarRegistroBD($tipoEntidad, $idEntidad, $rutaParaBD);

        return $rutaParaBD;
    }

    private function validarArchivoSubido(array $archivo): void 
    {
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Error en la subida del archivo. Código: " . $archivo['error']);
        }

        $tipoMime = mime_content_type($archivo['tmp_name']);
        if (!in_array($tipoMime, ['image/jpeg', 'image/png', 'image/gif'])) {
            throw new \Exception('Tipo de archivo no permitido. Solo se aceptan imágenes JPG, PNG o GIF.');
        }

        if ($archivo['size'] > 5 * 1024 * 1024) { // 5 MB
            throw new \Exception('El archivo es demasiado grande. El límite es 5 MB.');
        }
    }

    private function generarNombreUnico(string $nombreOriginal): string
    {
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        return uniqid(date('Ymd_His_')) . '.' . strtolower($extension);
    }

    private function obtenerRutas(string $tipo): array 
    {
        // DOCUMENT_ROOT puede no ser fiable en todos los entornos. Se asume una estructura de carpetas estándar.
        // La ruta del proyecto es la carpeta padre de 'servicios'
        $rutaProyecto = dirname(dirname(dirname(__DIR__)));
        $base = $rutaProyecto . '/publico/imagenes/';
        $publicBase = '/publico/imagenes/';

        $subcarpeta = '';
        switch ($tipo) {
            case 'autoridad':
                $subcarpeta = 'autoridades/';
                break;
            case 'nucleo':
                $subcarpeta = 'nucleos/';
                break;
            case 'noticia':
                $subcarpeta = 'noticias/';
                break;
            default:
                throw new \Exception("Tipo de entidad '$tipo' no reconocido.");
        }

        $directorioCompleto = $base . $subcarpeta;
        if (!is_dir($directorioCompleto)) {
            if (!mkdir($directorioCompleto, 0775, true)) {
                throw new \Exception("No se pudo crear el directorio de destino: $directorioCompleto");
            }
        }

        return [
            'directorio' => $directorioCompleto,
            'publica'    => $publicBase . $subcarpeta
        ];
    }

    private function actualizarRegistroBD(string $tipo, int $id, string $rutaImagen): void
    {
        switch ($tipo) {
            case 'autoridad':
                $this->autoridadesModelo->actualizar('autoridades_academicas', ['imagen' => $rutaImagen], $id);
                break;
            case 'nucleo':
                $this->nucleosModelo->actualizar('nucleos', ['imagen' => $rutaImagen], $id);
                break;
            case 'noticia':
                $this->noticiasModelo->actualizar('noticias', ['imagen_principal' => $rutaImagen], $id, 'noticia_id');
                break;
        }
    }
}
