-- Migración: Agregar campo direccion_id a la tabla pedidos
-- Fecha: 2024
-- Propósito: Almacenar la dirección de envío asociada a cada pedido

USE tennisyzapatos_db;

-- 1. Agregar campo direccion_id a la tabla pedidos
ALTER TABLE `pedidos`
ADD COLUMN `direccion_id` INT(11) NULL DEFAULT NULL AFTER `usuario_id`,
ADD INDEX `idx_direccion` (`direccion_id`);

-- 2. Agregar constraint de clave foránea (opcional)
-- ALTER TABLE `pedidos`
-- ADD CONSTRAINT `fk_pedidos_direccion`
-- FOREIGN KEY (`direccion_id`) REFERENCES `direcciones_envio` (`id`)
-- ON DELETE SET NULL
-- ON UPDATE CASCADE;

-- 3. Verificación
SELECT 'Migración completada exitosamente' as Estado;

-- Verificar que el campo se agregó correctamente
DESCRIBE pedidos;

-- Mostrar estructura actualizada
SHOW CREATE TABLE pedidos;

SELECT 'Campo direccion_id agregado a pedidos' as Resultado;
