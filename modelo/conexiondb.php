<?php
function conectarBD() {
    $host = 'localhost';
    $puerto = '5432';
    $nombredb = 'unexcadb';
    $usuario = 'postgres';
    $clave = '1234';

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

conectarBD();