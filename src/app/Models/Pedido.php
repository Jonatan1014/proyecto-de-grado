<?php
/**
 * =============================================================================
 * MODELO: Pedido.php
 * Ubicación: src/app/Models/Pedido.php
 * =============================================================================
 */

require_once __DIR__ . '/../../config/database.php';

class Pedido {
    
    /**
     * Crear un nuevo pedido
     */
    public static function crear($datos) {
        $db = Database::getConnection();
        
        try {
            $db->beginTransaction();
            
            // Generar número de pedido único
            $numeroPedido = self::generarNumeroPedido();
            
            // Insertar pedido
            $sql = "INSERT INTO pedidos (
                        numero_pedido, usuario_id, empleado_id, total, subtotal, 
                        descuento, impuestos, metodo_pago_id, estado_pedido_id, 
                        tipo_pedido, observaciones
                    ) VALUES (
                        :numero_pedido, :usuario_id, :empleado_id, :total, :subtotal,
                        :descuento, :impuestos, :metodo_pago_id, :estado_pedido_id,
                        :tipo_pedido, :observaciones
                    )";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':numero_pedido' => $numeroPedido,
                ':usuario_id' => $datos['usuario_id'],
                ':empleado_id' => $datos['empleado_id'] ?? null,
                ':total' => $datos['total'],
                ':subtotal' => $datos['subtotal'],
                ':descuento' => $datos['descuento'] ?? 0,
                ':impuestos' => $datos['impuestos'] ?? 0,
                ':metodo_pago_id' => $datos['metodo_pago_id'],
                ':estado_pedido_id' => 1, // Pendiente por defecto
                ':tipo_pedido' => $datos['tipo_pedido'] ?? 'online',
                ':observaciones' => $datos['observaciones'] ?? null
            ]);
            
            $pedidoId = $db->lastInsertId();
            
            // Insertar detalles del pedido
            foreach ($datos['items'] as $item) {
                self::agregarDetalle($pedidoId, $item);
                
                // Reducir stock
                self::reducirStock($item['producto_id'], $item['cantidad']);
            }
            
            $db->commit();
            
            return [
                'success' => true,
                'pedido_id' => $pedidoId,
                'numero_pedido' => $numeroPedido
            ];
            
        } catch (Exception $e) {
            $db->rollBack();
            error_log("Error al crear pedido: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al procesar el pedido'
            ];
        }
    }
    
    /**
     * Agregar detalle al pedido
     */
    private static function agregarDetalle($pedidoId, $item) {
        $db = Database::getConnection();
        
        $sql = "INSERT INTO detalle_pedidos (
                    pedido_id, producto_id, cantidad, precio_unitario, subtotal
                ) VALUES (
                    :pedido_id, :producto_id, :cantidad, :precio_unitario, :subtotal
                )";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':pedido_id' => $pedidoId,
            ':producto_id' => $item['producto_id'],
            ':cantidad' => $item['cantidad'],
            ':precio_unitario' => $item['precio'],
            ':subtotal' => $item['precio'] * $item['cantidad']
        ]);
    }
    
    /**
     * Reducir stock del producto
     */
    private static function reducirStock($productoId, $cantidad) {
        $db = Database::getConnection();
        
        // Actualizar stock
        $sql = "UPDATE productos 
                SET stock = stock - :cantidad 
                WHERE id = :producto_id AND stock >= :cantidad";
        
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            ':cantidad' => $cantidad,
            ':producto_id' => $productoId
        ]);
        
        if (!$result || $stmt->rowCount() === 0) {
            throw new Exception("Stock insuficiente para el producto ID: $productoId");
        }
        
        // Registrar en historial
        $sqlHistorial = "INSERT INTO historial_stock (
                            producto_id, usuario_id, tipo, cantidad, 
                            stock_anterior, stock_nuevo, motivo
                        ) SELECT 
                            :producto_id,
                            NULL,
                            'salida',
                            :cantidad,
                            stock + :cantidad,
                            stock,
                            'Venta online'
                        FROM productos 
                        WHERE id = :producto_id";
        
        $stmtHistorial = $db->prepare($sqlHistorial);
        $stmtHistorial->execute([
            ':producto_id' => $productoId,
            ':cantidad' => $cantidad
        ]);
    }
    
    /**
     * Generar número de pedido único
     */
    private static function generarNumeroPedido() {
        return 'PED-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
    
    /**
     * Obtener pedidos por usuario
     */
    public static function obtenerPorUsuario($usuarioId, $limite = 10, $offset = 0) {
        $db = Database::getConnection();
        
        $sql = "SELECT p.*, 
                       ep.nombre as estado_nombre,
                       ep.color as estado_color,
                       mp.nombre as metodo_pago_nombre,
                       COUNT(dp.id) as total_items
                FROM pedidos p
                LEFT JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
                LEFT JOIN metodos_pago mp ON p.metodo_pago_id = mp.id
                LEFT JOIN detalle_pedidos dp ON p.id = dp.pedido_id
                WHERE p.usuario_id = :usuario_id
                GROUP BY p.id
                ORDER BY p.fecha_pedido DESC
                LIMIT :limite OFFSET :offset";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener detalle del pedido
     */
    public static function obtenerDetalle($pedidoId) {
        $db = Database::getConnection();
        
        $sql = "SELECT p.*,
                       u.nombre as usuario_nombre,
                       u.apellido as usuario_apellido,
                       u.email as usuario_email,
                       u.telefono as usuario_telefono,
                       ep.nombre as estado_nombre,
                       ep.color as estado_color,
                       mp.nombre as metodo_pago_nombre
                FROM pedidos p
                LEFT JOIN usuarios u ON p.usuario_id = u.id
                LEFT JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
                LEFT JOIN metodos_pago mp ON p.metodo_pago_id = mp.id
                WHERE p.id = :pedido_id";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener items del pedido
     */
    public static function obtenerItems($pedidoId) {
        $db = Database::getConnection();
        
        $sql = "SELECT dp.*,
                       prod.nombre as producto_nombre,
                       prod.imagen_principal as producto_imagen,
                       prod.codigo_sku as producto_sku
                FROM detalle_pedidos dp
                LEFT JOIN productos prod ON dp.producto_id = prod.id
                WHERE dp.pedido_id = :pedido_id";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Actualizar estado del pedido
     */
    public static function actualizarEstado($pedidoId, $estadoId) {
        $db = Database::getConnection();
        
        $sql = "UPDATE pedidos SET estado_pedido_id = :estado_id WHERE id = :pedido_id";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':estado_id' => $estadoId,
            ':pedido_id' => $pedidoId
        ]);
    }
   

    /**
     * Obtener pedidos recientes
     */
    public static function obtenerRecientes($limite = 10) {
        $db = Database::getConnection();
        
        $sql = "SELECT p.*, 
                       u.nombre as usuario_nombre,
                       u.apellido as usuario_apellido,
                       ep.nombre as estado_nombre,
                       ep.color as estado_color
                FROM pedidos p
                LEFT JOIN usuarios u ON p.usuario_id = u.id
                LEFT JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
                ORDER BY p.fecha_pedido DESC
                LIMIT :limite";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
