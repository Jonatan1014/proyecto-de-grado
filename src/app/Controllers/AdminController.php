<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Producto.php';
require_once __DIR__ . '/../Models/Pedido.php';

class AdminController {

    /**
     * Dashboard principal
     */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación y rol
        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        // Obtener estadísticas
        $stats = $this->obtenerEstadisticas();
        
        // Obtener pedidos recientes
        $pedidos_recientes = Pedido::obtenerRecientes(10);

        include __DIR__ . '/../Views/admin/dashboard.php';
    }

    /**
     * Gestión de productos
     */
    public function productos() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        $action = $_GET['action'] ?? 'listar';
        $productoId = $_GET['id'] ?? null;

        // Obtener datos necesarios
        $categorias = $this->obtenerCategorias();
        $marcas = $this->obtenerMarcas();
        $tallas = $this->obtenerTallas();
        $colores = $this->obtenerColores();
        $generos = $this->obtenerGeneros();

        if ($action === 'listar') {
            // Obtener productos con filtros
            $search = $_GET['search'] ?? '';
            $categoriaFilter = $_GET['categoria'] ?? '';
            $estadoFilter = $_GET['estado'] ?? '';
            
            $productos = Producto::obtenerTodos(null, $search, $categoriaFilter, $estadoFilter);
        } elseif ($action === 'editar' && $productoId) {
            $producto = Producto::obtenerPorId($productoId);
        }

        include __DIR__ . '/../Views/admin/productos.php';
    }

    /**
     * API para gestionar productos
     */
    public function productosApi() {
        header('Content-Type: application/json');
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        $method = $_SERVER['REQUEST_METHOD'];
        $action = $_GET['action'] ?? '';

        if ($method === 'POST') {
            // Crear o actualizar producto
            $resultado = $this->guardarProducto($_POST, $_FILES);
            echo json_encode($resultado);
        } elseif ($method === 'DELETE' && $action === 'eliminar') {
            $id = $_GET['id'] ?? 0;
            $resultado = Producto::eliminar($id);
            echo json_encode($resultado);
        }
    }

    /**
     * Obtener estadísticas para el dashboard
     */
    private function obtenerEstadisticas() {
        $db = Database::getConnection();
        
        $stats = [];
        
        // Total de productos
        $stmt = $db->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'activo'");
        $stats['total_productos'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Pedidos de hoy
        $stmt = $db->query("SELECT COUNT(*) as total FROM pedidos WHERE DATE(fecha_pedido) = CURDATE()");
        $stats['pedidos_hoy'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Ventas del mes
        $stmt = $db->query("SELECT COALESCE(SUM(total), 0) as total FROM pedidos WHERE MONTH(fecha_pedido) = MONTH(CURDATE()) AND YEAR(fecha_pedido) = YEAR(CURDATE())");
        $stats['ventas_mes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Productos con stock bajo
        $stmt = $db->query("SELECT COUNT(*) as total FROM productos WHERE stock <= stock_minimo AND estado = 'activo'");
        $stats['stock_bajo'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }

    /**
     * Guardar producto (crear o actualizar)
     */
    private function guardarProducto($data, $files) {
        try {
            // Validar datos obligatorios
            if (empty($data['nombre']) || empty($data['codigo_sku']) || empty($data['categoria_id'])) {
                return ['success' => false, 'message' => 'Faltan campos obligatorios'];
            }

            // Procesar imágenes
            $imagenes = $this->procesarImagenesProducto($files);
            
            // Preparar datos del producto
            $productoData = [
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
                'precio' => $data['precio'],
                'precio_oferta' => !empty($data['precio_oferta']) ? $data['precio_oferta'] : null,
                'categoria_id' => $data['categoria_id'],
                'marca_id' => !empty($data['marca_id']) ? $data['marca_id'] : null,
                'talla_id' => !empty($data['talla_id']) ? $data['talla_id'] : null,
                'color_id' => !empty($data['color_id']) ? $data['color_id'] : null,
                'genero_id' => !empty($data['genero_id']) ? $data['genero_id'] : null,
                'stock' => $data['stock'],
                'stock_minimo' => $data['stock_minimo'] ?? 5,
                'codigo_sku' => $data['codigo_sku'],
                'destacado' => $data['destacado'] ?? 0,
                'estado' => $data['estado'] ?? 'activo'
            ];

            // Agregar imágenes si se subieron
            foreach ($imagenes as $campo => $nombreArchivo) {
                $productoData[$campo] = $nombreArchivo;
            }

            if (!empty($data['id'])) {
                // Actualizar
                $resultado = Producto::actualizar($data['id'], $productoData);
            } else {
                // Crear nuevo
                $resultado = Producto::crear($productoData);
            }

            return $resultado;
        } catch (Exception $e) {
            error_log("Error al guardar producto: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al guardar el producto'];
        }
    }

    /**
     * Procesar imágenes subidas
     */
    private function procesarImagenesProducto($files) {
        $imagenes = [];
        $uploadDir = __DIR__ . '/../../public/img/product/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach (['imagen_principal', 'imagen_2', 'imagen_3', 'imagen_4', 'imagen_5'] as $campo) {
            if (isset($files[$campo]) && $files[$campo]['error'] === UPLOAD_ERR_OK) {
                $extension = pathinfo($files[$campo]['name'], PATHINFO_EXTENSION);
                $nombreArchivo = uniqid('prod_') . '.' . $extension;
                $rutaDestino = $uploadDir . $nombreArchivo;

                if (move_uploaded_file($files[$campo]['tmp_name'], $rutaDestino)) {
                    $imagenes[$campo] = $nombreArchivo;
                }
            }
        }

        return $imagenes;
    }

    /**
     * Obtener categorías
     */
    private function obtenerCategorias() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM categorias WHERE estado = 'activo' ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener marcas
     */
    private function obtenerMarcas() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM marcas WHERE estado = 'activo' ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener tallas
     */
    private function obtenerTallas() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM tallas WHERE estado = 'activo' ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener colores
     */
    private function obtenerColores() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM colores WHERE estado = 'activo' ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener géneros
     */
    private function obtenerGeneros() {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM generos WHERE estado = 'activo' ORDER BY nombre");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





    /**
     * Gestión de categorías
     */
    public function categorias() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        $categorias = $this->obtenerCategorias();
        
        include __DIR__ . '/../Views/admin/categorias.php';
    }

    /**
     * API REST para categorías (AJAX)
     */
    public function categoriasApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Crear o actualizar categoría
                $id = $_POST['id'] ?? null;
                $datos = [
                    'nombre' => $_POST['nombre'] ?? '',
                    'descripcion' => $_POST['descripcion'] ?? '',
                    'estado' => $_POST['estado'] ?? 'activo'
                ];

                // Procesar imagen si se subió
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/img/category/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    $nombreArchivo = 'cat_' . uniqid() . '.' . $extension;
                    $rutaDestino = $uploadDir . $nombreArchivo;
                    
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                        $datos['imagen'] = $nombreArchivo;
                    }
                }

                if ($id) {
                    // Actualizar
                    $resultado = $this->actualizarCategoria($id, $datos);
                } else {
                    // Crear
                    $resultado = $this->crearCategoria($datos);
                }

                echo json_encode($resultado);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                // Eliminar categoría
                $id = $_GET['id'] ?? null;
                if ($id) {
                    $resultado = $this->eliminarCategoria($id);
                    echo json_encode($resultado);
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            }
        } catch (Exception $e) {
            error_log("Error en categoriasApi: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error del servidor']);
        }
    }

    /**
     * Gestión de marcas
     */
    public function marcas() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        $marcas = $this->obtenerMarcas();
        
        include __DIR__ . '/../Views/admin/marcas.php';
    }

    /**
     * API REST para marcas (AJAX)
     */
    public function marcasApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Crear o actualizar marca
                $id = $_POST['id'] ?? null;
                $datos = [
                    'nombre' => $_POST['nombre'] ?? '',
                    'descripcion' => $_POST['descripcion'] ?? '',
                    'estado' => $_POST['estado'] ?? 'activo'
                ];

                // Procesar logo si se subió
                if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../../public/img/brand/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
                    $nombreArchivo = 'brand_' . uniqid() . '.' . $extension;
                    $rutaDestino = $uploadDir . $nombreArchivo;
                    
                    if (move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino)) {
                        $datos['logo'] = $nombreArchivo;
                    }
                }

                if ($id) {
                    // Actualizar
                    $resultado = $this->actualizarMarca($id, $datos);
                } else {
                    // Crear
                    $resultado = $this->crearMarca($datos);
                }

                echo json_encode($resultado);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                // Eliminar marca
                $id = $_GET['id'] ?? null;
                if ($id) {
                    $resultado = $this->eliminarMarca($id);
                    echo json_encode($resultado);
                } else {
                    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            }
        } catch (Exception $e) {
            error_log("Error en marcasApi: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error del servidor']);
        }
    }

    /**
     * Métodos privados para CRUD de categorías
     */
    private function crearCategoria($datos) {
        try {
            $conexion = Database::getConnection();
            $sql = "INSERT INTO categorias (nombre, descripcion, imagen, estado) 
                    VALUES (:nombre, :descripcion, :imagen, :estado)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':imagen' => $datos['imagen'] ?? null,
                ':estado' => $datos['estado']
            ]);
            
            return ['success' => true, 'message' => 'Categoría creada', 'id' => $conexion->lastInsertId()];
        } catch (Exception $e) {
            error_log("Error al crear categoría: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear categoría'];
        }
    }

    private function actualizarCategoria($id, $datos) {
        try {
            $conexion = Database::getConnection();
            
            $campos = [];
            $parametros = [':id' => $id];
            
            foreach ($datos as $campo => $valor) {
                if ($valor !== null && $valor !== '') {
                    $campos[] = "$campo = :$campo";
                    $parametros[":$campo"] = $valor;
                }
            }
            
            if (empty($campos)) {
                return ['success' => false, 'message' => 'No hay datos para actualizar'];
            }
            
            $sql = "UPDATE categorias SET " . implode(', ', $campos) . " WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            
            return ['success' => true, 'message' => 'Categoría actualizada'];
        } catch (Exception $e) {
            error_log("Error al actualizar categoría: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar categoría'];
        }
    }

    private function eliminarCategoria($id) {
        try {
            $conexion = Database::getConnection();
            $sql = "UPDATE categorias SET estado = 'inactivo' WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return ['success' => true, 'message' => 'Categoría eliminada'];
        } catch (Exception $e) {
            error_log("Error al eliminar categoría: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar categoría'];
        }
    }

    /**
     * Métodos privados para CRUD de marcas
     */
    private function crearMarca($datos) {
        try {
            $conexion = Database::getConnection();
            $sql = "INSERT INTO marcas (nombre, descripcion, logo, estado) 
                    VALUES (:nombre, :descripcion, :logo, :estado)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':nombre' => $datos['nombre'],
                ':descripcion' => $datos['descripcion'],
                ':logo' => $datos['logo'] ?? null,
                ':estado' => $datos['estado']
            ]);
            
            return ['success' => true, 'message' => 'Marca creada', 'id' => $conexion->lastInsertId()];
        } catch (Exception $e) {
            error_log("Error al crear marca: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al crear marca'];
        }
    }

    private function actualizarMarca($id, $datos) {
        try {
            $conexion = Database::getConnection();
            
            $campos = [];
            $parametros = [':id' => $id];
            
            foreach ($datos as $campo => $valor) {
                if ($valor !== null && $valor !== '') {
                    $campos[] = "$campo = :$campo";
                    $parametros[":$campo"] = $valor;
                }
            }
            
            if (empty($campos)) {
                return ['success' => false, 'message' => 'No hay datos para actualizar'];
            }
            
            $sql = "UPDATE marcas SET " . implode(', ', $campos) . " WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            
            return ['success' => true, 'message' => 'Marca actualizada'];
        } catch (Exception $e) {
            error_log("Error al actualizar marca: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al actualizar marca'];
        }
    }

    private function eliminarMarca($id) {
        try {
            $conexion = Database::getConnection();
            $sql = "UPDATE marcas SET estado = 'inactivo' WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return ['success' => true, 'message' => 'Marca eliminada'];
        } catch (Exception $e) {
            error_log("Error al eliminar marca: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar marca'];
        }
    }

    /**
     * Gestión de pedidos
     */
    public function pedidos() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        include __DIR__ . '/../Views/admin/pedidos.php';
    }

    /**
     * API REST para pedidos (AJAX)
     */
    public function pedidosApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            exit;
        }

        try {
            $action = $_GET['action'] ?? 'listar';

            switch ($action) {
                case 'listar':
                    $pedidos = $this->obtenerTodosPedidos();
                    echo json_encode(['success' => true, 'pedidos' => $pedidos]);
                    break;

                case 'detalle':
                    $pedidoId = $_GET['id'] ?? null;
                    if ($pedidoId) {
                        $pedido = Pedido::obtenerDetalle($pedidoId);
                        $items = Pedido::obtenerItems($pedidoId);
                        echo json_encode(['success' => true, 'pedido' => $pedido, 'items' => $items]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
                    }
                    break;

                case 'cambiar-estado':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $pedidoId = $_POST['pedido_id'] ?? null;
                        $estadoId = $_POST['estado_id'] ?? null;
                        $observaciones = $_POST['observaciones'] ?? null;

                        if ($pedidoId && $estadoId) {
                            // Actualizar estado con observaciones si se proporcionan
                            $resultado = Pedido::actualizarEstado($pedidoId, $estadoId, $observaciones);
                            if ($resultado) {
                                echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
                            } else {
                                echo json_encode(['success' => false, 'message' => 'Error al actualizar estado']);
                            }
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                        }
                    }
                    break;

                default:
                    echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            }
        } catch (Exception $e) {
            error_log("Error en pedidosApi: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error del servidor']);
        }
    }

    /**
     * Obtener todos los pedidos con información completa
     */
    private function obtenerTodosPedidos() {
        try {
            $conexion = Database::getConnection();
            
            $sql = "SELECT 
                        p.*,
                        u.nombre as usuario_nombre,
                        u.apellido as usuario_apellido,
                        u.email as usuario_email,
                        ep.nombre as estado_nombre,
                        ep.color as estado_color,
                        mp.nombre as metodo_pago
                    FROM pedidos p
                    LEFT JOIN usuarios u ON p.usuario_id = u.id
                    LEFT JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
                    LEFT JOIN metodos_pago mp ON p.metodo_pago_id = mp.id
                    ORDER BY p.fecha_pedido DESC";
            
            $stmt = $conexion->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener pedidos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Gestión de clientes
     */
    public function clientes() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["usuario_id"]) || !in_array($_SESSION["user"]["rol"], ["administrador", "empleado"])) {
            header("Location: login");
            exit;
        }

        include __DIR__ . "/../Views/admin/clientes.php";
    }

    /**
     * API REST para clientes (AJAX)
     */
    public function clientesApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header("Content-Type: application/json");

        if (!isset($_SESSION["usuario_id"]) || !in_array($_SESSION["user"]["rol"], ["administrador", "empleado"])) {
            echo json_encode(["success" => false, "message" => "No autorizado"]);
            exit;
        }

        try {
            $action = $_GET["action"] ?? "listar";

            switch ($action) {
                case "listar":
                    $clientes = $this->obtenerTodosClientes();
                    echo json_encode(["success" => true, "clientes" => $clientes]);
                    break;

                case "detalle":
                    $clienteId = $_GET["id"] ?? null;
                    if ($clienteId) {
                        $cliente = $this->obtenerDetalleCliente($clienteId);
                        $direcciones = $this->obtenerDireccionesCliente($clienteId);
                        $pedidos = $this->obtenerPedidosCliente($clienteId);
                        echo json_encode([
                            "success" => true,
                            "cliente" => $cliente,
                            "direcciones" => $direcciones,
                            "pedidos" => $pedidos
                        ]);
                    } else {
                        echo json_encode(["success" => false, "message" => "ID no proporcionado"]);
                    }
                    break;

                default:
                    echo json_encode(["success" => false, "message" => "Acción no válida"]);
            }
        } catch (Exception $e) {
            error_log("Error en clientesApi: " . $e->getMessage());
            echo json_encode(["success" => false, "message" => "Error del servidor"]);
        }
    }

    /**
     * Obtener todos los clientes con estadísticas
     */
    private function obtenerTodosClientes() {
        try {
            $conexion = Database::getConnection();
            
            $sql = "SELECT 
                        u.*,
                        COUNT(DISTINCT p.id) as total_pedidos,
                        COALESCE(SUM(p.total), 0) as total_gastado,
                        MAX(p.fecha_pedido) as ultima_actividad
                    FROM usuarios u
                    LEFT JOIN pedidos p ON u.id = p.usuario_id
                    WHERE u.rol = 'cliente'
                    GROUP BY u.id
                    ORDER BY u.fecha_registro DESC";
            
            $stmt = $conexion->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener clientes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener detalle de un cliente específico
     */
    private function obtenerDetalleCliente($clienteId) {
        try {
            $conexion = Database::getConnection();
            
            $sql = "SELECT 
                        u.*,
                        COUNT(DISTINCT p.id) as total_pedidos,
                        COALESCE(SUM(p.total), 0) as total_gastado,
                        MAX(p.fecha_pedido) as ultima_actividad
                    FROM usuarios u
                    LEFT JOIN pedidos p ON u.id = p.usuario_id
                    WHERE u.id = :id
                    GROUP BY u.id";
            
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":id" => $clienteId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener detalle del cliente: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Obtener direcciones de un cliente
     */
    private function obtenerDireccionesCliente($clienteId) {
        try {
            $conexion = Database::getConnection();
            
            $sql = "SELECT * FROM direcciones 
                    WHERE usuario_id = :usuario_id 
                    ORDER BY es_principal DESC, fecha_creacion DESC";
            
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":usuario_id" => $clienteId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener direcciones: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Obtener pedidos de un cliente
     */
    private function obtenerPedidosCliente($clienteId) {
        try {
            $conexion = Database::getConnection();
            
            $sql = "SELECT 
                        p.*,
                        ep.nombre as estado_nombre,
                        ep.color as estado_color
                    FROM pedidos p
                    LEFT JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
                    WHERE p.usuario_id = :usuario_id
                    ORDER BY p.fecha_pedido DESC";
            
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":usuario_id" => $clienteId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener pedidos del cliente: " . $e->getMessage());
            return [];
        }
    }




    /**
     * Gestión de usuarios (administradores y empleados)
     */
    public function usuarios() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Solo administradores pueden acceder
        if (!isset($_SESSION["usuario_id"]) || $_SESSION["user"]["rol"] !== "administrador") {
            header("Location: login");
            exit;
        }

        include __DIR__ . "/../Views/admin/usuarios.php";
    }

    /**
     * API REST para usuarios (AJAX)
     */
    public function usuariosApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header("Content-Type: application/json");

        // Solo administradores pueden acceder
        if (!isset($_SESSION["usuario_id"]) || $_SESSION["user"]["rol"] !== "administrador") {
            echo json_encode(["success" => false, "message" => "No autorizado"]);
            exit;
        }

        try {
            $action = $_GET["action"] ?? "crear";

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // Crear o actualizar usuario
                $id = $_POST["id"] ?? null;
                $datos = [
                    "nombre" => $_POST["nombre"] ?? "",
                    "apellido" => $_POST["apellido"] ?? "",
                    "email" => $_POST["email"] ?? "",
                    "telefono" => $_POST["telefono"] ?? null,
                    "rol" => $_POST["rol"] ?? "empleado",
                    "estado" => $_POST["estado"] ?? "activo"
                ];

                // Validar rol
                if (!in_array($datos["rol"], ["administrador", "empleado"])) {
                    echo json_encode(["success" => false, "message" => "Rol no válido"]);
                    exit;
                }

                // Solo agregar password si se proporcionó
                if (!empty($_POST["password"])) {
                    $datos["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
                }

                if ($id) {
                    // Actualizar
                    $resultado = $this->actualizarUsuario($id, $datos);
                } else {
                    // Crear - validar que password esté presente
                    if (empty($_POST["password"])) {
                        echo json_encode(["success" => false, "message" => "La contraseña es requerida"]);
                        exit;
                    }
                    $resultado = $this->crearUsuario($datos);
                }

                echo json_encode($resultado);
            } elseif ($_SERVER["REQUEST_METHOD"] === "DELETE") {
                // Eliminar usuario
                $id = $_GET["id"] ?? null;
                if ($id) {
                    // No permitir eliminar el usuario actual
                    if ($id == $_SESSION["usuario_id"]) {
                        echo json_encode(["success" => false, "message" => "No puedes eliminarte a ti mismo"]);
                        exit;
                    }
                    $resultado = $this->eliminarUsuario($id);
                    echo json_encode($resultado);
                } else {
                    echo json_encode(["success" => false, "message" => "ID no proporcionado"]);
                }
            } elseif ($action === "listar") {
                // Listar usuarios
                $usuarios = $this->obtenerTodosUsuarios();
                echo json_encode(["success" => true, "usuarios" => $usuarios]);
            } else {
                echo json_encode(["success" => false, "message" => "Acción no válida"]);
            }
        } catch (Exception $e) {
            error_log("Error en usuariosApi: " . $e->getMessage());
            echo json_encode(["success" => false, "message" => "Error del servidor"]);
        }
    }

    /**
     * Obtener todos los usuarios del sistema (no clientes)
     */
    private function obtenerTodosUsuarios() {
        try {
            $conexion = Database::getConnection();
            
            $sql = "SELECT id, nombre, apellido, email, telefono,
                           rol, estado, fecha_registro
                    FROM usuarios 
                    WHERE rol IN ('administrador', 'empleado')
                    ORDER BY fecha_registro DESC";
            
            $stmt = $conexion->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al obtener usuarios: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Crear nuevo usuario
     */
    private function crearUsuario($datos) {
        try {
            $conexion = Database::getConnection();
            
            // Verificar si el email ya existe
            $sqlCheck = "SELECT id FROM usuarios WHERE email = :email";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->execute([":email" => $datos["email"]]);
            
            if ($stmtCheck->fetch()) {
                return ["success" => false, "message" => "El email ya está registrado"];
            }

            $sql = "INSERT INTO usuarios (nombre, apellido, email, password, telefono,  rol, estado) 
                    VALUES (:nombre, :apellido, :email, :password, :telefono, :rol, :estado)";

            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ":nombre" => $datos["nombre"],
                ":apellido" => $datos["apellido"],
                ":email" => $datos["email"],
                ":password" => $datos["password"],
                ":telefono" => $datos["telefono"],
                ":rol" => $datos["rol"],
                ":estado" => $datos["estado"]
            ]);
            
            return ["success" => true, "message" => "Usuario creado exitosamente", "id" => $conexion->lastInsertId()];
        } catch (Exception $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return ["success" => false, "message" => "Error al crear usuario"];
        }
    }

    /**
     * Actualizar usuario existente
     */
    private function actualizarUsuario($id, $datos) {
        try {
            $conexion = Database::getConnection();
            
            // Verificar si el email ya existe en otro usuario
            $sqlCheck = "SELECT id FROM usuarios WHERE email = :email AND id != :id";
            $stmtCheck = $conexion->prepare($sqlCheck);
            $stmtCheck->execute([":email" => $datos["email"], ":id" => $id]);
            
            if ($stmtCheck->fetch()) {
                return ["success" => false, "message" => "El email ya está registrado en otro usuario"];
            }
            
            $campos = [];
            $parametros = [":id" => $id];
            
            foreach ($datos as $campo => $valor) {
                if ($valor !== null && $valor !== "" && $campo !== "password") {
                    $campos[] = "$campo = :$campo";
                    $parametros[":$campo"] = $valor;
                }
            }
            
            // Agregar password si se proporcionó
            if (isset($datos["password"]) && !empty($datos["password"])) {
                $campos[] = "password = :password";
                $parametros[":password"] = $datos["password"];
            }
            
            if (empty($campos)) {
                return ["success" => false, "message" => "No hay datos para actualizar"];
            }
            
            $sql = "UPDATE usuarios SET " . implode(", ", $campos) . " WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute($parametros);
            
            return ["success" => true, "message" => "Usuario actualizado exitosamente"];
        } catch (Exception $e) {
            error_log("Error al actualizar usuario: " . $e->getMessage());
            return ["success" => false, "message" => "Error al actualizar usuario"];
        }
    }

    /**
     * Eliminar usuario (cambiar a inactivo)
     */
    private function eliminarUsuario($id) {
        try {
            $conexion = Database::getConnection();
            
            $sql = "UPDATE usuarios SET estado = 'inactivo' WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([":id" => $id]);
            
            return ["success" => true, "message" => "Usuario eliminado"];
        } catch (Exception $e) {
            error_log("Error al eliminar usuario: " . $e->getMessage());
            return ["success" => false, "message" => "Error al eliminar usuario"];
        }
    }


    /**
     * Mostrar página de reportes
     */
    public function reportes() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        include __DIR__ . '/../Views/admin/reportes.php';
    }

    /**
     * API para generar reportes
     */
    public function reportesApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        $action = $_GET['action'] ?? '';
        $tipo = $_GET['tipo'] ?? 'general';
        $fechaInicio = $_GET['inicio'] ?? date('Y-m-01');
        $fechaFin = $_GET['fin'] ?? date('Y-m-d');

        try {
            if ($action === 'generar') {
                $reporte = $this->generarReporte($tipo, $fechaInicio, $fechaFin);
                echo json_encode(['success' => true, 'reporte' => $reporte]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            }
        } catch (Exception $e) {
            error_log("Error en reportes: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al generar el reporte']);
        }
    }

    /**
     * Generar reporte según tipo
     */
    private function generarReporte($tipo, $fechaInicio, $fechaFin) {
        switch ($tipo) {
            case 'ventas':
                return $this->reporteVentas($fechaInicio, $fechaFin);
            case 'productos':
                return $this->reporteProductos($fechaInicio, $fechaFin);
            case 'clientes':
                return $this->reporteClientes($fechaInicio, $fechaFin);
            case 'inventario':
                return $this->reporteInventario($fechaInicio, $fechaFin);
            default:
                return $this->reporteGeneral($fechaInicio, $fechaFin);
        }
    }

    /**
     * Reporte general
     */
    private function reporteGeneral($fechaInicio, $fechaFin) {
        $conn = Database::getConnection();

        // Estadísticas principales
        $statsVentas = $conn->query("
            SELECT 
                COUNT(*) as total_pedidos,
                COALESCE(SUM(total), 0) as total_ventas,
                COALESCE(AVG(total), 0) as promedio_venta
            FROM pedidos 
            WHERE DATE(fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND estado_pedido_id != 6
        ")->fetch(PDO::FETCH_ASSOC);

        $totalProductos = $conn->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];
        $totalClientes = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'")->fetch(PDO::FETCH_ASSOC)['total'];
        $stockBajo = $conn->query("SELECT COUNT(*) as total FROM productos WHERE stock < 5 AND estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];

        $estadisticas = [
            [
                'titulo' => 'Total Ventas',
                'valor' => '$' . number_format($statsVentas['total_ventas'], 0, ',', '.'),
                'icono' => 'ti-money',
                'color' => 'purple'
            ],
            [
                'titulo' => 'Pedidos',
                'valor' => $statsVentas['total_pedidos'],
                'icono' => 'ti-shopping-cart',
                'color' => 'green'
            ],
            [
                'titulo' => 'Productos Activos',
                'valor' => $totalProductos,
                'icono' => 'ti-package',
                'color' => 'orange'
            ],
            [
                'titulo' => 'Clientes',
                'valor' => $totalClientes,
                'icono' => 'ti-user',
                'color' => 'blue'
            ]
        ];

        // Gráfico de ventas por día
        $ventasPorDia = $conn->query("
            SELECT 
                DATE(fecha_pedido) as fecha,
                COUNT(*) as cantidad,
                SUM(total) as total
            FROM pedidos 
            WHERE DATE(fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND estado_pedido_id != 6
            GROUP BY DATE(fecha_pedido)
            ORDER BY fecha
        ")->fetchAll(PDO::FETCH_ASSOC);

        $labels = [];
        $datos = [];
        foreach ($ventasPorDia as $venta) {
            $labels[] = date('d/m', strtotime($venta['fecha']));
            $datos[] = floatval($venta['total']);
        }

        // Gráfico de productos más vendidos
        $productosMasVendidos = $conn->query("
            SELECT 
                p.nombre,
                SUM(dp.cantidad) as cantidad_vendida
            FROM detalle_pedidos dp
            INNER JOIN productos p ON dp.producto_id = p.id
            INNER JOIN pedidos ped ON dp.pedido_id = ped.id
            WHERE DATE(ped.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND ped.estado_pedido_id != 6
            GROUP BY p.id, p.nombre
            ORDER BY cantidad_vendida DESC
            LIMIT 10
        ")->fetchAll(PDO::FETCH_ASSOC);

        $productosLabels = [];
        $productosDatos = [];
        foreach ($productosMasVendidos as $prod) {
            $productosLabels[] = $prod['nombre'];
            $productosDatos[] = intval($prod['cantidad_vendida']);
        }

        // Gráfico de estados de pedidos
        $pedidosPorEstado = $conn->query("
            SELECT 
                ep.nombre,
                COUNT(*) as cantidad
            FROM pedidos p
            INNER JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
            WHERE DATE(p.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            GROUP BY ep.id, ep.nombre
            ORDER BY cantidad DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $estadosLabels = [];
        $estadosDatos = [];
        $colores = ['#667eea', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#6c757d'];
        foreach ($pedidosPorEstado as $index => $estado) {
            $estadosLabels[] = $estado['nombre'];
            $estadosDatos[] = intval($estado['cantidad']);
        }

        $graficos = [
            [
                'titulo' => '💰 Ventas Diarias',
                'tipo' => 'line',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [[
                        'label' => 'Ventas ($)',
                        'data' => $datos,
                        'borderColor' => '#667eea',
                        'backgroundColor' => 'rgba(102, 126, 234, 0.1)',
                        'tension' => 0.4,
                        'fill' => true
                    ]]
                ]
            ],
            [
                'titulo' => '🛍️ Productos Más Vendidos',
                'tipo' => 'bar',
                'data' => [
                    'labels' => $productosLabels,
                    'datasets' => [[
                        'label' => 'Unidades Vendidas',
                        'data' => $productosDatos,
                        'backgroundColor' => '#11998e'
                    ]]
                ]
            ],
            [
                'titulo' => '📊 Pedidos por Estado',
                'tipo' => 'doughnut',
                'data' => [
                    'labels' => $estadosLabels,
                    'datasets' => [[
                        'data' => $estadosDatos,
                        'backgroundColor' => $colores
                    ]]
                ]
            ]
        ];

        // Tabla de últimos pedidos
        $ultimosPedidos = $conn->query("
            SELECT 
                p.numero_pedido,
                CONCAT(u.nombre, ' ', u.apellido) as cliente,
                DATE_FORMAT(p.fecha_pedido, '%d/%m/%Y %H:%i') as fecha,
                CONCAT('$', FORMAT(p.total, 0)) as total,
                ep.nombre as estado
            FROM pedidos p
            INNER JOIN usuarios u ON p.usuario_id = u.id
            INNER JOIN estados_pedido ep ON p.estado_pedido_id = ep.id
            WHERE DATE(p.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            ORDER BY p.fecha_pedido DESC
            LIMIT 20
        ")->fetchAll(PDO::FETCH_ASSOC);

        $datosTabla = [];
        foreach ($ultimosPedidos as $pedido) {
            $datosTabla[] = [
                $pedido['numero_pedido'],
                $pedido['cliente'],
                $pedido['fecha'],
                $pedido['total'],
                $pedido['estado']
            ];
        }

        $tablas = [
            [
                'titulo' => '📦 Últimos Pedidos',
                'columnas' => ['N° Pedido', 'Cliente', 'Fecha', 'Total', 'Estado'],
                'datos' => $datosTabla
            ]
        ];

        return [
            'estadisticas' => $estadisticas,
            'graficos' => $graficos,
            'tablas' => $tablas
        ];
    }

    /**
     * Reporte de ventas
     */
    private function reporteVentas($fechaInicio, $fechaFin) {
        $conn = Database::getConnection();

        // Estadísticas de ventas
        $stats = $conn->query("
            SELECT 
                COUNT(*) as total_pedidos,
                COALESCE(SUM(total), 0) as total_ventas,
                COALESCE(AVG(total), 0) as promedio_venta,
                COALESCE(MAX(total), 0) as venta_maxima
            FROM pedidos 
            WHERE DATE(fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND estado_pedido_id IN (2,3,4,5)
        ")->fetch(PDO::FETCH_ASSOC);

        $estadisticas = [
            [
                'titulo' => 'Total Ventas',
                'valor' => '$' . number_format($stats['total_ventas'], 0, ',', '.'),
                'icono' => 'ti-money',
                'color' => 'purple'
            ],
            [
                'titulo' => 'Promedio por Venta',
                'valor' => '$' . number_format($stats['promedio_venta'], 0, ',', '.'),
                'icono' => 'ti-stats-up',
                'color' => 'green'
            ],
            [
                'titulo' => 'Total Pedidos',
                'valor' => $stats['total_pedidos'],
                'icono' => 'ti-shopping-cart',
                'color' => 'orange'
            ],
            [
                'titulo' => 'Venta Máxima',
                'valor' => '$' . number_format($stats['venta_maxima'], 0, ',', '.'),
                'icono' => 'ti-crown',
                'color' => 'blue'
            ]
        ];

        // Ventas por categoría
        $ventasPorCategoria = $conn->query("
            SELECT 
                c.nombre,
                COUNT(DISTINCT p.id) as pedidos,
                SUM(dp.cantidad) as unidades,
                SUM(dp.subtotal) as total
            FROM detalle_pedidos dp
            INNER JOIN productos pr ON dp.producto_id = pr.id
            INNER JOIN categorias c ON pr.categoria_id = c.id
            INNER JOIN pedidos p ON dp.pedido_id = p.id
            WHERE DATE(p.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND p.estado_pedido_id IN (2,3,4,5)
            GROUP BY c.id, c.nombre
            ORDER BY total DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $catLabels = [];
        $catDatos = [];
        foreach ($ventasPorCategoria as $cat) {
            $catLabels[] = $cat['nombre'];
            $catDatos[] = floatval($cat['total']);
        }

        $graficos = [
            [
                'titulo' => '📊 Ventas por Categoría',
                'tipo' => 'pie',
                'data' => [
                    'labels' => $catLabels,
                    'datasets' => [[
                        'data' => $catDatos,
                        'backgroundColor' => ['#667eea', '#11998e', '#f09819', '#2193b0', '#764ba2', '#38ef7d']
                    ]]
                ]
            ]
        ];

        // Tabla detallada
        $datosTabla = [];
        foreach ($ventasPorCategoria as $cat) {
            $datosTabla[] = [
                $cat['nombre'],
                $cat['pedidos'],
                $cat['unidades'],
                '$' . number_format($cat['total'], 0, ',', '.')
            ];
        }

        $tablas = [
            [
                'titulo' => '📈 Ventas por Categoría',
                'columnas' => ['Categoría', 'Pedidos', 'Unidades', 'Total'],
                'datos' => $datosTabla
            ]
        ];

        return [
            'estadisticas' => $estadisticas,
            'graficos' => $graficos,
            'tablas' => $tablas
        ];
    }

    /**
     * Reporte de productos
     */
    private function reporteProductos($fechaInicio, $fechaFin) {
        $conn = Database::getConnection();

        $totalProductos = $conn->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];
        $stockBajo = $conn->query("SELECT COUNT(*) as total FROM productos WHERE stock < 5 AND estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];
        $sinStock = $conn->query("SELECT COUNT(*) as total FROM productos WHERE stock = 0 AND estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];
        $valorInventario = $conn->query("SELECT COALESCE(SUM(precio * stock), 0) as total FROM productos WHERE estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];

        $estadisticas = [
            [
                'titulo' => 'Total Productos',
                'valor' => $totalProductos,
                'icono' => 'ti-package',
                'color' => 'purple'
            ],
            [
                'titulo' => 'Stock Bajo',
                'valor' => $stockBajo,
                'icono' => 'ti-alert',
                'color' => 'orange'
            ],
            [
                'titulo' => 'Sin Stock',
                'valor' => $sinStock,
                'icono' => 'ti-close',
                'color' => 'blue'
            ],
            [
                'titulo' => 'Valor Inventario',
                'valor' => '$' . number_format($valorInventario, 0, ',', '.'),
                'icono' => 'ti-money',
                'color' => 'green'
            ]
        ];

        // Productos más vendidos
        $masVendidos = $conn->query("
            SELECT 
                p.nombre,
                p.stock,
                SUM(dp.cantidad) as vendidos,
                SUM(dp.subtotal) as ingresos
            FROM detalle_pedidos dp
            INNER JOIN productos p ON dp.producto_id = p.id
            INNER JOIN pedidos ped ON dp.pedido_id = ped.id
            WHERE DATE(ped.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND ped.estado_pedido_id IN (2,3,4,5)
            GROUP BY p.id, p.nombre, p.stock
            ORDER BY vendidos DESC
            LIMIT 10
        ")->fetchAll(PDO::FETCH_ASSOC);

        $datosTabla = [];
        foreach ($masVendidos as $prod) {
            $datosTabla[] = [
                $prod['nombre'],
                $prod['stock'],
                $prod['vendidos'],
                '$' . number_format($prod['ingresos'], 0, ',', '.')
            ];
        }

        $tablas = [
            [
                'titulo' => '🏆 Productos Más Vendidos',
                'columnas' => ['Producto', 'Stock Actual', 'Unidades Vendidas', 'Ingresos'],
                'datos' => $datosTabla
            ]
        ];

        return [
            'estadisticas' => $estadisticas,
            'graficos' => [],
            'tablas' => $tablas
        ];
    }

    /**
     * Reporte de clientes
     */
    private function reporteClientes($fechaInicio, $fechaFin) {
        $conn = Database::getConnection();

        $totalClientes = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'cliente'")->fetch(PDO::FETCH_ASSOC)['total'];
        $clientesActivos = $conn->query("
            SELECT COUNT(DISTINCT usuario_id) as total 
            FROM pedidos 
            WHERE DATE(fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
        ")->fetch(PDO::FETCH_ASSOC)['total'];

        $estadisticas = [
            [
                'titulo' => 'Total Clientes',
                'valor' => $totalClientes,
                'icono' => 'ti-user',
                'color' => 'purple'
            ],
            [
                'titulo' => 'Clientes Activos',
                'valor' => $clientesActivos,
                'icono' => 'ti-check',
                'color' => 'green'
            ]
        ];

        // Top clientes
        $topClientes = $conn->query("
            SELECT 
                CONCAT(u.nombre, ' ', u.apellido) as cliente,
                COUNT(p.id) as pedidos,
                SUM(p.total) as total_gastado
            FROM pedidos p
            INNER JOIN usuarios u ON p.usuario_id = u.id
            WHERE DATE(p.fecha_pedido) BETWEEN '$fechaInicio' AND '$fechaFin'
            AND p.estado_pedido_id IN (2,3,4,5)
            GROUP BY u.id, u.nombre, u.apellido
            ORDER BY total_gastado DESC
            LIMIT 20
        ")->fetchAll(PDO::FETCH_ASSOC);

        $datosTabla = [];
        foreach ($topClientes as $cliente) {
            $datosTabla[] = [
                $cliente['cliente'],
                $cliente['pedidos'],
                '$' . number_format($cliente['total_gastado'], 0, ',', '.')
            ];
        }

        $tablas = [
            [
                'titulo' => '👑 Top Clientes',
                'columnas' => ['Cliente', 'Pedidos', 'Total Gastado'],
                'datos' => $datosTabla
            ]
        ];

        return [
            'estadisticas' => $estadisticas,
            'graficos' => [],
            'tablas' => $tablas
        ];
    }

    /**
     * Reporte de inventario
     */
    private function reporteInventario($fechaInicio, $fechaFin) {
        $conn = Database::getConnection();

        $stockBajo = $conn->query("
            SELECT 
                p.nombre,
                p.stock,
                c.nombre as categoria,
                m.nombre as marca
            FROM productos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            LEFT JOIN marcas m ON p.marca_id = m.id
            WHERE p.stock < 5 
            AND p.estado = 'activo'
            ORDER BY p.stock ASC
        ")->fetchAll(PDO::FETCH_ASSOC);

        $datosTabla = [];
        foreach ($stockBajo as $prod) {
            $datosTabla[] = [
                $prod['nombre'],
                $prod['categoria'] ?? 'Sin categoría',
                $prod['marca'] ?? 'Sin marca',
                $prod['stock']
            ];
        }

        $totalProductos = $conn->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'activo'")->fetch(PDO::FETCH_ASSOC)['total'];
        $stockBajoCount = count($stockBajo);

        $estadisticas = [
            [
                'titulo' => 'Total Productos',
                'valor' => $totalProductos,
                'icono' => 'ti-package',
                'color' => 'purple'
            ],
            [
                'titulo' => 'Productos con Stock Bajo',
                'valor' => $stockBajoCount,
                'icono' => 'ti-alert',
                'color' => 'orange'
            ]
        ];

        $tablas = [
            [
                'titulo' => '⚠️ Productos con Stock Bajo (< 5 unidades)',
                'columnas' => ['Producto', 'Categoría', 'Marca', 'Stock'],
                'datos' => $datosTabla
            ]
        ];

        return [
            'estadisticas' => $estadisticas,
            'graficos' => [],
            'tablas' => $tablas
        ];
    }

    /**
     * Exportar reporte
     */
    public function exportarReporte() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
            header('Location: login');
            exit;
        }

        $formato = $_GET['formato'] ?? 'excel';
        $tipo = $_GET['tipo'] ?? 'general';
        $fechaInicio = $_GET['inicio'] ?? date('Y-m-01');
        $fechaFin = $_GET['fin'] ?? date('Y-m-d');

        $reporte = $this->generarReporte($tipo, $fechaInicio, $fechaFin);

        if ($formato === 'excel') {
            $this->exportarExcel($reporte, $tipo, $fechaInicio, $fechaFin);
        } elseif ($formato === 'pdf') {
            $this->exportarPDF($reporte, $tipo, $fechaInicio, $fechaFin);
        }
    }

    /**
     * Exportar a Excel (CSV)
     */
    private function exportarExcel($reporte, $tipo, $fechaInicio, $fechaFin) {
        $filename = "reporte_{$tipo}_" . date('Y-m-d_His') . ".csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename={$filename}");
        
        $output = fopen('php://output', 'w');
        
        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Encabezado
        fputcsv($output, ['REPORTE: ' . strtoupper($tipo)]);
        fputcsv($output, ['Período: ' . $fechaInicio . ' al ' . $fechaFin]);
        fputcsv($output, ['Generado: ' . date('Y-m-d H:i:s')]);
        fputcsv($output, []);
        
        // Estadísticas
        fputcsv($output, ['ESTADÍSTICAS']);
        foreach ($reporte['estadisticas'] as $stat) {
            fputcsv($output, [$stat['titulo'], $stat['valor']]);
        }
        fputcsv($output, []);
        
        // Tablas
        foreach ($reporte['tablas'] as $tabla) {
            fputcsv($output, [$tabla['titulo']]);
            fputcsv($output, $tabla['columnas']);
            foreach ($tabla['datos'] as $fila) {
                fputcsv($output, $fila);
            }
            fputcsv($output, []);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Exportar a PDF (HTML básico)
     */
    private function exportarPDF($reporte, $tipo, $fechaInicio, $fechaFin) {
        $filename = "reporte_{$tipo}_" . date('Y-m-d_His') . ".html";
        
        header('Content-Type: text/html; charset=utf-8');
        header("Content-Disposition: attachment; filename={$filename}");
        
        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte ' . strtoupper($tipo) . '</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                h1 { color: #667eea; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background-color: #667eea; color: white; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0; }
                .stat-card { background: #f8f9fa; padding: 20px; border-radius: 8px; }
                .stat-card h3 { margin: 0; font-size: 32px; color: #667eea; }
                .stat-card p { margin: 10px 0 0 0; color: #666; }
            </style>
        </head>
        <body>
            <h1>REPORTE: ' . strtoupper($tipo) . '</h1>
            <p><strong>Período:</strong> ' . $fechaInicio . ' al ' . $fechaFin . '</p>
            <p><strong>Generado:</strong> ' . date('Y-m-d H:i:s') . '</p>
            
            <h2>Estadísticas</h2>
            <div class="stats">';
        
        foreach ($reporte['estadisticas'] as $stat) {
            echo '<div class="stat-card">
                    <h3>' . htmlspecialchars($stat['valor']) . '</h3>
                    <p>' . htmlspecialchars($stat['titulo']) . '</p>
                  </div>';
        }
        
        echo '</div>';
        
        foreach ($reporte['tablas'] as $tabla) {
            echo '<h2>' . htmlspecialchars($tabla['titulo']) . '</h2>';
            echo '<table>';
            echo '<thead><tr>';
            foreach ($tabla['columnas'] as $col) {
                echo '<th>' . htmlspecialchars($col) . '</th>';
            }
            echo '</tr></thead><tbody>';
            foreach ($tabla['datos'] as $fila) {
                echo '<tr>';
                foreach ($fila as $valor) {
                    echo '<td>' . htmlspecialchars($valor) . '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        
        echo '</body></html>';
        exit;
    }


    /**
     * Mostrar página de desencriptación
     */
    public function desencriptar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('Location: login');
            exit();
        }

        $rol = $_SESSION['rol'] ?? '';
        if ($rol !== 'administrador' && $rol !== 'empleado') {
            header('Location: /');
            exit();
        }

        include __DIR__ . '/../Views/admin/desencriptar.php';
    }

    /**
     * API para desencriptar datos
     */
    public function desencriptarApi() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        $rol = $_SESSION['rol'] ?? '';
        if ($rol !== 'administrador' && $rol !== 'empleado') {
            echo json_encode(['success' => false, 'message' => 'No autorizado']);
            return;
        }

        try {
            require_once __DIR__ . '/../../config/whatsapp.php';
            
            $datosEncriptados = $_POST['datos'] ?? '';
            
            if (empty($datosEncriptados)) {
                echo json_encode(['success' => false, 'message' => 'No se recibieron datos']);
                return;
            }

            $datosDesencriptados = desencriptarDatos($datosEncriptados);

            if ($datosDesencriptados === false || empty($datosDesencriptados)) {
                echo json_encode(['success' => false, 'message' => 'Error al desencriptar. Verifica que los datos sean correctos.']);
                return;
            }

            echo json_encode([
                'success' => true,
                'datos' => $datosDesencriptados
            ]);

        } catch (Exception $e) {
            error_log("Error al desencriptar: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error al procesar los datos']);
        }
    }
}

