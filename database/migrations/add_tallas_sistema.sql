-- ============================================================================
-- MIGRACIÓN: Sistema de Tallas para Productos
-- Fecha: 27 de Octubre de 2025
-- Descripción: Permite que los productos tengan múltiples tallas disponibles
--              y que los clientes seleccionen talla al añadir al carrito
-- ============================================================================

USE tennisyzapatos_db;

-- ============================================================================
-- 1. CREAR TABLA INTERMEDIA producto_tallas
-- ============================================================================

CREATE TABLE IF NOT EXISTS `producto_tallas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_producto_talla` (`producto_id`, `talla_id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_talla` (`talla_id`),
  KEY `idx_estado` (`estado`),
  CONSTRAINT `fk_pt_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pt_talla` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 2. AGREGAR CAMPO talla_id A detalle_pedidos
-- ============================================================================

-- Verificar si la columna ya existe
SET @col_exists = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'tennisyzapatos_db' 
    AND TABLE_NAME = 'detalle_pedidos' 
    AND COLUMN_NAME = 'talla_id'
);

-- Agregar columna si no existe
SET @query = IF(
    @col_exists = 0,
    'ALTER TABLE `detalle_pedidos` ADD COLUMN `talla_id` int(11) DEFAULT NULL AFTER `producto_id`, ADD KEY `idx_talla` (`talla_id`)',
    'SELECT "La columna talla_id ya existe en detalle_pedidos" AS mensaje'
);

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ============================================================================
-- 3. AGREGAR CAMPO talla_seleccionada A productos (para mostrar en UI)
-- ============================================================================

-- Verificar si la columna ya existe
SET @col_exists2 = (
    SELECT COUNT(*) 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'tennisyzapatos_db' 
    AND TABLE_NAME = 'productos' 
    AND COLUMN_NAME = 'requiere_talla'
);

-- Agregar columna si no existe
SET @query2 = IF(
    @col_exists2 = 0,
    'ALTER TABLE `productos` ADD COLUMN `requiere_talla` tinyint(1) NOT NULL DEFAULT 1 AFTER `estado`',
    'SELECT "La columna requiere_talla ya existe en productos" AS mensaje'
);

PREPARE stmt2 FROM @query2;
EXECUTE stmt2;
DEALLOCATE PREPARE stmt2;

-- ============================================================================
-- 4. INSERTAR TALLAS COMUNES SI NO EXISTEN
-- ============================================================================

INSERT IGNORE INTO `tallas` (`id`, `nombre`, `descripcion`, `estado`) VALUES
(1, '35', 'Talla 35', 'activo'),
(2, '36', 'Talla 36', 'activo'),
(3, '37', 'Talla 37', 'activo'),
(4, '38', 'Talla 38', 'activo'),
(5, '39', 'Talla 39', 'activo'),
(6, '40', 'Talla 40', 'activo'),
(7, '41', 'Talla 41', 'activo'),
(8, '42', 'Talla 42', 'activo'),
(9, '43', 'Talla 43', 'activo'),
(10, '44', 'Talla 44', 'activo'),
(11, '45', 'Talla 45', 'activo'),
(12, 'XS', 'Extra Small', 'activo'),
(13, 'S', 'Small', 'activo'),
(14, 'M', 'Medium', 'activo'),
(15, 'L', 'Large', 'activo'),
(16, 'XL', 'Extra Large', 'activo'),
(17, 'XXL', '2XL', 'activo');

-- ============================================================================
-- 5. MIGRAR DATOS EXISTENTES (Opcional)
-- ============================================================================

-- Si los productos existentes tienen talla_id, crear relación en producto_tallas
INSERT INTO `producto_tallas` (`producto_id`, `talla_id`, `stock`, `stock_minimo`)
SELECT 
    p.id,
    p.talla_id,
    p.stock,
    p.stock_minimo
FROM productos p
WHERE p.talla_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM producto_tallas pt 
      WHERE pt.producto_id = p.id AND pt.talla_id = p.talla_id
  );

-- ============================================================================
-- 6. DATOS DE EJEMPLO (Opcional - Para Testing)
-- ============================================================================

-- Ejemplo: Asignar múltiples tallas a productos existentes
-- Descomentar si quieres que los primeros 5 productos tengan tallas 38, 39, 40, 41, 42

-- INSERT INTO `producto_tallas` (`producto_id`, `talla_id`, `stock`, `stock_minimo`)
-- SELECT p.id, t.id, 10, 5
-- FROM productos p
-- CROSS JOIN tallas t
-- WHERE p.id <= 5 
--   AND t.id IN (4, 5, 6, 7, 8)
--   AND NOT EXISTS (
--       SELECT 1 FROM producto_tallas pt 
--       WHERE pt.producto_id = p.id AND pt.talla_id = t.id
--   );

-- ============================================================================
-- VERIFICACIÓN
-- ============================================================================

SELECT 'Migración completada exitosamente' AS Estado;

-- Ver tablas creadas
SHOW TABLES LIKE '%talla%';

-- Ver estructura de producto_tallas
DESCRIBE producto_tallas;

-- Contar registros
SELECT 
    (SELECT COUNT(*) FROM tallas WHERE estado = 'activo') as tallas_activas,
    (SELECT COUNT(*) FROM producto_tallas) as relaciones_producto_talla,
    (SELECT COUNT(*) FROM productos WHERE requiere_talla = 1) as productos_con_talla;

-- ============================================================================
-- NOTAS DE USO
-- ============================================================================

/*
CÓMO USAR:

1. ASIGNAR TALLAS A UN PRODUCTO:
   INSERT INTO producto_tallas (producto_id, talla_id, stock) 
   VALUES (1, 5, 15);  -- Producto 1, Talla 39, Stock 15

2. OBTENER TALLAS DISPONIBLES DE UN PRODUCTO:
   SELECT t.*, pt.stock 
   FROM tallas t
   INNER JOIN producto_tallas pt ON t.id = pt.talla_id
   WHERE pt.producto_id = 1 AND pt.estado = 'activo' AND pt.stock > 0;

3. CREAR PEDIDO CON TALLA:
   INSERT INTO detalle_pedidos (pedido_id, producto_id, talla_id, cantidad, precio_unitario, subtotal)
   VALUES (1, 1, 5, 2, 350000, 700000);

4. ACTUALIZAR STOCK AL VENDER:
   UPDATE producto_tallas 
   SET stock = stock - 2 
   WHERE producto_id = 1 AND talla_id = 5;
*/

-- ============================================================================
-- FIN DE MIGRACIÓN
-- ============================================================================
