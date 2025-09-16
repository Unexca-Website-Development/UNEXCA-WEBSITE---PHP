<?php
require_once colocar_ruta_sistema('@servicios/cargar_env.php');
cargar_env(__DIR__ . '/../.env.default');

function conectarBD() {
    $host     = $_ENV['DB_HOST'] ?? 'localhost';
    $puerto   = $_ENV['DB_PORT'] ?? '5432';
    $nombredb = $_ENV['DB_NAME'] ?? '';
    $usuario  = $_ENV['DB_USER'] ?? '';
    $clave    = $_ENV['DB_PASS'] ?? '';

    if (!$nombredb || !$usuario) {
        die("Error: variables de entorno de la base de datos no están definidas.");
    }

    $dsn = "pgsql:host=$host;port=$puerto;dbname=$nombredb";

    try {
        $pdo = new PDO($dsn, $usuario, $clave, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}