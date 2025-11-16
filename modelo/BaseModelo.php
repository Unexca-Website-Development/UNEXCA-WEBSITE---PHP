<?php
namespace Modelo;

require_once colocar_ruta_sistema('@modelo/conexionDB.php');

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
class BaseModelo {
    /**
     * @var \PDO Conexión PDO a la base de datos
     */
    private $pdo;

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
        'menu_enlaces_dinamicos'
    ];

    /**
     * Constructor
     *
     * Inicializa la conexión a la base de datos usando conectarBD().
     *
     * @throws \PDOException Si la conexión falla
     */
    public function __construct()
    {
        $this->pdo = conectarBD();
    }

    /**
     * Valida que la tabla exista dentro de las permitidas
     *
     * @param string $tabla Nombre de la tabla a validar
     * @throws \Exception Si la tabla no está permitida
     */
    private function validarTabla($tabla) 
    {
        if (!in_array($tabla, $this->tablasPermitidas)) {
            throw new \Exception("Tabla '$tabla' no permitida.");
        }
    }

    /**
     * Obtiene todos los registros de una tabla
     *
     * @param string $tabla Nombre de la tabla
     * @return array Lista de registros en formato asociativo
     * @throws \Exception Si la tabla no está permitida
     */
    public function obtenerTodos($tabla)
    {
        $this->validarTabla($tabla);
        $query = "SELECT * FROM {$tabla}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un registro por su ID
     *
     * @param string $tabla Nombre de la tabla
     * @param int $id ID del registro
     * @return array|null Registro encontrado o null si no existe
     * @throws \Exception Si la tabla no está permitida
     */
    public function obtenerPorId($tabla, $id)
    {
        $this->validarTabla($tabla);
        $query = "SELECT * FROM {$tabla} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Inserta un registro en la tabla especificada
     *
     * @param string $tabla Nombre de la tabla
     * @param array $data Datos a insertar (clave = columna, valor = valor)
     * @return bool Resultado de la operación
     * @throws \Exception Si la tabla no está permitida
     */
    public function insertar($tabla, $data)
    {
        $this->validarTabla($tabla);
        $columnas = implode(', ', array_keys($data));
        $valores = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$tabla} ($columnas) VALUES ($valores)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Actualiza un registro existente por ID
     *
     * @param string $tabla Nombre de la tabla
     * @param array $data Datos a actualizar (clave = columna, valor = valor)
     * @param int $id ID del registro a actualizar
     * @return bool Resultado de la operación
     * @throws \Exception Si la tabla no está permitida
     */
    public function actualizar($tabla, $data, $id)
    {
        $this->validarTabla($tabla);
        $camposArray = [];
        foreach ($data as $columna => $valor) {
            $camposArray[] = "$columna = :$columna";
        }
        $campos = implode(', ', $camposArray);
        $data['id'] = $id;

        $query = "UPDATE {$tabla} SET $campos WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Elimina un registro por ID
     *
     * @param string $tabla Nombre de la tabla
     * @param int $id ID del registro a eliminar
     * @return bool Resultado de la operación
     * @throws \Exception Si la tabla no está permitida
     */
    public function eliminar($tabla, $id)
    {
        $this->validarTabla($tabla);
        $query = "DELETE FROM {$tabla} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Ejecuta una consulta SQL personalizada
     *
     * @param string $sql Consulta SQL con placeholders
     * @param array $params Parámetros para la consulta
     * @return array Resultado en formato asociativo
     */
    public function ejecutarConsultaPersonalizada($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
