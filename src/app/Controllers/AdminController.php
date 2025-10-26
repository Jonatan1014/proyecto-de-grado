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
            
            $productos = Producto::obtenerTodos($search, $categoriaFilter, $estadoFilter);
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

    public function appsCalendar() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/apps-calendar.php';
    }

    public function appsTasks() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/apps-tasks.php';
    }

    public function pagesProfile() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-profile.php';
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
            $conexion = Conexion::obtenerConexion();
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
            $conexion = Conexion::obtenerConexion();
            
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
            $conexion = Conexion::obtenerConexion();
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
            $conexion = Conexion::obtenerConexion();
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
            $conexion = Conexion::obtenerConexion();
            
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
            $conexion = Conexion::obtenerConexion();
            $sql = "UPDATE marcas SET estado = 'inactivo' WHERE id = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return ['success' => true, 'message' => 'Marca eliminada'];
        } catch (Exception $e) {
            error_log("Error al eliminar marca: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al eliminar marca'];
        }
    }

}