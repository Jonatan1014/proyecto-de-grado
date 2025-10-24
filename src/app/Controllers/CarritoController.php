<?php
// src/app/Controllers/CarritoController.php

require_once __DIR__ . '/../Models/Carrito.php';
require_once __DIR__ . '/../Models/Producto.php';

class CarritoController {

    /**
     * Obtener datos de la petición (JSON o POST)
     */
    private function obtenerDatosRequest() {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        
        if (strpos($contentType, 'application/json') !== false) {
            $json = file_get_contents('php://input');
            return json_decode($json, true) ?? [];
        }
        
        return $_POST;
    }

    /**
     * Obtener o crear ID de carrito (usuario logueado o sesión temporal)
     */
    private function obtenerCarritoId() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si el usuario está logueado, usar su ID
        if (isset($_SESSION['usuario_id'])) {
            return $_SESSION['usuario_id'];
        }

        // Si no está logueado, usar/crear un ID de sesión temporal
        if (!isset($_SESSION['carrito_temp_id'])) {
            $_SESSION['carrito_temp_id'] = 'temp_' . uniqid() . '_' . time();
        }

        return $_SESSION['carrito_temp_id'];
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar() {
        header('Content-Type: application/json');
        
        try {
            session_start();
            
            $data = $this->obtenerDatosRequest();
            $carritoId = $this->obtenerCarritoId();
            $productoId = $data['producto_id'] ?? null;
            $cantidad = isset($data['cantidad']) ? (int)$data['cantidad'] : 1;

            if (!$productoId) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de producto requerido'
                ]);
                return;
            }

            // Verificar que el producto exista
            $producto = Producto::obtenerPorId($productoId);
            if (!$producto) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ]);
                return;
            }

            // Verificar stock disponible
            if ($producto['stock'] < $cantidad) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Stock insuficiente. Disponible: ' . $producto['stock']
                ]);
                return;
            }

            // Agregar al carrito
            $precio = $producto['precio_oferta'] ?? $producto['precio'];
            $resultado = Carrito::agregar($carritoId, $productoId, $cantidad, $precio);

            if ($resultado) {
                $totalItems = Carrito::contarItems($carritoId);
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto agregado al carrito',
                    'total_items' => $totalItems
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al agregar producto al carrito'
                ]);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Actualizar cantidad de un producto en el carrito
     */
    public function actualizar() {
        header('Content-Type: application/json');
        
        try {
            session_start();
            
            $data = $this->obtenerDatosRequest();
            $carritoId = $data['carrito_id'] ?? null;
            $cantidad = isset($data['cantidad']) ? (int)$data['cantidad'] : 1;

            if (!$carritoId || $cantidad < 1) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Datos inválidos'
                ]);
                return;
            }

            $resultado = Carrito::actualizarCantidad($carritoId, $cantidad);

            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Cantidad actualizada'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al actualizar cantidad'
                ]);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar() {
        header('Content-Type: application/json');
        
        try {
            session_start();
            
            $data = $this->obtenerDatosRequest();
            $carritoIdItem = $data['carrito_id'] ?? null;

            if (!$carritoIdItem) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de carrito requerido'
                ]);
                return;
            }

            $resultado = Carrito::eliminar($carritoIdItem);

            if ($resultado) {
                $carritoId = $this->obtenerCarritoId();
                $totalItems = Carrito::contarItems($carritoId);
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto eliminado del carrito',
                    'total_items' => $totalItems
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al eliminar producto'
                ]);
            }

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error del servidor',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Ver carrito
     */
    public function ver() {
        try {
            session_start();
            
            $carritoId = $this->obtenerCarritoId();
            $items = Carrito::obtenerPorUsuario($carritoId);
            $total = Carrito::calcularTotal($carritoId);

            $data = [
                'items' => $items,
                'total' => $total
            ];

            extract($data);

            include __DIR__ . '/../Views/cart.php';

        } catch (Exception $e) {
            error_log("Error en CarritoController::ver: " . $e->getMessage());
            header('Location: /404');
            exit();
        }
    }

    /**
     * Obtener número de items en el carrito (AJAX)
     */
    public function contarItems() {
        header('Content-Type: application/json');
        
        try {
            session_start();
            
            $carritoId = $this->obtenerCarritoId();
            $totalItems = Carrito::contarItems($carritoId);

            echo json_encode([
                'success' => true,
                'total_items' => $totalItems
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

    /**
     * Vaciar carrito
     */
    public function vaciar() {
        header('Content-Type: application/json');
        
        try {
            session_start();
            
            $carritoId = $this->obtenerCarritoId();
            $resultado = Carrito::vaciar($carritoId);

            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Carrito vaciado'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error al vaciar carrito'
                ]);
            }

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
