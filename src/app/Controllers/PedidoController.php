<?php
/**
 * =============================================================================
 * CONTROLADOR: PedidoController.php
 * Ubicación: src/app/Controllers/PedidoController.php
 * =============================================================================
 */

require_once __DIR__ . '/../Models/Pedido.php';
require_once __DIR__ . '/../Models/User.php';

class PedidoController {
    
    /**
     * Mostrar detalle del pedido
     */
    public function detalle() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar autenticación
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login');
            exit;
        }
        
        // Verificar que se recibió el ID del pedido
        if (!isset($_GET['id'])) {
            header('Location: perfil');
            exit;
        }
        
        $pedidoId = intval($_GET['id']);
        $usuarioId = $_SESSION['usuario_id'];
        
        // Obtener detalle del pedido
        $pedido = Pedido::obtenerDetalle($pedidoId);
        
        // Verificar que el pedido existe y pertenece al usuario
        if (!$pedido || $pedido['usuario_id'] != $usuarioId) {
            header('Location: perfil');
            exit;
        }
        
        // Obtener items del pedido
        $items = Pedido::obtenerItems($pedidoId);
        
        // Cargar vista
        require_once __DIR__ . '/../Views/detalle-pedido.php';
    }
    
    /**
     * Cancelar pedido (solo si está en estado pendiente)
     */
    public function cancelar() {
        header('Content-Type: application/json');
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        if (!isset($_POST['pedido_id'])) {
            echo json_encode(['success' => false, 'message' => 'ID de pedido no proporcionado']);
            exit;
        }
        
        $pedidoId = intval($_POST['pedido_id']);
        $usuarioId = $_SESSION['usuario_id'];
        
        // Verificar que el pedido pertenece al usuario
        $pedido = Pedido::obtenerDetalle($pedidoId);
        
        if (!$pedido || $pedido['usuario_id'] != $usuarioId) {
            echo json_encode(['success' => false, 'message' => 'Pedido no encontrado']);
            exit;
        }
        
        // Solo se puede cancelar si está pendiente (estado_pedido_id = 1)
        if ($pedido['estado_pedido_id'] != 1) {
            echo json_encode(['success' => false, 'message' => 'El pedido no puede ser cancelado']);
            exit;
        }
        
        // Actualizar a estado cancelado (asumiendo que el estado 5 es cancelado)
        $resultado = Pedido::actualizarEstado($pedidoId, 5);
        
        if ($resultado) {
            echo json_encode(['success' => true, 'message' => 'Pedido cancelado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al cancelar el pedido']);
        }
    }
}
