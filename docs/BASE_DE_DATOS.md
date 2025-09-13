[< Volver al README principal](../README.md)

# Base de Datos

La persistencia de datos del proyecto se gestiona a través de un servidor de base de datos **PostgreSQL**.

## Conexión a la Base de Datos

La configuración de la conexión se encuentra en el archivo `modelo/conexiondb.php`. Este archivo, y toda la capa de acceso a datos, se describe con más detalle en la [documentación de Arquitectura](./ARQUITECTURA.md#análisis-por-directorios).

**Credenciales de ejemplo (deben ser adaptadas):**
-   **Host:** `localhost`
-   **Puerto:** `5432`
-   **Usuario:** `postgres`
-   **Contraseña:** `1234`
-   **Nombre de la BD:** `unexcadb`

```php
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
```

> **Nota de seguridad:** Es una mala práctica tener credenciales directamente en el código. Para un entorno de producción, se recomienda gestionar esta configuración a través de variables de entorno.

## Esquema de la Base de Datos

A continuación se presenta el script SQL para crear la estructura de la base de datos y sus tablas en **PostgreSQL**.

```sql
CREATE TABLE nucleos (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

CREATE TABLE carrera (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  link_malla_curricular VARCHAR(500),
  imagen VARCHAR(500)
);

CREATE TABLE contactos_directivos (
  id SERIAL PRIMARY KEY,
  nombre_completo VARCHAR(255) NOT NULL,
  cargo VARCHAR(255) NOT NULL,
  telefono VARCHAR(50),
  email VARCHAR(255),
  oficina TEXT,
  nucleo_id INTEGER REFERENCES nucleos(id) ON DELETE CASCADE
);

CREATE TABLE contactos_coordinadores_pnf (
  id SERIAL PRIMARY KEY,
  nombre_completo VARCHAR(255) NOT NULL,
  titulo_academico VARCHAR(100),
  telefono VARCHAR(50),
  email VARCHAR(255),
  oficina TEXT,
  horario_atencion TEXT,
  nucleo_id INTEGER REFERENCES nucleos(id) ON DELETE SET NULL,
  carrera_id INTEGER REFERENCES carrera(id) ON DELETE CASCADE
);

CREATE TABLE carrera_parrafos (
  id SERIAL PRIMARY KEY,
  carrera_id INT NOT NULL,
  numero_parrafo INT,
  contenido TEXT,
  FOREIGN KEY (carrera_id) REFERENCES carrera(id) ON DELETE CASCADE
);

CREATE TABLE carrera_turnos (
  id SERIAL PRIMARY KEY,
  carrera_id INT NOT NULL,
  turno VARCHAR(100),
  FOREIGN KEY (carrera_id) REFERENCES carrera(id) ON DELETE CASCADE
);

CREATE TABLE carrera_nucleos (
  id SERIAL PRIMARY KEY,
  carrera_id INT NOT NULL REFERENCES carrera(id) ON DELETE CASCADE,
  nucleo_id INT NOT NULL REFERENCES nucleos(id) ON DELETE CASCADE
);

CREATE TABLE autoridades_academicas (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  cargo VARCHAR(255) NOT NULL,
  imagen VARCHAR(500)
);

CREATE TABLE faqs (
  id SERIAL PRIMARY KEY,
  pregunta TEXT NOT NULL,
  respuesta TEXT NOT NULL
);

CREATE TABLE servicios (
  id SERIAL PRIMARY KEY,
  servicio TEXT NOT NULL,
  respuesta TEXT NOT NULL
);

CREATE TABLE header_links (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  url VARCHAR(500),
  id_padre INTEGER REFERENCES header_links(id) ON DELETE CASCADE
);

CREATE TABLE footer_secciones (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL
);

CREATE TABLE footer_links (
  id SERIAL PRIMARY KEY,
  texto VARCHAR(255) NOT NULL,
  url VARCHAR(500) NOT NULL,
  seccion_id INTEGER REFERENCES footer_secciones(id) ON DELETE CASCADE
);

CREATE TABLE carrera_niveles_academicos (
  id SERIAL PRIMARY KEY,
  carrera_id INTEGER NOT NULL REFERENCES carrera(id) ON DELETE CASCADE,
  nivel VARCHAR(50) NOT NULL,
  duracion VARCHAR(100) NOT NULL,
  diploma VARCHAR(255) NOT NULL
);
```