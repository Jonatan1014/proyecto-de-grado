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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías - Admin</title>

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

    /* Sidebar */
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

    .categoria-card {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .categoria-card:hover {
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    }

    .categoria-imagen {
        width: 80px;
        height: 80px;
        border-radius: 8px;
        object-fit: cover;
    }

    .categoria-info {
        flex: 1;
    }

    .categoria-nombre {
        font-size: 18px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .categoria-descripcion {
        color: #6c757d;
        font-size: 14px;
    }

    .categoria-actions {
        display: flex;
        gap: 10px;
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
            <li><a href="admin-productos"><i class="ti-package"></i> Productos</a></li>
            <li><a href="admin-categorias" class="active"><i class="ti-folder"></i> Categorías</a></li>
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
                <h2>Gestión de Categorías</h2>
            </div>
        </div>

        <div class="content-area">
            <div class="row">
                <!-- Lista de Categorías -->
                <div class="col-lg-8">
                    <div class="content-card">
                        <div class="card-title">
                            <span>Categorías Registradas (<?php echo count($categorias ?? []); ?>)</span>
                        </div>

                        <div id="listaCategorias">
                            <?php if (empty($categorias)): ?>
                            <div class="alert alert-info">
                                <i class="ti-info-alt mr-2"></i>
                                No hay categorías registradas. Agrega la primera categoría.
                            </div>
                            <?php else: ?>
                            <?php foreach ($categorias as $cat): ?>
                            <div class="categoria-card">
                                <?php if ($cat['imagen']): ?>
                                <img src="img/product/<?php echo htmlspecialchars($cat['imagen']); ?>"
                                    alt="<?php echo htmlspecialchars($cat['nombre']); ?>" class="categoria-imagen">
                                <?php else: ?>
                                <div class="categoria-imagen"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    <i class="ti-folder"></i>
                                </div>
                                <?php endif; ?>

                                <div class="categoria-info">
                                    <div class="categoria-nombre"><?php echo htmlspecialchars($cat['nombre']); ?></div>
                                    <div class="categoria-descripcion">
                                        <?php echo htmlspecialchars($cat['descripcion'] ?? 'Sin descripción'); ?>
                                    </div>
                                    <div class="mt-2">
                                        <span
                                            class="badge badge-<?php echo $cat['estado'] === 'activo' ? 'success' : 'secondary'; ?>">
                                            <?php echo ucfirst($cat['estado']); ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="categoria-actions">
                                    <button class="btn btn-sm btn-warning"
                                        onclick="editarCategoria(<?php echo htmlspecialchars(json_encode($cat)); ?>)">
                                        <i class="ti-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="eliminarCategoria(<?php echo $cat['id']; ?>)">
                                        <i class="ti-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Formulario Nueva/Editar Categoría -->
                <div class="col-lg-4">
                    <div class="content-card">
                        <div class="card-title">
                            <span id="formTitle">Nueva Categoría</span>
                        </div>

                        <form id="formCategoria" enctype="multipart/form-data">
                            <input type="hidden" id="categoria_id" name="id">

                            <div class="form-group">
                                <label for="nombre">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Imagen</label>
                                <div class="image-upload-preview" onclick="document.getElementById('imagen').click()">
                                    <img id="preview_imagen" style="display:none">
                                    <span id="placeholder_imagen">
                                        <i class="ti-camera" style="font-size: 48px; color: #ddd;"></i>
                                    </span>
                                </div>
                                <input type="file" id="imagen" name="imagen" accept="image/*" style="display:none"
                                    onchange="previewImage(this)">
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary-custom btn-block">
                                <i class="ti-save mr-2"></i>
                                <span id="btnText">Guardar Categoría</span>
                            </button>

                            <button type="button" class="btn btn-secondary btn-block" onclick="limpiarFormulario()"
                                style="display:none" id="btnCancelar">
                                <i class="ti-close mr-2"></i>
                                Cancelar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>

    <script>
    // Preview de imagen
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview_imagen').src = e.target.result;
                document.getElementById('preview_imagen').style.display = 'block';
                document.getElementById('placeholder_imagen').style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Guardar categoría
    document.getElementById('formCategoria').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('admin-categorias-api', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Categoría guardada exitosamente');
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'No se pudo guardar la categoría'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la categoría');
            });
    });

    // Editar categoría
    function editarCategoria(categoria) {
        document.getElementById('formTitle').textContent = 'Editar Categoría';
        document.getElementById('btnText').textContent = 'Actualizar Categoría';
        document.getElementById('btnCancelar').style.display = 'block';

        document.getElementById('categoria_id').value = categoria.id;
        document.getElementById('nombre').value = categoria.nombre;
        document.getElementById('descripcion').value = categoria.descripcion || '';
        document.getElementById('estado').value = categoria.estado;

        if (categoria.imagen) {
            document.getElementById('preview_imagen').src = 'img/product/' + categoria.imagen;
            document.getElementById('preview_imagen').style.display = 'block';
            document.getElementById('placeholder_imagen').style.display = 'none';
        }

        // Scroll al formulario
        document.getElementById('formCategoria').scrollIntoView({
            behavior: 'smooth'
        });
    }

    // Eliminar categoría
    function eliminarCategoria(id) {
        if (!confirm('¿Estás seguro de eliminar esta categoría?')) {
            return;
        }

        fetch('admin-categorias-api?action=eliminar&id=' + id, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Categoría eliminada');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar la categoría');
            });
    }

    // Limpiar formulario
    function limpiarFormulario() {
        document.getElementById('formTitle').textContent = 'Nueva Categoría';
        document.getElementById('btnText').textContent = 'Guardar Categoría';
        document.getElementById('btnCancelar').style.display = 'none';

        document.getElementById('formCategoria').reset();
        document.getElementById('categoria_id').value = '';
        document.getElementById('preview_imagen').style.display = 'none';
        document.getElementById('placeholder_imagen').style.display = 'block';
    }
    </script>
</body>

</html>