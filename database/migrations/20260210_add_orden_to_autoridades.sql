-- Migración: Agregar campo 'orden' a autoridades_academicas
-- Fecha: 10 de febrero de 2026

-- 1. Agregar la columna con un valor por defecto
ALTER TABLE autoridades_academicas ADD COLUMN orden INTEGER DEFAULT 0;

-- 2. Inicializar el campo 'orden' con el valor del 'id' para los registros existentes
-- Esto evita que todos tengan 0 y permite empezar a reordenar de inmediato.
UPDATE autoridades_academicas SET orden = id;

-- 3. (Opcional) Si quieres asegurar que no haya nulos en el futuro
ALTER TABLE autoridades_academicas ALTER COLUMN orden SET NOT NULL;
