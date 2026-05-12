-- ==========================================================
-- SCRIPT DE SEGURIDAD: CONFIGURACIÓN DE USUARIO Y PERMISOS
-- Proyecto: UNEXCA Portal Web
-- ==========================================================

-- 1. Asegurar que el esquema public existe y tiene permisos base
GRANT ALL ON SCHEMA public TO postgres;
GRANT USAGE ON SCHEMA public TO public;

-- 2. Permisos para el usuario de la aplicación (unexca_user)
-- Nota: El usuario debe ser creado previamente o mediante:
-- CREATE USER unexca_user WITH PASSWORD 'tu_clave';

-- Limpiar permisos previos para evitar conflictos
REVOKE ALL ON ALL TABLES IN SCHEMA public FROM unexca_user;
REVOKE ALL ON ALL SEQUENCES IN SCHEMA public FROM unexca_user;

-- Otorgar solo permisos de manipulación de datos (DML)
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO unexca_user;

-- Otorgar permisos para manejo de IDs automáticos (Sequences)
GRANT USAGE, SELECT ON ALL SEQUENCES IN SCHEMA public TO unexca_user;

-- Configurar permisos automáticos para futuras tablas (Scalability)
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT SELECT, INSERT, UPDATE, DELETE ON TABLES TO unexca_user;
ALTER DEFAULT PRIVILEGES IN SCHEMA public GRANT USAGE, SELECT ON SEQUENCES TO unexca_user;

-- 3. Restringir funciones críticas (si existieran)
-- REVOKE ALL ON FUNCTION public.funcion_critica FROM unexca_user;
