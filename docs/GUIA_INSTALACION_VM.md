### **Guía Definitiva: Instalar y Correr el Proyecto en la VM**

**1. Acceso a la Máquina Virtual (VM)**
   - Descargar la VM y el archivo `.oba`.
   - Iniciar la VM.
   - Usar la contraseña `123456` para el usuario `engelbert`.

**2. Obtener el Código Fuente**
   - Instalar Git:
     ```bash
     sudo apt update
     sudo apt install git
     ```
   - Clonar el repositorio en la carpeta de inicio:
     ```bash
     cd ~
     git clone https://github.com/Unexca-Website-Development/UNEXCA-WEBSITE---PHP.git
     ```

**3. Preparar la Base de Datos**
   - Pasa el archivo `respaldo.sql` a la VM (p. ej. descárgalo de Discord/WhatsApp) y asegúrate de que esté en tu carpeta de inicio (`/home/engelbert/`).
   - Accede a la consola de PostgreSQL:
     ```bash
     sudo -u postgres psql
     ```
   - Dentro de `psql`, crea el usuario y la base de datos (usa una contraseña segura):
     ```sql
     CREATE USER unexca_user WITH PASSWORD '1234';
     CREATE DATABASE unexca_db OWNER unexca_user;
     \q
     ```
   - Edita la configuración de autenticación de PostgreSQL:
     ```bash
     sudo nano /etc/postgresql/15/main/pg_hba.conf
     ```
     *(Nota: El número `15` puede cambiar según tu versión de Postgres)*.
   - Busca la línea `local all all peer` y cámbiala a `local all all md5`. Guarda el archivo (`Ctrl+X`, `Y`, `Enter`).
   - Reinicia el servicio de PostgreSQL para aplicar los cambios:
     ```bash
     sudo systemctl restart postgresql
     ```
   - Importa el respaldo (te pedirá la contraseña que creaste):
     ```bash
     psql -U unexca_user -d unexca_db -f ~/respaldo.sql
     ```

**4. Configurar el Proyecto PHP**
   - Ve a la carpeta del proyecto:
     ```bash
     cd ~/UNEXCA-WEBSITE---PHP
     ```
   - Copia el archivo de configuración de ejemplo:
     ```bash
     cp .env.default .env
     ```
   - Edita el nuevo archivo con los datos de tu base de datos:
     ```bash
     nano .env
     ```
   - Asegúrate de que las variables queden así:
     ```ini
     DB_HOST=localhost
     DB_PORT=5432
     DB_NAME=unexca_db
     DB_USER=unexca_user
     DB_PASS=1234
     ```
   - Guarda el archivo (`Ctrl+X`, `Y`, `Enter`).

**5. Configurar el Servidor Web (Apache) - El Paso Clave**
   - **a) Desactiva las configuraciones conflictivas** que ya trae la VM:
     ```bash
     sudo a2dissite 000-default.conf
     sudo a2dissite inscripciones2025_1_completo.conf
     ```
   - **b) Activa los módulos necesarios** para Apache:
     ```bash
     sudo a2enmod rewrite
     sudo a2enmod php7.4
     ```
   - **c) Crea la configuración correcta para tu sitio**, que incluye las reglas de enrutamiento (ya que `.htaccess` no se usa):
     ```bash
     sudo bash -c 'cat <<EOF > /etc/apache2/sites-available/unexca.conf
     <VirtualHost *:80>
         ServerName localhost
         DocumentRoot /home/engelbert/UNEXCA-WEBSITE---PHP/publico
         <Directory /home/engelbert/UNEXCA-WEBSITE---PHP/publico>
             Options FollowSymLinks
             AllowOverride All
             Require all granted
             RewriteEngine On
             RewriteBase /
             RewriteCond %{REQUEST_FILENAME} !-f
             RewriteCond %{REQUEST_FILENAME} !-d
             RewriteRule ^(.*)$ index.php?ruta=$1 [QSA,L]
         </Directory>
         ErrorLog ${APACHE_LOG_DIR}/error.log
         CustomLog ${APACHE_LOG_DIR}/access.log combined
     </VirtualHost>
     EOF'
     ```
   - **d) Activa tu nueva configuración**:
     ```bash
     sudo a2ensite unexca.conf
     ```

**6. Ajustar Permisos del Sistema**
   - Asegúrate de que Apache tenga permiso para acceder y leer las carpetas del proyecto:
     ```bash
     sudo chmod 755 /home/engelbert
     sudo chown -R www-data:www-data /home/engelbert/UNEXCA-WEBSITE---PHP
     ```

**7. Reinicio Final y Prueba**
   - Reinicia Apache para que todos los cambios surtan efecto:
     ```bash
     sudo systemctl restart apache2
     ```
   - Abre el navegador y visita **`http://localhost`**.
