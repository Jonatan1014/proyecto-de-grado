<?php
/**
 * =============================================================================
 * CONTROLADOR: PerfilController.php
 * Ubicación: src/app/Controllers/PerfilController.php
 * Descripción: Gestión del perfil del usuario
 * =============================================================================
 */

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Direccion.php';
require_once __DIR__ . '/../Models/Pedido.php';

class PerfilController {
    
    /**
     * Mostrar página de perfil
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
        
        $usuarioId = $_SESSION['usuario_id'];
        
        // Obtener datos del usuario
        $usuario = User::obtenerPorId($usuarioId);
        
        // Obtener direcciones del usuario
        $direcciones = Direccion::obtenerPorUsuario($usuarioId);
        
        // Obtener pedidos recientes
        $pedidos = Pedido::obtenerPorUsuario($usuarioId, 5);
        
        // Cargar vista
        require_once __DIR__ . '/../Views/perfil.php';
    }
    
    /**
     * Actualizar información personal
     */
    public function actualizarInformacion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        try {
            $usuarioId = $_SESSION['usuario_id'];
            
            $datos = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'email' => trim($_POST['email'] ?? '')
            ];
            
            // Validar campos
            if (empty($datos['nombre']) || empty($datos['apellido']) || empty($datos['email'])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            // Validar email
            if (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Email inválido']);
                exit;
            }
            
            // Verificar si el email ya está en uso por otro usuario
            if (User::emailEnUso($datos['email'], $usuarioId)) {
                echo json_encode(['success' => false, 'message' => 'El email ya está en uso']);
                exit;
            }
            
            // Actualizar usuario
            $resultado = User::actualizar($usuarioId, $datos);
            
            if ($resultado) {
                // Actualizar datos en sesión
                $_SESSION['user']['nombre'] = $datos['nombre'];
                $_SESSION['user']['apellido'] = $datos['apellido'];
                $_SESSION['user']['email'] = $datos['email'];
                
                echo json_encode(['success' => true, 'message' => 'Información actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la información']);
            }
            
        } catch (Exception $e) {
            error_log("Error al actualizar información: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la información']);
        }
    }
    
    /**
     * Cambiar contraseña
     */
    public function cambiarPassword() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        try {
            $usuarioId = $_SESSION['usuario_id'];
            $passwordActual = $_POST['password_actual'] ?? '';
            $passwordNuevo = $_POST['password_nuevo'] ?? '';
            $passwordConfirmar = $_POST['password_confirmar'] ?? '';
            
            // Validar campos
            if (empty($passwordActual) || empty($passwordNuevo) || empty($passwordConfirmar)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            // Validar que las contraseñas nuevas coincidan
            if ($passwordNuevo !== $passwordConfirmar) {
                echo json_encode(['success' => false, 'message' => 'Las contraseñas nuevas no coinciden']);
                exit;
            }
            
            // Validar longitud mínima
            if (strlen($passwordNuevo) < 6) {
                echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
                exit;
            }
            
            // Verificar contraseña actual
            if (!User::verificarPassword($usuarioId, $passwordActual)) {
                echo json_encode(['success' => false, 'message' => 'La contraseña actual es incorrecta']);
                exit;
            }
            
            // Actualizar contraseña
            $resultado = User::actualizarPassword($usuarioId, $passwordNuevo);
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña']);
            }
            
        } catch (Exception $e) {
            error_log("Error al cambiar contraseña: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al cambiar la contraseña']);
        }
    }
    
    /**
     * Agregar nueva dirección
     */
    public function agregarDireccion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        try {
            $datos = [
                'usuario_id' => $_SESSION['usuario_id'],
                'direccion' => trim($_POST['direccion'] ?? ''),
                'ciudad' => trim($_POST['ciudad'] ?? ''),
                'departamento' => trim($_POST['departamento'] ?? ''),
                'codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
                'pais' => 'Colombia',
                'es_principal' => isset($_POST['es_principal']) ? 1 : 0
            ];
            
            // Validar campos requeridos
            if (empty($datos['direccion']) || empty($datos['ciudad']) || empty($datos['departamento'])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            $resultado = Direccion::crear($datos);
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Error al agregar dirección: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al agregar la dirección']);
        }
    }
    
    /**
     * Eliminar dirección
     */
    public function eliminarDireccion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        try {
            $direccionId = $_POST['direccion_id'] ?? null;
            
            if (!$direccionId) {
                echo json_encode(['success' => false, 'message' => 'ID de dirección inválido']);
                exit;
            }
            
            $resultado = Direccion::eliminar($direccionId, $_SESSION['usuario_id']);
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Error al eliminar dirección: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al eliminar la dirección']);
        }
    }
    
    /**
     * Establecer dirección principal
     */
    public function establecerPrincipal() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        try {
            $direccionId = $_POST['direccion_id'] ?? null;
            
            if (!$direccionId) {
                echo json_encode(['success' => false, 'message' => 'ID de dirección inválido']);
                exit;
            }
            
            error_log("Intentando establecer dirección principal - Usuario: " . $_SESSION['usuario_id'] . ", Dirección: " . $direccionId);
            
            $resultado = Direccion::establecerPrincipal($direccionId, $_SESSION['usuario_id']);
            
            error_log("Resultado de establecer principal: " . json_encode($resultado));
            
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Error al establecer dirección principal: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al establecer dirección principal: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Actualizar dirección existente
     */
    public function actualizarDireccion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autenticado']);
            exit;
        }
        
        try {
            $direccionId = $_POST['direccion_id'] ?? null;
            
            if (!$direccionId) {
                echo json_encode(['success' => false, 'message' => 'ID de dirección inválido']);
                exit;
            }
            
            $datos = [
                'direccion' => trim($_POST['direccion'] ?? ''),
                'ciudad' => trim($_POST['ciudad'] ?? ''),
                'departamento' => trim($_POST['departamento'] ?? ''),
                'codigo_postal' => trim($_POST['codigo_postal'] ?? ''),
                'es_principal' => isset($_POST['es_principal']) ? 1 : 0
            ];
            
            // Validar campos requeridos
            if (empty($datos['direccion']) || empty($datos['ciudad']) || empty($datos['departamento'])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
            
            $resultado = Direccion::actualizar($direccionId, $_SESSION['usuario_id'], $datos);
            echo json_encode($resultado);
            
        } catch (Exception $e) {
            error_log("Error al actualizar dirección: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la dirección']);
        }
    }
}
