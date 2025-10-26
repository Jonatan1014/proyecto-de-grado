<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar autenticación y rol
if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['user']['rol'], ['administrador', 'empleado'])) {
    header('Location: login');
    exit;
}

$usuario = $_SESSION['user'];
$action = $_GET['action'] ?? 'listar';
$productoId = $_GET['id'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Admin</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/themify-icons.css">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f5f5;
    }

    /* Sidebar - Same as dashboard */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 260px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        overflow-y: auto;
        transition: all 0.3s;
        z-index: 1000;
    }

    .sidebar-header {
        padding: 25px 20px;
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-header h3 {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
    }

    .sidebar-menu {
        list-style: none;
        padding: 20px 0;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: white;
        text-decoration: none;
        transition: all 0.3s;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active {
        background: rgba(255, 255, 255, 0.1);
        border-left: 4px solid #ffba00;
    }

    .sidebar-menu i {
        margin-right: 12px;
        font-size: 18px;
        width: 20px;
    }

    .sidebar-footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        padding: 20px;
        background: rgba(0, 0, 0, 0.2);
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        min-height: 100vh;
    }

    .topbar {
        background: white;
        padding: 15px 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .topbar-left h2 {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .content-area {
        padding: 30px;
    }

    .content-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-custom {
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .product-image-preview {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
    }

    .badge-stock-low {
        background: #dc3545;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 11px;
    }

    .badge-stock-ok {
        background: #28a745;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 11px;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .image-upload-preview {
        width: 150px;
        height: 150px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        overflow: hidden;
    }

    .image-upload-preview:hover {
        border-color: #667eea;
    }

    .image-upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .search-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .search-bar input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .search-bar select {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h3><i class="ti-shopping-cart"></i> Tennis y Zapatos</h3>
            <p>Panel Administrativo</p>
        </div>

        <ul class="sidebar-menu">
            <li><a href="admin-dashboard"><i class="ti-dashboard"></i> Dashboard</a></li>
            <li><a href="admin-productos" class="active"><i class="ti-package"></i> Productos</a></li>
            <li><a href="admin-categorias"><i class="ti-folder"></i> Categorías</a></li>
            <li><a href="admin-marcas"><i class="ti-tag"></i> Marcas</a></li>
            <li><a href="admin-pedidos"><i class="ti-receipt"></i> Pedidos</a></li>
            <li><a href="admin-clientes"><i class="ti-user"></i> Clientes</a></li>
            <?php if ($usuario['rol'] === 'administrador'): ?>
            <li><a href="admin-usuarios"><i class="ti-id-badge"></i> Usuarios</a></li>
            <li><a href="admin-reportes"><i class="ti-bar-chart"></i> Reportes</a></li>
            <?php endif; ?>
            <li><a href="admin-configuracion"><i class="ti-settings"></i> Configuración</a></li>
        </ul>

        <div class="sidebar-footer">
            <a href="home" class="btn btn-light btn-sm btn-block mb-2">
                <i class="ti-world"></i> Ver Tienda
            </a>
            <a href="logout" class="btn btn-danger btn-sm btn-block">
                <i class="ti-power-off"></i> Cerrar Sesión
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <h2>Gestión de Productos</h2>
            </div>
        </div>

        <div class="content-area">
            <?php if ($action === 'listar'): ?>
            <!-- Lista de Productos -->
            <div class="content-card">
                <div class="card-title">
                    <span>Lista de Productos</span>
                    <a href="admin-productos?action=nuevo" class="btn btn-primary-custom">
                        <i class="ti-plus mr-2"></i>Nuevo Producto
                    </a>
                </div>

                <!-- Search and Filters -->
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Buscar productos..." class="form-control">
                    <select id="categoriaFilter" class="form-control">
                        <option value="">Todas las categorías</option>
                        <?php foreach ($categorias ?? [] as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>">
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <select id="estadoFilter" class="form-control">
                        <option value="">Todos los estados</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                    <button class="btn btn-primary-custom" onclick="buscarProductos()">
                        <i class="ti-search"></i> Buscar
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Imagen</th>
                                <th>Código SKU</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="productosTableBody">
                            <?php if (empty($productos)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No hay productos registrados
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($productos as $prod): ?>
                            <tr>
                                <td>
                                    <img src="img/product/<?php echo htmlspecialchars($prod['imagen_principal'] ?? 'default.jpg'); ?>"
                                        alt="Producto" class="product-image-preview">
                                </td>
                                <td><strong><?php echo htmlspecialchars($prod['codigo_sku']); ?></strong></td>
                                <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($prod['categoria_nombre']); ?></td>
                                <td>
                                    <?php if ($prod['precio_oferta']): ?>
                                    <del
                                        class="text-muted">$<?php echo number_format($prod['precio'], 0, ',', '.'); ?></del><br>
                                    <strong
                                        class="text-success">$<?php echo number_format($prod['precio_oferta'], 0, ',', '.'); ?></strong>
                                    <?php else: ?>
                                    <strong>$<?php echo number_format($prod['precio'], 0, ',', '.'); ?></strong>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($prod['stock'] <= $prod['stock_minimo']): ?>
                                    <span class="badge-stock-low"><?php echo $prod['stock']; ?> unidades</span>
                                    <?php else: ?>
                                    <span class="badge-stock-ok"><?php echo $prod['stock']; ?> unidades</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span
                                        class="badge badge-<?php echo $prod['estado'] === 'activo' ? 'success' : 'secondary'; ?>">
                                        <?php echo ucfirst($prod['estado']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admin-productos?action=editar&id=<?php echo $prod['id']; ?>"
                                        class="btn btn-sm btn-warning" title="Editar">
                                        <i class="ti-pencil"></i>
                                    </a>
                                    <button onclick="eliminarProducto(<?php echo $prod['id']; ?>)"
                                        class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php elseif ($action === 'nuevo' || $action === 'editar'): ?>
            <!-- Formulario Nuevo/Editar Producto -->
            <div class="content-card">
                <div class="card-title">
                    <span><?php echo $action === 'nuevo' ? 'Nuevo Producto' : 'Editar Producto'; ?></span>
                    <a href="admin-productos" class="btn btn-secondary">
                        <i class="ti-arrow-left mr-2"></i>Volver
                    </a>
                </div>

                <form id="formProducto" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $productoId; ?>">
                    <input type="hidden" name="action" value="<?php echo $action; ?>">

                    <div class="row">
                        <!-- Información Básica -->
                        <div class="col-md-8">
                            <h5 class="mb-3">Información Básica</h5>

                            <div class="form-group">
                                <label for="nombre">Nombre del Producto *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    value="<?php echo htmlspecialchars($producto['nombre'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion"
                                    rows="4"><?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo_sku">Código SKU *</label>
                                        <input type="text" class="form-control" id="codigo_sku" name="codigo_sku"
                                            value="<?php echo htmlspecialchars($producto['codigo_sku'] ?? ''); ?>"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="categoria_id">Categoría *</label>
                                        <select class="form-control" id="categoria_id" name="categoria_id" required>
                                            <option value="">Seleccionar categoría</option>
                                            <?php foreach ($categorias ?? [] as $cat): ?>
                                            <option value="<?php echo $cat['id']; ?>"
                                                <?php echo isset($producto['categoria_id']) && $producto['categoria_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($cat['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="marca_id">Marca</label>
                                        <select class="form-control" id="marca_id" name="marca_id">
                                            <option value="">Sin marca</option>
                                            <?php foreach ($marcas ?? [] as $marca): ?>
                                            <option value="<?php echo $marca['id']; ?>"
                                                <?php echo isset($producto['marca_id']) && $producto['marca_id'] == $marca['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($marca['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="talla_id">Talla</label>
                                        <select class="form-control" id="talla_id" name="talla_id">
                                            <option value="">Sin talla</option>
                                            <?php foreach ($tallas ?? [] as $talla): ?>
                                            <option value="<?php echo $talla['id']; ?>"
                                                <?php echo isset($producto['talla_id']) && $producto['talla_id'] == $talla['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($talla['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="color_id">Color</label>
                                        <select class="form-control" id="color_id" name="color_id">
                                            <option value="">Sin color</option>
                                            <?php foreach ($colores ?? [] as $color): ?>
                                            <option value="<?php echo $color['id']; ?>"
                                                <?php echo isset($producto['color_id']) && $producto['color_id'] == $color['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($color['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="genero_id">Género</label>
                                        <select class="form-control" id="genero_id" name="genero_id">
                                            <option value="">Sin especificar</option>
                                            <?php foreach ($generos ?? [] as $genero): ?>
                                            <option value="<?php echo $genero['id']; ?>"
                                                <?php echo isset($producto['genero_id']) && $producto['genero_id'] == $genero['id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($genero['nombre']); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="precio">Precio *</label>
                                        <input type="number" class="form-control" id="precio" name="precio" step="0.01"
                                            value="<?php echo $producto['precio'] ?? ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="precio_oferta">Precio Oferta</label>
                                        <input type="number" class="form-control" id="precio_oferta"
                                            name="precio_oferta" step="0.01"
                                            value="<?php echo $producto['precio_oferta'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock">Stock *</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            value="<?php echo $producto['stock'] ?? ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="stock_minimo">Stock Mínimo *</label>
                                        <input type="number" class="form-control" id="stock_minimo" name="stock_minimo"
                                            value="<?php echo $producto['stock_minimo'] ?? 5; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="destacado">Producto Destacado</label>
                                        <select class="form-control" id="destacado" name="destacado">
                                            <option value="0"
                                                <?php echo isset($producto['destacado']) && $producto['destacado'] == 0 ? 'selected' : ''; ?>>
                                                No</option>
                                            <option value="1"
                                                <?php echo isset($producto['destacado']) && $producto['destacado'] == 1 ? 'selected' : ''; ?>>
                                                Sí</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <select class="form-control" id="estado" name="estado">
                                            <option value="activo"
                                                <?php echo isset($producto['estado']) && $producto['estado'] == 'activo' ? 'selected' : ''; ?>>
                                                Activo</option>
                                            <option value="inactivo"
                                                <?php echo isset($producto['estado']) && $producto['estado'] == 'inactivo' ? 'selected' : ''; ?>>
                                                Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Imágenes -->
                        <div class="col-md-4">
                            <h5 class="mb-3">Imágenes del Producto</h5>

                            <div class="form-group">
                                <label>Imagen Principal *</label>
                                <div class="image-upload-preview"
                                    onclick="document.getElementById('imagen_principal').click()">
                                    <img id="preview_principal"
                                        src="<?php echo isset($producto['imagen_principal']) ? '../img/product/' . $producto['imagen_principal'] : ''; ?>"
                                        style="<?php echo !isset($producto['imagen_principal']) ? 'display:none' : ''; ?>">
                                    <span id="placeholder_principal"
                                        style="<?php echo isset($producto['imagen_principal']) ? 'display:none' : ''; ?>">
                                        <i class="ti-camera" style="font-size: 48px; color: #ddd;"></i>
                                    </span>
                                </div>
                                <input type="file" id="imagen_principal" name="imagen_principal" accept="image/*"
                                    style="display:none"
                                    onchange="previewImage(this, 'preview_principal', 'placeholder_principal')">
                            </div>

                            <?php for ($i = 2; $i <= 5; $i++): ?>
                            <div class="form-group">
                                <label>Imagen <?php echo $i; ?></label>
                                <div class="image-upload-preview"
                                    onclick="document.getElementById('imagen_<?php echo $i; ?>').click()"
                                    style="height: 100px; width: 100px;">
                                    <img id="preview_<?php echo $i; ?>"
                                        src="<?php echo isset($producto['imagen_' . $i]) ? '../img/product/' . $producto['imagen_' . $i] : ''; ?>"
                                        style="<?php echo !isset($producto['imagen_' . $i]) ? 'display:none' : ''; ?>">
                                    <span id="placeholder_<?php echo $i; ?>"
                                        style="<?php echo isset($producto['imagen_' . $i]) ? 'display:none' : ''; ?>">
                                        <i class="ti-camera" style="font-size: 24px; color: #ddd;"></i>
                                    </span>
                                </div>
                                <input type="file" id="imagen_<?php echo $i; ?>" name="imagen_<?php echo $i; ?>"
                                    accept="image/*" style="display:none"
                                    onchange="previewImage(this, 'preview_<?php echo $i; ?>', 'placeholder_<?php echo $i; ?>')">
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary-custom">
                            <i
                                class="ti-save mr-2"></i><?php echo $action === 'nuevo' ? 'Crear Producto' : 'Actualizar Producto'; ?>
                        </button>
                        <a href="admin-productos" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>

    <script>
    // Preview de imágenes
    function previewImage(input, previewId, placeholderId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
                document.getElementById(previewId).style.display = 'block';
                document.getElementById(placeholderId).style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Guardar producto
    document.getElementById('formProducto')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('admin-productos-api', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Producto guardado exitosamente');
                    window.location.href = 'admin-productos';
                } else {
                    alert('Error: ' + (data.message || 'No se pudo guardar el producto'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar el producto');
            });
    });

    // Eliminar producto
    function eliminarProducto(id) {
        if (!confirm('¿Estás seguro de eliminar este producto?')) {
            return;
        }

        fetch('admin-productos-api?action=eliminar&id=' + id, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Producto eliminado');
                    location.reload();
                } else {
                    alert('Error al eliminar: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el producto');
            });
    }

    // Buscar productos
    function buscarProductos() {
        const search = document.getElementById('searchInput').value;
        const categoria = document.getElementById('categoriaFilter').value;
        const estado = document.getElementById('estadoFilter').value;

        let url = 'admin-productos?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (categoria) url += 'categoria=' + categoria + '&';
        if (estado) url += 'estado=' + estado;

        window.location.href = url;
    }

    // Buscar al presionar Enter
    document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            buscarProductos();
        }
    });
    </script>
</body>

</html>