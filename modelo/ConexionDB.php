<?php
namespace Modelo;

use PDO;
use PDOException;
use Exception;

/**
 * Clase ConexionDB
 *
 * Implementa el patrón Singleton para gestionar la conexión a la base de datos PostgreSQL.
 * Asegura que solo exista una instancia de conexión durante el ciclo de vida de la solicitud.
 *
 * @package Modelo
 */
class ConexionDB {
    /**
     * @var ConexionDB|null Instancia única de la clase
     */
    private static $instancia = null;

    /**
     * @var PDO Objeto de conexión PDO
     */
    private $pdo;

    /**
     * Constructor privado para evitar instanciación directa.
     * Lee las variables de entorno y establece la conexión PDO.
     * @throws Exception Si faltan variables de entorno críticas.
     */
    private function __construct() {
        $host     = $_ENV['DB_HOST'] ?? 'localhost';
        $puerto   = $_ENV['DB_PORT'] ?? '5432';
        $nombredb = $_ENV['DB_NAME'] ?? '';
        $usuario  = $_ENV['DB_USER'] ?? '';
        $clave    = $_ENV['DB_PASS'] ?? '';

        // Validación de variables críticas
        if (!$nombredb || !$usuario) {
            throw new Exception("Error: variables de entorno de la base de datos no están definidas.");
        }

        // DSN para PostgreSQL
        $dsn = "pgsql:host=$host;port=$puerto;dbname=$nombredb";

        try {
            $this->pdo = new PDO($dsn, $usuario, $clave, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Excepciones en errores de PDO
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch asociativo por defecto
                PDO::ATTR_PERSISTENT => false // Deshabilitar persistencia para evitar problemas en entornos compartidos
            ]);
        } catch (PDOException $e) {
            // En producción, esto debería loguearse y no mostrarse al usuario
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Obtiene la instancia única de la clase ConexionDB.
     *
     * @return ConexionDB La instancia única.
     */
    public static function obtenerInstancia() {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    /**
     * Obtiene el objeto PDO de la conexión.
     *
     * @return PDO El objeto de conexión.
     */
    public function obtenerConexion() {
        return $this->pdo;
    }
}
