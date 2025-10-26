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
    <title>Gestión de Clientes - Admin</title>
    
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

        .stat-card.activos {
            border-left-color: #28a745;
        }

        .stat-card.nuevos {
            border-left-color: #17a2b8;
        }

        .stat-card.compras {
            border-left-color: #ffc107;
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

        .clientes-table {
            width: 100%;
            border-collapse: collapse;
        }

        .clientes-table thead {
            background: #f8f9fa;
        }

        .clientes-table th,
        .clientes-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .clientes-table tbody tr:hover {
            background: #f8f9fa;
            cursor: pointer;
        }

        .cliente-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
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

        .btn-custom {
            padding: 6px 15px;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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
            margin: 30px auto;
            padding: 0;
            border-radius: 12px;
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 22px;
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

        .cliente-detalle-header {
            display: flex;
            gap: 20px;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 25px;
        }

        .cliente-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 32px;
        }

        .cliente-info-header {
            flex: 1;
        }

        .cliente-nombre-grande {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .detalle-section {
            margin-bottom: 30px;
        }

        .detalle-section h4 {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }

        .detalle-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .detalle-item {
            display: flex;
            flex-direction: column;
        }

        .detalle-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .detalle-value {
            font-size: 15px;
            color: #333;
            font-weight: 600;
        }

        .direcciones-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .direccion-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }

        .direccion-principal {
            border-left-color: #28a745;
        }

        .direccion-nombre {
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .direccion-texto {
            color: #6c757d;
            font-size: 14px;
        }

        .pedidos-historial {
            max-height: 400px;
            overflow-y: auto;
        }

        .pedido-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pedido-info {
            flex: 1;
        }

        .pedido-numero {
            font-weight: 700;
            color: #333;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .pedido-fecha {
            font-size: 13px;
            color: #6c757d;
        }

        .pedido-total {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
        }

        .stats-cliente {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-cliente-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-cliente-value {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-cliente-label {
            font-size: 13px;
            color: #6c757d;
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
            <li><a href="admin-clientes" class="active"><i class="ti-user"></i> Clientes</a></li>
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
                <h2>Gestión de Clientes</h2>
            </div>
        </div>

        <div class="content-area">
            <!-- Estadísticas de clientes -->
            <div class="stats-cards">
                <div class="stat-card total">
                    <div class="stat-label">Total Clientes</div>
                    <div class="stat-value" id="stat-total">0</div>
                </div>
                <div class="stat-card activos">
                    <div class="stat-label">Clientes Activos</div>
                    <div class="stat-value" id="stat-activos">0</div>
                </div>
                <div class="stat-card nuevos">
                    <div class="stat-label">Nuevos (Este Mes)</div>
                    <div class="stat-value" id="stat-nuevos">0</div>
                </div>
                <div class="stat-card compras">
                    <div class="stat-label">Con Compras</div>
                    <div class="stat-value" id="stat-compras">0</div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="content-card">
                <div class="filters-section">
                    <div class="filter-group">
                        <label for="filtro-estado">Estado</label>
                        <select class="form-control" id="filtro-estado" onchange="filtrarClientes()">
                            <option value="">Todos</option>
                            <option value="activo">Activos</option>
                            <option value="inactivo">Inactivos</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtro-compras">Con Compras</label>
                        <select class="form-control" id="filtro-compras" onchange="filtrarClientes()">
                            <option value="">Todos</option>
                            <option value="si">Con compras</option>
                            <option value="no">Sin compras</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtro-buscar">Buscar</label>
                        <input type="text" class="form-control" id="filtro-buscar"
                               placeholder="Nombre, email o documento..."
                               onkeyup="filtrarClientes()">
                    </div>
                </div>
            </div>

            <!-- Tabla de clientes -->
            <div class="content-card">
                <div class="card-title">
                    <span>Lista de Clientes (<span id="total-clientes">0</span>)</span>
                </div>

                <div style="overflow-x: auto;">
                    <table class="clientes-table">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Compras</th>
                                <th>Total Gastado</th>
                                <th>Registro</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="clientes-tbody">
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <i class="ti-reload" style="font-size: 48px; color: #ddd;"></i>
                                    <p style="color: #999; margin-top: 10px;">Cargando clientes...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detalle Cliente -->
    <div id="modalDetalle" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="ti-user mr-2"></i> Perfil del Cliente</h3>
                <span class="close-modal" onclick="cerrarModal()">&times;</span>
            </div>

            <div class="modal-body" id="modal-body">
                <!-- El contenido se cargará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    
    <script>
    let clientesData = [];

    // Cargar clientes al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        cargarClientes();
    });

    // Cargar todos los clientes
    function cargarClientes() {
        fetch('admin-clientes-api?action=listar')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    clientesData = data.clientes;
                    actualizarEstadisticas(data.clientes);
                    mostrarClientes(data.clientes);
                } else {
                    console.error('Error al cargar clientes:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('clientes-tbody').innerHTML = `
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #dc3545;">
                            <i class="ti-alert" style="font-size: 48px;"></i>
                            <p style="margin-top: 10px;">Error al cargar los clientes</p>
                        </td>
                    </tr>
                `;
            });
    }

    // Actualizar estadísticas
    function actualizarEstadisticas(clientes) {
        const total = clientes.length;
        const activos = clientes.filter(c => c.estado === 'activo').length;
        const conCompras = clientes.filter(c => c.total_pedidos > 0).length;
        
        // Clientes nuevos este mes
        const hoy = new Date();
        const inicioMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        const nuevos = clientes.filter(c => {
            const fechaRegistro = new Date(c.fecha_registro);
            return fechaRegistro >= inicioMes;
        }).length;

        document.getElementById('stat-total').textContent = total;
        document.getElementById('stat-activos').textContent = activos;
        document.getElementById('stat-nuevos').textContent = nuevos;
        document.getElementById('stat-compras').textContent = conCompras;
    }

    // Mostrar clientes en la tabla
    function mostrarClientes(clientes) {
        const tbody = document.getElementById('clientes-tbody');
        
        if (clientes.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px;">
                        <i class="ti-user" style="font-size: 48px; color: #ddd;"></i>
                        <p style="color: #999; margin-top: 10px;">No hay clientes</p>
                    </td>
                </tr>
            `;
            document.getElementById('total-clientes').textContent = '0';
            return;
        }

        let html = '';
        clientes.forEach(cliente => {
            const iniciales = obtenerIniciales(cliente.nombre, cliente.apellido);
            const estadoClass = cliente.estado === 'activo' ? 'estado-activo' : 'estado-inactivo';
            const fechaRegistro = new Date(cliente.fecha_registro).toLocaleDateString('es-CO');
            const totalGastado = Number(cliente.total_gastado || 0);
            
            html += `
                <tr onclick="verDetalle(${cliente.id})">
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="cliente-avatar">${iniciales}</div>
                            <div>
                                <div style="font-weight: 600;">${cliente.nombre} ${cliente.apellido}</div>
                                <div style="font-size: 12px; color: #6c757d;">${cliente.numero_documento || 'N/A'}</div>
                            </div>
                        </div>
                    </td>
                    <td>${cliente.email}</td>
                    <td>${cliente.telefono || 'N/A'}</td>
                    <td><strong>${cliente.total_pedidos || 0}</strong></td>
                    <td><strong style="color: #667eea;">$${totalGastado.toLocaleString('es-CO')}</strong></td>
                    <td>${fechaRegistro}</td>
                    <td><span class="estado-badge ${estadoClass}">${cliente.estado}</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="event.stopPropagation(); verDetalle(${cliente.id})" title="Ver detalle">
                            <i class="ti-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('total-clientes').textContent = clientes.length;
    }

    // Obtener iniciales del nombre
    function obtenerIniciales(nombre, apellido) {
        const inicial1 = nombre ? nombre.charAt(0).toUpperCase() : '';
        const inicial2 = apellido ? apellido.charAt(0).toUpperCase() : '';
        return inicial1 + inicial2;
    }

    // Filtrar clientes
    function filtrarClientes() {
        const estadoFiltro = document.getElementById('filtro-estado').value;
        const comprasFiltro = document.getElementById('filtro-compras').value;
        const busqueda = document.getElementById('filtro-buscar').value.toLowerCase();

        let clientesFiltrados = clientesData.filter(cliente => {
            // Filtro por estado
            if (estadoFiltro && cliente.estado !== estadoFiltro) {
                return false;
            }

            // Filtro por compras
            if (comprasFiltro === 'si' && (!cliente.total_pedidos || cliente.total_pedidos === 0)) {
                return false;
            }
            if (comprasFiltro === 'no' && cliente.total_pedidos > 0) {
                return false;
            }

            // Filtro por búsqueda
            if (busqueda) {
                const textoCompleto = `${cliente.nombre} ${cliente.apellido} ${cliente.email} ${cliente.numero_documento || ''}`.toLowerCase();
                if (!textoCompleto.includes(busqueda)) {
                    return false;
                }
            }

            return true;
        });

        mostrarClientes(clientesFiltrados);
    }

    // Ver detalle del cliente
    function verDetalle(clienteId) {
        fetch(`admin-clientes-api?action=detalle&id=${clienteId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarModalDetalle(data.cliente, data.direcciones, data.pedidos);
                } else {
                    alert('Error al cargar el detalle del cliente');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar el detalle');
            });
    }

    // Mostrar modal con detalle
    function mostrarModalDetalle(cliente, direcciones, pedidos) {
        const iniciales = obtenerIniciales(cliente.nombre, cliente.apellido);
        const estadoClass = cliente.estado === 'activo' ? 'estado-activo' : 'estado-inactivo';
        const totalGastado = Number(cliente.total_gastado || 0);
        const totalPedidos = pedidos.length;
        const pedidosPendientes = pedidos.filter(p => p.estado_pedido_id === 1).length;

        // HTML de direcciones
        let direccionesHtml = '';
        if (direcciones && direcciones.length > 0) {
            direcciones.forEach(dir => {
                const esPrincipal = dir.es_principal == 1;
                direccionesHtml += `
                    <div class="direccion-item ${esPrincipal ? 'direccion-principal' : ''}">
                        <div class="direccion-nombre">
                            ${dir.nombre_direccion || 'Dirección'}
                            ${esPrincipal ? '<span class="badge badge-success ml-2">Principal</span>' : ''}
                        </div>
                        <div class="direccion-texto">
                            ${dir.direccion}<br>
                            ${dir.ciudad}, ${dir.departamento} - ${dir.codigo_postal || 'N/A'}
                        </div>
                    </div>
                `;
            });
        } else {
            direccionesHtml = '<p style="color: #6c757d;">No hay direcciones registradas</p>';
        }

        // HTML de pedidos
        let pedidosHtml = '';
        if (pedidos && pedidos.length > 0) {
            pedidos.forEach(pedido => {
                const estadoBadge = obtenerClaseEstado(pedido.estado_pedido_id);
                const fecha = new Date(pedido.fecha_pedido).toLocaleDateString('es-CO');
                pedidosHtml += `
                    <div class="pedido-item">
                        <div class="pedido-info">
                            <div class="pedido-numero">#${pedido.numero_pedido}</div>
                            <div class="pedido-fecha">
                                ${fecha} - <span class="estado-badge ${estadoBadge}">${pedido.estado_nombre}</span>
                            </div>
                        </div>
                        <div class="pedido-total">$${Number(pedido.total).toLocaleString('es-CO')}</div>
                    </div>
                `;
            });
        } else {
            pedidosHtml = '<p style="color: #6c757d;">No hay pedidos registrados</p>';
        }

        const html = `
            <div class="cliente-detalle-header">
                <div class="cliente-avatar-large">${iniciales}</div>
                <div class="cliente-info-header">
                    <div class="cliente-nombre-grande">${cliente.nombre} ${cliente.apellido}</div>
                    <div style="color: #6c757d; margin-bottom: 10px;">${cliente.email}</div>
                    <span class="estado-badge ${estadoClass}">${cliente.estado}</span>
                </div>
            </div>

            <div class="stats-cliente">
                <div class="stat-cliente-card">
                    <div class="stat-cliente-value">${totalPedidos}</div>
                    <div class="stat-cliente-label">Total Pedidos</div>
                </div>
                <div class="stat-cliente-card">
                    <div class="stat-cliente-value">$${totalGastado.toLocaleString('es-CO')}</div>
                    <div class="stat-cliente-label">Total Gastado</div>
                </div>
                <div class="stat-cliente-card">
                    <div class="stat-cliente-value">${pedidosPendientes}</div>
                    <div class="stat-cliente-label">Pedidos Pendientes</div>
                </div>
            </div>

            <div class="detalle-section">
                <h4>Información Personal</h4>
                <div class="detalle-grid">
                    <div class="detalle-item">
                        <div class="detalle-label">Nombre Completo</div>
                        <div class="detalle-value">${cliente.nombre} ${cliente.apellido}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Email</div>
                        <div class="detalle-value">${cliente.email}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Teléfono</div>
                        <div class="detalle-value">${cliente.telefono || 'N/A'}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Documento</div>
                        <div class="detalle-value">${cliente.numero_documento || 'N/A'}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Fecha de Registro</div>
                        <div class="detalle-value">${new Date(cliente.fecha_registro).toLocaleDateString('es-CO')}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Última Actividad</div>
                        <div class="detalle-value">${cliente.ultima_actividad ? new Date(cliente.ultima_actividad).toLocaleDateString('es-CO') : 'N/A'}</div>
                    </div>
                </div>
            </div>

            <div class="detalle-section">
                <h4>Direcciones (${direcciones.length})</h4>
                <div class="direcciones-list">
                    ${direccionesHtml}
                </div>
            </div>

            <div class="detalle-section">
                <h4>Historial de Pedidos (${pedidos.length})</h4>
                <div class="pedidos-historial">
                    ${pedidosHtml}
                </div>
            </div>
        `;

        document.getElementById('modal-body').innerHTML = html;
        document.getElementById('modalDetalle').style.display = 'block';
    }

    // Obtener clase CSS según estado del pedido
    function obtenerClaseEstado(estadoId) {
        const clases = {
            1: 'estado-pendiente',
            2: 'estado-confirmado',
            3: 'estado-en-proceso',
            4: 'estado-enviado',
            5: 'estado-entregado',
            6: 'estado-cancelado'
        };
        return clases[estadoId] || '';
    }

    // Cerrar modal
    function cerrarModal() {
        document.getElementById('modalDetalle').style.display = 'none';
    }

    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        const modal = document.getElementById('modalDetalle');
        if (event.target === modal) {
            cerrarModal();
        }
    }
    </script>
</body>

</html>
