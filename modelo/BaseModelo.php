<?php
namespace Modelo;

require_once colocar_ruta_sistema('@modelo/ConexionDB.php');

/**
 * Clase BaseModelo
 *
 * Proporciona operaciones CRUD genéricas para las tablas permitidas
 * de la base de datos de la UNEXCA. Incluye métodos para:
 * - Obtener todos los registros
 * - Obtener por ID
 * - Insertar, actualizar y eliminar registros
 * - Ejecutar consultas personalizadas
 *
 * @package Modelo
 */
class BaseModelo
{
    /**
     * @var \PDO Conexión PDO a la base de datos
     */
    protected $pdo;

    /**
     * @var array Listado de tablas permitidas para operaciones CRUD
     */
    private $tablasPermitidas =
    [
        'autoridades_academicas',
        'carrera',
        'carrera_niveles_academicos',
        'carrera_nucleos',
        'carrera_parrafos',
        'carrera_turnos',
        'contactos_coordinadores_pnf',
        'contactos_directivos',
        'faqs',
        'footer_links',
        'footer_secciones',
        'header_links',
        'nucleos',
        'servicios',
        'menus',
        'menu_enlaces_estaticos',
        'menu_enlaces_dinamicos',
        'noticias',
        'noticias_contenido',
    ];

    /**
     * Constructor
     *
     * Inicializa la conexión a la base de datos usando el Singleton ConexionDB.
     *
     * @throws \Exception Si la conexión falla
     */
    public function __construct()
    {
        $this->pdo = ConexionDB::obtenerInstancia()->obtenerConexion();
    }

    /**
     * Valida que la tabla exista dentro de las permitidas
     *
     * @param string $tabla Nombre de la tabla a validar
     * @throws \InvalidArgumentException Si la tabla no está permitida o no es un string
     */
    private function validarTabla($tabla)
    {
        if (!is_string($tabla) || !in_array($tabla, $this->tablasPermitidas)) {
            throw new \InvalidArgumentException("Error de Lógica: La tabla '$tabla' no existe en la lista blanca de BaseModelo.");
        }
    }

    /**
     * Obtiene todos los registros de una tabla
     *
     * @param string $tabla
     * @param array $filtros Columna => valor para WHERE
     * @param string|null $orden Columna y dirección (ej: 'id DESC')
     * @param int|null $limite
     * @return array
     * @throws \InvalidArgumentException
     */
    public function obtenerTodos($tabla, array $filtros = [], $orden = null, $limite = null)
    {
        $this->validarTabla($tabla);
        $query = "SELECT * FROM {$tabla}";
        $params = [];

        if (!empty($filtros)) {
            $condiciones = [];
            foreach ($filtros as $columna => $valor) {
                $condiciones[] = "$columna = :$columna";
                $params[$columna] = $valor;
            }
            $query .= ' WHERE ' . implode(' AND ', $condiciones);
        }

        if ($orden !== null) {
            $query .= " ORDER BY $orden";
        }

        if ($limite !== null) {
            $query .= " LIMIT " . (int)$limite;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un registro por su clave primaria
     *
     * @param string $tabla
     * @param int|string $id
     * @param string $columna Nombre de la clave primaria
     * @return array|false
     * @throws \InvalidArgumentException
     */
    public function obtenerPorId($tabla, $id, $columna = 'id')
    {
        $this->validarTabla($tabla);
        $query = "SELECT * FROM {$tabla} WHERE {$columna} = :valor";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['valor' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Inserta un registro en la tabla especificada
     *
     * @param string $tabla
     * @param array $data Columna => valor
     * @return string|false ID del registro insertado o false si falla
     * @throws \InvalidArgumentException
     */
    public function insertar($tabla, $data)
    {
        $this->validarTabla($tabla);
        $columnas = implode(', ', array_keys($data));
        $valores = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$tabla} ($columnas) VALUES ($valores)";
        $stmt = $this->pdo->prepare($query);

        if (!$stmt->execute($data)) {
            return false;
        }

        return $this->pdo->lastInsertId();
    }

    /**
     * Actualiza un registro existente por clave primaria
     *
     * @param string $tabla
     * @param array $data Columna => valor
     * @param int|string $id
     * @param string $columna Nombre de la clave primaria
     * @return int Filas afectadas
     * @throws \InvalidArgumentException
     */
    public function actualizar($tabla, $data, $id, $columna = 'id')
    {
        $this->validarTabla($tabla);
        $camposArray = [];
        foreach ($data as $col => $valor) {
            $camposArray[] = "$col = :$col";
        }
        $campos = implode(', ', $camposArray);
        $data['__pk'] = $id;

        $query = "UPDATE {$tabla} SET $campos WHERE {$columna} = :__pk";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        return $stmt->rowCount();
    }

    /**
     * Elimina un registro por clave primaria
     *
     * @param string $tabla
     * @param int|string $id
     * @param string $columna Nombre de la clave primaria
     * @return int Filas afectadas
     * @throws \InvalidArgumentException
     */
    public function eliminar($tabla, $id, $columna = 'id')
    {
        $this->validarTabla($tabla);
        $query = "DELETE FROM {$tabla} WHERE {$columna} = :valor";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['valor' => $id]);
        return $stmt->rowCount();
    }
    /**
     * Ejecuta un SELECT y retorna todos los resultados
     *
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function consultar($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Ejecuta un INSERT, UPDATE o DELETE y retorna filas afectadas
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function ejecutar($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    /**
     * Ejecuta una consulta y retorna un único valor escalar
     *
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public function ejecutarYRetornarValor($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    /**
     * Inicia una transacción
     *
     * @return bool
     */
    public function iniciarTransaccion()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * Confirma la transacción activa
     *
     * @return bool
     */
    public function confirmarTransaccion()
    {
        return $this->pdo->commit();
    }

    /**
     * Revierte la transacción activa
     *
     * @return bool
     */
    public function revertirTransaccion()
    {
        return $this->pdo->rollBack();
    }
}
