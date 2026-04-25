<?php
namespace Servicios\Paginas;

require_once colocar_ruta_sistema('@modelo/paginas/InicioModelo.php');
require_once colocar_ruta_sistema('@modelo/paginas/NoticiasModelo.php');

/**
 * Servicio para la página de inicio.
 *
 * Proporciona métodos para obtener y procesar los datos de inicio, en particular
 * la información de carreras, para ser consumidos por la vista.
 */
class InicioServicio
{
    /**
     * @var \Modelo\Paginas\InicioModelo Instancia del modelo de inicio.
     */
    private $modelo_inicio;

    /**
     * @var \NoticiasModelo Instancia del modelo de noticias.
     */
    private $modelo_noticias;

    /**
     * Constructor.
     *
     * Inicializa el modelo de inicio.
     */
    public function __construct()
    {
        $this->modelo_inicio = new \Modelo\Paginas\InicioModelo();
        $this->modelo_noticias = new \NoticiasModelo();
    }

    /**
     * Obtiene los datos de las carreras.
     *
     * Procesa la información de la base de datos y la convierte en un array
     * listo para ser usado en la vista de inicio.
     *
     * @return array Lista de carreras con título, descripción, enlace e imagen.
     */
    public function obtenerDatosCarreras()
    {
        $carreras_lista = $this->modelo_inicio->obtenerCarrerasSimples();
        $carreras_array = [];

        foreach ($carreras_lista as $carrera) {
            $link_carrera = colocar_enlace('carrera', ['slug' => $carrera['slug']]);
            $carreras_array[] = [
                "titulo"      => $carrera['titulo'],
                "descripcion" => $carrera['descripcion'],
                "links"       => $link_carrera,
                "img"         => $carrera['imagen'],
            ];
        }

        return $carreras_array;
    }

    /**
     * Obtiene las noticias publicadas para la página de inicio.
     *
     * @return array
     */
    public function obtenerNoticias()
    {
        $noticias_lista = $this->modelo_noticias->obtenerNoticiasPublicadas(4);
        $noticias_array = [];

        foreach ($noticias_lista as $noticia) {
            $noticias_array[] = [
                'titulo' => $noticia['titulo_principal'],
                'img'    => $noticia['imagen_principal'],
                'link'   => colocar_enlace('noticia', ['url' => $noticia['url']])
            ];
        }

        return $noticias_array;
    }
}

