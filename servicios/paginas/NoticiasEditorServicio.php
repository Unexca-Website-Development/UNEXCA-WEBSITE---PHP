<?php
require_once colocar_ruta_sistema('@modelo/paginas/NoticiasEditorModelo.php');
require_once colocar_ruta_sistema('@servicios/utilidadesNoticiasEditor.php');

class NoticiasEditorServicio {
	private $modelo_noticias_editor;

	public function __construct() {
		$this->modelo_noticias_editor = new NoticiasEditorModelo();
	}

	public function crearNoticiaConBloques(array $data, array $bloques) {
		$noticiaID = $this->modelo_noticias_editor->crearNoticia($data);
		if (!$noticiaID) return false;

		// Crear carpeta de la noticia
		crearCarpetaNoticia($data['fecha_publicacion'] ?? date('Y-m-d'), $noticiaID, $data['url']);

		// Preparar bloques para DB
		$bloquesDB = prepararBloquesJSON($bloques);

		foreach ($bloquesDB as $bloque) {
			$bloque['noticia_id'] = $noticiaID;
			$this->modelo_noticias_editor->crearBloqueNoticia($bloque);
		}

		return $noticiaID;
	}

	// Actualizar bloques existentes
	public function actualizarBloquesNoticia(int $noticiaID, array $bloques) {
		$bloquesDB = prepararBloquesJSON($bloques);

		foreach ($bloquesDB as $bloque) {
			$bloque['noticia_id'] = $noticiaID;

			if (!empty($bloque['contenido_id'])) {
				$this->modelo_noticias_editor->actualizar('noticias_contenido', [
					'tipo_bloque' => $bloque['tipo_bloque'],
					'datos'       => $bloque['datos'],
					'posicion'    => $bloque['posicion']
				], $bloque['contenido_id']);
			} else {
				$this->modelo_noticias_editor->crearBloqueNoticia($bloque);
			}
		}
	}

	// Obtener noticia con bloques para edición
	public function obtenerNoticiaConBloques(int $noticiaID) {
		$noticia = $this->modelo_noticias_editor->obtenerNoticiaPorId($noticiaID);
		$bloques = $this->modelo_noticias_editor->obtenerBloquesPorNoticia($noticiaID);

		foreach ($bloques as &$bloque) {
			$bloque['datos'] = json_decode($bloque['datos'], true);
		}

		return [
			'noticia' => $noticia[0] ?? null,
			'bloques' => $bloques
		];
	}

	// Eliminar noticia completa
	public function eliminarNoticia(int $noticiaID, string $fecha, string $slug) {
		// Borrar carpeta con imágenes
		eliminarCarpetaNoticia($fecha, $noticiaID, $slug);

		// Borrar noticia y sus bloques (cascade)
		return $this->modelo_noticias_editor->eliminarNoticia($noticiaID);
	}
}