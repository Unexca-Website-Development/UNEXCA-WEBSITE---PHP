<?php
require_once colocar_ruta_sistema('@modelo/conexionDB.php');

class BaseModelo {
    private $pdo;

    //Tablas creadas en la base de datos de la unexca
    private $tablasPermitidas = 
    [
        'autoridades_academicas',
        'carrera',
        'carrera_id',
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
    ];

    public function __construct()
    {
        $this->pdo = conectarBD();
    }

    private function validarTabla($tabla) 
    {
        if (!in_array($tabla, $this->tablasPermitidas)) {
            throw new Exception("Tabla '$tabla' no permitida.");
        }
    }

    public function obtenerTodos($tabla)
    {
        $this->validarTabla($tabla);
        $query = "SELECT * FROM {$tabla}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($tabla, $id)
    {
        $this->validarTabla($tabla);
        $query = "SELECT * FROM {$tabla} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertar($tabla, $data)
    {
        $this->validarTabla($tabla);
        $columnas = implode(', ', array_keys($data));
        $valores = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$tabla} ($columnas) VALUES ($valores)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute($data);
    }

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

    public function eliminar($tabla, $id)
    {
        $this->validarTabla($tabla);
        $query = "DELETE FROM {$tabla} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    public function ejecutarConsultaPersonalizada($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
