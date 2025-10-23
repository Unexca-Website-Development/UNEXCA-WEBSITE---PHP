# Guía de Instalación y Configuración - Portal UNEXCA

## Resumen Ejecutivo

Esta guía proporciona instrucciones detalladas para la instalación y configuración completa del Portal UNEXCA en un entorno de desarrollo. Incluye todos los pasos necesarios desde la preparación del entorno hasta la puesta en marcha del sistema.

## Requisitos del Sistema

### Requisitos Mínimos
- **Sistema Operativo**: Windows 10+, macOS 10.14+, Ubuntu 18.04+
- **RAM**: 4GB mínimo, 8GB recomendado
- **Espacio en Disco**: 2GB libres
- **Conexión a Internet**: Para descargar dependencias

### Software Requerido
- **PHP**: 7.4 o superior (8.0+ recomendado)
- **PostgreSQL**: 12.0 o superior
- **Servidor Web**: Apache 2.4+ o Nginx 1.18+
- **Git**: Para control de versiones
- **Composer**: Para gestión de dependencias (opcional)

## Opciones de Entorno de Desarrollo

### Comparación de Opciones

| Característica | Máquina Virtual | XAMPP | Docker | Entorno Nativo |
|----------------|-----------------|-------|--------|----------------|
| **Dificultad** | ⭐⭐ Fácil | ⭐⭐⭐ Medio | ⭐⭐⭐⭐ Avanzado | ⭐⭐⭐⭐⭐ Experto |
| **Tiempo Setup** | 30 min | 2-3 horas | 1-2 horas | 4-6 horas |
| **Consistencia** | ✅ Perfecta | ❌ Variable | ✅ Buena | ❌ Variable |
| **Aislamiento** | ✅ Completo | ❌ Limitado | ✅ Bueno | ❌ Ninguno |
| **Recursos** | 8GB RAM | 4GB RAM | 6GB RAM | 4GB RAM |
| **Recomendado para** | Equipos | Principiantes | Desarrolladores | Experiencia |

### Opción 1: Máquina Virtual (Recomendado para Equipos)

#### Ventajas de la Máquina Virtual
- **Entorno preconfigurado**: Todo listo para usar
- **Consistencia**: Mismo entorno para todos los desarrolladores
- **Aislamiento**: No interfiere con el sistema principal
- **Portabilidad**: Funciona en cualquier sistema operativo
- **Seguridad**: Entorno controlado y aislado

#### Requisitos para la Máquina Virtual
- **VirtualBox**: 7.1.10 o superior
- **RAM**: 8GB mínimo, 16GB recomendado
- **Espacio en Disco**: 20GB libres
- **Acceso al repositorio privado**: Solicitar acceso a Anthony Fuentes o Aaron Trujillo

#### Instalación de la Máquina Virtual

##### Paso 1: Obtener Acceso al Repositorio

###### Contacto para Acceso
Para obtener acceso al repositorio privado de la máquina virtual, contacta a uno de los administradores:

**Anthony Fuentes**
- GitHub: [@AnthoFu](https://github.com/AnthoFu)
- Email: [proporcionar email de contacto]
- Especificar: "Solicito acceso al repositorio VirtualBox-Unexca para desarrollo del Portal UNEXCA"

**Aaron Trujillo**
- GitHub: [proporcionar usuario]
- Email: [proporcionar email de contacto]
- Especificar: "Solicito acceso al repositorio VirtualBox-Unexca para desarrollo del Portal UNEXCA"

###### Términos de Seguridad
Al solicitar acceso, debes aceptar y comprometerte a:

1. **Confidencialidad Absoluta**
   - No distribuir el archivo .ova bajo ninguna circunstancia
   - Mantener el acceso en un entorno de trabajo seguro
   - No compartir credenciales o información del repositorio

2. **Uso Exclusivo**
   - Utilizar la máquina virtual únicamente para desarrollo del Portal UNEXCA
   - No usar el entorno para otros proyectos
   - Mantener el propósito educativo y de desarrollo

3. **Responsabilidad Personal**
   - Asumir responsabilidad total por el uso del material
   - Notificar inmediatamente cualquier problema de seguridad
   - Mantener la integridad del entorno de desarrollo

4. **Custodia Segura**
   - Almacenar el archivo .ova en un lugar seguro
   - No subir el archivo a servicios de nube públicos
   - Mantener copias de seguridad en entornos controlados

##### Paso 2: Descargar Archivos Necesarios
```bash
# Clonar el repositorio privado (requiere acceso)
git clone https://github.com/AnthoFu/VirtualBox-Unexca.git
cd VirtualBox-Unexca

# Navegar a la página de releases
# https://github.com/AnthoFu/VirtualBox-Unexca/releases
```

**Archivos a descargar:**
- `VirtualBox-7.1.10-169112-Win.exe` (Instalador de VirtualBox)
- `Proyecto.Portal.Web.7z.001` (Parte 1 de la máquina virtual)
- `Proyecto.Portal.Web.7z.002` (Parte 2 de la máquina virtual)

##### Paso 3: Instalar VirtualBox
```bash
# Windows: Ejecutar el instalador
VirtualBox-7.1.10-169112-Win.exe

# Seguir el asistente de instalación
# Aceptar configuración por defecto
# Instalar drivers cuando se solicite
```

##### Paso 4: Unir Archivos de la Máquina Virtual
```bash
# Instalar 7-Zip si no está disponible
# https://www.7-zip.org/

# Unir archivos divididos
# Clic derecho en Proyecto.Portal.Web.7z.001
# 7-Zip > Extraer aquí
# Se generará: Proyecto_Portal.Web.ova
```

##### Paso 5: Importar Máquina Virtual
```bash
# Abrir VirtualBox
# Archivo > Importar servicio virtualizado...
# Seleccionar: Proyecto_Portal.Web.ova
# Seguir asistente de importación
# Aceptar configuración por defecto
```

##### Paso 6: Configurar la Máquina Virtual
```bash
# Configuración recomendada:
# RAM: 4GB mínimo, 8GB recomendado
# CPU: 2 cores mínimo, 4 cores recomendado
# Almacenamiento: 20GB mínimo

# Configurar red:
# Adaptador 1: NAT
# Adaptador 2: Red Interna (opcional)
```

##### Paso 7: Iniciar y Configurar
```bash
# Iniciar la máquina virtual
# Usuario por defecto: unexca
# Contraseña: [proporcionada en el repositorio]

# Verificar servicios:
sudo systemctl status apache2
sudo systemctl status postgresql
sudo systemctl status php8.1-fpm
```

#### Configuración del Entorno Virtual

##### Verificar Instalación
```bash
# Verificar PHP
php -v
# Debería mostrar: PHP 8.1.x

# Verificar PostgreSQL
psql --version
# Debería mostrar: psql (PostgreSQL) 14.x

# Verificar Apache
apache2 -v
# Debería mostrar: Server version: Apache/2.4.x
```

##### Acceder al Portal
```bash
# Desde la máquina virtual:
http://localhost/unexca/publico/

# Desde el sistema host (si está configurado):
http://[IP_DE_LA_VM]/unexca/publico/
```

##### Configurar Acceso desde el Host
```bash
# En la máquina virtual, configurar red:
sudo nano /etc/apache2/sites-available/000-default.conf

# Agregar:
<VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www/html/unexca/publico
    <Directory /var/www/html/unexca/publico>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>

# Reiniciar Apache
sudo systemctl restart apache2
```

#### Ventajas del Entorno Virtual

##### Para el Desarrollo del Portal UNEXCA
- **Consistencia total**: Mismo entorno para todos los desarrolladores
- **Configuración optimizada**: PHP 8.1, PostgreSQL 14, Apache 2.4 preconfigurados
- **Herramientas incluidas**: Git, Composer, editores, debuggers
- **Base de datos poblada**: Datos de prueba de UNEXCA incluidos
- **Estructura del proyecto**: Portal UNEXCA ya clonado y configurado
- **Variables de entorno**: Configuración .env ya establecida
- **Permisos configurados**: Estructura de archivos con permisos correctos

##### Para la Seguridad
- **Aislamiento completo**: No afecta el sistema principal del desarrollador
- **Control de acceso**: Entorno restringido y monitoreado
- **Backup fácil**: Snapshot completo del entorno de desarrollo
- **Rollback instantáneo**: Restaurar estado anterior si es necesario
- **Confidencialidad**: Entorno aislado para desarrollo sensible

##### Para la Colaboración en Equipo
- **Mismo entorno**: Elimina problemas de "funciona en mi máquina"
- **Configuración compartida**: Todos usan exactamente la misma configuración
- **Onboarding rápido**: Nuevos desarrolladores listos en 30 minutos
- **Documentación incluida**: Guías y ejemplos del Portal UNEXCA en el entorno
- **Versionado del entorno**: Snapshots para diferentes versiones del proyecto

##### Para el Aprendizaje
- **Entorno educativo**: Configurado específicamente para aprender desarrollo web
- **Ejemplos incluidos**: Código de ejemplo del Portal UNEXCA
- **Herramientas de debugging**: Xdebug, logs, y herramientas de desarrollo
- **Documentación local**: Guías y tutoriales accesibles desde el entorno
- **Experimentos seguros**: Probar cambios sin afectar el sistema principal

#### Comandos Útiles en la Máquina Virtual

##### Gestión de Servicios
```bash
# Iniciar servicios
sudo systemctl start apache2
sudo systemctl start postgresql
sudo systemctl start php8.1-fpm

# Verificar estado
sudo systemctl status apache2
sudo systemctl status postgresql
sudo systemctl status php8.1-fpm

# Reiniciar servicios
sudo systemctl restart apache2
sudo systemctl restart postgresql
```

##### Gestión del Proyecto
```bash
# Navegar al proyecto
cd /var/www/html/unexca

# Ver estado del repositorio
git status

# Actualizar código
git pull origin main

# Ver logs de errores
tail -f /var/log/apache2/error.log
tail -f /var/log/postgresql/postgresql-14-main.log
```

##### Backup y Restauración
```bash
# Crear snapshot
# En VirtualBox: Máquina > Tomar instantánea
# Nombre: "Estado inicial"
# Descripción: "Entorno configurado y funcionando"

# Restaurar snapshot
# En VirtualBox: Máquina > Restaurar instantánea
# Seleccionar: "Estado inicial"
```

#### Solución de Problemas en la Máquina Virtual

##### Problemas de Red
```bash
# Verificar IP
ip addr show

# Verificar conectividad
ping google.com

# Reiniciar red
sudo systemctl restart networking
```

##### Problemas de Servicios
```bash
# Ver logs de Apache
sudo tail -f /var/log/apache2/error.log

# Ver logs de PostgreSQL
sudo tail -f /var/log/postgresql/postgresql-14-main.log

# Verificar puertos
sudo netstat -tlnp | grep :80
sudo netstat -tlnp | grep :5432
```

##### Problemas de Permisos
```bash
# Corregir permisos del proyecto
sudo chown -R www-data:www-data /var/www/html/unexca
sudo chmod -R 755 /var/www/html/unexca

# Corregir permisos de base de datos
sudo chown -R postgres:postgres /var/lib/postgresql
```

#### Consideraciones de Seguridad

##### Uso Responsable
- **No compartir**: El archivo .ova es confidencial
- **Uso exclusivo**: Solo para desarrollo del Portal UNEXCA
- **Custodia segura**: Mantener en entorno de trabajo seguro
- **Notificación**: Reportar cualquier problema de seguridad

##### Mejores Prácticas
- **Snapshots regulares**: Crear puntos de restauración
- **Actualizaciones**: Mantener el entorno actualizado
- **Backup**: Respaldo regular del trabajo
- **Documentación**: Registrar cambios importantes

#### Flujo de Trabajo Recomendado

##### Configuración Inicial
```bash
# 1. Crear snapshot inicial
# VirtualBox > Máquina > Tomar instantánea
# Nombre: "Estado inicial"
# Descripción: "Entorno configurado y funcionando"

# 2. Verificar que todo funciona
cd /var/www/html/unexca
git status
php -v
psql --version
```

##### Desarrollo Diario
```bash
# 1. Iniciar la máquina virtual
# 2. Verificar servicios
sudo systemctl status apache2 postgresql php8.1-fpm

# 3. Navegar al proyecto
cd /var/www/html/unexca

# 4. Actualizar código
git pull origin main

# 5. Desarrollar normalmente
# Editar archivos, probar cambios, etc.

# 6. Al final del día, crear snapshot
# VirtualBox > Máquina > Tomar instantánea
# Nombre: "Día [fecha] - [descripción]"
```

##### Resolución de Problemas
```bash
# Si algo se rompe, restaurar snapshot
# VirtualBox > Máquina > Restaurar instantánea
# Seleccionar: "Estado inicial" o último snapshot funcional

# Si necesitas empezar de cero
# VirtualBox > Máquina > Restaurar instantánea
# Seleccionar: "Estado inicial"
```

##### Colaboración en Equipo
```bash
# 1. Antes de empezar a trabajar
git pull origin main

# 2. Crear rama para tu trabajo
git checkout -b mi-nueva-funcionalidad

# 3. Desarrollar y probar
# Hacer cambios, probar, debuggear

# 4. Crear snapshot de progreso
# VirtualBox > Máquina > Tomar instantánea
# Nombre: "Progreso - [descripción]"

# 5. Al terminar, hacer commit y push
git add .
git commit -m "Descripción de cambios"
git push origin mi-nueva-funcionalidad
```

##### Mantenimiento del Entorno
```bash
# Actualizar el entorno (mensual)
sudo apt update && sudo apt upgrade -y

# Limpiar espacio
sudo apt autoremove -y
sudo apt autoclean

# Crear snapshot de mantenimiento
# VirtualBox > Máquina > Tomar instantánea
# Nombre: "Mantenimiento [fecha]"
```

### Opción 2: XAMPP (Recomendado para Principiantes)

#### Instalación de XAMPP
1. **Descargar XAMPP**
   - Visita: https://www.apachefriends.org/
   - Descarga la versión para tu sistema operativo
   - Incluye Apache, PHP, MySQL/MariaDB, phpMyAdmin

2. **Instalar XAMPP**
   ```bash
   # Windows: Ejecutar el instalador como administrador
   # macOS: Arrastrar a /Applications
   # Linux: chmod +x xampp-linux-x64-8.x.x-installer.run
   ```

3. **Configurar XAMPP**
   - Iniciar Apache desde el panel de control
   - Verificar que PHP esté funcionando
   - Acceder a http://localhost para confirmar

#### Instalación de PostgreSQL en XAMPP
```bash
# Windows: Descargar PostgreSQL desde postgresql.org
# macOS: brew install postgresql
# Linux: sudo apt-get install postgresql postgresql-contrib
```

### Opción 2: Docker (Recomendado para Desarrolladores Avanzados)

#### Crear docker-compose.yml
```yaml
version: '3.8'

services:
  web:
    image: php:8.1-apache
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html
    depends_on:
      - db
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html/publico

  db:
    image: postgres:14
    environment:
      POSTGRES_DB: unexca_dev
      POSTGRES_USER: unexca_user
      POSTGRES_PASSWORD: unexca_pass
    ports:
      - "5432:5432"
    volumes:
      - postgres_data:/var/lib/postgresql/data

volumes:
  postgres_data:
```

#### Comandos Docker
```bash
# Construir y ejecutar contenedores
docker-compose up -d

# Ver logs
docker-compose logs -f

# Detener contenedores
docker-compose down
```

### Opción 3: Entorno Nativo

#### Instalación en Ubuntu/Debian
```bash
# Actualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar Apache
sudo apt install apache2 -y

# Instalar PHP y extensiones
sudo apt install php php-pgsql php-mbstring php-xml php-curl -y

# Instalar PostgreSQL
sudo apt install postgresql postgresql-contrib -y

# Instalar Git
sudo apt install git -y
```

#### Instalación en Windows
```powershell
# Usar Chocolatey (recomendado)
# Instalar Chocolatey primero: https://chocolatey.org/install

# Instalar dependencias
choco install apache php postgresql git -y
```

#### Instalación en macOS
```bash
# Usar Homebrew
# Instalar Homebrew: https://brew.sh/

# Instalar dependencias
brew install apache php postgresql git
```

## Configuración del Proyecto

### 1. Clonar el Repositorio

```bash
# Clonar desde GitHub
git clone https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP.git

# Navegar al directorio
cd UNEXCA-WEBSITE---PHP

# Verificar estructura
ls -la
```

### 2. Configurar Permisos (Linux/macOS)

```bash
# Dar permisos al directorio web
sudo chown -R www-data:www-data /ruta/al/proyecto
sudo chmod -R 755 /ruta/al/proyecto

# Permisos específicos para archivos
sudo chmod 644 publico/index.php
sudo chmod 755 publico/
```

### 3. Configurar Variables de Entorno

#### Crear archivo .env
```bash
# Crear archivo de configuración
touch .env
```

#### Contenido del archivo .env
```env
# Configuración de Base de Datos
DB_HOST=localhost
DB_PORT=5432
DB_NAME=unexca_dev
DB_USER=unexca_user
DB_PASS=unexca_password

# Configuración de Aplicación
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost/unexca

# Configuración de Logs
LOG_LEVEL=debug
LOG_FILE=logs/app.log
```

#### Crear archivo .env.default
```env
# Configuración por defecto
DB_HOST=localhost
DB_PORT=5432
DB_NAME=unexca
DB_USER=postgres
DB_PASS=1234

APP_ENV=production
APP_DEBUG=false
```

### 4. Configurar Base de Datos

#### Crear Base de Datos PostgreSQL
```sql
-- Conectar como superusuario
sudo -u postgres psql

-- Crear usuario y base de datos
CREATE USER unexca_user WITH PASSWORD 'unexca_password';
CREATE DATABASE unexca_dev OWNER unexca_user;
GRANT ALL PRIVILEGES ON DATABASE unexca_dev TO unexca_user;

-- Conectar a la base de datos
\c unexca_dev

-- Crear esquema de tablas
-- (Ejecutar el script SQL completo de la documentación de base de datos)
```

#### Script de Creación de Tablas
```sql
-- Ejecutar en orden de dependencias

-- 1. Tabla de núcleos
CREATE TABLE nucleos (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

-- 2. Tabla de carreras
CREATE TABLE carrera (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  link_malla_curricular VARCHAR(500),
  imagen VARCHAR(500)
);

-- 3. Tabla de contactos directivos
CREATE TABLE contactos_directivos (
  id SERIAL PRIMARY KEY,
  nombre_completo VARCHAR(255) NOT NULL,
  cargo VARCHAR(255) NOT NULL,
  telefono VARCHAR(50),
  email VARCHAR(255),
  oficina TEXT,
  nucleo_id INTEGER REFERENCES nucleos(id) ON DELETE CASCADE
);

-- 4. Tabla de contactos coordinadores PNF
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

-- 5. Tabla de párrafos de carreras
CREATE TABLE carrera_parrafos (
  id SERIAL PRIMARY KEY,
  carrera_id INT NOT NULL,
  numero_parrafo INT,
  contenido TEXT,
  FOREIGN KEY (carrera_id) REFERENCES carrera(id) ON DELETE CASCADE
);

-- 6. Tabla de turnos de carreras
CREATE TABLE carrera_turnos (
  id SERIAL PRIMARY KEY,
  carrera_id INT NOT NULL,
  turno VARCHAR(100),
  FOREIGN KEY (carrera_id) REFERENCES carrera(id) ON DELETE CASCADE
);

-- 7. Tabla de niveles académicos
CREATE TABLE carrera_niveles_academicos (
  id SERIAL PRIMARY KEY,
  carrera_id INTEGER NOT NULL REFERENCES carrera(id) ON DELETE CASCADE,
  nivel VARCHAR(50) NOT NULL,
  duracion VARCHAR(100) NOT NULL,
  diploma VARCHAR(255) NOT NULL
);

-- 8. Tabla de relación carrera-núcleos
CREATE TABLE carrera_nucleos (
  id SERIAL PRIMARY KEY,
  carrera_id INT NOT NULL REFERENCES carrera(id) ON DELETE CASCADE,
  nucleo_id INT NOT NULL REFERENCES nucleos(id) ON DELETE CASCADE
);

-- 9. Tabla de autoridades académicas
CREATE TABLE autoridades_academicas (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  cargo VARCHAR(255) NOT NULL,
  imagen VARCHAR(500)
);

-- 10. Tabla de FAQs
CREATE TABLE faqs (
  id SERIAL PRIMARY KEY,
  pregunta TEXT NOT NULL,
  respuesta TEXT NOT NULL
);

-- 11. Tabla de servicios
CREATE TABLE servicios (
  id SERIAL PRIMARY KEY,
  servicio TEXT NOT NULL,
  respuesta TEXT NOT NULL
);

-- 12. Tabla de enlaces del header
CREATE TABLE header_links (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  url VARCHAR(500),
  id_padre INTEGER REFERENCES header_links(id) ON DELETE CASCADE
);

-- 13. Tabla de secciones del footer
CREATE TABLE footer_secciones (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL
);

-- 14. Tabla de enlaces del footer
CREATE TABLE footer_links (
  id SERIAL PRIMARY KEY,
  texto VARCHAR(255) NOT NULL,
  url VARCHAR(500) NOT NULL,
  seccion_id INTEGER REFERENCES footer_secciones(id) ON DELETE CASCADE
);

-- 15. Tabla de menús
CREATE TABLE menus (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

-- 16. Tabla de enlaces estáticos del menú
CREATE TABLE menu_enlaces_estaticos (
  id SERIAL PRIMARY KEY,
  menu_id INTEGER NOT NULL REFERENCES menus(id) ON DELETE CASCADE,
  titulo VARCHAR(255) NOT NULL,
  url VARCHAR(500),
  padre_id INTEGER REFERENCES menu_enlaces_estaticos(id) ON DELETE CASCADE,
  orden INTEGER DEFAULT 0
);

-- 17. Tabla de enlaces dinámicos del menú
CREATE TABLE menu_enlaces_dinamicos (
  id SERIAL PRIMARY KEY,
  menu_id INTEGER NOT NULL REFERENCES menus(id) ON DELETE CASCADE,
  titulo VARCHAR(255) NOT NULL,
  url VARCHAR(500),
  tabla_origen VARCHAR(100),
  registro_id INTEGER,
  padre_id INTEGER REFERENCES menu_enlaces_estaticos(id) ON DELETE CASCADE,
  orden INTEGER DEFAULT 0
);
```

#### Insertar Datos de Prueba
```sql
-- Insertar núcleos
INSERT INTO nucleos (nombre) VALUES 
('Altagracia'),
('Floresta'),
('Guaira'),
('Urbina');

-- Insertar carreras de ejemplo
INSERT INTO carrera (titulo, descripcion, imagen) VALUES 
('Ingeniería en Informática', 'Programa de formación en desarrollo de software y sistemas informáticos', 'ing-informatica.jpg'),
('Administración', 'Programa de formación en gestión empresarial y administrativa', 'administracion.jpg'),
('Contaduría', 'Programa de formación en ciencias contables y financieras', 'contaduria.jpg');

-- Insertar autoridades de ejemplo
INSERT INTO autoridades_academicas (nombre, cargo, imagen) VALUES 
('Dr. Juan Pérez', 'Rector', 'autoridad_1.jpg'),
('Dra. María González', 'Vicerrectora Académica', 'autoridad_2.jpg');

-- Insertar FAQs de ejemplo
INSERT INTO faqs (pregunta, respuesta) VALUES 
('¿Cuáles son los requisitos de ingreso?', 'Los requisitos incluyen título de bachiller y documentos específicos según la carrera.'),
('¿Cómo me inscribo?', 'El proceso de inscripción se realiza a través del sistema en línea disponible en el portal.');
```

### 5. Configurar Servidor Web

#### Configuración de Apache

##### Crear archivo .htaccess
```apache
# publico/.htaccess
RewriteEngine On

# Redirigir todo a index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]

# Seguridad
<Files "*.env">
    Order allow,deny
    Deny from all
</Files>

<Files "*.log">
    Order allow,deny
    Deny from all
</Files>

# Headers de seguridad
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
```

##### Configuración de Virtual Host
```apache
# /etc/apache2/sites-available/unexca.conf
<VirtualHost *:80>
    ServerName unexca.local
    DocumentRoot /ruta/completa/al/proyecto/publico
    
    <Directory /ruta/completa/al/proyecto/publico>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/unexca_error.log
    CustomLog ${APACHE_LOG_DIR}/unexca_access.log combined
</VirtualHost>
```

#### Configuración de Nginx

```nginx
# /etc/nginx/sites-available/unexca
server {
    listen 80;
    server_name unexca.local;
    root /ruta/completa/al/proyecto/publico;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(env|log) {
        deny all;
    }
}
```

### 6. Configurar PHP

#### Verificar Extensiones PHP
```bash
# Verificar extensiones instaladas
php -m | grep -E "(pdo|pgsql|mbstring|xml|curl)"

# Instalar extensiones faltantes
# Ubuntu/Debian
sudo apt install php-pgsql php-mbstring php-xml php-curl

# CentOS/RHEL
sudo yum install php-pgsql php-mbstring php-xml php-curl
```

#### Configuración de php.ini
```ini
; Configuración recomendada
memory_limit = 256M
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 30
max_input_time = 60

; Extensiones requeridas
extension=pdo
extension=pdo_pgsql
extension=mbstring
extension=xml
extension=curl

; Configuración de errores para desarrollo
display_errors = On
error_reporting = E_ALL
log_errors = On
error_log = /ruta/al/proyecto/logs/php_errors.log
```

### 7. Configurar Git

#### Configuración Inicial
```bash
# Configurar usuario
git config --global user.name "Tu Nombre"
git config --global user.email "tu.email@ejemplo.com"

# Configurar editor
git config --global core.editor "code"  # Para VS Code

# Crear .gitignore
touch .gitignore
```

#### Contenido del .gitignore
```gitignore
# Archivos de configuración
.env
.env.local
.env.production

# Logs
*.log
logs/
error.log

# Archivos temporales
*.tmp
*.temp
.DS_Store
Thumbs.db

# Archivos de IDE
.vscode/
.idea/
*.swp
*.swo

# Archivos de sistema
node_modules/
vendor/
composer.lock
```

## Verificación de la Instalación

### 1. Verificar Servidor Web
```bash
# Verificar Apache
sudo systemctl status apache2
# o
sudo service apache2 status

# Verificar Nginx
sudo systemctl status nginx
# o
sudo service nginx status
```

### 2. Verificar PHP
```bash
# Verificar versión de PHP
php -v

# Verificar extensiones
php -m

# Crear archivo de prueba
echo "<?php phpinfo(); ?>" > publico/info.php
# Visitar http://localhost/info.php
# Eliminar después de verificar: rm publico/info.php
```

### 3. Verificar PostgreSQL
```bash
# Verificar servicio
sudo systemctl status postgresql

# Conectar a base de datos
psql -h localhost -U unexca_user -d unexca_dev

# Verificar tablas
\dt
```

### 4. Verificar Aplicación
```bash
# Visitar la aplicación
http://localhost/unexca/publico/

# Verificar páginas específicas
http://localhost/unexca/publico/?pagina=inicio
http://localhost/unexca/publico/?pagina=historia
http://localhost/unexca/publico/?pagina=autoridades
```

## Solución de Problemas Comunes

### Error de Conexión a Base de Datos
```bash
# Verificar que PostgreSQL esté ejecutándose
sudo systemctl status postgresql

# Verificar configuración en .env
cat .env | grep DB_

# Probar conexión manual
psql -h localhost -U unexca_user -d unexca_dev
```

### Error 404 en Páginas
```bash
# Verificar configuración de Apache/Nginx
# Verificar que .htaccess esté presente
ls -la publico/.htaccess

# Verificar permisos
ls -la publico/
```

### Error de Permisos
```bash
# Corregir permisos
sudo chown -R www-data:www-data /ruta/al/proyecto
sudo chmod -R 755 /ruta/al/proyecto
sudo chmod 644 publico/index.php
```

### Error de PHP
```bash
# Verificar logs de PHP
tail -f /var/log/apache2/error.log
# o
tail -f /var/log/nginx/error.log

# Verificar configuración de PHP
php -i | grep error_log
```

## Configuración de Entorno de Desarrollo

### 1. Configurar IDE (VS Code)

#### Extensiones Recomendadas
```json
{
  "recommendations": [
    "ms-vscode.vscode-json",
    "bradlc.vscode-tailwindcss",
    "formulahendry.auto-rename-tag",
    "ms-vscode.vscode-typescript-next",
    "esbenp.prettier-vscode",
    "ms-vscode.vscode-php-debug"
  ]
}
```

#### Configuración de Workspace
```json
{
  "settings": {
    "editor.formatOnSave": true,
    "editor.tabSize": 4,
    "files.associations": {
      "*.php": "php"
    },
    "emmet.includeLanguages": {
      "php": "html"
    }
  }
}
```

### 2. Configurar Debugging

#### Xdebug para PHP
```ini
; php.ini
[xdebug]
zend_extension=xdebug.so
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
```

#### Configuración de VS Code para Debugging
```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/var/www/html": "${workspaceFolder}"
      }
    }
  ]
}
```

### 3. Configurar Herramientas de Desarrollo

#### Composer (Opcional)
```bash
# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar dependencias (si las hay)
composer install
```

#### NPM para Frontend (Opcional)
```bash
# Instalar Node.js y NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Instalar dependencias de frontend
npm install
```

## Scripts de Automatización

### Script de Instalación Completa
```bash
#!/bin/bash
# install.sh

echo "🚀 Instalando Portal UNEXCA..."

# Verificar dependencias
echo "📋 Verificando dependencias..."
php -v || { echo "❌ PHP no está instalado"; exit 1; }
psql --version || { echo "❌ PostgreSQL no está instalado"; exit 1; }

# Configurar base de datos
echo "🗄️ Configurando base de datos..."
psql -U postgres -c "CREATE DATABASE unexca_dev;"
psql -U postgres -c "CREATE USER unexca_user WITH PASSWORD 'unexca_pass';"
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE unexca_dev TO unexca_user;"

# Configurar permisos
echo "🔐 Configurando permisos..."
sudo chown -R www-data:www-data .
sudo chmod -R 755 .

# Crear archivos de configuración
echo "⚙️ Creando configuración..."
cp .env.default .env

# Insertar datos de prueba
echo "📊 Insertando datos de prueba..."
psql -U unexca_user -d unexca_dev -f database/schema.sql
psql -U unexca_user -d unexca_dev -f database/seed.sql

echo "✅ Instalación completada!"
echo "🌐 Accede a: http://localhost/unexca/publico/"
```

### Script de Verificación
```bash
#!/bin/bash
# verify.sh

echo "🔍 Verificando instalación..."

# Verificar PHP
echo "PHP: $(php -v | head -n1)"

# Verificar PostgreSQL
echo "PostgreSQL: $(psql --version)"

# Verificar conexión a BD
psql -U unexca_user -d unexca_dev -c "SELECT version();" > /dev/null
if [ $? -eq 0 ]; then
    echo "✅ Conexión a base de datos: OK"
else
    echo "❌ Conexión a base de datos: FALLO"
fi

# Verificar archivos críticos
if [ -f "publico/index.php" ]; then
    echo "✅ Archivo principal: OK"
else
    echo "❌ Archivo principal: FALLO"
fi

if [ -f ".env" ]; then
    echo "✅ Configuración: OK"
else
    echo "❌ Configuración: FALLO"
fi

echo "🎉 Verificación completada!"
```

## Conclusión

Esta guía proporciona todos los pasos necesarios para instalar y configurar el Portal UNEXCA en un entorno de desarrollo. Siguiendo estas instrucciones, los desarrolladores pueden:

- **Configurar** un entorno de desarrollo completo
- **Resolver** problemas comunes de instalación
- **Automatizar** el proceso de setup
- **Verificar** que todo funcione correctamente

El proceso de instalación está diseñado para ser robusto y cubrir diferentes escenarios de desarrollo, desde entornos simples con XAMPP hasta configuraciones avanzadas con Docker.
