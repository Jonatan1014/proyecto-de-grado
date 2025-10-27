-- Agregar campo de envío a la tabla pedidos
ALTER TABLE `pedidos` ADD COLUMN `costo_envio` DECIMAL(10,2) DEFAULT 0.00 AFTER `impuestos`;
