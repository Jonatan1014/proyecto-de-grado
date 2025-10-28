-- Migración: Agregar campo talla_id a la tabla carrito
-- Fecha: 2024
-- Propósito: Permitir que los items del carrito tengan una talla específica

USE tennisyzapatos_db;

-- 1. Agregar campo talla_id a la tabla carrito
ALTER TABLE `carrito`
ADD COLUMN `talla_id` INT(11) NULL DEFAULT NULL AFTER `producto_id`,
ADD INDEX `idx_talla` (`talla_id`);

-- 2. Agregar constraint de clave foránea para integridad referencial
-- (Opcional - descomentar si quieres forzar que talla_id sea válido)
-- ALTER TABLE `carrito`
-- ADD CONSTRAINT `fk_carrito_talla`
-- FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`)
-- ON DELETE SET NULL
-- ON UPDATE CASCADE;

-- 3. Verificación
SELECT 'Migración completada exitosamente' as Estado;

-- Verificar que el campo se agregó correctamente
DESCRIBE carrito;

-- Mostrar estructura actualizada
SHOW CREATE TABLE carrito;

-- 4. Notas importantes:
-- - El campo talla_id es NULL por defecto para productos que no requieren talla
-- - Los items existentes en el carrito mantendrán talla_id = NULL
-- - La combinación única es ahora (usuario_id, producto_id, talla_id)
--   para permitir el mismo producto con diferentes tallas

-- 5. Índice compuesto para búsquedas eficientes
-- Crear índice para la combinación producto + talla
ALTER TABLE `carrito`
ADD INDEX `idx_producto_talla` (`producto_id`, `talla_id`);

-- Verificar índices
SHOW INDEX FROM carrito;

SELECT 'Migración completada - Campo talla_id agregado a carrito' as Resultado;
