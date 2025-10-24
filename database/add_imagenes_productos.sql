-- =====================================================
-- Migración: Agregar campos de imágenes a productos
-- Fecha: 24 de octubre de 2025
-- Descripción: Agrega imagen_2, imagen_3, imagen_4, imagen_5 a la tabla productos
-- =====================================================

USE tennisyzapatos_db;

-- Verificar si las columnas ya existen antes de agregarlas
SET @dbname = DATABASE();
SET @tablename = 'productos';

-- Agregar imagen_2 si no existe
SET @column_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname 
    AND TABLE_NAME = @tablename 
    AND COLUMN_NAME = 'imagen_2'
);

SET @sql = IF(@column_check = 0,
    'ALTER TABLE productos ADD COLUMN imagen_2 VARCHAR(255) DEFAULT NULL AFTER imagen_principal',
    'SELECT "La columna imagen_2 ya existe" AS mensaje'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar imagen_3 si no existe
SET @column_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname 
    AND TABLE_NAME = @tablename 
    AND COLUMN_NAME = 'imagen_3'
);

SET @sql = IF(@column_check = 0,
    'ALTER TABLE productos ADD COLUMN imagen_3 VARCHAR(255) DEFAULT NULL AFTER imagen_2',
    'SELECT "La columna imagen_3 ya existe" AS mensaje'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar imagen_4 si no existe
SET @column_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname 
    AND TABLE_NAME = @tablename 
    AND COLUMN_NAME = 'imagen_4'
);

SET @sql = IF(@column_check = 0,
    'ALTER TABLE productos ADD COLUMN imagen_4 VARCHAR(255) DEFAULT NULL AFTER imagen_3',
    'SELECT "La columna imagen_4 ya existe" AS mensaje'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Agregar imagen_5 si no existe
SET @column_check = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = @dbname 
    AND TABLE_NAME = @tablename 
    AND COLUMN_NAME = 'imagen_5'
);

SET @sql = IF(@column_check = 0,
    'ALTER TABLE productos ADD COLUMN imagen_5 VARCHAR(255) DEFAULT NULL AFTER imagen_4',
    'SELECT "La columna imagen_5 ya existe" AS mensaje'
);

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Actualizar productos existentes con imágenes adicionales
UPDATE productos 
SET 
    imagen_2 = CASE 
        WHEN id % 8 = 1 THEN 'p2.jpg'
        WHEN id % 8 = 2 THEN 'p1.jpg'
        WHEN id % 8 = 3 THEN 'p4.jpg'
        WHEN id % 8 = 4 THEN 'p5.jpg'
        WHEN id % 8 = 5 THEN 'p6.jpg'
        WHEN id % 8 = 6 THEN 'p7.jpg'
        WHEN id % 8 = 7 THEN 'p8.jpg'
        ELSE 'p1.jpg'
    END,
    imagen_3 = CASE 
        WHEN id % 8 = 1 THEN 'p3.jpg'
        WHEN id % 8 = 2 THEN 'p3.jpg'
        WHEN id % 8 = 3 THEN 'p5.jpg'
        WHEN id % 8 = 4 THEN 'p6.jpg'
        WHEN id % 8 = 5 THEN 'p7.jpg'
        WHEN id % 8 = 6 THEN 'p8.jpg'
        WHEN id % 8 = 7 THEN 'p1.jpg'
        ELSE 'p2.jpg'
    END,
    imagen_4 = CASE 
        WHEN id % 3 = 0 THEN CASE 
            WHEN id % 8 = 1 THEN 'p4.jpg'
            WHEN id % 8 = 2 THEN NULL
            WHEN id % 8 = 3 THEN NULL
            WHEN id % 8 = 4 THEN 'p7.jpg'
            WHEN id % 8 = 5 THEN 'p8.jpg'
            WHEN id % 8 = 6 THEN NULL
            WHEN id % 8 = 7 THEN NULL
            ELSE 'p3.jpg'
        END
        ELSE NULL
    END,
    imagen_5 = CASE 
        WHEN id % 5 = 0 THEN CASE 
            WHEN id % 8 = 5 THEN NULL
            ELSE NULL
        END
        ELSE NULL
    END
WHERE imagen_principal IS NOT NULL;

-- Mostrar resumen de la migración
SELECT 
    'Migración completada' AS estado,
    COUNT(*) AS productos_actualizados,
    SUM(CASE WHEN imagen_2 IS NOT NULL THEN 1 ELSE 0 END) AS con_imagen_2,
    SUM(CASE WHEN imagen_3 IS NOT NULL THEN 1 ELSE 0 END) AS con_imagen_3,
    SUM(CASE WHEN imagen_4 IS NOT NULL THEN 1 ELSE 0 END) AS con_imagen_4,
    SUM(CASE WHEN imagen_5 IS NOT NULL THEN 1 ELSE 0 END) AS con_imagen_5
FROM productos;

-- Mostrar algunos productos de ejemplo con sus imágenes
SELECT 
    id,
    nombre,
    imagen_principal,
    imagen_2,
    imagen_3,
    imagen_4,
    imagen_5
FROM productos
LIMIT 10;
