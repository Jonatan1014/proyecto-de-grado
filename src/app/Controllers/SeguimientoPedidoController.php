<?php
/**
 * =============================================================================
 * CONTROLADOR: SeguimientoPedidoController.php
 * Ubicación: src/app/Controllers/SeguimientoPedidoController.php
 * Descripción: Gestión del seguimiento de pedidos para clientes
 * =============================================================================
 */

require_once __DIR__ . '/../Models/Pedido.php';

class SeguimientoPedidoController {
    
    /**
     * Mostrar seguimiento de un pedido específico
     */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login');
            exit;
        }
        
        $pedidoId = $_GET['id'] ?? null;
        
        if (!$pedidoId) {
            header('Location: perfil');
            exit;
        }
        
        // Obtener información del pedido
        $pedido = Pedido::obtenerDetalle($pedidoId);
        
        // Verificar que el pedido pertenece al usuario actual
        if (!$pedido || $pedido['usuario_id'] != $_SESSION['usuario_id']) {
            $pedido = null;
        }
        
        // Obtener items del pedido si existe
        $items = [];
        if ($pedido) {
            $items = Pedido::obtenerItems($pedidoId);
        }
        
        // Cargar vista
        require_once __DIR__ . '/../Views/seguimiento-pedido.php';
    }
    
    /**
     * API para obtener el estado actual del pedido (para actualizaciones en tiempo real)
     */
    public function obtenerEstado() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        $pedidoId = $_GET['id'] ?? null;
        
        if (!$pedidoId) {
            echo json_encode(['success' => false, 'message' => 'ID de pedido no proporcionado']);
            exit;
        }
        
        try {
            $pedido = Pedido::obtenerDetalle($pedidoId);
            
            // Verificar que el pedido pertenece al usuario
            if (!$pedido || $pedido['usuario_id'] != $_SESSION['usuario_id']) {
                echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
                exit;
            }
            
            echo json_encode([
                'success' => true,
                'estado_id' => $pedido['estado_pedido_id'],
                'estado_nombre' => $pedido['estado_nombre'],
                'estado_color' => $pedido['estado_color'],
                'observaciones' => $pedido['observaciones']
            ]);
            
        } catch (Exception $e) {
            error_log("Error al obtener estado del pedido: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al obtener el estado']);
        }
    }
}
