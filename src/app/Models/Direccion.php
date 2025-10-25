<?php
/**
 * =============================================================================
 * MODELO: Direccion.php
 * Ubicación: src/app/Models/Direccion.php
 * =============================================================================
 */

require_once __DIR__ . '/../../config/database.php';

class Direccion {
    
    /**
     * Obtener direcciones del usuario
     */
    public static function obtenerPorUsuario($usuarioId) {
        $db = Database::getConnection();
        
        $sql = "SELECT * FROM direcciones 
                WHERE usuario_id = :usuario_id 
                ORDER BY es_principal DESC, fecha_creacion DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener dirección principal
     */
    public static function obtenerPrincipal($usuarioId) {
        $db = Database::getConnection();
        
        $sql = "SELECT * FROM direcciones 
                WHERE usuario_id = :usuario_id AND es_principal = 1 
                LIMIT 1";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear nueva dirección
     */
    public static function crear($datos) {
        $db = Database::getConnection();
        
        try {
            $db->beginTransaction();
            
            // Si es principal, quitar principal a las demás
            if ($datos['es_principal']) {
                self::quitarPrincipal($datos['usuario_id']);
            }
            
            $sql = "INSERT INTO direcciones (
                        usuario_id, direccion, ciudad, departamento, 
                        codigo_postal, pais, es_principal
                    ) VALUES (
                        :usuario_id, :direccion, :ciudad, :departamento,
                        :codigo_postal, :pais, :es_principal
                    )";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':usuario_id' => $datos['usuario_id'],
                ':direccion' => $datos['direccion'],
                ':ciudad' => $datos['ciudad'],
                ':departamento' => $datos['departamento'],
                ':codigo_postal' => $datos['codigo_postal'] ?? null,
                ':pais' => $datos['pais'] ?? 'Colombia',
                ':es_principal' => $datos['es_principal'] ?? 0
            ]);
            
            $direccionId = $db->lastInsertId();
            
            $db->commit();
            
            return [
                'success' => true,
                'direccion_id' => $direccionId
            ];
            
        } catch (Exception $e) {
            $db->rollBack();
            error_log("Error al crear dirección: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al guardar la dirección'
            ];
        }
    }
    
    /**
     * Quitar principal a todas las direcciones del usuario
     */
    private static function quitarPrincipal($usuarioId) {
        $db = Database::getConnection();
        
        $sql = "UPDATE direcciones SET es_principal = 0 WHERE usuario_id = :usuario_id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);
    }
    
    /**
     * Establecer como dirección principal
     */
    public static function establecerPrincipal($direccionId, $usuarioId) {
        $db = Database::getConnection();
        
        try {
            $db->beginTransaction();
            
            // Quitar principal a todas
            self::quitarPrincipal($usuarioId);
            
            // Establecer como principal
            $sql = "UPDATE direcciones SET es_principal = 1 
                    WHERE id = :direccion_id AND usuario_id = :usuario_id";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':direccion_id' => $direccionId,
                ':usuario_id' => $usuarioId
            ]);
            
            $db->commit();
            return true;
            
        } catch (Exception $e) {
            $db->rollBack();
            error_log("Error al establecer dirección principal: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtener dirección por ID
     */
    public static function obtenerPorId($direccionId) {
        $db = Database::getConnection();
        
        $sql = "SELECT * FROM direcciones WHERE id = :direccion_id";
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':direccion_id', $direccionId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}