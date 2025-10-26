-- ================================================================
-- MIGRACIÓN: Agregar campos de dirección de envío a pedidos
-- Fecha: 2025-10-26
-- Descripción: Agrega columnas para almacenar la dirección de envío
--              directamente en la tabla pedidos
-- ================================================================

USE tennisyzapatos_db;

-- Agregar campos de dirección de envío a la tabla pedidos
ALTER TABLE `pedidos`
ADD COLUMN `direccion_envio` VARCHAR(255) NULL AFTER `observaciones`,
ADD COLUMN `ciudad_envio` VARCHAR(100) NULL AFTER `direccion_envio`,
ADD COLUMN `departamento_envio` VARCHAR(100) NULL AFTER `ciudad_envio`,
ADD COLUMN `codigo_postal_envio` VARCHAR(20) NULL AFTER `departamento_envio`,
ADD COLUMN `fecha_actualizacion` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP AFTER `codigo_postal_envio`;

-- Agregar índice para búsquedas por ciudad
ALTER TABLE `pedidos`
ADD INDEX `idx_ciudad_envio` (`ciudad_envio`);

-- Comentario de las columnas agregadas
ALTER TABLE `pedidos`
MODIFY COLUMN `direccion_envio` VARCHAR(255) NULL COMMENT 'Dirección completa de envío del pedido',
MODIFY COLUMN `ciudad_envio` VARCHAR(100) NULL COMMENT 'Ciudad de envío',
MODIFY COLUMN `departamento_envio` VARCHAR(100) NULL COMMENT 'Departamento o estado de envío',
MODIFY COLUMN `codigo_postal_envio` VARCHAR(20) NULL COMMENT 'Código postal de la dirección de envío',
MODIFY COLUMN `fecha_actualizacion` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de última actualización del pedido';
