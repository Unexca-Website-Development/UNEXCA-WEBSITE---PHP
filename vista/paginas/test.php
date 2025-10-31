<?php
require_once colocar_ruta_sistema('@modelo/paginas/NoticiasEditorModelo.php');

$modelo = new NoticiasEditorModelo;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['accion'] === 'crear') {
        $data = [
            'titulo_principal'   => $_POST['titulo_principal'],
            'descripcion_corta'  => $_POST['descripcion_corta'],
            'imagen_principal'   => $_POST['imagen_principal'],
            'descripcion_imagen' => $_POST['descripcion_imagen'],
            'url'                => $_POST['url']
        ];
        $modelo->crearNoticia($data);
        echo "<p>Noticia creada correctamente</p>";
    }

    if ($_POST['accion'] === 'crear_bloque') {
        $datos_json = [
            'contenido' => $_POST['contenido']
        ];

        $data = [
            'noticia_id' => $_POST['noticia_id'],
            'tipo_bloque'=> $_POST['tipo'],
            'datos'      => json_encode($datos_json, JSON_UNESCAPED_UNICODE),
            'posicion'   => $_POST['posicion']
        ];
        $modelo->crearBloqueNoticia($data);
        echo "<p>Bloque agregado correctamente</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba NoticiasEditorModelo</title>
</head>
<body>
    <form method="POST">
        <h2>Crear Noticia</h2>
        <label>Título principal:</label>
        <input type="text" name="titulo_principal" required><br>

        <label>Descripción corta:</label>
        <textarea name="descripcion_corta" required></textarea><br>

        <label>Imagen principal:</label>
        <input type="text" name="imagen_principal" required><br>

        <label>Descripción de la imagen:</label>
        <input type="text" name="descripcion_imagen"><br>

        <label>URL amigable:</label>
        <input type="text" name="url" required><br>

        <button type="submit" name="accion" value="crear">Guardar Noticia</button>
    </form>

    <hr>

    <form method="POST">
        <h2>Agregar Bloque a Noticia</h2>
        <label>ID de la Noticia:</label>
        <input type="number" name="noticia_id" required><br>

        <label>Tipo de Bloque:</label>
        <input type="text" name="tipo" required><br>

        <label>Contenido:</label>
        <textarea name="contenido" required></textarea><br>

        <label>Posición:</label>
        <input type="number" name="posicion" required><br>

        <button type="submit" name="accion" value="crear_bloque">Agregar Bloque</button>
    </form>

    <script>
        // Opcional: previsualización simple del JSON
        const textarea = document.querySelector('textarea[name="contenido"]');
        textarea.addEventListener('input', () => {
            console.log(JSON.stringify({contenido: textarea.value}));
        });
    </script>
</body>
</html>
