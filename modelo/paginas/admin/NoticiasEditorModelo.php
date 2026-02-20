<?php
namespace Modelo\Paginas\Admin;

require_once colocar_ruta_sistema('@modelo/BaseModelo.php');

/**
 * Clase NoticiasEditorModelo
 *
 * Gestiona la persistencia de noticias y su contenido en bloques.
 * Tablas: noticias, noticias_contenido
 *
 * @package Modelo\Paginas\Admin
 */
class NoticiasEditorModelo extends \Modelo\BaseModelo
{
    /**
     * Guarda una noticia completa con sus bloques de contenido de forma atómica
     *
     * @param array $estructura ['noticia' => [...], 'contenido' => [...]]
     * @return string|false ID de la noticia insertada o false si falla
     */
    public function guardarNoticiaCompleta(array $estructura)
    {
        $this->iniciarTransaccion();

        $noticia_id = $this->insertar('noticias', $estructura['noticia']);

        if (!$noticia_id) {
            $this->revertirTransaccion();
            return false;
        }

        foreach ($estructura['contenido'] as $bloque) {
            $bloque['noticia_id'] = $noticia_id;

            if (!$this->insertar('noticias_contenido', $bloque)) {
                $this->revertirTransaccion();
                return false;
            }
        }

        $this->confirmarTransaccion();
        return $noticia_id;
    }

    /**
     * Carga una noticia con todos sus bloques de contenido
     *
     * @param int $noticia_id
     * @return array|null ['noticia' => [...], 'contenido' => [...]] o null si no existe
     */
    public function cargarNoticia($noticia_id)
    {
        $noticia = $this->obtenerPorId('noticias', $noticia_id, 'noticia_id');

        if (!$noticia) {
            return null;
        }

        $contenido = $this->consultar(
            "SELECT * FROM noticias_contenido WHERE noticia_id = :noticia_id ORDER BY posicion ASC",
            ['noticia_id' => $noticia_id]
        );

        return [
            'noticia'   => $noticia,
            'contenido' => $contenido
        ];
    }

    /**
     * Elimina una noticia y todo su contenido de forma atómica
     *
     * @param int $noticia_id
     * @return bool
     */
    public function eliminarNoticia($noticia_id)
    {
        $this->iniciarTransaccion();

        $this->ejecutar(
            "DELETE FROM noticias_contenido WHERE noticia_id = :noticia_id",
            ['noticia_id' => $noticia_id]
        );

        $afectadas = $this->eliminar('noticias', $noticia_id, 'noticia_id');

        if ($afectadas === 0) {
            $this->revertirTransaccion();
            return false;
        }

        $this->confirmarTransaccion();
        return true;
    }

    /**
     * Actualiza los datos base de una noticia sin tocar el contenido
     *
     * @param int $noticia_id
     * @param array $data
     * @return int Filas afectadas
     */
    public function actualizarNoticia($noticia_id, array $data)
    {
        return $this->actualizar('noticias', $data, $noticia_id, 'noticia_id');
    }

    /**
     * Reemplaza todos los bloques de contenido de una noticia
     *
     * @param int $noticia_id
     * @param array $bloques
     * @return bool
     */
    public function reemplazarContenido($noticia_id, array $bloques)
    {
        $this->iniciarTransaccion();

        $this->ejecutar(
            "DELETE FROM noticias_contenido WHERE noticia_id = :noticia_id",
            ['noticia_id' => $noticia_id]
        );

        foreach ($bloques as $bloque) {
            $bloque['noticia_id'] = $noticia_id;

            if (!$this->insertar('noticias_contenido', $bloque)) {
                $this->revertirTransaccion();
                return false;
            }
        }

        $this->confirmarTransaccion();
        return true;
    }
}