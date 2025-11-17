<?php
/**
 * Conecta a la base de datos PostgreSQL usando PDO
 *
 * Lee los datos de conexión desde variables de entorno:
 * - DB_HOST: host de la base de datos (default 'localhost')
 * - DB_PORT: puerto de conexión (default '5432')
 * - DB_NAME: nombre de la base de datos
 * - DB_USER: usuario
 * - DB_PASS: contraseña
 *
 * @return \PDO Instancia de PDO conectada a la base de datos
 * @throws \Exception Si faltan variables de entorno críticas o falla la conexión
 */
function conectarBD() {
    $host     = $_ENV['DB_HOST'] ?? 'localhost';
    $puerto   = $_ENV['DB_PORT'] ?? '5432';
    $nombredb = $_ENV['DB_NAME'] ?? '';
    $usuario  = $_ENV['DB_USER'] ?? '';
    $clave    = $_ENV['DB_PASS'] ?? '';

    // Validación de variables críticas
    if (!$nombredb || !$usuario) {
        die("Error: variables de entorno de la base de datos no están definidas.");
    }

    // DSN para PostgreSQL
    $dsn = "pgsql:host=$host;port=$puerto;dbname=$nombredb";

    try {
        $pdo = new PDO($dsn, $usuario, $clave, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Excepciones en errores de PDO
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // Manejo de error de conexión
        die("Error de conexión: " . $e->getMessage());
    }
}
