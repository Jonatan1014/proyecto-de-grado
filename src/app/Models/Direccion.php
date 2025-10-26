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
            // Primero verificar que la dirección existe y pertenece al usuario
            $sqlVerificar = "SELECT COUNT(*) FROM direcciones 
                            WHERE id = :direccion_id AND usuario_id = :usuario_id";
            $stmtVerificar = $db->prepare($sqlVerificar);
            $stmtVerificar->execute([
                ':direccion_id' => $direccionId,
                ':usuario_id' => $usuarioId
            ]);
            
            if ($stmtVerificar->fetchColumn() == 0) {
                return ['success' => false, 'message' => 'Dirección no encontrada'];
            }
            
            $db->beginTransaction();
            
            // Quitar principal a todas las direcciones del usuario
            self::quitarPrincipal($usuarioId);
            
            // Establecer como principal la dirección seleccionada
            $sql = "UPDATE direcciones SET es_principal = 1 
                    WHERE id = :direccion_id AND usuario_id = :usuario_id";
            
            $stmt = $db->prepare($sql);
            $resultado = $stmt->execute([
                ':direccion_id' => $direccionId,
                ':usuario_id' => $usuarioId
            ]);
            
            $db->commit();
            
            if ($resultado) {
                return ['success' => true, 'message' => 'Dirección principal actualizada'];
            } else {
                return ['success' => false, 'message' => 'No se pudo actualizar la dirección'];
            }
            
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Error al establecer dirección principal: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al establecer dirección principal: ' . $e->getMessage()];
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

    /**
     * Eliminar dirección
     */
    
    public static function eliminar($direccionId, $usuarioId) {
            $db = Database::getConnection();
            
            try {
                $sql = "DELETE FROM direcciones 
                        WHERE id = :direccion_id AND usuario_id = :usuario_id";
                
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':direccion_id' => $direccionId,
                    ':usuario_id' => $usuarioId
                ]);
                
                return ['success' => true, 'message' => 'Dirección eliminada'];
                
            } catch (Exception $e) {
                error_log("Error al eliminar dirección: " . $e->getMessage());
                return ['success' => false, 'message' => 'Error al eliminar la dirección'];
            }
        }
    
    /**
     * Actualizar dirección existente
     */
    public static function actualizar($direccionId, $usuarioId, $datos) {
        $db = Database::getConnection();
        
        try {
            // Verificar que la dirección pertenece al usuario
            $sqlVerificar = "SELECT COUNT(*) FROM direcciones 
                            WHERE id = :direccion_id AND usuario_id = :usuario_id";
            $stmtVerificar = $db->prepare($sqlVerificar);
            $stmtVerificar->execute([
                ':direccion_id' => $direccionId,
                ':usuario_id' => $usuarioId
            ]);
            
            if ($stmtVerificar->fetchColumn() == 0) {
                return ['success' => false, 'message' => 'Dirección no encontrada'];
            }
            
            $db->beginTransaction();
            
            // Si se marca como principal, quitar principal a las demás
            if ($datos['es_principal']) {
                self::quitarPrincipal($usuarioId);
            }
            
            // Actualizar la dirección
            $sql = "UPDATE direcciones 
                    SET direccion = :direccion,
                        ciudad = :ciudad,
                        departamento = :departamento,
                        codigo_postal = :codigo_postal,
                        es_principal = :es_principal
                    WHERE id = :direccion_id AND usuario_id = :usuario_id";
            
            $stmt = $db->prepare($sql);
            $resultado = $stmt->execute([
                ':direccion' => $datos['direccion'],
                ':ciudad' => $datos['ciudad'],
                ':departamento' => $datos['departamento'],
                ':codigo_postal' => $datos['codigo_postal'] ?? null,
                ':es_principal' => $datos['es_principal'] ?? 0,
                ':direccion_id' => $direccionId,
                ':usuario_id' => $usuarioId
            ]);
            
            $db->commit();
            
            if ($resultado) {
                return ['success' => true, 'message' => 'Dirección actualizada correctamente'];
            } else {
                return ['success' => false, 'message' => 'No se pudo actualizar la dirección'];
            }
            
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Error al actualizar dirección: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar la dirección: ' . $e->getMessage()];
        }
    }
}
        