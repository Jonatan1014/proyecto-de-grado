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
                        numero_pedido, usuario_id, direccion_id, empleado_id, total, subtotal, 
                        descuento, impuestos, costo_envio, metodo_pago_id, estado_pedido_id, 
                        tipo_pedido, observaciones
                    ) VALUES (
                        :numero_pedido, :usuario_id, :direccion_id, :empleado_id, :total, :subtotal,
                        :descuento, :impuestos, :costo_envio, :metodo_pago_id, :estado_pedido_id,
                        :tipo_pedido, :observaciones
                    )";

            // --- CÓDIGO DE DEPURACIÓN ---
            error_log("=== Depuración Pedido::crear ===");
            error_log("  - Datos recibidos: " . print_r($datos, true));

            $executeArray = [
                ':numero_pedido' => $numeroPedido,
                ':usuario_id' => $datos['usuario_id'],
                ':direccion_id' => $datos['direccion_id'] ?? null,
                ':empleado_id' => $datos['empleado_id'] ?? null,
                ':total' => $datos['total'],
                ':subtotal' => $datos['subtotal'],
                ':descuento' => $datos['descuento'] ?? 0,
                ':impuestos' => $datos['impuestos'] ?? 0,
                ':costo_envio' => $datos['envio'] ?? 0, // Asegúrate que sea 'envio'
                ':metodo_pago_id' => $datos['metodo_pago_id'],
                ':estado_pedido_id' => 1, // Pendiente por defecto
                ':tipo_pedido' => $datos['tipo_pedido'] ?? 'online',
                ':observaciones' => $datos['observaciones'] ?? null
            ];

            error_log("  - Array para execute: " . print_r($executeArray, true));
            error_log("  - Número de marcadores en SQL: " . substr_count($sql, ':'));
            error_log("  - Número de parámetros en array: " . count($executeArray));
            // --- FIN CÓDIGO DE DEPURACIÓN ---

            $stmt = $db->prepare($sql);
            
            // --- CÓDIGO DE DEPURACIÓN (ejecución) ---
            try {
                $stmt->execute($executeArray);
                error_log("  - Ejecución de INSERT en 'pedidos' exitosa.");
            } catch (PDOException $e) {
                error_log("  - ERROR PDO en INSERT pedidos: " . $e->getMessage());
                error_log("  - Código SQL: " . $sql);
                error_log("  - Parámetros: " . print_r($executeArray, true));
                throw $e; // Relanzar para que lo maneje el catch externo
            }
            // --- FIN CÓDIGO DE DEPURACIÓN (ejecución) ---
            
            $pedidoId = $db->lastInsertId();
            
            // Insertar detalles del pedido
            foreach ($datos['items'] as $item) {
                self::agregarDetalle($pedidoId, $item); // Llamada a la función que también puede tener depuración
                
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
                'message' => 'Error al procesar el pedido: ' . $e->getMessage() // Incluir el mensaje de error real para diagnóstico
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

        // --- CÓDIGO DE DEPURACIÓN para agregarDetalle ---
        error_log("=== Depuración Pedido::agregarDetalle ===");
        error_log("  - Item recibido: " . print_r($item, true));

        $executeArray = [
            ':pedido_id' => $pedidoId,
            ':producto_id' => $item['producto_id'],
            ':cantidad' => $item['cantidad'],
            ':precio_unitario' => $item['precio'], // Asegúrate que sea 'precio'
            ':subtotal' => $item['precio'] * $item['cantidad']
        ];

        error_log("  - Array para execute en detalle: " . print_r($executeArray, true));
        error_log("  - Número de marcadores en SQL detalle: " . substr_count($sql, ':'));
        error_log("  - Número de parámetros en array detalle: " . count($executeArray));
        // --- FIN CÓDIGO DE DEPURACIÓN para agregarDetalle ---

        $stmt = $db->prepare($sql);

        // --- CÓDIGO DE DEPURACIÓN (ejecución detalle) ---
        try {
            $stmt->execute($executeArray);
            error_log("  - Ejecución de INSERT en 'detalle_pedidos' exitosa para producto ID: {$item['producto_id']}");
        } catch (PDOException $e) {
            error_log("  - ERROR PDO en INSERT detalle_pedidos: " . $e->getMessage());
            error_log("  - Código SQL: " . $sql);
            error_log("  - Parámetros: " . print_r($executeArray, true));
            // Cerrar el cursor antes de relanzar
            if ($stmt) $stmt->closeCursor();
            throw $e; // Relanzar para que lo maneje el catch externo
        }
        // Cerrar el cursor después de la ejecución exitosa
        $stmt->closeCursor();
        // --- FIN CÓDIGO DE DEPURACIÓN (ejecución detalle) ---
    }


/**
 * Reducir stock del producto
 */
private static function reducirStock($productoId, $cantidad) {
    $db = Database::getConnection();

    // Actualizar stock: restar la cantidad pedida y verificar que haya suficiente
    // Usamos :cantidad_restar para la resta y :cantidad_minima para la condición
    $sql = "UPDATE productos
            SET stock = stock - :cantidad_restar
            WHERE id = :producto_id AND stock >= :cantidad_minima";

    $stmt = $db->prepare($sql);
    $executeArrayStock = [
        ':cantidad_restar' => $cantidad, // <-- Renombrado
        ':cantidad_minima' => $cantidad, // <-- Renombrado
        ':producto_id' => $productoId
    ];

    try {
        $result = $stmt->execute($executeArrayStock);
        if (!$result || $stmt->rowCount() === 0) {
            // Cerrar cursor antes de lanzar la excepción
            $stmt->closeCursor();
            throw new Exception("Stock insuficiente para el producto ID: $productoId");
        }
    } catch (PDOException $e) {
        // Cerrar cursor antes de relanzar
        $stmt->closeCursor();
        throw $e;
    }
    // Cerrar cursor después de la actualización exitosa
    $stmt->closeCursor();

    // Registrar en historial
    // CORREGIDO: Renombrar el segundo :producto_id en la cláusula WHERE Y el segundo :cantidad
    $sqlHistorial = "INSERT INTO historial_stock (
                        producto_id, usuario_id, tipo, cantidad,
                        stock_anterior, stock_nuevo, motivo
                    ) SELECT
                        :producto_id_insert, -- <-- Renombrado
                        NULL, 
                        'salida',
                        :cantidad_insert, -- <-- Renombrado (era :cantidad)
                        stock + :cantidad_anterior, -- stock_anterior (antes del update) - <-- Renombrado (era :cantidad)
                        stock,             -- stock_nuevo (después del update)
                        'Venta online'
                    FROM productos
                    WHERE id = :producto_id_where"; 

    $stmtHistorial = $db->prepare($sqlHistorial);
    $executeArrayHistorial = [
        ':producto_id_insert' => $productoId, // <-- Renombrado
        ':producto_id_where' => $productoId,  // <-- Renombrado
        ':cantidad_insert' => $cantidad,      // <-- Renombrado
        ':cantidad_anterior' => $cantidad    // <-- Renombrado
    ];

    try {
        $stmtHistorial->execute($executeArrayHistorial);
    } catch (PDOException $e) {
        // Cerrar cursor antes de relanzar
        $stmtHistorial->closeCursor();
        throw $e;
    }
    // Cerrar cursor después de la inserción exitosa
    $stmtHistorial->closeCursor();
}
    
    /**
     * Generar número de pedido único
     */
    private static function generarNumeroPedido() {
        return 'PED-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
    
    /**
     * Obtener pedido por número de pedido
     */
    public static function obtenerPorNumero($numeroPedido) {
        $db = Database::getConnection();
        
        $sql = "SELECT p.*, 
                       ep.nombre as estado_nombre,
                       ep.color as estado_color,
                       mp.nombre as metodo_pago_nombre,
                       u.nombre as usuario_nombre,
                       u.email as usuario_email,
                       u.telefono as usuario_telefono
                FROM pedidos p
                LEFT JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
                LEFT JOIN metodos_pago mp ON p.metodo_pago_id = mp.id
                LEFT JOIN usuarios u ON p.usuario_id = u.id
                WHERE p.numero_pedido = :numero_pedido
                LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':numero_pedido', $numeroPedido, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
    public static function actualizarEstado($pedidoId, $estadoId, $observaciones = null) {
        $db = Database::getConnection();
        
        // Si se proporcionan observaciones, actualizar también ese campo
        if ($observaciones !== null) {
            $sql = "UPDATE pedidos 
                    SET estado_pedido_id = :estado_id, 
                        observaciones = :observaciones 
                    WHERE id = :pedido_id";
            
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':estado_id' => $estadoId,
                ':observaciones' => $observaciones,
                ':pedido_id' => $pedidoId
            ]);
        } else {
            $sql = "UPDATE pedidos SET estado_pedido_id = :estado_id WHERE id = :pedido_id";
            
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':estado_id' => $estadoId,
                ':pedido_id' => $pedidoId
            ]);
        }
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