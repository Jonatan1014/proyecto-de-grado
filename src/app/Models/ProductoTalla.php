<?php
// src/app/Models/ProductoTalla.php


class ProductoTalla {
    
    /**
     * Obtener tallas disponibles de un producto
     */
    public static function obtenerPorProducto($productoId) {
        $conn = Database::getConnection();
        
        $sql = "SELECT 
                    t.id,
                    t.nombre,
                    t.descripcion,
                    pt.stock,
                    pt.stock_minimo,
                    pt.estado
                FROM tallas t
                INNER JOIN producto_tallas pt ON t.id = pt.talla_id
                WHERE pt.producto_id = :producto_id
                  AND pt.estado = 'activo'
                  AND t.estado = 'activo'
                ORDER BY 
                    CASE 
                        WHEN t.nombre REGEXP '^[0-9]+$' THEN CAST(t.nombre AS UNSIGNED)
                        ELSE 999
                    END,
                    t.nombre";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener información de una talla específica de un producto
     */
    public static function obtenerPorProductoYTalla($productoId, $tallaId) {
        $conn = Database::getConnection();
        
        $sql = "SELECT 
                    pt.*,
                    t.nombre as talla_nombre,
                    t.descripcion as talla_descripcion
                FROM producto_tallas pt
                INNER JOIN tallas t ON pt.talla_id = t.id
                WHERE pt.producto_id = :producto_id
                  AND pt.talla_id = :talla_id
                  AND pt.estado = 'activo'
                  AND t.estado = 'activo'";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->bindParam(':talla_id', $tallaId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Verificar stock disponible de una talla
     */
    public static function verificarStock($productoId, $tallaId, $cantidad = 1) {
        $info = self::obtenerPorProductoYTalla($productoId, $tallaId);
        
        if (!$info) {
            return [
                'disponible' => false,
                'mensaje' => 'Talla no disponible',
                'stock' => 0
            ];
        }
        
        if ($info['stock'] < $cantidad) {
            return [
                'disponible' => false,
                'mensaje' => 'Stock insuficiente. Solo quedan ' . $info['stock'] . ' unidades',
                'stock' => $info['stock']
            ];
        }
        
        return [
            'disponible' => true,
            'mensaje' => 'Stock disponible',
            'stock' => $info['stock']
        ];
    }
    
    /**
     * Agregar talla a un producto
     */
    public static function agregar($productoId, $tallaId, $stock = 0, $stockMinimo = 5) {
        $conn = Database::getConnection();
        
        try {
            $sql = "INSERT INTO producto_tallas 
                    (producto_id, talla_id, stock, stock_minimo, estado) 
                    VALUES (:producto_id, :talla_id, :stock, :stock_minimo, 'activo')
                    ON DUPLICATE KEY UPDATE 
                    stock = :stock,
                    stock_minimo = :stock_minimo,
                    estado = 'activo'";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->bindParam(':talla_id', $tallaId, PDO::PARAM_INT);
            $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
            $stmt->bindParam(':stock_minimo', $stockMinimo, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar talla: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar stock de una talla
     */
    public static function actualizarStock($productoId, $tallaId, $nuevoStock) {
        $conn = Database::getConnection();
        
        try {
            $sql = "UPDATE producto_tallas 
                    SET stock = :stock 
                    WHERE producto_id = :producto_id 
                      AND talla_id = :talla_id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':stock', $nuevoStock, PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->bindParam(':talla_id', $tallaId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al actualizar stock: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Reducir stock al realizar venta
     */
    public static function reducirStock($productoId, $tallaId, $cantidad) {
        $conn = Database::getConnection();
        
        try {
            $sql = "UPDATE producto_tallas 
                    SET stock = stock - :cantidad 
                    WHERE producto_id = :producto_id 
                      AND talla_id = :talla_id
                      AND stock >= :cantidad";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->bindParam(':talla_id', $tallaId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            // Verificar si se actualizó alguna fila
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error al reducir stock: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Eliminar talla de un producto
     */
    public static function eliminar($productoId, $tallaId) {
        $conn = Database::getConnection();
        
        try {
            $sql = "DELETE FROM producto_tallas 
                    WHERE producto_id = :producto_id 
                      AND talla_id = :talla_id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
            $stmt->bindParam(':talla_id', $tallaId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al eliminar talla: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener todas las tallas del sistema
     */
    public static function obtenerTodasLasTallas() {
        $conn = Database::getConnection();
        
        $sql = "SELECT * FROM tallas 
                WHERE estado = 'activo' 
                ORDER BY 
                    CASE 
                        WHEN nombre REGEXP '^[0-9]+$' THEN CAST(nombre AS UNSIGNED)
                        ELSE 999
                    END,
                    nombre";
        
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener stock total de un producto (suma de todas las tallas)
     */
    public static function obtenerStockTotal($productoId) {
        $conn = Database::getConnection();
        
        $sql = "SELECT COALESCE(SUM(stock), 0) as stock_total
                FROM producto_tallas 
                WHERE producto_id = :producto_id 
                  AND estado = 'activo'";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? intval($result['stock_total']) : 0;
    }
    
    /**
     * Verificar si un producto requiere selección de talla
     */
    public static function productoRequiereTalla($productoId) {
        $conn = Database::getConnection();
        
        $sql = "SELECT requiere_talla FROM productos WHERE id = :producto_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result && $result['requiere_talla'] == 1;
    }
}
