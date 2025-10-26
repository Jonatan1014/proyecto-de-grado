<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar autenticación y rol ADMINISTRADOR
if (!isset($_SESSION['usuario_id']) || $_SESSION['user']['rol'] !== 'administrador') {
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
    <title>Gestión de Usuarios - Admin</title>
    
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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid;
        }

        .stat-card.total {
            border-left-color: #667eea;
        }

        .stat-card.administradores {
            border-left-color: #dc3545;
        }

        .stat-card.empleados {
            border-left-color: #28a745;
        }

        .stat-card.activos {
            border-left-color: #17a2b8;
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .usuarios-table {
            width: 100%;
            border-collapse: collapse;
        }

        .usuarios-table thead {
            background: #f8f9fa;
        }

        .usuarios-table th,
        .usuarios-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .usuarios-table tbody tr:hover {
            background: #f8f9fa;
        }

        .usuario-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: white;
        }

        .avatar-admin {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .avatar-empleado {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        }

        .rol-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .rol-administrador {
            background: #f8d7da;
            color: #721c24;
        }

        .rol-empleado {
            background: #d4edda;
            color: #155724;
        }

        .estado-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-activo {
            background: #d4edda;
            color: #155724;
        }

        .estado-inactivo {
            background: #f8d7da;
            color: #721c24;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: white;
            margin: 50px auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 30px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
        }

        .close-modal {
            font-size: 28px;
            font-weight: bold;
            color: white;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.2);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .close-modal:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filters-section {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            <li><a href="admin-categorias"><i class="ti-folder"></i> Categorías</a></li>
            <li><a href="admin-marcas"><i class="ti-tag"></i> Marcas</a></li>
            <li><a href="admin-pedidos"><i class="ti-receipt"></i> Pedidos</a></li>
            <li><a href="admin-clientes"><i class="ti-user"></i> Clientes</a></li>
            <li><a href="admin-usuarios" class="active"><i class="ti-id-badge"></i> Usuarios</a></li>
            <li><a href="admin-reportes"><i class="ti-bar-chart"></i> Reportes</a></li>
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
                <h2>Gestión de Usuarios del Sistema</h2>
            </div>
            <button class="btn btn-primary-custom" onclick="abrirModalNuevo()">
                <i class="ti-plus mr-2"></i> Nuevo Usuario
            </button>
        </div>

        <div class="content-area">
            <!-- Estadísticas -->
            <div class="stats-cards">
                <div class="stat-card total">
                    <div class="stat-label">Total Usuarios</div>
                    <div class="stat-value" id="stat-total">0</div>
                </div>
                <div class="stat-card administradores">
                    <div class="stat-label">Administradores</div>
                    <div class="stat-value" id="stat-admins">0</div>
                </div>
                <div class="stat-card empleados">
                    <div class="stat-label">Empleados</div>
                    <div class="stat-value" id="stat-empleados">0</div>
                </div>
                <div class="stat-card activos">
                    <div class="stat-label">Activos</div>
                    <div class="stat-value" id="stat-activos">0</div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="content-card">
                <div class="filters-section">
                    <div class="filter-group">
                        <label for="filtro-rol">Rol</label>
                        <select class="form-control" id="filtro-rol" onchange="filtrarUsuarios()">
                            <option value="">Todos</option>
                            <option value="administrador">Administradores</option>
                            <option value="empleado">Empleados</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtro-estado">Estado</label>
                        <select class="form-control" id="filtro-estado" onchange="filtrarUsuarios()">
                            <option value="">Todos</option>
                            <option value="activo">Activos</option>
                            <option value="inactivo">Inactivos</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtro-buscar">Buscar</label>
                        <input type="text" class="form-control" id="filtro-buscar"
                               placeholder="Nombre o email..."
                               onkeyup="filtrarUsuarios()">
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="content-card">
                <div class="card-title">
                    <span>Usuarios del Sistema (<span id="total-usuarios">0</span>)</span>
                </div>

                <div style="overflow-x: auto;">
                    <table class="usuarios-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Teléfono</th>
                                <th>Registro</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="usuarios-tbody">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="ti-reload" style="font-size: 48px; color: #ddd;"></i>
                                    <p style="color: #999; margin-top: 10px;">Cargando usuarios...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Nuevo/Editar Usuario -->
    <div id="modalUsuario" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title"><i class="ti-user mr-2"></i> Nuevo Usuario</h3>
                <span class="close-modal" onclick="cerrarModal()">&times;</span>
            </div>

            <div class="modal-body">
                <form id="formUsuario">
                    <input type="hidden" id="usuario_id" name="id">
                    
                    <div class="form-group">
                        <label for="nombre">Nombre *</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="apellido">Apellido *</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>

                    

                    <div class="form-group">
                        <label for="rol">Rol *</label>
                        <select class="form-control" id="rol" name="rol" required>
                            <option value="">Seleccione...</option>
                            <option value="administrador">Administrador</option>
                            <option value="empleado">Empleado</option>
                        </select>
                    </div>

                    <div class="form-group" id="password-group">
                        <label for="password">Contraseña *</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="text-muted">Mínimo 6 caracteres</small>
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
                        <span id="btn-text">Guardar Usuario</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    
    <script>
    let usuariosData = [];

    // Cargar usuarios al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        cargarUsuarios();
    });

    // Cargar todos los usuarios
    function cargarUsuarios() {
        fetch('admin-usuarios-api?action=listar')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    usuariosData = data.usuarios;
                    actualizarEstadisticas(data.usuarios);
                    mostrarUsuarios(data.usuarios);
                } else {
                    console.error('Error al cargar usuarios:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('usuarios-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #dc3545;">
                            <i class="ti-alert" style="font-size: 48px;"></i>
                            <p style="margin-top: 10px;">Error al cargar los usuarios</p>
                        </td>
                    </tr>
                `;
            });
    }

    // Actualizar estadísticas
    function actualizarEstadisticas(usuarios) {
        const total = usuarios.length;
        const admins = usuarios.filter(u => u.rol === 'administrador').length;
        const empleados = usuarios.filter(u => u.rol === 'empleado').length;
        const activos = usuarios.filter(u => u.estado === 'activo').length;

        document.getElementById('stat-total').textContent = total;
        document.getElementById('stat-admins').textContent = admins;
        document.getElementById('stat-empleados').textContent = empleados;
        document.getElementById('stat-activos').textContent = activos;
    }

    // Mostrar usuarios en la tabla
    function mostrarUsuarios(usuarios) {
        const tbody = document.getElementById('usuarios-tbody');
        
        if (usuarios.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <i class="ti-user" style="font-size: 48px; color: #ddd;"></i>
                        <p style="color: #999; margin-top: 10px;">No hay usuarios</p>
                    </td>
                </tr>
            `;
            document.getElementById('total-usuarios').textContent = '0';
            return;
        }

        let html = '';
        usuarios.forEach(usuario => {
            const iniciales = obtenerIniciales(usuario.nombre, usuario.apellido);
            const avatarClass = usuario.rol === 'administrador' ? 'avatar-admin' : 'avatar-empleado';
            const rolClass = usuario.rol === 'administrador' ? 'rol-administrador' : 'rol-empleado';
            const estadoClass = usuario.estado === 'activo' ? 'estado-activo' : 'estado-inactivo';
            const fechaRegistro = new Date(usuario.fecha_registro).toLocaleDateString('es-CO');
            
            html += `
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="usuario-avatar ${avatarClass}">${iniciales}</div>
                            <div>
                                <div style="font-weight: 600;">${usuario.nombre} ${usuario.apellido}</div>
                            </div>
                        </div>
                    </td>
                    <td>${usuario.email}</td>
                    <td><span class="rol-badge ${rolClass}">${usuario.rol}</span></td>
                    <td>${usuario.telefono || 'N/A'}</td>
                    <td>${fechaRegistro}</td>
                    <td><span class="estado-badge ${estadoClass}">${usuario.estado}</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarUsuario(${usuario.id})" title="Editar">
                            <i class="ti-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${usuario.id})" title="Eliminar">
                            <i class="ti-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('total-usuarios').textContent = usuarios.length;
    }

    // Obtener iniciales
    function obtenerIniciales(nombre, apellido) {
        const inicial1 = nombre ? nombre.charAt(0).toUpperCase() : '';
        const inicial2 = apellido ? apellido.charAt(0).toUpperCase() : '';
        return inicial1 + inicial2;
    }

    // Filtrar usuarios
    function filtrarUsuarios() {
        const rolFiltro = document.getElementById('filtro-rol').value;
        const estadoFiltro = document.getElementById('filtro-estado').value;
        const busqueda = document.getElementById('filtro-buscar').value.toLowerCase();

        let usuariosFiltrados = usuariosData.filter(usuario => {
            if (rolFiltro && usuario.rol !== rolFiltro) return false;
            if (estadoFiltro && usuario.estado !== estadoFiltro) return false;
            if (busqueda) {
                const texto = `${usuario.nombre} ${usuario.apellido} ${usuario.email}`.toLowerCase();
                if (!texto.includes(busqueda)) return false;
            }
            return true;
        });

        mostrarUsuarios(usuariosFiltrados);
    }

    // Abrir modal para nuevo usuario
    function abrirModalNuevo() {
        document.getElementById('modal-title').innerHTML = '<i class="ti-user mr-2"></i> Nuevo Usuario';
        document.getElementById('btn-text').textContent = 'Guardar Usuario';
        document.getElementById('formUsuario').reset();
        document.getElementById('usuario_id').value = '';
        document.getElementById('password').required = true;
        document.getElementById('password-group').querySelector('label').textContent = 'Contraseña *';
        document.getElementById('modalUsuario').style.display = 'block';
    }

    // Editar usuario
    function editarUsuario(id) {
        const usuario = usuariosData.find(u => u.id === id);
        if (!usuario) return;

        document.getElementById('modal-title').innerHTML = '<i class="ti-pencil mr-2"></i> Editar Usuario';
        document.getElementById('btn-text').textContent = 'Actualizar Usuario';
        
        document.getElementById('usuario_id').value = usuario.id;
        document.getElementById('nombre').value = usuario.nombre;
        document.getElementById('apellido').value = usuario.apellido;
        document.getElementById('email').value = usuario.email;
        document.getElementById('telefono').value = usuario.telefono || '';
        document.getElementById('rol').value = usuario.rol;
        document.getElementById('estado').value = usuario.estado;
        document.getElementById('password').value = '';
        document.getElementById('password').required = false;
        document.getElementById('password-group').querySelector('label').textContent = 'Contraseña (dejar en blanco para no cambiar)';
        
        document.getElementById('modalUsuario').style.display = 'block';
    }

    // Guardar usuario
    document.getElementById('formUsuario').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const usuarioId = document.getElementById('usuario_id').value;
        
        // Validar contraseña en nuevo usuario
        if (!usuarioId && formData.get('password').length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres');
            return;
        }
        
        fetch('admin-usuarios-api', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                cerrarModal();
                cargarUsuarios();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar el usuario');
        });
    });

    // Eliminar usuario
    function eliminarUsuario(id) {
        if (!confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')) {
            return;
        }
        
        fetch(`admin-usuarios-api?action=eliminar&id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Usuario eliminado correctamente');
                cargarUsuarios();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al eliminar el usuario');
        });
    }

    // Cerrar modal
    function cerrarModal() {
        document.getElementById('modalUsuario').style.display = 'none';
    }

    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modal = document.getElementById('modalUsuario');
        if (event.target === modal) {
            cerrarModal();
        }
    }
    </script>
</body>

</html>
