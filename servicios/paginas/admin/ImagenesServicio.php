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
        try {
            $this->validarArchivoSubido($archivo);

            $rutas = $this->obtenerRutas($tipoEntidad);
            $directorioDestino = $rutas['directorio'];
            
            $nombreArchivo = $this->generarNombreUnico($archivo['name']);
            $rutaDestinoFinal = $directorioDestino . $nombreArchivo;

            // Verificar si el directorio es escribible antes de intentar mover
            if (!is_writable($directorioDestino)) {
                $mensaje = "El directorio de destino no es escribible: $directorioDestino";
                \Servicios\Nucleo\Logger::registrar('ERROR', $mensaje);
                throw new \Exception($mensaje);
            }

            if (!move_uploaded_file($archivo['tmp_name'], $rutaDestinoFinal)) {
                $error = error_get_last();
                $mensaje = "Error de PHP al mover el archivo: " . ($error['message'] ?? 'Desconocido');
                \Servicios\Nucleo\Logger::registrar('ERROR', $mensaje);
                throw new \Exception('Error al mover el archivo subido a su destino final.');
            }

            $rutaParaBD = $rutas['publica'] . $nombreArchivo;
            $this->actualizarRegistroBD($tipoEntidad, $idEntidad, $rutaParaBD);

            \Servicios\Nucleo\Logger::registrar('INFO', "Imagen subida exitosamente: $rutaParaBD para $tipoEntidad ID $idEntidad");

            return $rutaParaBD;
        } catch (\Exception $e) {
            \Servicios\Nucleo\Logger::registrar('ERROR', "Fallo en subirImagen: " . $e->getMessage());
            throw $e;
        }
    }

    private function validarArchivoSubido(array $archivo): void 
    {
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            $errores_upload = [
                UPLOAD_ERR_INI_SIZE   => 'El archivo excede el límite definido en php.ini',
                UPLOAD_ERR_FORM_SIZE  => 'El archivo excede el límite definido en el formulario HTML',
                UPLOAD_ERR_PARTIAL    => 'El archivo se subió solo parcialmente',
                UPLOAD_ERR_NO_FILE    => 'No se subió ningún archivo',
                UPLOAD_ERR_NO_TMP_DIR => 'Falta la carpeta temporal en el servidor',
                UPLOAD_ERR_CANT_WRITE => 'Error al escribir el archivo en el disco',
                UPLOAD_ERR_EXTENSION  => 'Una extensión de PHP detuvo la subida'
            ];
            $mensaje = $errores_upload[$archivo['error']] ?? 'Error desconocido en la subida';
            throw new \Exception($mensaje);
        }

        $tipoMime = mime_content_type($archivo['tmp_name']);
        if (!in_array($tipoMime, ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
            throw new \Exception('Tipo de archivo no permitido. Solo se aceptan imágenes JPG, PNG, WEBP o GIF.');
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
        // Usar el sistema de alias de rutas para mayor consistencia
        $base = colocar_ruta_sistema('@imagenes') . '/';
        
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

        // Intentar crear el directorio si no existe o asegurar permisos si existe
        if (!is_dir($directorioCompleto)) {
            if (!mkdir($directorioCompleto, 0777, true)) {
                $mensaje = "No se pudo crear el directorio de destino: $directorioCompleto. Verifique los permisos de la carpeta padre.";
                \Servicios\Nucleo\Logger::registrar('ERROR', $mensaje);
                throw new \Exception($mensaje);
            }
        }
        
        // Intentar asegurar permisos siempre (útil en Linux si la carpeta existía pero no era escribible)
        @chmod($directorioCompleto, 0777);

        return [
            'directorio' => $directorioCompleto,
            'publica'    => $subcarpeta
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
