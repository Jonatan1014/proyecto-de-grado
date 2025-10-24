<?php
// src/app/Controllers/ProductoController.php

require_once __DIR__ . '/../Models/Producto.php';
require_once __DIR__ . '/../Utils/Helpers.php';
require_once __DIR__ . '/../../config/database.php';

class ProductoController {

    /**
     * Mostrar página de inicio con productos destacados
     */
    public function index() {
        try {
            $productosDestacados = Producto::obtenerDestacados(8);
            $productosNuevos = Producto::obtenerTodos(8);
            $productosOferta = Producto::obtenerEnOferta(4);

            // Pasar los datos a la vista
            $data = [
                'productosDestacados' => $productosDestacados,
                'productosNuevos' => $productosNuevos,
                'productosOferta' => $productosOferta
            ];

            // Extraer variables para usar en la vista
            extract($data);

            // Cargar la vista home
            include __DIR__ . '/../Views/home.php';
        } catch (Exception $e) {
            error_log("Error en ProductoController::index: " . $e->getMessage());
            header('Location: 404');
            exit();
        }
    }

    /**
     * Mostrar todos los productos (catálogo)
     */
    public function catalogo() {
        try {
            require_once __DIR__ . '/../Utils/Helpers.php';
            require_once __DIR__ . '/../Models/Categoria.php';
            require_once __DIR__ . '/../Models/Marca.php';
            
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $productosPorPagina = 12;
            $offset = ($pagina - 1) * $productosPorPagina;

            $filtros = [
                'categoria_id' => $_GET['categoria'] ?? null,
                'marca_id' => $_GET['marca'] ?? null,
                'genero_id' => $_GET['genero'] ?? null,
                'talla_id' => $_GET['talla'] ?? null,
                'color_id' => $_GET['color'] ?? null,
                'precio_min' => $_GET['precio_min'] ?? null,
                'precio_max' => $_GET['precio_max'] ?? null,
                'orden' => $_GET['orden'] ?? 'reciente',
                'busqueda' => $_GET['q'] ?? null
            ];

            $productos = Producto::obtenerPorFiltros($filtros, $productosPorPagina, $offset);
            $totalProductos = Producto::contarTotal($filtros);
            $totalPaginas = ceil($totalProductos / $productosPorPagina);

            // Obtener opciones para filtros con conteos
            $categorias = self::obtenerCategoriasConConteo($filtros);
            $marcas = self::obtenerMarcasConConteo($filtros);
            $generos = self::obtenerGenerosConConteo($filtros);
            $tallas = self::obtenerTallasConConteo($filtros);
            $colores = self::obtenerColoresConConteo($filtros);

            $data = [
                'productos' => $productos,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas,
                'totalProductos' => $totalProductos,
                'filtros' => $filtros,
                'categorias' => $categorias,
                'marcas' => $marcas,
                'generos' => $generos,
                'tallas' => $tallas,
                'colores' => $colores
            ];

            extract($data);

            include __DIR__ . '/../Views/category.php';
        } catch (Exception $e) {
            error_log("Error en ProductoController::catalogo: " . $e->getMessage());
            header('Location: 404');
            exit();
        }
    }

    /**
     * Obtener categorías con conteo de productos
     */
    private static function obtenerCategoriasConConteo($filtrosActuales) {
        $db = Database::getConnection();
        
        // Construir WHERE clause excluyendo categoría
        $where = ["p.estado = 'activo'"];
        $params = [];
        
        if (!empty($filtrosActuales['marca_id'])) {
            $where[] = "p.marca_id = :marca_id";
            $params[':marca_id'] = $filtrosActuales['marca_id'];
        }
        if (!empty($filtrosActuales['genero_id'])) {
            $where[] = "p.genero_id = :genero_id";
            $params[':genero_id'] = $filtrosActuales['genero_id'];
        }
        if (!empty($filtrosActuales['talla_id'])) {
            $where[] = "p.talla_id = :talla_id";
            $params[':talla_id'] = $filtrosActuales['talla_id'];
        }
        if (!empty($filtrosActuales['color_id'])) {
            $where[] = "p.color_id = :color_id";
            $params[':color_id'] = $filtrosActuales['color_id'];
        }
        if (!empty($filtrosActuales['precio_min'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) >= :precio_min";
            $params[':precio_min'] = $filtrosActuales['precio_min'];
        }
        if (!empty($filtrosActuales['precio_max'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) <= :precio_max";
            $params[':precio_max'] = $filtrosActuales['precio_max'];
        }
        if (!empty($filtrosActuales['busqueda'])) {
            $where[] = "(p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtrosActuales['busqueda'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT c.id, c.nombre, COUNT(p.id) as total_productos
                FROM categorias c
                LEFT JOIN productos p ON c.id = p.categoria_id AND $whereClause
                WHERE c.estado = 'activo'
                GROUP BY c.id, c.nombre
                ORDER BY c.nombre";
        
        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener marcas con conteo de productos
     */
    private static function obtenerMarcasConConteo($filtrosActuales) {
        $db = Database::getConnection();
        
        // Construir WHERE clause excluyendo marca
        $where = ["p.estado = 'activo'"];
        $params = [];
        
        if (!empty($filtrosActuales['categoria_id'])) {
            $where[] = "p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtrosActuales['categoria_id'];
        }
        if (!empty($filtrosActuales['genero_id'])) {
            $where[] = "p.genero_id = :genero_id";
            $params[':genero_id'] = $filtrosActuales['genero_id'];
        }
        if (!empty($filtrosActuales['talla_id'])) {
            $where[] = "p.talla_id = :talla_id";
            $params[':talla_id'] = $filtrosActuales['talla_id'];
        }
        if (!empty($filtrosActuales['color_id'])) {
            $where[] = "p.color_id = :color_id";
            $params[':color_id'] = $filtrosActuales['color_id'];
        }
        if (!empty($filtrosActuales['precio_min'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) >= :precio_min";
            $params[':precio_min'] = $filtrosActuales['precio_min'];
        }
        if (!empty($filtrosActuales['precio_max'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) <= :precio_max";
            $params[':precio_max'] = $filtrosActuales['precio_max'];
        }
        if (!empty($filtrosActuales['busqueda'])) {
            $where[] = "(p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtrosActuales['busqueda'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT m.id, m.nombre, COUNT(p.id) as total_productos
                FROM marcas m
                LEFT JOIN productos p ON m.id = p.marca_id AND $whereClause
                WHERE m.estado = 'activo'
                GROUP BY m.id, m.nombre
                HAVING COUNT(p.id) > 0
                ORDER BY m.nombre";
        
        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener géneros con conteo de productos
     */
    private static function obtenerGenerosConConteo($filtrosActuales) {
        $db = Database::getConnection();
        
        // Construir WHERE clause excluyendo género
        $where = ["p.estado = 'activo'"];
        $params = [];
        
        if (!empty($filtrosActuales['categoria_id'])) {
            $where[] = "p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtrosActuales['categoria_id'];
        }
        if (!empty($filtrosActuales['marca_id'])) {
            $where[] = "p.marca_id = :marca_id";
            $params[':marca_id'] = $filtrosActuales['marca_id'];
        }
        if (!empty($filtrosActuales['talla_id'])) {
            $where[] = "p.talla_id = :talla_id";
            $params[':talla_id'] = $filtrosActuales['talla_id'];
        }
        if (!empty($filtrosActuales['color_id'])) {
            $where[] = "p.color_id = :color_id";
            $params[':color_id'] = $filtrosActuales['color_id'];
        }
        if (!empty($filtrosActuales['precio_min'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) >= :precio_min";
            $params[':precio_min'] = $filtrosActuales['precio_min'];
        }
        if (!empty($filtrosActuales['precio_max'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) <= :precio_max";
            $params[':precio_max'] = $filtrosActuales['precio_max'];
        }
        if (!empty($filtrosActuales['busqueda'])) {
            $where[] = "(p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtrosActuales['busqueda'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT g.id, g.nombre, COUNT(p.id) as total_productos
                FROM generos g
                LEFT JOIN productos p ON g.id = p.genero_id AND $whereClause
                WHERE g.estado = 'activo'
                GROUP BY g.id, g.nombre
                HAVING COUNT(p.id) > 0
                ORDER BY g.nombre";
        
        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener tallas con conteo de productos
     */
    private static function obtenerTallasConConteo($filtrosActuales) {
        $db = Database::getConnection();
        
        // Construir WHERE clause excluyendo talla
        $where = ["p.estado = 'activo'"];
        $params = [];
        
        if (!empty($filtrosActuales['categoria_id'])) {
            $where[] = "p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtrosActuales['categoria_id'];
        }
        if (!empty($filtrosActuales['marca_id'])) {
            $where[] = "p.marca_id = :marca_id";
            $params[':marca_id'] = $filtrosActuales['marca_id'];
        }
        if (!empty($filtrosActuales['genero_id'])) {
            $where[] = "p.genero_id = :genero_id";
            $params[':genero_id'] = $filtrosActuales['genero_id'];
        }
        if (!empty($filtrosActuales['color_id'])) {
            $where[] = "p.color_id = :color_id";
            $params[':color_id'] = $filtrosActuales['color_id'];
        }
        if (!empty($filtrosActuales['precio_min'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) >= :precio_min";
            $params[':precio_min'] = $filtrosActuales['precio_min'];
        }
        if (!empty($filtrosActuales['precio_max'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) <= :precio_max";
            $params[':precio_max'] = $filtrosActuales['precio_max'];
        }
        if (!empty($filtrosActuales['busqueda'])) {
            $where[] = "(p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtrosActuales['busqueda'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT t.id, t.nombre, COUNT(p.id) as total_productos
                FROM tallas t
                LEFT JOIN productos p ON t.id = p.talla_id AND $whereClause
                WHERE t.estado = 'activo'
                GROUP BY t.id, t.nombre
                HAVING COUNT(p.id) > 0
                ORDER BY CAST(t.nombre AS UNSIGNED), t.nombre";
        
        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener colores con conteo de productos
     */
    private static function obtenerColoresConConteo($filtrosActuales) {
        $db = Database::getConnection();
        
        // Construir WHERE clause excluyendo color
        $where = ["p.estado = 'activo'"];
        $params = [];
        
        if (!empty($filtrosActuales['categoria_id'])) {
            $where[] = "p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtrosActuales['categoria_id'];
        }
        if (!empty($filtrosActuales['marca_id'])) {
            $where[] = "p.marca_id = :marca_id";
            $params[':marca_id'] = $filtrosActuales['marca_id'];
        }
        if (!empty($filtrosActuales['genero_id'])) {
            $where[] = "p.genero_id = :genero_id";
            $params[':genero_id'] = $filtrosActuales['genero_id'];
        }
        if (!empty($filtrosActuales['talla_id'])) {
            $where[] = "p.talla_id = :talla_id";
            $params[':talla_id'] = $filtrosActuales['talla_id'];
        }
        if (!empty($filtrosActuales['precio_min'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) >= :precio_min";
            $params[':precio_min'] = $filtrosActuales['precio_min'];
        }
        if (!empty($filtrosActuales['precio_max'])) {
            $where[] = "COALESCE(p.precio_oferta, p.precio) <= :precio_max";
            $params[':precio_max'] = $filtrosActuales['precio_max'];
        }
        if (!empty($filtrosActuales['busqueda'])) {
            $where[] = "(p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtrosActuales['busqueda'] . '%';
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT c.id, c.nombre, c.codigo_hex, COUNT(p.id) as total_productos
                FROM colores c
                LEFT JOIN productos p ON c.id = p.color_id AND $whereClause
                WHERE c.estado = 'activo'
                GROUP BY c.id, c.nombre, c.codigo_hex
                HAVING COUNT(p.id) > 0
                ORDER BY c.nombre";
        
        $stmt = $db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener lista de géneros
     */
    private static function obtenerGeneros() {
        $db = Database::getConnection();
        $sql = "SELECT id, nombre FROM generos WHERE estado = 'activo' ORDER BY nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener lista de tallas
     */
    private static function obtenerTallas() {
        $db = Database::getConnection();
        $sql = "SELECT id, nombre FROM tallas WHERE estado = 'activo' ORDER BY nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener lista de colores
     */
    private static function obtenerColores() {
        $db = Database::getConnection();
        $sql = "SELECT id, nombre, codigo_hex FROM colores WHERE estado = 'activo' ORDER BY nombre";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mostrar detalle de un producto
     */
    public function detalle() {
        try {
            error_log("=== INICIO ProductoController::detalle ===");
            
            $id = $_GET['id'] ?? null;
            error_log("ID recibido: " . ($id ?? 'NULL'));

            if (!$id) {
                error_log("ERROR: No se proporcionó ID de producto");
                header('Location: 404');
                exit();
            }

            error_log("Intentando obtener producto con ID: " . $id);
            $producto = Producto::obtenerPorId($id);

            if (!$producto) {
                error_log("ERROR: Producto no encontrado con ID: " . $id);
                header('Location: 404');
                exit();
            }

            error_log("Producto encontrado: " . $producto['nombre']);
            error_log("Categoría ID: " . ($producto['categoria_id'] ?? 'NULL'));

            error_log("Obteniendo imágenes del producto...");
            $imagenes = Producto::obtenerImagenes($id);
            error_log("Total de imágenes encontradas: " . count($imagenes));

            error_log("Obteniendo productos relacionados...");
            $productosRelacionados = Producto::obtenerRelacionados(
                $id,
                $producto['categoria_id'],
                4
            );
            error_log("Total de productos relacionados: " . count($productosRelacionados));

            $data = [
                'producto' => $producto,
                'imagenes' => $imagenes,
                'productosRelacionados' => $productosRelacionados
            ];

            extract($data);

            $vistaPath = __DIR__ . '/../Views/producto-detalle.php';
            error_log("Intentando cargar vista: " . $vistaPath);
            error_log("¿Vista existe?: " . (file_exists($vistaPath) ? 'SÍ' : 'NO'));

            if (!file_exists($vistaPath)) {
                error_log("ERROR CRÍTICO: La vista producto-detalle.php no existe!");
                error_log("Buscando vista alternativa single-product.php...");
                $vistaAlternativa = __DIR__ . '/../Views/single-product.php';
                if (file_exists($vistaAlternativa)) {
                    error_log("Vista alternativa encontrada: single-product.php");
                    include $vistaAlternativa;
                } else {
                    error_log("ERROR: Ninguna vista de detalle encontrada");
                    throw new Exception("Vista de detalle no encontrada");
                }
            } else {
                error_log("Cargando vista producto-detalle.php");
                include $vistaPath;
            }
            
            error_log("=== FIN ProductoController::detalle ===");
        } catch (Exception $e) {
            error_log("ERROR en ProductoController::detalle: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            header('Location: 404');
            exit();
        }
    }

    /**
     * Buscar productos
     */
    public function buscar() {
        try {
            $termino = $_GET['q'] ?? '';
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $productosPorPagina = 12;
            $offset = ($pagina - 1) * $productosPorPagina;

            if (empty($termino)) {
                header('Location: category');
                exit();
            }

            $productos = Producto::buscar($termino, $productosPorPagina, $offset);
            $totalProductos = count(Producto::buscar($termino));
            $totalPaginas = ceil($totalProductos / $productosPorPagina);

            $data = [
                'productos' => $productos,
                'terminoBusqueda' => $termino,
                'paginaActual' => $pagina,
                'totalPaginas' => $totalPaginas,
                'totalProductos' => $totalProductos
            ];

            extract($data);

            include __DIR__ . '/../Views/category.php';
        } catch (Exception $e) {
            error_log("Error en ProductoController::buscar: " . $e->getMessage());
            header('Location: 404');
            exit();
        }
    }

    /**
     * API: Obtener productos en formato JSON
     */
    public function apiObtenerProductos() {
        header('Content-Type: application/json');

        try {
            $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
            $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
            $destacados = isset($_GET['destacados']) ? (bool)$_GET['destacados'] : false;

            if ($destacados) {
                $productos = Producto::obtenerDestacados($limite);
            } else {
                $productos = Producto::obtenerTodos($limite, $offset);
            }

            echo json_encode([
                'success' => true,
                'data' => $productos,
                'total' => count($productos)
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener productos',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * API: Obtener un producto por ID
     */
    public function apiObtenerProducto() {
        header('Content-Type: application/json');

        try {
            $id = $_GET['id'] ?? null;

            if (!$id) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de producto requerido'
                ]);
                return;
            }

            $producto = Producto::obtenerPorId($id);

            if (!$producto) {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ]);
                return;
            }

            echo json_encode([
                'success' => true,
                'data' => $producto
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener el producto',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * API: Verificar disponibilidad de stock
     */
    public function apiVerificarStock() {
        header('Content-Type: application/json');

        try {
            $productoId = $_POST['producto_id'] ?? null;
            $cantidad = $_POST['cantidad'] ?? 1;

            if (!$productoId) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de producto requerido'
                ]);
                return;
            }

            $disponible = Producto::verificarStock($productoId, $cantidad);

            echo json_encode([
                'success' => true,
                'disponible' => $disponible
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Error al verificar stock',
                'error' => $e->getMessage()
            ]);
        }
    }
}