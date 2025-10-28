-- =====================================================
-- ESTRUCTURA COMPLETA DE BASE DE DATOS
-- Sistema E-Commerce Tennis y Zapatos
-- Fecha: 27 de Octubre de 2025
-- Versión: 2.0 (Optimizada y Relacional)
-- =====================================================

-- Configuración inicial
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Configurar charset por defecto
SET NAMES utf8mb4;
SET CHARACTER_SET_CLIENT = utf8mb4;
SET CHARACTER_SET_CONNECTION = utf8mb4;
SET CHARACTER_SET_RESULTS = utf8mb4;

-- Desactivar restricciones temporalmente
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================
-- CREAR BASE DE DATOS
-- =====================================================

CREATE DATABASE IF NOT EXISTS `tennisyzapatos_db` 
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE `tennisyzapatos_db`;

-- =====================================================
-- TABLAS DE CATÁLOGO Y CONFIGURACIÓN
-- =====================================================

-- -----------------------------------------------------
-- Tabla: categorias
-- Descripción: Categorías de productos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre` (`nombre`),
  KEY `idx_estado` (`estado`),
  KEY `idx_slug` (`slug`),
  KEY `idx_orden` (`orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Categorías de productos';

-- -----------------------------------------------------
-- Tabla: marcas
-- Descripción: Marcas de productos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `marcas`;
CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sitio_web` varchar(255) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre` (`nombre`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Marcas de productos';

-- -----------------------------------------------------
-- Tabla: tallas
-- Descripción: Catálogo de tallas disponibles
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tallas`;
CREATE TABLE `tallas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `tipo` enum('numerica','alfabetica','unica') NOT NULL DEFAULT 'numerica',
  `descripcion` varchar(100) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre_tipo` (`nombre`, `tipo`),
  KEY `idx_estado` (`estado`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_orden` (`orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Catálogo de tallas';

-- -----------------------------------------------------
-- Tabla: colores
-- Descripción: Catálogo de colores disponibles
-- -----------------------------------------------------
DROP TABLE IF EXISTS `colores`;
CREATE TABLE `colores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `codigo_hex` varchar(7) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre` (`nombre`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Catálogo de colores';

-- -----------------------------------------------------
-- Tabla: generos
-- Descripción: Géneros de productos (Masculino, Femenino, Unisex, etc.)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `generos`;
CREATE TABLE `generos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre` (`nombre`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Géneros de productos';

-- -----------------------------------------------------
-- Tabla: metodos_pago
-- Descripción: Métodos de pago disponibles
-- -----------------------------------------------------
DROP TABLE IF EXISTS `metodos_pago`;
CREATE TABLE `metodos_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `requiere_verificacion` tinyint(1) DEFAULT 0,
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre` (`nombre`),
  KEY `idx_estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Métodos de pago';

-- -----------------------------------------------------
-- Tabla: estados_pedido
-- Descripción: Estados del flujo de pedidos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estados_pedido`;
CREATE TABLE `estados_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `color` varchar(20) DEFAULT '#6c757d',
  `icono` varchar(50) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `es_final` tinyint(1) DEFAULT 0 COMMENT 'Indica si es un estado terminal',
  `notificar_cliente` tinyint(1) DEFAULT 1 COMMENT 'Si se debe notificar al cliente',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_nombre` (`nombre`),
  KEY `idx_estado` (`estado`),
  KEY `idx_orden` (`orden`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Estados del flujo de pedidos';

-- =====================================================
-- TABLAS DE USUARIOS Y AUTENTICACIÓN
-- =====================================================

-- -----------------------------------------------------
-- Tabla: usuarios
-- Descripción: Usuarios del sistema (clientes, empleados, administradores)
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `documento` varchar(50) DEFAULT NULL COMMENT 'Cédula o documento de identidad',
  `tipo_documento` enum('CC','CE','NIT','Pasaporte') DEFAULT 'CC',
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` enum('M','F','Otro','Prefiero no decir') DEFAULT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `rol` enum('cliente','empleado','administrador') NOT NULL DEFAULT 'cliente',
  `estado` enum('activo','inactivo','suspendido') NOT NULL DEFAULT 'activo',
  `email_verificado` tinyint(1) DEFAULT 0,
  `telefono_verificado` tinyint(1) DEFAULT 0,
  `ultimo_acceso` timestamp NULL DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_email` (`email`),
  UNIQUE KEY `uk_documento` (`documento`),
  KEY `idx_rol` (`rol`),
  KEY `idx_estado` (`estado`),
  KEY `idx_email_verificado` (`email_verificado`),
  KEY `idx_nombre_apellido` (`nombre`, `apellido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Usuarios del sistema';

-- -----------------------------------------------------
-- Tabla: direcciones_envio
-- Descripción: Direcciones de envío de los usuarios
-- -----------------------------------------------------
DROP TABLE IF EXISTS `direcciones_envio`;
CREATE TABLE `direcciones_envio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `nombre_completo` varchar(200) DEFAULT NULL COMMENT 'Nombre del destinatario',
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL COMMENT 'Apartamento, casa, oficina, etc.',
  `ciudad` varchar(100) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `pais` varchar(100) NOT NULL DEFAULT 'Colombia',
  `referencias` text DEFAULT NULL COMMENT 'Referencias para encontrar la dirección',
  `es_principal` tinyint(1) NOT NULL DEFAULT 0,
  `tipo` enum('casa','oficina','otro') DEFAULT 'casa',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_es_principal` (`es_principal`),
  KEY `idx_ciudad` (`ciudad`),
  CONSTRAINT `fk_direccion_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Direcciones de envío';

-- =====================================================
-- TABLAS DE PRODUCTOS
-- =====================================================

-- -----------------------------------------------------
-- Tabla: productos
-- Descripción: Catálogo de productos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `descripcion_corta` varchar(500) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precio_oferta` decimal(10,2) DEFAULT NULL,
  `precio_costo` decimal(10,2) DEFAULT NULL COMMENT 'Precio de costo para cálculos',
  `categoria_id` int(11) NOT NULL,
  `marca_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `genero_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT 'Stock total (suma de producto_tallas)',
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `requiere_talla` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Si el producto requiere selección de talla',
  `codigo_sku` varchar(50) NOT NULL,
  `codigo_barras` varchar(100) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL COMMENT 'Peso en gramos',
  `imagen_principal` varchar(255) DEFAULT NULL,
  `imagen_2` varchar(255) DEFAULT NULL,
  `imagen_3` varchar(255) DEFAULT NULL,
  `imagen_4` varchar(255) DEFAULT NULL,
  `imagen_5` varchar(255) DEFAULT NULL,
  `destacado` tinyint(1) NOT NULL DEFAULT 0,
  `nuevo` tinyint(1) DEFAULT 0,
  `en_oferta` tinyint(1) DEFAULT 0,
  `vistas` int(11) DEFAULT 0 COMMENT 'Contador de vistas del producto',
  `valoracion_promedio` decimal(3,2) DEFAULT 0.00,
  `total_valoraciones` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo','agotado') NOT NULL DEFAULT 'activo',
  `meta_title` varchar(200) DEFAULT NULL COMMENT 'SEO: Título',
  `meta_description` varchar(500) DEFAULT NULL COMMENT 'SEO: Descripción',
  `meta_keywords` varchar(255) DEFAULT NULL COMMENT 'SEO: Palabras clave',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_codigo_sku` (`codigo_sku`),
  KEY `idx_categoria` (`categoria_id`),
  KEY `idx_marca` (`marca_id`),
  KEY `idx_color` (`color_id`),
  KEY `idx_genero` (`genero_id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_destacado` (`destacado`),
  KEY `idx_nuevo` (`nuevo`),
  KEY `idx_en_oferta` (`en_oferta`),
  KEY `idx_nombre` (`nombre`),
  KEY `idx_precio` (`precio`),
  KEY `idx_valoracion` (`valoracion_promedio`),
  CONSTRAINT `fk_producto_categoria` 
    FOREIGN KEY (`categoria_id`) 
    REFERENCES `categorias` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_producto_marca` 
    FOREIGN KEY (`marca_id`) 
    REFERENCES `marcas` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_producto_color` 
    FOREIGN KEY (`color_id`) 
    REFERENCES `colores` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_producto_genero` 
    FOREIGN KEY (`genero_id`) 
    REFERENCES `generos` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Catálogo de productos';

-- -----------------------------------------------------
-- Tabla: producto_tallas
-- Descripción: Relación muchos a muchos entre productos y tallas
--              Permite que un producto tenga múltiples tallas con stock individual
-- -----------------------------------------------------
DROP TABLE IF EXISTS `producto_tallas`;
CREATE TABLE `producto_tallas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 5,
  `precio_adicional` decimal(10,2) DEFAULT 0.00 COMMENT 'Precio adicional por esta talla',
  `estado` enum('activo','inactivo') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_producto_talla` (`producto_id`, `talla_id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_talla` (`talla_id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_stock` (`stock`),
  CONSTRAINT `fk_pt_producto` 
    FOREIGN KEY (`producto_id`) 
    REFERENCES `productos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pt_talla` 
    FOREIGN KEY (`talla_id`) 
    REFERENCES `tallas` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Stock de productos por talla';

-- -----------------------------------------------------
-- Tabla: imagenes_producto
-- Descripción: Galería de imágenes adicionales de productos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `imagenes_producto`;
CREATE TABLE `imagenes_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `es_principal` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_orden` (`orden`),
  CONSTRAINT `fk_imagen_producto` 
    FOREIGN KEY (`producto_id`) 
    REFERENCES `productos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Galería de imágenes de productos';

-- =====================================================
-- TABLAS DE CARRITO Y PEDIDOS
-- =====================================================

-- -----------------------------------------------------
-- Tabla: carrito
-- Descripción: Carrito de compras de los usuarios
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carrito`;
CREATE TABLE `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL COMMENT 'NULL para usuarios no autenticados (sesión)',
  `session_id` varchar(255) DEFAULT NULL COMMENT 'ID de sesión para usuarios no autenticados',
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `precio` decimal(10,2) NOT NULL COMMENT 'Precio al momento de agregar',
  `fecha_agregado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_session` (`session_id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_talla` (`talla_id`),
  KEY `idx_producto_talla` (`producto_id`, `talla_id`),
  KEY `idx_fecha_agregado` (`fecha_agregado`),
  CONSTRAINT `fk_carrito_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_carrito_producto` 
    FOREIGN KEY (`producto_id`) 
    REFERENCES `productos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_carrito_talla` 
    FOREIGN KEY (`talla_id`) 
    REFERENCES `tallas` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Carrito de compras';

-- -----------------------------------------------------
-- Tabla: pedidos
-- Descripción: Pedidos realizados por los clientes
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_pedido` varchar(50) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `direccion_id` int(11) DEFAULT NULL COMMENT 'Dirección de envío del pedido',
  `empleado_id` int(11) DEFAULT NULL COMMENT 'Empleado que procesó el pedido',
  `total` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00,
  `impuestos` decimal(10,2) DEFAULT 0.00,
  `costo_envio` decimal(10,2) DEFAULT 0.00,
  `metodo_pago_id` int(11) NOT NULL,
  `estado_pedido_id` int(11) NOT NULL,
  `tipo_pedido` enum('online','presencial','telefono','whatsapp') NOT NULL DEFAULT 'online',
  
  -- Información de envío (desnormalizada para histórico)
  `direccion_envio` varchar(255) DEFAULT NULL,
  `ciudad_envio` varchar(100) DEFAULT NULL,
  `departamento_envio` varchar(100) DEFAULT NULL,
  `codigo_postal_envio` varchar(20) DEFAULT NULL,
  `pais_envio` varchar(100) DEFAULT 'Colombia',
  `nombre_destinatario` varchar(200) DEFAULT NULL,
  `telefono_destinatario` varchar(20) DEFAULT NULL,
  
  -- Datos de rastreo
  `numero_guia` varchar(100) DEFAULT NULL COMMENT 'Número de guía de envío',
  `transportadora` varchar(100) DEFAULT NULL,
  
  -- Fechas importantes
  `fecha_pedido` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `fecha_preparacion` timestamp NULL DEFAULT NULL,
  `fecha_envio` timestamp NULL DEFAULT NULL,
  `fecha_entrega` timestamp NULL DEFAULT NULL,
  `fecha_cancelacion` timestamp NULL DEFAULT NULL,
  
  -- Información adicional
  `observaciones` text DEFAULT NULL,
  `notas_internas` text DEFAULT NULL COMMENT 'Notas visibles solo para empleados',
  `ip_cliente` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  
  -- Control
  `requiere_factura` tinyint(1) DEFAULT 0,
  `facturado` tinyint(1) DEFAULT 0,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_numero_pedido` (`numero_pedido`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_direccion` (`direccion_id`),
  KEY `idx_empleado` (`empleado_id`),
  KEY `idx_metodo_pago` (`metodo_pago_id`),
  KEY `idx_estado_pedido` (`estado_pedido_id`),
  KEY `idx_tipo_pedido` (`tipo_pedido`),
  KEY `idx_fecha_pedido` (`fecha_pedido`),
  KEY `idx_fecha_entrega` (`fecha_entrega`),
  KEY `idx_numero_guia` (`numero_guia`),
  
  CONSTRAINT `fk_pedido_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pedido_direccion` 
    FOREIGN KEY (`direccion_id`) 
    REFERENCES `direcciones_envio` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pedido_empleado` 
    FOREIGN KEY (`empleado_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pedido_metodo_pago` 
    FOREIGN KEY (`metodo_pago_id`) 
    REFERENCES `metodos_pago` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pedido_estado` 
    FOREIGN KEY (`estado_pedido_id`) 
    REFERENCES `estados_pedido` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Pedidos de clientes';

-- -----------------------------------------------------
-- Tabla: detalle_pedidos
-- Descripción: Líneas de productos en cada pedido
-- -----------------------------------------------------
DROP TABLE IF EXISTS `detalle_pedidos`;
CREATE TABLE `detalle_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) DEFAULT 0.00,
  `impuesto` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  
  -- Información desnormalizada para histórico
  `nombre_producto` varchar(200) DEFAULT NULL,
  `sku_producto` varchar(50) DEFAULT NULL,
  `nombre_talla` varchar(20) DEFAULT NULL,
  
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_talla` (`talla_id`),
  
  CONSTRAINT `fk_detalle_pedido` 
    FOREIGN KEY (`pedido_id`) 
    REFERENCES `pedidos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detalle_producto` 
    FOREIGN KEY (`producto_id`) 
    REFERENCES `productos` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_detalle_talla` 
    FOREIGN KEY (`talla_id`) 
    REFERENCES `tallas` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Detalles de pedidos';

-- -----------------------------------------------------
-- Tabla: historial_estados_pedido
-- Descripción: Rastreo de cambios de estado de pedidos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `historial_estados_pedido`;
CREATE TABLE `historial_estados_pedido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `estado_anterior_id` int(11) DEFAULT NULL,
  `estado_nuevo_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL COMMENT 'Usuario que realizó el cambio',
  `observaciones` text DEFAULT NULL,
  `fecha_cambio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_estado_anterior` (`estado_anterior_id`),
  KEY `idx_estado_nuevo` (`estado_nuevo_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_fecha_cambio` (`fecha_cambio`),
  
  CONSTRAINT `fk_hist_pedido` 
    FOREIGN KEY (`pedido_id`) 
    REFERENCES `pedidos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_hist_estado_anterior` 
    FOREIGN KEY (`estado_anterior_id`) 
    REFERENCES `estados_pedido` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_hist_estado_nuevo` 
    FOREIGN KEY (`estado_nuevo_id`) 
    REFERENCES `estados_pedido` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_hist_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Historial de estados de pedidos';

-- =====================================================
-- TABLAS DE FACTURACIÓN Y FINANZAS
-- =====================================================

-- -----------------------------------------------------
-- Tabla: facturas
-- Descripción: Facturas generadas
-- -----------------------------------------------------
DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(50) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `impuestos` decimal(10,2) DEFAULT 0.00,
  `descuentos` decimal(10,2) DEFAULT 0.00,
  
  -- Datos fiscales
  `nit_empresa` varchar(50) DEFAULT NULL,
  `nombre_empresa` varchar(200) DEFAULT NULL,
  `direccion_empresa` varchar(255) DEFAULT NULL,
  `telefono_empresa` varchar(20) DEFAULT NULL,
  
  -- Datos del cliente
  `nit_cliente` varchar(50) DEFAULT NULL,
  `nombre_cliente` varchar(200) DEFAULT NULL,
  `direccion_cliente` varchar(255) DEFAULT NULL,
  
  -- Control
  `fecha_emision` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_vencimiento` timestamp NULL DEFAULT NULL,
  `fecha_pago` timestamp NULL DEFAULT NULL,
  `estado` enum('pendiente','pagada','vencida','cancelada','anulada') NOT NULL DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `archivo_pdf` varchar(255) DEFAULT NULL,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_numero_factura` (`numero_factura`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_empleado` (`empleado_id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha_emision` (`fecha_emision`),
  KEY `idx_fecha_vencimiento` (`fecha_vencimiento`),
  
  CONSTRAINT `fk_factura_pedido` 
    FOREIGN KEY (`pedido_id`) 
    REFERENCES `pedidos` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE RESTRICT 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_empleado` 
    FOREIGN KEY (`empleado_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Facturas';

-- =====================================================
-- TABLAS DE INVENTARIO Y STOCK
-- =====================================================

-- -----------------------------------------------------
-- Tabla: historial_stock
-- Descripción: Movimientos de inventario
-- -----------------------------------------------------
DROP TABLE IF EXISTS `historial_stock`;
CREATE TABLE `historial_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL COMMENT 'Usuario que realizó el movimiento',
  `tipo` enum('entrada','salida','ajuste','devolucion','merma','venta','compra') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `stock_anterior` int(11) NOT NULL,
  `stock_nuevo` int(11) NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `referencia` varchar(100) DEFAULT NULL COMMENT 'Número de pedido, factura, etc.',
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `costo_total` decimal(10,2) DEFAULT NULL,
  `fecha_movimiento` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_talla` (`talla_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_fecha_movimiento` (`fecha_movimiento`),
  KEY `idx_referencia` (`referencia`),
  
  CONSTRAINT `fk_histstock_producto` 
    FOREIGN KEY (`producto_id`) 
    REFERENCES `productos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_histstock_talla` 
    FOREIGN KEY (`talla_id`) 
    REFERENCES `tallas` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_histstock_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Historial de movimientos de stock';

-- =====================================================
-- TABLAS DE VALORACIONES Y COMENTARIOS
-- =====================================================

-- -----------------------------------------------------
-- Tabla: valoraciones_producto
-- Descripción: Valoraciones y reseñas de productos
-- -----------------------------------------------------
DROP TABLE IF EXISTS `valoraciones_producto`;
CREATE TABLE `valoraciones_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL COMMENT 'Pedido asociado a la compra',
  `puntuacion` tinyint(1) NOT NULL COMMENT 'De 1 a 5 estrellas',
  `titulo` varchar(200) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `ventajas` text DEFAULT NULL,
  `desventajas` text DEFAULT NULL,
  `verificado` tinyint(1) DEFAULT 0 COMMENT 'Compra verificada',
  `aprobado` tinyint(1) DEFAULT 0 COMMENT 'Aprobado por moderador',
  `util_positivo` int(11) DEFAULT 0 COMMENT '¿Útil? - votos positivos',
  `util_negativo` int(11) DEFAULT 0 COMMENT '¿Útil? - votos negativos',
  `respuesta_tienda` text DEFAULT NULL,
  `fecha_respuesta` timestamp NULL DEFAULT NULL,
  `estado` enum('pendiente','aprobado','rechazado','reportado') DEFAULT 'pendiente',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_producto` (`producto_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_puntuacion` (`puntuacion`),
  KEY `idx_estado` (`estado`),
  KEY `idx_verificado` (`verificado`),
  
  CONSTRAINT `fk_valoracion_producto` 
    FOREIGN KEY (`producto_id`) 
    REFERENCES `productos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_valoracion_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_valoracion_pedido` 
    FOREIGN KEY (`pedido_id`) 
    REFERENCES `pedidos` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE,
  CONSTRAINT `chk_puntuacion` 
    CHECK (`puntuacion` >= 1 AND `puntuacion` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Valoraciones de productos';

-- =====================================================
-- TABLAS DE CUPONES Y PROMOCIONES
-- =====================================================

-- -----------------------------------------------------
-- Tabla: cupones
-- Descripción: Cupones de descuento
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cupones`;
CREATE TABLE `cupones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `tipo_descuento` enum('porcentaje','monto_fijo','envio_gratis') NOT NULL,
  `valor` decimal(10,2) NOT NULL COMMENT 'Porcentaje (0-100) o monto fijo',
  `monto_minimo` decimal(10,2) DEFAULT NULL COMMENT 'Compra mínima para aplicar',
  `monto_maximo_descuento` decimal(10,2) DEFAULT NULL COMMENT 'Descuento máximo aplicable',
  `usos_maximos` int(11) DEFAULT NULL COMMENT 'Límite de usos totales',
  `usos_maximos_usuario` int(11) DEFAULT 1 COMMENT 'Límite de usos por usuario',
  `usos_actuales` int(11) DEFAULT 0,
  `fecha_inicio` timestamp NULL DEFAULT NULL,
  `fecha_fin` timestamp NULL DEFAULT NULL,
  `productos_aplicables` text DEFAULT NULL COMMENT 'IDs de productos (JSON)',
  `categorias_aplicables` text DEFAULT NULL COMMENT 'IDs de categorías (JSON)',
  `solo_primera_compra` tinyint(1) DEFAULT 0,
  `estado` enum('activo','inactivo','vencido') NOT NULL DEFAULT 'activo',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_codigo` (`codigo`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha_inicio` (`fecha_inicio`),
  KEY `idx_fecha_fin` (`fecha_fin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Cupones de descuento';

-- -----------------------------------------------------
-- Tabla: cupones_usados
-- Descripción: Registro de uso de cupones
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cupones_usados`;
CREATE TABLE `cupones_usados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cupon_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `descuento_aplicado` decimal(10,2) NOT NULL,
  `fecha_uso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_cupon` (`cupon_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_pedido` (`pedido_id`),
  
  CONSTRAINT `fk_cuponuso_cupon` 
    FOREIGN KEY (`cupon_id`) 
    REFERENCES `cupones` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cuponuso_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE,
  CONSTRAINT `fk_cuponuso_pedido` 
    FOREIGN KEY (`pedido_id`) 
    REFERENCES `pedidos` (`id`) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Uso de cupones';

-- =====================================================
-- TABLAS DE SISTEMA Y CONFIGURACIÓN
-- =====================================================

-- -----------------------------------------------------
-- Tabla: configuraciones
-- Descripción: Configuraciones generales del sistema
-- -----------------------------------------------------
DROP TABLE IF EXISTS `configuraciones`;
CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clave` varchar(100) NOT NULL,
  `valor` text DEFAULT NULL,
  `tipo` enum('texto','numero','boolean','json','fecha') DEFAULT 'texto',
  `grupo` varchar(50) DEFAULT NULL COMMENT 'Agrupación de configuraciones',
  `descripcion` varchar(255) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT 1,
  `fecha_actualizacion` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_clave` (`clave`),
  KEY `idx_grupo` (`grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Configuraciones del sistema';

-- -----------------------------------------------------
-- Tabla: logs_sistema
-- Descripción: Registro de eventos del sistema
-- -----------------------------------------------------
DROP TABLE IF EXISTS `logs_sistema`;
CREATE TABLE `logs_sistema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo` enum('info','warning','error','security','access') NOT NULL,
  `accion` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tabla_afectada` varchar(100) DEFAULT NULL,
  `registro_id` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `datos_adicionales` text DEFAULT NULL COMMENT 'JSON con información adicional',
  `fecha_log` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_accion` (`accion`),
  KEY `idx_fecha_log` (`fecha_log`),
  
  CONSTRAINT `fk_log_usuario` 
    FOREIGN KEY (`usuario_id`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE SET NULL 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Logs del sistema';

-- -----------------------------------------------------
-- Tabla: sesiones
-- Descripción: Sesiones activas de usuarios
-- -----------------------------------------------------
DROP TABLE IF EXISTS `sesiones`;
CREATE TABLE `sesiones` (
  `id` varchar(128) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `payload` text DEFAULT NULL,
  `ultimo_acceso` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_ultimo_acceso` (`ultimo_acceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci 
  COMMENT='Sesiones de usuarios';

-- =====================================================
-- VISTAS ÚTILES
-- =====================================================

-- Vista: productos_completos
-- Descripción: Productos con toda su información relacionada
DROP VIEW IF EXISTS `vista_productos_completos`;
CREATE VIEW `vista_productos_completos` AS
SELECT 
  p.*,
  c.nombre AS categoria_nombre,
  m.nombre AS marca_nombre,
  co.nombre AS color_nombre,
  g.nombre AS genero_nombre,
  (SELECT COUNT(*) FROM producto_tallas pt WHERE pt.producto_id = p.id AND pt.estado = 'activo') AS total_tallas_disponibles,
  (SELECT SUM(pt.stock) FROM producto_tallas pt WHERE pt.producto_id = p.id) AS stock_total_tallas
FROM productos p
LEFT JOIN categorias c ON p.categoria_id = c.id
LEFT JOIN marcas m ON p.marca_id = m.id
LEFT JOIN colores co ON p.color_id = co.id
LEFT JOIN generos g ON p.genero_id = g.id;

-- Vista: pedidos_completos
-- Descripción: Pedidos con información resumida
DROP VIEW IF EXISTS `vista_pedidos_completos`;
CREATE VIEW `vista_pedidos_completos` AS
SELECT 
  p.*,
  u.nombre AS cliente_nombre,
  u.apellido AS cliente_apellido,
  u.email AS cliente_email,
  u.telefono AS cliente_telefono,
  e.nombre AS empleado_nombre,
  e.apellido AS empleado_apellido,
  ep.nombre AS estado_nombre,
  ep.color AS estado_color,
  mp.nombre AS metodo_pago_nombre,
  (SELECT COUNT(*) FROM detalle_pedidos dp WHERE dp.pedido_id = p.id) AS total_items,
  (SELECT SUM(dp.cantidad) FROM detalle_pedidos dp WHERE dp.pedido_id = p.id) AS total_productos
FROM pedidos p
INNER JOIN usuarios u ON p.usuario_id = u.id
LEFT JOIN usuarios e ON p.empleado_id = e.id
INNER JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
INNER JOIN metodos_pago mp ON p.metodo_pago_id = mp.id;

-- =====================================================
-- TRIGGERS
-- =====================================================

-- Trigger: Actualizar stock total del producto al modificar producto_tallas
DELIMITER $$

DROP TRIGGER IF EXISTS `trg_producto_tallas_after_insert`$$
CREATE TRIGGER `trg_producto_tallas_after_insert`
AFTER INSERT ON `producto_tallas`
FOR EACH ROW
BEGIN
  UPDATE productos 
  SET stock = (SELECT COALESCE(SUM(stock), 0) FROM producto_tallas WHERE producto_id = NEW.producto_id AND estado = 'activo')
  WHERE id = NEW.producto_id;
END$$

DROP TRIGGER IF EXISTS `trg_producto_tallas_after_update`$$
CREATE TRIGGER `trg_producto_tallas_after_update`
AFTER UPDATE ON `producto_tallas`
FOR EACH ROW
BEGIN
  UPDATE productos 
  SET stock = (SELECT COALESCE(SUM(stock), 0) FROM producto_tallas WHERE producto_id = NEW.producto_id AND estado = 'activo')
  WHERE id = NEW.producto_id;
END$$

DROP TRIGGER IF EXISTS `trg_producto_tallas_after_delete`$$
CREATE TRIGGER `trg_producto_tallas_after_delete`
AFTER DELETE ON `producto_tallas`
FOR EACH ROW
BEGIN
  UPDATE productos 
  SET stock = (SELECT COALESCE(SUM(stock), 0) FROM producto_tallas WHERE producto_id = OLD.producto_id AND estado = 'activo')
  WHERE id = OLD.producto_id;
END$$

-- Trigger: Actualizar valoración promedio del producto
DROP TRIGGER IF EXISTS `trg_valoraciones_after_insert`$$
CREATE TRIGGER `trg_valoraciones_after_insert`
AFTER INSERT ON `valoraciones_producto`
FOR EACH ROW
BEGIN
  UPDATE productos p
  SET 
    valoracion_promedio = (
      SELECT AVG(puntuacion) 
      FROM valoraciones_producto 
      WHERE producto_id = NEW.producto_id AND aprobado = 1
    ),
    total_valoraciones = (
      SELECT COUNT(*) 
      FROM valoraciones_producto 
      WHERE producto_id = NEW.producto_id AND aprobado = 1
    )
  WHERE p.id = NEW.producto_id;
END$$

DROP TRIGGER IF EXISTS `trg_valoraciones_after_update`$$
CREATE TRIGGER `trg_valoraciones_after_update`
AFTER UPDATE ON `valoraciones_producto`
FOR EACH ROW
BEGIN
  UPDATE productos p
  SET 
    valoracion_promedio = (
      SELECT AVG(puntuacion) 
      FROM valoraciones_producto 
      WHERE producto_id = NEW.producto_id AND aprobado = 1
    ),
    total_valoraciones = (
      SELECT COUNT(*) 
      FROM valoraciones_producto 
      WHERE producto_id = NEW.producto_id AND aprobado = 1
    )
  WHERE p.id = NEW.producto_id;
END$$

-- Trigger: Registrar cambio de estado de pedido
DROP TRIGGER IF EXISTS `trg_pedidos_after_update`$$
CREATE TRIGGER `trg_pedidos_after_update`
AFTER UPDATE ON `pedidos`
FOR EACH ROW
BEGIN
  IF OLD.estado_pedido_id != NEW.estado_pedido_id THEN
    INSERT INTO historial_estados_pedido (pedido_id, estado_anterior_id, estado_nuevo_id, observaciones)
    VALUES (NEW.id, OLD.estado_pedido_id, NEW.estado_pedido_id, 'Cambio automático de estado');
  END IF;
END$$

DELIMITER ;

-- =====================================================
-- PROCEDIMIENTOS ALMACENADOS
-- =====================================================

DELIMITER $$

-- Procedimiento: Obtener stock disponible por talla
DROP PROCEDURE IF EXISTS `sp_obtener_stock_talla`$$
CREATE PROCEDURE `sp_obtener_stock_talla`(
  IN p_producto_id INT,
  IN p_talla_id INT
)
BEGIN
  SELECT stock 
  FROM producto_tallas 
  WHERE producto_id = p_producto_id 
    AND talla_id = p_talla_id 
    AND estado = 'activo'
  LIMIT 1;
END$$

-- Procedimiento: Actualizar stock de talla
DROP PROCEDURE IF EXISTS `sp_actualizar_stock_talla`$$
CREATE PROCEDURE `sp_actualizar_stock_talla`(
  IN p_producto_id INT,
  IN p_talla_id INT,
  IN p_cantidad INT,
  IN p_tipo VARCHAR(20),
  IN p_usuario_id INT,
  IN p_motivo VARCHAR(255),
  IN p_referencia VARCHAR(100)
)
BEGIN
  DECLARE v_stock_actual INT;
  DECLARE v_stock_nuevo INT;
  
  -- Obtener stock actual
  SELECT stock INTO v_stock_actual 
  FROM producto_tallas 
  WHERE producto_id = p_producto_id AND talla_id = p_talla_id
  LIMIT 1;
  
  -- Calcular nuevo stock
  IF p_tipo IN ('entrada', 'devolucion', 'compra') THEN
    SET v_stock_nuevo = v_stock_actual + p_cantidad;
  ELSE
    SET v_stock_nuevo = v_stock_actual - p_cantidad;
  END IF;
  
  -- Actualizar stock
  UPDATE producto_tallas 
  SET stock = v_stock_nuevo 
  WHERE producto_id = p_producto_id AND talla_id = p_talla_id;
  
  -- Registrar en historial
  INSERT INTO historial_stock (
    producto_id, talla_id, usuario_id, tipo, cantidad, 
    stock_anterior, stock_nuevo, motivo, referencia
  ) VALUES (
    p_producto_id, p_talla_id, p_usuario_id, p_tipo, p_cantidad,
    v_stock_actual, v_stock_nuevo, p_motivo, p_referencia
  );
  
  SELECT v_stock_nuevo AS stock_actualizado;
END$$

-- Procedimiento: Limpiar carritos antiguos
DROP PROCEDURE IF EXISTS `sp_limpiar_carritos_antiguos`$$
CREATE PROCEDURE `sp_limpiar_carritos_antiguos`(
  IN p_dias INT
)
BEGIN
  DELETE FROM carrito 
  WHERE fecha_actualizacion < DATE_SUB(NOW(), INTERVAL p_dias DAY)
     OR (fecha_actualizacion IS NULL AND fecha_agregado < DATE_SUB(NOW(), INTERVAL p_dias DAY));
  
  SELECT ROW_COUNT() AS registros_eliminados;
END$$

DELIMITER ;

-- =====================================================
-- REACTIVAR RESTRICCIONES
-- =====================================================

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- =====================================================
-- RESUMEN DE LA ESTRUCTURA
-- =====================================================

SELECT 
  'Base de datos creada exitosamente' AS estado,
  DATABASE() AS base_datos,
  (SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_TYPE = 'BASE TABLE') AS total_tablas,
  (SELECT COUNT(*) FROM information_schema.VIEWS WHERE TABLE_SCHEMA = DATABASE()) AS total_vistas,
  (SELECT COUNT(*) FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE = 'PROCEDURE') AS total_procedimientos,
  (SELECT COUNT(*) FROM information_schema.TRIGGERS WHERE TRIGGER_SCHEMA = DATABASE()) AS total_triggers;

-- Listar todas las tablas
SELECT TABLE_NAME AS tabla, 
       ENGINE AS motor,
       TABLE_ROWS AS filas_aprox,
       ROUND((DATA_LENGTH + INDEX_LENGTH) / 1024 / 1024, 2) AS tamaño_mb,
       TABLE_COMMENT AS comentario
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = DATABASE() 
  AND TABLE_TYPE = 'BASE TABLE'
ORDER BY TABLE_NAME;

-- =====================================================
-- FIN DE ESTRUCTURA
-- =====================================================
