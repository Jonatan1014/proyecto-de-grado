<?php
/**
 * =============================================================================
 * CONTROLADOR: CheckoutController.php
 * Ubicación: src/app/Controllers/CheckoutController.php
 * =============================================================================
 */

require_once __DIR__ . '/../Models/Carrito.php';
require_once __DIR__ . '/../Models/Pedido.php';
require_once __DIR__ . '/../Models/Direccion.php';
require_once __DIR__ . '/../Models/MetodoPago.php';
require_once __DIR__ . '/../Utils/Helpers.php';
require_once __DIR__ . '/../../config/whatsapp.php';

class CheckoutController {
    
    /**
     * Mostrar página de checkout
     */
    public function index() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Debug: Verificar contenido de la sesión
        error_log("CheckoutController - Session ID: " . session_id());
        error_log("CheckoutController - usuario_id isset: " . (isset($_SESSION['usuario_id']) ? 'SI' : 'NO'));
        error_log("CheckoutController - usuario_id value: " . ($_SESSION['usuario_id'] ?? 'NULL'));
        error_log("CheckoutController - user isset: " . (isset($_SESSION['user']) ? 'SI' : 'NO'));
        
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['usuario_id'])) {
            $_SESSION['redirect_after_login'] = 'checkout';
            header('Location: login');
            exit();
        }
        
        $usuarioId = $_SESSION['usuario_id'];
        
        // Obtener carrito
        $itemsCarrito = Carrito::obtenerItems($usuarioId);
        
        if (empty($itemsCarrito)) {
            header('Location: cart');
            exit();
        }
        
        // Calcular totales
        $subtotal = 0;
        foreach ($itemsCarrito as $item) {
            $precio = $item['precio_oferta'] ?? $item['precio'];
            $subtotal += $precio * $item['cantidad'];
        }
        
        $impuestos = $subtotal * 0.19; // IVA 19%
        $envio = $subtotal >= 150000 ? 0 : 15000; // Envío gratis por compras mayores a $150.000
        $total = $subtotal + $impuestos + $envio;
        
        // Obtener direcciones del usuario
        $direcciones = Direccion::obtenerPorUsuario($usuarioId);
        $direccionPrincipal = Direccion::obtenerPrincipal($usuarioId);
        
        // Obtener métodos de pago
        $metodosPago = MetodoPago::obtenerActivos();
        
        $data = [
            'itemsCarrito' => $itemsCarrito,
            'subtotal' => $subtotal,
            'impuestos' => $impuestos,
            'envio' => $envio,
            'total' => $total,
            'direcciones' => $direcciones,
            'direccionPrincipal' => $direccionPrincipal,
            'metodosPago' => $metodosPago,
            'usuario' => $_SESSION['user']
        ];
        
        extract($data);
        
        include __DIR__ . '/../Views/checkout.php';
    }
    
    /**
     * Procesar el pedido
     */
    public function procesarPedido() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        // Verificar que sea POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debe iniciar sesión']);
            return;
        }
        
        try {
            $usuarioId = $_SESSION['usuario_id'];
            
            // Validar datos
            $direccionId = $_POST['direccion_id'] ?? null;
            $metodoPagoId = $_POST['metodo_pago_id'] ?? null;
            $observaciones = $_POST['observaciones'] ?? null;
            
            if (!$direccionId || !$metodoPagoId) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Datos incompletos'
                ]);
                return;
            }
            
            // Verificar dirección
            $direccion = Direccion::obtenerPorId($direccionId);
            if (!$direccion || $direccion['usuario_id'] != $usuarioId) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Dirección inválida'
                ]);
                return;
            }
            
            // Verificar método de pago
            $metodoPago = MetodoPago::obtenerPorId($metodoPagoId);
            if (!$metodoPago) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Método de pago inválido'
                ]);
                return;
            }
            
            // Obtener items del carrito
            $itemsCarrito = Carrito::obtenerItems($usuarioId);
            
            if (empty($itemsCarrito)) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'El carrito está vacío'
                ]);
                return;
            }
            
            // Obtener datos del usuario
            require_once __DIR__ . '/../Models/User.php';
            $usuario = User::obtenerPorId($usuarioId);
            
            // Calcular totales
            $subtotal = 0;
            $items = [];
            $productosDetalle = [];
            
            foreach ($itemsCarrito as $item) {
                $precio = $item['precio_oferta'] ?? $item['precio'];
                $subtotal += $precio * $item['cantidad'];
                
                $items[] = [
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $precio
                ];
                
                // Guardar detalle para WhatsApp
                $productosDetalle[] = [
                    'nombre' => $item['producto_nombre'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $precio,
                    'subtotal' => $precio * $item['cantidad']
                ];
            }
            
            $impuestos = $subtotal * 0.19;
            $envio = $subtotal >= 150000 ? 0 : 15000;
            $total = $subtotal + $impuestos + $envio;
            
            // Crear pedido con estado PENDIENTE
            $datosPedido = [
                'usuario_id' => $usuarioId,
                'total' => $total,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'envio' => $envio,
                'metodo_pago_id' => $metodoPagoId,
                'tipo_pedido' => 'online',
                'observaciones' => $observaciones,
                'items' => $items
            ];
            
            $resultado = Pedido::crear($datosPedido);
            
            if ($resultado['success']) {
                // Generar mensaje para WhatsApp con datos encriptados
                $mensajeWhatsApp = $this->generarMensajeWhatsApp(
                    $resultado['numero_pedido'],
                    $usuario,
                    $productosDetalle,
                    $direccion,
                    $metodoPago,
                    $subtotal,
                    $impuestos,
                    $envio,
                    $total
                );
                
                // Vaciar carrito
                Carrito::vaciarCarrito($usuarioId);
                
                echo json_encode([
                    'success' => true,
                    'message' => 'Pedido creado exitosamente',
                    'pedido_id' => $resultado['pedido_id'],
                    'numero_pedido' => $resultado['numero_pedido'],
                    'whatsapp_url' => $mensajeWhatsApp
                ]);
            } else {
                echo json_encode($resultado);
            }
            
        } catch (Exception $e) {
            error_log("Error al procesar pedido: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error al procesar el pedido'
            ]);
        }
    }
    
    /**
     * Generar mensaje de WhatsApp con datos encriptados
     */
    private function generarMensajeWhatsApp($numeroPedido, $usuario, $productos, $direccion, $metodoPago, $subtotal, $impuestos, $envio, $total) {
        // Obtener número de WhatsApp desde configuración
        $numeroWhatsApp = WHATSAPP_NUMERO;
        
        // Construir mensaje
        $mensaje = "🛍️ *" . WHATSAPP_NOMBRE_NEGOCIO . "*\n";
        $mensaje .= WHATSAPP_MENSAJE_BIENVENIDA . "\n\n";
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "📋 *PEDIDO: {$numeroPedido}*\n";
        $mensaje .= "━━━━━━━━━━━━━━━━\n\n";
        
        // Datos del cliente (encriptados con AES-256)
        $datosCliente = 
            "Nombre: " . $usuario['nombre'] . ' ' . $usuario['apellido'] . "\n" .
            "Email: " . $usuario['email'] . "\n" .
            "Teléfono: " . ($usuario['telefono'] ?? 'No especificado');
        
        $clienteEncriptado = encriptarDatos($datosCliente);
        
        $mensaje .= "👤 *DATOS DEL CLIENTE*\n";
        $mensaje .= "_(Datos encriptados por seguridad)_\n";
        $mensaje .= "```{$clienteEncriptado}```\n\n";
        
        // Productos
        $mensaje .= "📦 *PRODUCTOS SOLICITADOS*\n";
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        
        foreach ($productos as $i => $producto) {
            $num = $i + 1;
            $mensaje .= "*{$num}.* {$producto['nombre']}\n";
            $mensaje .= "   • Cantidad: *{$producto['cantidad']} unidad(es)*\n";
            $mensaje .= "   • Precio unitario: " . formatearPrecioWhatsApp($producto['precio_unitario']) . "\n";
            $mensaje .= "   • Subtotal: *" . formatearPrecioWhatsApp($producto['subtotal']) . "*\n\n";
        }
        
        // Dirección de envío (encriptada)
        $datosDir = 
            $direccion['direccion'] . "\n" .
            $direccion['ciudad'] . ", " . $direccion['departamento'];
        
        if (!empty($direccion['codigo_postal'])) {
            $datosDir .= "\nCP: " . $direccion['codigo_postal'];
        }
        
        $direccionEncriptada = encriptarDatos($datosDir);
        
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "📍 *DIRECCIÓN DE ENVÍO*\n";
        $mensaje .= "_(Datos encriptados por seguridad)_\n";
        $mensaje .= "```{$direccionEncriptada}```\n\n";
        
        // Método de pago
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "💳 *MÉTODO DE PAGO*\n";
        $mensaje .= "{$metodoPago['nombre']}\n\n";
        
        // Totales
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "💰 *RESUMEN DE PAGO*\n";
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "Subtotal: " . formatearPrecioWhatsApp($subtotal) . "\n";
        $mensaje .= "IVA (19%): " . formatearPrecioWhatsApp($impuestos) . "\n";
        $mensaje .= "Envío: " . ($envio == 0 ? '*GRATIS* ✅' : formatearPrecioWhatsApp($envio)) . "\n";
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "🏷️ *TOTAL A PAGAR*\n";
        $mensaje .= "*" . formatearPrecioWhatsApp($total) . "*\n\n";
        
        $mensaje .= "━━━━━━━━━━━━━━━━\n";
        $mensaje .= "⏳ *Estado:* PENDIENTE\n";
        $mensaje .= "━━━━━━━━━━━━━━━━\n\n";
        
        $mensaje .= "📝 *INSTRUCCIONES:*\n";
        $mensaje .= "1️⃣ Realiza el pago según el método seleccionado\n";
        $mensaje .= "2️⃣ Envía el comprobante de pago\n";
        $mensaje .= "3️⃣ Confirmaremos tu pedido en breve\n\n";
        
        $mensaje .= "🕐 *Horario de atención:*\n";
        $mensaje .= "Lunes a Viernes: 8:00 AM - 6:00 PM\n";
        $mensaje .= "Sábados: 9:00 AM - 1:00 PM\n\n";
        
        $mensaje .= "¡Gracias por tu preferencia! 🙏✨";
        
        // Codificar mensaje para URL
        $mensajeCodificado = urlencode($mensaje);
        
        // Generar URL de WhatsApp
        return "https://wa.me/{$numeroWhatsApp}?text={$mensajeCodificado}";
    }
    
    /**
     * Guardar nueva dirección
     */
    public function guardarDireccion() {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debe iniciar sesión']);
            return;
        }
        
        try {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'direccion' => $_POST['direccion'] ?? '',
                'ciudad' => $_POST['ciudad'] ?? '',
                'departamento' => $_POST['departamento'] ?? '',
                'codigo_postal' => $_POST['codigo_postal'] ?? null,
                'pais' => $_POST['pais'] ?? 'Colombia',
                'es_principal' => isset($_POST['es_principal']) ? 1 : 0
            ];
            
            // Validar campos requeridos
            if (empty($datos['direccion']) || empty($datos['ciudad']) || empty($datos['departamento'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Todos los campos son requeridos'
                ]);
                return;
            }
            
            $resultado = Direccion::crear($datos);
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Error al guardar dirección: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Error al guardar la dirección'
            ]);
        }
    }
    
   /**
 * Actualizar cantidad de un item del carrito (AJAX)
 * AGREGAR AL CheckoutController.php
 */
public function actualizarCantidad() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    header('Content-Type: application/json');

    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'message' => 'No autenticado']);
        exit;
    }

    $carritoId = $_POST['carrito_id'] ?? null;
    $cantidad = intval($_POST['cantidad'] ?? 0);

    if (!$carritoId || $cantidad < 1) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    try {
        // Actualizar cantidad en el carrito
        $resultado = Carrito::actualizarCantidad($carritoId, $cantidad);

        if ($resultado) {
            // Recalcular totales
            $usuarioId = $_SESSION['usuario_id'];
            $itemsCarrito = Carrito::obtenerItems($usuarioId);
            
            $subtotal = 0;
            $precioItem = 0;
            
            foreach ($itemsCarrito as $item) {
                $precio = $item['precio_oferta'] ?? $item['precio'];
                $subtotal += $precio * $item['cantidad'];
                
                // Obtener precio del item actualizado
                if ($item['id'] == $carritoId) {
                    $precioItem = $precio * $item['cantidad'];
                }
            }
            
            $iva = $subtotal * 0.19;
            $costoEnvio = $subtotal >= 150000 ? 0 : 15000;
            $total = $subtotal + $iva + $costoEnvio;
            
            // Contar total de items
            $totalItems = Carrito::contarItems($usuarioId);

            echo json_encode([
                'success' => true,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'envio' => $costoEnvio,
                'total' => $total,
                'precio_item' => $precioItem,
                'total_items' => $totalItems,
                'message' => 'Cantidad actualizada correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Error al actualizar la cantidad'
            ]);
        }
    } catch (Exception $e) {
        error_log("Error en actualizarCantidad: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error del servidor: ' . $e->getMessage()
        ]);
    }
    exit;
}

/**
 * Eliminar item del carrito (AJAX)
 * AGREGAR AL CheckoutController.php
 */
public function eliminarItem() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    header('Content-Type: application/json');

    if (!isset($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'message' => 'No autenticado']);
        exit;
    }

    $carritoId = $_POST['carrito_id'] ?? null;

    if (!$carritoId) {
        echo json_encode(['success' => false, 'message' => 'ID inválido']);
        exit;
    }

    try {
        $resultado = Carrito::eliminar($carritoId);

        if ($resultado) {
            // Recalcular totales
            $usuarioId = $_SESSION['usuario_id'];
            $itemsCarrito = Carrito::obtenerItems($usuarioId);
            
            $subtotal = 0;
            foreach ($itemsCarrito as $item) {
                $precio = $item['precio_oferta'] ?? $item['precio'];
                $subtotal += $precio * $item['cantidad'];
            }
            
            $iva = $subtotal * 0.19;
            $costoEnvio = $subtotal >= 150000 ? 0 : 15000;
            $total = $subtotal + $iva + $costoEnvio;
            
            // Contar items
            $itemsCount = count($itemsCarrito);
            $totalItems = Carrito::contarItems($usuarioId);

            echo json_encode([
                'success' => true,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'envio' => $costoEnvio,
                'total' => $total,
                'itemsCount' => $itemsCount,
                'total_items' => $totalItems,
                'message' => 'Producto eliminado correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Error al eliminar el producto'
            ]);
        }
    } catch (Exception $e) {
        error_log("Error en eliminarItem: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error del servidor: ' . $e->getMessage()
        ]);
    }
    exit;
}
}