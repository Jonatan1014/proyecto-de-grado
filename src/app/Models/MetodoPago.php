<?php
/**
 * =============================================================================
 * MODELO: MetodoPago.php
 * Ubicación: src/app/Models/MetodoPago.php
 * =============================================================================
 */

require_once __DIR__ . '/../../config/database.php';

class MetodoPago {
    
    /**
     * Obtener todos los métodos de pago activos
     */
    public static function obtenerActivos() {
        $db = Database::getConnection();
        
        $sql = "SELECT * FROM metodos_pago WHERE estado = 'activo' ORDER BY nombre";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener método de pago por ID
     */
    public static function obtenerPorId($id) {
        $db = Database::getConnection();
        
        $sql = "SELECT * FROM metodos_pago WHERE id = :id AND estado = 'activo'";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}