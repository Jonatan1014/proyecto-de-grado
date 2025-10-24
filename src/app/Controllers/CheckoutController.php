<?php
// src/app/Controllers/CheckoutController.php

require_once __DIR__ . '/../Models/Carrito.php';
require_once __DIR__ . '/../Models/Producto.php';

class CheckoutController {

    /**
     * Obtener o crear ID de carrito
     */
    private function obtenerCarritoId() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario_id'])) {
            return $_SESSION['usuario_id'];
        }

        if (!isset($_SESSION['carrito_temp_id'])) {
            $_SESSION['carrito_temp_id'] = 'temp_' . uniqid() . '_' . time();
        }

        return $_SESSION['carrito_temp_id'];
    }

    /**
     * Ver página de checkout (requiere login)
     */
    public function ver() {
        try {
            session_start();
            
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['usuario_id'])) {
                // Guardar la URL de destino para redirigir después del login
                $_SESSION['redirect_after_login'] = '/checkout';
                header('Location: /login?mensaje=Debes iniciar sesión para continuar con tu compra');
                exit();
            }

            $carritoId = $this->obtenerCarritoId();
            $items = Carrito::obtenerPorUsuario($carritoId);
            
            // Verificar que el carrito no esté vacío
            if (empty($items)) {
                header('Location: /cart?error=Carrito vacío');
                exit();
            }

            $total = Carrito::calcularTotal($carritoId);

            $data = [
                'items' => $items,
                'total' => $total
            ];

            extract($data);

            include __DIR__ . '/../Views/checkout.php';

        } catch (Exception $e) {
            error_log("Error en CheckoutController::ver: " . $e->getMessage());
            header('Location: /404');
            exit();
        }
    }

    /**
     * Procesar orden (requiere login)
     */
    public function procesar() {
        header('Content-Type: application/json');
        
        try {
            session_start();
            
            // Verificar que el usuario esté logueado
            if (!isset($_SESSION['usuario_id'])) {
                http_response_code(401);
                echo json_encode([
                    'success' => false,
                    'message' => 'Debes iniciar sesión para completar tu compra'
                ]);
                return;
            }

            $usuarioId = $_SESSION['usuario_id'];
            $items = Carrito::obtenerPorUsuario($usuarioId);
            
            if (empty($items)) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'El carrito está vacío'
                ]);
                return;
            }

            // Aquí iría la lógica de procesar el pedido
            // Por ahora solo retornamos éxito
            
            echo json_encode([
                'success' => true,
                'message' => 'Pedido procesado exitosamente'
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor',
                'error' => $e->getMessage()
            ]);
        }
    }
}
