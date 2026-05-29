# Guía de Administración - Panel de Control

Esta guía es exclusiva para el personal autorizado y detalla cómo gestionar el contenido del Portal UNEXCA.

## Acceso al Panel
El acceso se realiza mediante un inicio de sesión seguro en la ruta administrativa. Utilice las credenciales proporcionadas por el equipo técnico.

## Módulos de Gestión

### 1. Módulo de Noticias (Editor de Contenido)
Permite gestionar la cartelera digital:
- **Redacción**: Cree nuevos artículos con el editor dinámico.
- **Imágenes**: Asigne una imagen principal y agregue múltiples imágenes dentro del cuerpo del artículo.
- **Estado**: Guarde artículos como `borrador` o cámbielos a `publicado` para que sean visibles en la web.
- **Orden**: Organice las secciones de la noticia subiendo o bajando los bloques de contenido.

### 2. Módulo Institucional
- **Autoridades**: Actualice la información, cargos y fotos del personal directivo.
- **Directorio**: Gestione los datos de contacto (teléfonos, correos, oficinas) de los coordinadores y directivos.

### 3. Módulo de Sedes
- **Gestión de Núcleos**: Actualice la información de las sedes, agregue nuevas descripciones o modifique los datos de las instalaciones actuales.

## Gestión de Usuarios vía CLI (Línea de Comandos)

Para la creación o actualización de usuarios con roles específicos, utilice el script proporcionado en el servidor:

```bash
php scripts/gestionar_usuario.php <usuario> <password> <nombre_completo> <rol_id>
```

### Roles Disponibles:
1. **Super Administrador**: Acceso total al sistema.
2. **Editor de Contenido**: Puede gestionar Noticias y Autoridades.
3. **Coordinador**: Enfocado en la gestión de contactos y directorio.

---
**Nota de Seguridad:** Por favor, cierre su sesión al finalizar el trabajo y nunca comparta sus credenciales de acceso.
