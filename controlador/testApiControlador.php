<?php
use Servicios\Nucleo\ControladorErroresHTTP;
use Servicios\Nucleo\Logger;


class TestApiControlador {
    public function mostrar($titulo = null, $contenido = null) {
        header('Content-Type: application/json');

        if (!$titulo || !$contenido) {
            ControladorErroresHTTP::error404();
            echo json_encode(['error' => 'Faltan campos']);
            return;
        }

        http_response_code(201);
        echo json_encode([
            'ok' => true,
            'mensaje' => 'Test API funcionando',
            'titulo' => $titulo,
            'contenido' => $contenido
        ]);

        Logger::registrar('INFO', 'Test API llamada correctamente: ' . json_encode([
                'titulo' => $titulo,
                'contenido' => $contenido
            ]), __FILE__, __LINE__);
    }
}