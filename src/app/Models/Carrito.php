<?php
// src/app/Models/Carrito.php

require_once __DIR__ . '/../../config/database.php';

class Carrito {

    /**
     * Agregar producto al carrito
     */
    public static function agregar($carritoId, $productoId, $cantidad, $precio) {
        $db = Database::getConnection();

        // Verificar si el producto ya está en el carrito
        $sqlCheck = "SELECT id, cantidad FROM carrito 
                     WHERE usuario_id = :carrito_id AND producto_id = :producto_id";
        
        $stmtCheck = $db->prepare($sqlCheck);
        $stmtCheck->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
        $stmtCheck->bindValue(':producto_id', $productoId, PDO::PARAM_INT);
        $stmtCheck->execute();
        
        $existing = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            // Actualizar cantidad
            $nuevaCantidad = $existing['cantidad'] + $cantidad;
            return self::actualizarCantidad($existing['id'], $nuevaCantidad);
        } else {
            // Insertar nuevo item
            $sql = "INSERT INTO carrito (usuario_id, producto_id, cantidad, precio) 
                    VALUES (:carrito_id, :producto_id, :cantidad, :precio)";
            
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
            $stmt->bindValue(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindValue(':precio', $precio, PDO::PARAM_STR);
            
            return $stmt->execute();
        }
    }

    /**
     * Obtener items del carrito por usuario
     */
    public static function obtenerPorUsuario($carritoId) {
        $db = Database::getConnection();

        $sql = "SELECT c.*, 
                       p.nombre as producto_nombre,
                       p.imagen_principal,
                       p.stock,
                       p.precio as precio_actual,
                       p.precio_oferta,
                       m.nombre as marca_nombre
                FROM carrito c
                INNER JOIN productos p ON c.producto_id = p.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                WHERE c.usuario_id = :carrito_id
                ORDER BY c.fecha_agregado DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener items del carrito (alias para checkout y vistas)
     */
    public static function obtenerItems($carritoId) {
        $db = Database::getConnection();

        $sql = "SELECT c.*, 
                       p.id as producto_id,
                       p.nombre as producto_nombre,
                       p.descripcion,
                       p.imagen_principal,
                       p.imagen_2,
                       p.imagen_3,
                       p.stock,
                       p.precio,
                       p.precio_oferta,
                       p.codigo_sku,
                       m.nombre as marca_nombre,
                       cat.nombre as categoria_nombre,
                       t.nombre as talla_nombre,
                       col.nombre as color_nombre,
                       gen.nombre as genero_nombre
                FROM carrito c
                INNER JOIN productos p ON c.producto_id = p.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN categorias cat ON p.categoria_id = cat.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores col ON p.color_id = col.id
                LEFT JOIN generos gen ON p.genero_id = gen.id
                WHERE c.usuario_id = :carrito_id
                ORDER BY c.fecha_agregado DESC";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualizar cantidad de un item
     */
    public static function actualizarCantidad($carritoId, $cantidad) {
        $db = Database::getConnection();

        $sql = "UPDATE carrito 
                SET cantidad = :cantidad 
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindValue(':id', $carritoId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Eliminar item del carrito
     */
    public static function eliminar($carritoId) {
        $db = Database::getConnection();

        $sql = "DELETE FROM carrito WHERE id = :id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $carritoId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Vaciar carrito del usuario
     */
    public static function vaciar($carritoId) {
        $db = Database::getConnection();

        $sql = "DELETE FROM carrito WHERE usuario_id = :carrito_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Vaciar carrito del usuario (alias)
     */
    public static function vaciarCarrito($carritoId) {
        return self::vaciar($carritoId);
    }

    /**
     * Contar items en el carrito
     */
    public static function contarItems($carritoId) {
        $db = Database::getConnection();

        $sql = "SELECT SUM(cantidad) as total 
                FROM carrito 
                WHERE usuario_id = :carrito_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }

    /**
     * Calcular total del carrito
     */
    public static function calcularTotal($carritoId) {
        $db = Database::getConnection();

        $sql = "SELECT SUM(c.cantidad * c.precio) as total 
                FROM carrito c
                WHERE c.usuario_id = :carrito_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }

    /**
     * Verificar si un producto está en el carrito
     */
    public static function existeProducto($carritoId, $productoId) {
        $db = Database::getConnection();

        $sql = "SELECT id FROM carrito 
                WHERE usuario_id = :carrito_id AND producto_id = :producto_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':carrito_id', $carritoId, PDO::PARAM_STR);
        $stmt->bindValue(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    /**
     * Migrar carrito temporal a usuario logueado
     */
    public static function migrarCarritoTemporal($carritoTempId, $usuarioId) {
        $db = Database::getConnection();

        // Actualizar todos los items del carrito temporal al usuario
        $sql = "UPDATE carrito 
                SET usuario_id = :usuario_id 
                WHERE usuario_id = :carrito_temp_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindValue(':carrito_temp_id', $carritoTempId, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
