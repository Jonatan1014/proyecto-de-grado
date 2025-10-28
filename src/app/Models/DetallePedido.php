<?php
/**
 * Modelo: DetallePedido
 * Gestiona los detalles de los pedidos
 */

require_once __DIR__ . '/../../config/database.php';

class DetallePedido {
    
    /**
     * Obtener detalles de un pedido con información de tallas
     */
    public static function obtenerPorPedidoConTallas($pedidoId) {
        $db = Database::getConnection();
        
        $sql = "SELECT 
                    dp.*,
                    p.nombre as producto_nombre,
                    p.imagen_principal,
                    p.descripcion as producto_descripcion,
                    t.nombre as talla_nombre,
                    t.nombre as talla_tipo
                FROM detalle_pedidos dp
                INNER JOIN productos p ON dp.producto_id = p.id
                LEFT JOIN tallas t ON dp.talla_id = t.id
                WHERE dp.pedido_id = :pedido_id
                ORDER BY dp.id ASC";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener detalles de un pedido (sin tallas)
     */
    public static function obtenerPorPedido($pedidoId) {
        $db = Database::getConnection();
        
        $sql = "SELECT 
                    dp.*,
                    p.nombre as producto_nombre,
                    p.imagen_principal,
                    p.descripcion as producto_descripcion
                FROM detalle_pedidos dp
                INNER JOIN productos p ON dp.producto_id = p.id
                WHERE dp.pedido_id = :pedido_id
                ORDER BY dp.id ASC";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear un detalle de pedido
     */
    public static function crear($pedidoId, $productoId, $cantidad, $precioUnitario, $tallaId = null) {
        $db = Database::getConnection();
        
        $subtotal = $cantidad * $precioUnitario;
        
        if ($tallaId) {
            $sql = "INSERT INTO detalle_pedidos 
                    (pedido_id, producto_id, talla_id, cantidad, precio_unitario, subtotal)
                    VALUES 
                    (:pedido_id, :producto_id, :talla_id, :cantidad, :precio_unitario, :subtotal)";
        } else {
            $sql = "INSERT INTO detalle_pedidos 
                    (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
                    VALUES 
                    (:pedido_id, :producto_id, :cantidad, :precio_unitario, :subtotal)";
        }
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->bindValue(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->bindValue(':precio_unitario', $precioUnitario);
        $stmt->bindValue(':subtotal', $subtotal);
        
        if ($tallaId) {
            $stmt->bindValue(':talla_id', $tallaId, PDO::PARAM_INT);
        }
        
        return $stmt->execute();
    }
    
    /**
     * Obtener total de un pedido sumando sus detalles
     */
    public static function calcularTotal($pedidoId) {
        $db = Database::getConnection();
        
        $sql = "SELECT SUM(subtotal) as total
                FROM detalle_pedidos
                WHERE pedido_id = :pedido_id";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }
}
