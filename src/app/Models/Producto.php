<?php
// src/app/Models/Producto.php

require_once __DIR__ . '/../../config/database.php';

class Producto {
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $precio_oferta;
    public $categoria_id;
    public $marca_id;
    public $stock;
    public $imagen_principal;
    public $destacado;
    public $estado;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
        $this->descripcion = $data['descripcion'] ?? null;
        $this->precio = $data['precio'];
        $this->precio_oferta = $data['precio_oferta'] ?? null;
        $this->categoria_id = $data['categoria_id'];
        $this->marca_id = $data['marca_id'] ?? null;
        $this->stock = $data['stock'] ?? 0;
        $this->imagen_principal = $data['imagen_principal'] ?? null;
        $this->destacado = $data['destacado'] ?? 0;
        $this->estado = $data['estado'] ?? 'activo';
    }

    /**
     * Obtener todos los productos activos
     */
    public static function obtenerTodos($limite = null, $offset = 0) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.estado = 'activo'
                ORDER BY p.fecha_creacion DESC";

        if ($limite !== null) {
            $sql .= " LIMIT :limite OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare($sql);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos destacados
     */
    public static function obtenerDestacados($limite = 8) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.estado = 'activo' AND p.destacado = 1
                ORDER BY p.fecha_creacion DESC
                LIMIT :limite";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener un producto por ID
     */
    public static function obtenerPorId($id) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.id = :id AND p.estado = 'activo'";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos por categoría
     */
    public static function obtenerPorCategoria($categoriaId, $limite = null, $offset = 0) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.estado = 'activo' AND p.categoria_id = :categoria_id
                ORDER BY p.fecha_creacion DESC";

        if ($limite !== null) {
            $sql .= " LIMIT :limite OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
            $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos en oferta
     */
    public static function obtenerEnOferta($limite = 8) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.estado = 'activo' AND p.precio_oferta IS NOT NULL AND p.precio_oferta > 0
                ORDER BY p.fecha_creacion DESC
                LIMIT :limite";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar productos
     */
    public static function buscar($termino, $limite = null, $offset = 0) {
        $db = Database::getConnection();
        $terminoBusqueda = "%{$termino}%";

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.estado = 'activo'
                AND (p.nombre LIKE :termino OR p.descripcion LIKE :termino OR m.nombre LIKE :termino)
                ORDER BY p.fecha_creacion DESC";

        if ($limite !== null) {
            $sql .= " LIMIT :limite OFFSET :offset";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':termino', $terminoBusqueda, PDO::PARAM_STR);
            $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':termino', $terminoBusqueda, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener imágenes del producto desde la tabla productos
     * @param int $productoId
     * @return array
     */
    public static function obtenerImagenes($productoId) {
        $db = Database::getConnection();

        // Obtener solo las columnas de imagen del producto específico
        $sql = "SELECT imagen_principal, imagen_2, imagen_3, imagen_4, imagen_5
                FROM productos
                WHERE id = :producto_id";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':producto_id', $productoId, PDO::PARAM_INT);
        $stmt->execute();

        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            return []; // Si no se encuentra el producto, devolver array vacío
        }

        // Filtrar las imágenes que existan (no nulas ni vacías) y construir un array
        // compatible con lo que espera la vista, si es necesario.
        // Suponiendo que la vista espera un array de arrays con una clave 'url'.
        $imagenes = [];
        for ($i = 1; $i <= 5; $i++) {
            $nombreCampo = ($i === 1) ? 'imagen_principal' : "imagen_$i";
            if (!empty($producto[$nombreCampo])) {
                // Opcional: puedes agregar un campo 'orden' si es relevante
                $imagenes[] = [
                    'url' => $producto[$nombreCampo],
                    'orden' => $i // Opcional
                ];
            }
        }

        return $imagenes; // Devuelve el array de imágenes con estructura ['url' => '...']
    }
    
    /**
     * Contar total de productos
     */
    public static function contarTotal($filtros = []) {
        $db = Database::getConnection();

        $sql = "SELECT COUNT(*) as total 
                FROM productos p
                LEFT JOIN marcas m ON p.marca_id = m.id
                WHERE p.estado = 'activo'";
        $params = [];

        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtros['categoria_id'];
        }

        if (!empty($filtros['marca_id'])) {
            $sql .= " AND p.marca_id = :marca_id";
            $params[':marca_id'] = $filtros['marca_id'];
        }

        if (!empty($filtros['genero_id'])) {
            $sql .= " AND p.genero_id = :genero_id";
            $params[':genero_id'] = $filtros['genero_id'];
        }

        if (!empty($filtros['talla_id'])) {
            $sql .= " AND p.talla_id = :talla_id";
            $params[':talla_id'] = $filtros['talla_id'];
        }

        if (!empty($filtros['color_id'])) {
            $sql .= " AND p.color_id = :color_id";
            $params[':color_id'] = $filtros['color_id'];
        }

        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda OR m.nombre LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtros['busqueda'] . '%';
        }

        if (!empty($filtros['precio_min'])) {
            $sql .= " AND p.precio >= :precio_min";
            $params[':precio_min'] = $filtros['precio_min'];
        }

        if (!empty($filtros['precio_max'])) {
            $sql .= " AND p.precio <= :precio_max";
            $params[':precio_max'] = $filtros['precio_max'];
        }

        $stmt = $db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total'];
    }

    /**
     * Verificar disponibilidad de stock
     */
    public static function verificarStock($productoId, $cantidad = 1) {
        $db = Database::getConnection();

        $sql = "SELECT stock FROM productos WHERE id = :id AND estado = 'activo'";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $productoId, PDO::PARAM_INT);
        $stmt->execute();
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$producto) {
            return false;
        }

        return $producto['stock'] >= $cantidad;
    }

    /**
     * Obtener productos relacionados (de la misma categoría)
     */
    public static function obtenerRelacionados($productoId, $categoriaId, $limite = 4) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                WHERE p.estado = 'activo'
                AND p.categoria_id = :categoria_id
                AND p.id != :id
                ORDER BY RAND()
                LIMIT :limite";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->bindValue(':id', $productoId, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos por filtros avanzados
     */
    public static function obtenerPorFiltros($filtros = [], $limite = null, $offset = 0) {
        $db = Database::getConnection();

        $sql = "SELECT p.*,
                       c.nombre as categoria_nombre,
                       m.nombre as marca_nombre,
                       t.nombre as talla_nombre,
                       co.nombre as color_nombre,
                       g.nombre as genero_nombre
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN marcas m ON p.marca_id = m.id
                LEFT JOIN tallas t ON p.talla_id = t.id
                LEFT JOIN colores co ON p.color_id = co.id
                LEFT JOIN generos g ON p.genero_id = g.id
                WHERE p.estado = 'activo'";

        $params = [];

        if (!empty($filtros['categoria_id'])) {
            $sql .= " AND p.categoria_id = :categoria_id";
            $params[':categoria_id'] = $filtros['categoria_id'];
        }

        if (!empty($filtros['marca_id'])) {
            $sql .= " AND p.marca_id = :marca_id";
            $params[':marca_id'] = $filtros['marca_id'];
        }

        if (!empty($filtros['genero_id'])) {
            $sql .= " AND p.genero_id = :genero_id";
            $params[':genero_id'] = $filtros['genero_id'];
        }

        if (!empty($filtros['talla_id'])) {
            $sql .= " AND p.talla_id = :talla_id";
            $params[':talla_id'] = $filtros['talla_id'];
        }

        if (!empty($filtros['color_id'])) {
            $sql .= " AND p.color_id = :color_id";
            $params[':color_id'] = $filtros['color_id'];
        }

        if (!empty($filtros['busqueda'])) {
            $sql .= " AND (p.nombre LIKE :busqueda OR p.descripcion LIKE :busqueda OR m.nombre LIKE :busqueda)";
            $params[':busqueda'] = '%' . $filtros['busqueda'] . '%';
        }

        if (!empty($filtros['precio_min'])) {
            $sql .= " AND p.precio >= :precio_min";
            $params[':precio_min'] = $filtros['precio_min'];
        }

        if (!empty($filtros['precio_max'])) {
            $sql .= " AND p.precio <= :precio_max";
            $params[':precio_max'] = $filtros['precio_max'];
        }

        if (!empty($filtros['orden'])) {
            switch ($filtros['orden']) {
                case 'precio_asc':
                    $sql .= " ORDER BY p.precio ASC";
                    break;
                case 'precio_desc':
                    $sql .= " ORDER BY p.precio DESC";
                    break;
                case 'nombre':
                    $sql .= " ORDER BY p.nombre ASC";
                    break;
                default:
                    $sql .= " ORDER BY p.fecha_creacion DESC";
            }
        } else {
            $sql .= " ORDER BY p.fecha_creacion DESC";
        }

        if ($limite !== null) {
            $sql .= " LIMIT :limite OFFSET :offset";
            $params[':limite'] = (int)$limite;
            $params[':offset'] = (int)$offset;
        }

        $stmt = $db->prepare($sql);

        foreach ($params as $key => $value) {
            if ($key === ':limite' || $key === ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crear un nuevo producto
     */
    public static function create($data) {
        $db = Database::getConnection();

        $sql = "INSERT INTO productos (nombre, descripcion, precio, precio_oferta, categoria_id, marca_id,
                talla_id, color_id, genero_id, stock, stock_minimo, codigo_sku, imagen_principal, destacado, estado)
                VALUES (:nombre, :descripcion, :precio, :precio_oferta, :categoria_id, :marca_id,
                :talla_id, :color_id, :genero_id, :stock, :stock_minimo, :codigo_sku, :imagen_principal, :destacado, :estado)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':precio' => $data['precio'],
            ':precio_oferta' => $data['precio_oferta'] ?? null,
            ':categoria_id' => $data['categoria_id'],
            ':marca_id' => $data['marca_id'] ?? null,
            ':talla_id' => $data['talla_id'] ?? null,
            ':color_id' => $data['color_id'] ?? null,
            ':genero_id' => $data['genero_id'] ?? null,
            ':stock' => $data['stock'] ?? 0,
            ':stock_minimo' => $data['stock_minimo'] ?? 5,
            ':codigo_sku' => $data['codigo_sku'],
            ':imagen_principal' => $data['imagen_principal'] ?? null,
            ':destacado' => $data['destacado'] ?? 0,
            ':estado' => $data['estado'] ?? 'activo'
        ]);

        return $db->lastInsertId();
    }

    /**
     * Actualizar producto
     */
    public static function update($id, $data) {
        $db = Database::getConnection();

        $sql = "UPDATE productos SET
                nombre = :nombre,
                descripcion = :descripcion,
                precio = :precio,
                precio_oferta = :precio_oferta,
                categoria_id = :categoria_id,
                marca_id = :marca_id,
                talla_id = :talla_id,
                color_id = :color_id,
                genero_id = :genero_id,
                stock = :stock,
                stock_minimo = :stock_minimo,
                codigo_sku = :codigo_sku,
                imagen_principal = :imagen_principal,
                destacado = :destacado,
                estado = :estado
                WHERE id = :id";

        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':precio' => $data['precio'],
            ':precio_oferta' => $data['precio_oferta'] ?? null,
            ':categoria_id' => $data['categoria_id'],
            ':marca_id' => $data['marca_id'] ?? null,
            ':talla_id' => $data['talla_id'] ?? null,
            ':color_id' => $data['color_id'] ?? null,
            ':genero_id' => $data['genero_id'] ?? null,
            ':stock' => $data['stock'] ?? 0,
            ':stock_minimo' => $data['stock_minimo'] ?? 5,
            ':codigo_sku' => $data['codigo_sku'],
            ':imagen_principal' => $data['imagen_principal'] ?? null,
            ':destacado' => $data['destacado'] ?? 0,
            ':estado' => $data['estado'] ?? 'activo'
        ]);
    }

    /**
     * Eliminar producto (cambiar estado a inactivo)
     */
    public static function delete($id) {
        $db = Database::getConnection();

        $sql = "UPDATE productos SET estado = 'inactivo' WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Verificar si un SKU ya existe
     */
    public static function skuExists($sku, $excludeId = null) {
        $db = Database::getConnection();

        if ($excludeId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM productos WHERE codigo_sku = :sku AND id != :id");
            $stmt->execute([':sku' => $sku, ':id' => $excludeId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM productos WHERE codigo_sku = :sku");
            $stmt->execute([':sku' => $sku]);
        }

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Actualizar stock de un producto
     */
    public static function actualizarStock($id, $cantidad, $operacion = 'sumar') {
        $db = Database::getConnection();

        if ($operacion === 'sumar') {
            $sql = "UPDATE productos SET stock = stock + :cantidad WHERE id = :id";
        } else {
            $sql = "UPDATE productos SET stock = stock - :cantidad WHERE id = :id AND stock >= :cantidad";
        }

        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id, ':cantidad' => $cantidad]);
    }
}