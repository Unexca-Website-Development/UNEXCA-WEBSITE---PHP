<?php
require_once colocar_ruta_sistema('@servicios/paginas/CarrerasServicio.php');

$slug = $_GET['carrera'] ?? null;
if (!$slug) {
    die("Carrera no encontrada");
}

$servicio = new CarrerasServicio();
$data_carreras = $servicio->obtenerDatosCarrera($slug);

if (!$data_carreras) {
    die("Carrera no encontrada");
}