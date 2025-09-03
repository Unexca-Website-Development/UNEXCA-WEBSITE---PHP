<?php
require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

$slug = $_GET['nombre'] ?? null;

if (!$slug) {
    die("Carrera no encontrada");
}

$servicio = new CarrerasServicio();
$data_carreras = $servicio->obtenerDatosCarrera($slug);