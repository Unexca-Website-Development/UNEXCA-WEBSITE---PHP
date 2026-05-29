# Documentación de la Base de Datos - Portal UNEXCA

El Portal Web de la UNEXCA utiliza **PostgreSQL** como sistema de gestión de base de datos relacional. Esta documentación detalla el esquema actual, las relaciones entre entidades y el sistema de acceso a datos.

## Arquitectura de Acceso a Datos

El proyecto utiliza una capa de Modelos que heredan de `BaseModelo.php`, empleando **PDO** con el driver `pgsql` para interactuar con la base de datos.

### Configuración de Conexión
La conexión se gestiona en `modelo/ConexionDB.php`. Se recomienda el uso de variables de entorno (`.env`) para las credenciales.

## Esquema de Tablas

### 1. Gestión de Contenido Académico

#### **nucleos**
Almacena las sedes o núcleos de la universidad.
- `id`: Identificador único (SERIAL).
- `nombre`: Nombre del núcleo (Altagracia, La Floresta, etc.).
- `imagen`: Ruta a la imagen representativa.
- `direccion`: Dirección física del núcleo.

#### **carrera**
Información principal de los Programas Nacionales de Formación (PNF).
- `id`: Identificador único.
- `titulo`: Nombre de la carrera.
- `descripcion`: Resumen descriptivo.
- `link_malla_curricular`: Enlace al PDF de la malla.
- `imagen`: Imagen de cabecera.
- `slug`: Identificador amigable para URLs (ej: `ing-informatica`).

#### **carrera_parrafos**
Contenido detallado de las carreras dividido en párrafos.
- `carrera_id`: Relación con la carrera.
- `contenido`: Texto del párrafo.

#### **carrera_turnos**
Horarios disponibles para cada carrera.
- `turno`: Mañana, Tarde, Noche.

#### **carrera_niveles_academicos**
Títulos y duraciones (TSU, Licenciatura, Ingeniería).
- `nivel`: Grado académico.
- `duracion`: Tiempo estimado.
- `diploma`: Título que se otorga.

#### **carrera_nucleos**
Relación muchos a muchos entre carreras y núcleos.

### 2. Sistema de Noticias (Editor de Bloques)

El portal cuenta con un editor de noticias dinámico basado en bloques JSON.

#### **noticias**
- `noticia_id`: Identificador único.
- `titulo_principal`: Titular de la noticia.
- `descripcion_corta`: Resumen para listados.
- `imagen_principal`: URL de la imagen de portada.
- `estado`: `borrador` o `publicado`.
- `fecha_publicacion`: Fecha programada o de salida.

#### **noticias_contenido**
Almacena el cuerpo de la noticia en formato modular.
- `noticia_id`: Relación con la noticia.
- `tipo_bloque`: Tipo de contenido (`titulo`, `parrafo`, `imagen`, `cita`).
- `datos`: Objeto **JSONB** con los datos específicos del bloque (ej: `{ "texto": "...", "autor": "..." }`).
- `posicion`: Orden de visualización.

### 3. Directorio y Contactos

#### **contactos_directivos**
Personal administrativo y directivo por núcleo.

#### **contactos_coordinadores_pnf**
Coordinadores de carrera específicos por sede.

#### **autoridades_academicas**
Altos cargos universitarios (Rector, Vicerrectores).

### 4. Navegación Dinámica

#### **menus**
Definición de menús del sistema (Header, Footer, etc.).

#### **menu_enlaces_estaticos**
Enlaces fijos definidos en la base de datos. Soporta jerarquía (padre/hijo).

#### **menu_enlaces_dinamicos**
Enlaces que apuntan a registros de otras tablas (ej: enlace automático a una carrera específica).

### 5. Seguridad y Administración

#### **usuarios**
Gestión de acceso al panel administrativo.
- `usuario`: Nombre de acceso.
- `password`: Hash de la contraseña (BCRYPT).
- `rol`: Nivel de acceso (`admin`, `editor`, etc.).

---

## Procedimiento de Respaldo y Restauración

### Generar Respaldo
```bash
pg_dump -U postgres -d unexcadb > respaldo.sql
```

### Restaurar Respaldo
```bash
psql -U postgres -d unexcadb < respaldo.sql
```
