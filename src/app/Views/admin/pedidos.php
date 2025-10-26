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
    <title>Gestión de Pedidos - Admin</title>
    
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

        .stat-card.pendientes {
            border-left-color: #ffc107;
        }

        .stat-card.confirmados {
            border-left-color: #17a2b8;
        }

        .stat-card.enviados {
            border-left-color: #28a745;
        }

        .stat-card.entregados {
            border-left-color: #6f42c1;
        }

        .stat-card.cancelados {
            border-left-color: #dc3545;
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

        .pedidos-table {
            width: 100%;
            border-collapse: collapse;
        }

        .pedidos-table thead {
            background: #f8f9fa;
        }

        .pedidos-table th,
        .pedidos-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .pedidos-table tbody tr:hover {
            background: #f8f9fa;
        }

        .estado-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .estado-confirmado {
            background: #d1ecf1;
            color: #0c5460;
        }

        .estado-en-proceso {
            background: #d1ecf1;
            color: #0c5460;
        }

        .estado-enviado {
            background: #d4edda;
            color: #155724;
        }

        .estado-entregado {
            background: #e2d9f3;
            color: #4a148c;
        }

        .estado-cancelado {
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

        .actions-group {
            display: flex;
            gap: 5px;
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
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .modal-header h3 {
            margin: 0;
            color: #333;
        }

        .close-modal {
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close-modal:hover {
            color: #000;
        }

        .pedido-detalle-section {
            margin-bottom: 25px;
        }

        .pedido-detalle-section h4 {
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

        .productos-detalle-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .productos-detalle-table th,
        .productos-detalle-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .productos-detalle-table thead {
            background: #f8f9fa;
        }

        .producto-img-small {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            gap: 100px;
            margin-bottom: 10px;
        }

        .total-label {
            font-weight: 600;
            color: #6c757d;
        }

        .total-value {
            font-weight: 700;
            color: #333;
        }

        .total-final {
            font-size: 20px;
            color: #667eea;
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
            <li><a href="admin-pedidos" class="active"><i class="ti-receipt"></i> Pedidos</a></li>
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
                <h2>Gestión de Pedidos</h2>
            </div>
        </div>

        <div class="content-area">
            <!-- Estadísticas de pedidos -->
            <div class="stats-cards">
                <div class="stat-card pendientes">
                    <div class="stat-label">Pendientes</div>
                    <div class="stat-value" id="stat-pendientes">0</div>
                </div>
                <div class="stat-card confirmados">
                    <div class="stat-label">Confirmados</div>
                    <div class="stat-value" id="stat-confirmados">0</div>
                </div>
                <div class="stat-card enviados">
                    <div class="stat-label">Enviados</div>
                    <div class="stat-value" id="stat-enviados">0</div>
                </div>
                <div class="stat-card entregados">
                    <div class="stat-label">Entregados</div>
                    <div class="stat-value" id="stat-entregados">0</div>
                </div>
                <div class="stat-card cancelados">
                    <div class="stat-label">Cancelados</div>
                    <div class="stat-value" id="stat-cancelados">0</div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="content-card">
                <div class="filters-section">
                    <div class="filter-group">
                        <label for="filtro-estado">Estado</label>
                        <select class="form-control" id="filtro-estado" onchange="filtrarPedidos()">
                            <option value="">Todos los estados</option>
                            <option value="1">Pendiente</option>
                            <option value="2">Confirmado</option>
                            <option value="3">En Proceso</option>
                            <option value="4">Enviado</option>
                            <option value="5">Entregado</option>
                            <option value="6">Cancelado</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="filtro-fecha">Fecha desde</label>
                        <input type="date" class="form-control" id="filtro-fecha-desde" onchange="filtrarPedidos()">
                    </div>
                    <div class="filter-group">
                        <label for="filtro-fecha">Fecha hasta</label>
                        <input type="date" class="form-control" id="filtro-fecha-hasta" onchange="filtrarPedidos()">
                    </div>
                    <div class="filter-group">
                        <label for="filtro-buscar">Buscar</label>
                        <input type="text" class="form-control" id="filtro-buscar" 
                               placeholder="Número de pedido o cliente..." 
                               onkeyup="filtrarPedidos()">
                    </div>
                </div>
            </div>

            <!-- Tabla de pedidos -->
            <div class="content-card">
                <div class="card-title">
                    <span>Lista de Pedidos (<span id="total-pedidos">0</span>)</span>
                </div>

                <div style="overflow-x: auto;">
                    <table class="pedidos-table">
                        <thead>
                            <tr>
                                <th>N° Pedido</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Tipo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="pedidos-tbody">
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px;">
                                    <i class="ti-reload" style="font-size: 48px; color: #ddd;"></i>
                                    <p style="color: #999; margin-top: 10px;">Cargando pedidos...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Detalle Pedido -->
    <div id="modalDetalle" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detalle del Pedido <span id="modal-numero-pedido"></span></h3>
                <span class="close-modal" onclick="cerrarModal()">&times;</span>
            </div>

            <div id="modal-body">
                <!-- El contenido se cargará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    
    <script>
    let pedidosData = [];

    // Cargar pedidos al iniciar
    document.addEventListener('DOMContentLoaded', function() {
        cargarPedidos();
    });

    // Cargar todos los pedidos
    function cargarPedidos() {
        fetch('admin-pedidos-api?action=listar')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    pedidosData = data.pedidos;
                    actualizarEstadisticas(data.pedidos);
                    mostrarPedidos(data.pedidos);
                } else {
                    console.error('Error al cargar pedidos:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('pedidos-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #dc3545;">
                            <i class="ti-alert" style="font-size: 48px;"></i>
                            <p style="margin-top: 10px;">Error al cargar los pedidos</p>
                        </td>
                    </tr>
                `;
            });
    }

    // Actualizar estadísticas
    function actualizarEstadisticas(pedidos) {
        const stats = {
            pendientes: 0,
            confirmados: 0,
            enviados: 0,
            entregados: 0,
            cancelados: 0
        };

        pedidos.forEach(pedido => {
            switch(pedido.estado_pedido_id) {
                case 1: stats.pendientes++; break;
                case 2: stats.confirmados++; break;
                case 3: stats.confirmados++; break;
                case 4: stats.enviados++; break;
                case 5: stats.entregados++; break;
                case 6: stats.cancelados++; break;
            }
        });

        document.getElementById('stat-pendientes').textContent = stats.pendientes;
        document.getElementById('stat-confirmados').textContent = stats.confirmados;
        document.getElementById('stat-enviados').textContent = stats.enviados;
        document.getElementById('stat-entregados').textContent = stats.entregados;
        document.getElementById('stat-cancelados').textContent = stats.cancelados;
    }

    // Mostrar pedidos en la tabla
    function mostrarPedidos(pedidos) {
        const tbody = document.getElementById('pedidos-tbody');
        
        if (pedidos.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <i class="ti-package" style="font-size: 48px; color: #ddd;"></i>
                        <p style="color: #999; margin-top: 10px;">No hay pedidos</p>
                    </td>
                </tr>
            `;
            document.getElementById('total-pedidos').textContent = '0';
            return;
        }

        let html = '';
        pedidos.forEach(pedido => {
            const estadoClass = obtenerClaseEstado(pedido.estado_pedido_id);
            const fecha = new Date(pedido.fecha_pedido).toLocaleDateString('es-CO');
            
            html += `
                <tr>
                    <td><strong>#${pedido.numero_pedido}</strong></td>
                    <td>${pedido.usuario_nombre} ${pedido.usuario_apellido}</td>
                    <td>${fecha}</td>
                    <td><strong>$${Number(pedido.total).toLocaleString('es-CO')}</strong></td>
                    <td><span class="estado-badge ${estadoClass}">${pedido.estado_nombre}</span></td>
                    <td>${pedido.tipo_pedido}</td>
                    <td class="actions-group">
                        <button class="btn btn-sm btn-info" onclick="verDetalle(${pedido.id})" title="Ver detalle">
                            <i class="ti-eye"></i>
                        </button>
                        ${pedido.estado_pedido_id !== 5 && pedido.estado_pedido_id !== 6 ? `
                        <button class="btn btn-sm btn-success" onclick="cambiarEstado(${pedido.id})" title="Cambiar estado">
                            <i class="ti-pencil"></i>
                        </button>
                        ` : ''}
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('total-pedidos').textContent = pedidos.length;
    }

    // Obtener clase CSS según estado
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

    // Filtrar pedidos
    function filtrarPedidos() {
        const estadoFiltro = document.getElementById('filtro-estado').value;
        const fechaDesde = document.getElementById('filtro-fecha-desde').value;
        const fechaHasta = document.getElementById('filtro-fecha-hasta').value;
        const busqueda = document.getElementById('filtro-buscar').value.toLowerCase();

        let pedidosFiltrados = pedidosData.filter(pedido => {
            // Filtro por estado
            if (estadoFiltro && pedido.estado_pedido_id != estadoFiltro) {
                return false;
            }

            // Filtro por fecha desde
            if (fechaDesde && new Date(pedido.fecha_pedido) < new Date(fechaDesde)) {
                return false;
            }

            // Filtro por fecha hasta
            if (fechaHasta && new Date(pedido.fecha_pedido) > new Date(fechaHasta)) {
                return false;
            }

            // Filtro por búsqueda
            if (busqueda) {
                const textoCompleto = `${pedido.numero_pedido} ${pedido.usuario_nombre} ${pedido.usuario_apellido}`.toLowerCase();
                if (!textoCompleto.includes(busqueda)) {
                    return false;
                }
            }

            return true;
        });

        mostrarPedidos(pedidosFiltrados);
    }

    // Ver detalle del pedido
    function verDetalle(pedidoId) {
        fetch(`admin-pedidos-api?action=detalle&id=${pedidoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarModalDetalle(data.pedido, data.items);
                } else {
                    alert('Error al cargar el detalle del pedido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cargar el detalle');
            });
    }

    // Mostrar modal con detalle
    function mostrarModalDetalle(pedido, items) {
        document.getElementById('modal-numero-pedido').textContent = '#' + pedido.numero_pedido;
        
        let productosHtml = '';
        let subtotal = 0;

        items.forEach(item => {
            const total = item.precio_unitario * item.cantidad;
            subtotal += total;
            productosHtml += `
                <tr>
                    <td>${item.producto_nombre}</td>
                    <td>${item.cantidad}</td>
                    <td>$${Number(item.precio_unitario).toLocaleString('es-CO')}</td>
                    <td><strong>$${Number(total).toLocaleString('es-CO')}</strong></td>
                </tr>
            `;
        });

        const fecha = new Date(pedido.fecha_pedido).toLocaleString('es-CO');
        const estadoClass = obtenerClaseEstado(pedido.estado_pedido_id);

        const html = `
            <div class="pedido-detalle-section">
                <h4>Información General</h4>
                <div class="detalle-grid">
                    <div class="detalle-item">
                        <div class="detalle-label">Cliente</div>
                        <div class="detalle-value">${pedido.usuario_nombre} ${pedido.usuario_apellido}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Email</div>
                        <div class="detalle-value">${pedido.usuario_email || 'N/A'}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Fecha</div>
                        <div class="detalle-value">${fecha}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Estado</div>
                        <div class="detalle-value">
                            <span class="estado-badge ${estadoClass}">${pedido.estado_nombre}</span>
                        </div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Tipo de Pedido</div>
                        <div class="detalle-value">${pedido.tipo_pedido}</div>
                    </div>
                    <div class="detalle-item">
                        <div class="detalle-label">Método de Pago</div>
                        <div class="detalle-value">${pedido.metodo_pago || 'N/A'}</div>
                    </div>
                </div>
                ${pedido.observaciones ? `
                <div style="margin-top: 15px;">
                    <div class="detalle-label">Observaciones</div>
                    <div class="detalle-value">${pedido.observaciones}</div>
                </div>
                ` : ''}
            </div>

            <div class="pedido-detalle-section">
                <h4>Productos</h4>
                <table class="productos-detalle-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productosHtml}
                    </tbody>
                </table>

                <div class="total-section">
                    <div class="total-row">
                        <div class="total-label">Subtotal:</div>
                        <div class="total-value">$${Number(pedido.subtotal).toLocaleString('es-CO')}</div>
                    </div>
                    ${pedido.descuento > 0 ? `
                    <div class="total-row">
                        <div class="total-label">Descuento:</div>
                        <div class="total-value" style="color: #28a745;">-$${Number(pedido.descuento).toLocaleString('es-CO')}</div>
                    </div>
                    ` : ''}
                    <div class="total-row">
                        <div class="total-label">Impuestos:</div>
                        <div class="total-value">$${Number(pedido.impuestos).toLocaleString('es-CO')}</div>
                    </div>
                    <div class="total-row" style="border-top: 2px solid #e9ecef; padding-top: 10px; margin-top: 10px;">
                        <div class="total-label" style="font-size: 18px;">TOTAL:</div>
                        <div class="total-value total-final">$${Number(pedido.total).toLocaleString('es-CO')}</div>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('modal-body').innerHTML = html;
        document.getElementById('modalDetalle').style.display = 'block';
    }

    // Cambiar estado del pedido
    function cambiarEstado(pedidoId) {
        const pedido = pedidosData.find(p => p.id === pedidoId);
        if (!pedido) return;

        const estados = [
            { id: 1, nombre: 'Pendiente' },
            { id: 2, nombre: 'Confirmado' },
            { id: 3, nombre: 'En Proceso' },
            { id: 4, nombre: 'Enviado' },
            { id: 5, nombre: 'Entregado' },
            { id: 6, nombre: 'Cancelado' }
        ];

        let opciones = '';
        estados.forEach(estado => {
            const selected = estado.id === pedido.estado_pedido_id ? 'selected' : '';
            opciones += `<option value="${estado.id}" ${selected}>${estado.nombre}</option>`;
        });

        const nuevoEstadoId = prompt(
            `Cambiar estado del pedido #${pedido.numero_pedido}\n\nEstado actual: ${pedido.estado_nombre}\n\nIngrese el número del nuevo estado:\n1. Pendiente\n2. Confirmado\n3. En Proceso\n4. Enviado\n5. Entregado\n6. Cancelado`,
            pedido.estado_pedido_id
        );

        if (nuevoEstadoId && nuevoEstadoId != pedido.estado_pedido_id) {
            actualizarEstadoPedido(pedidoId, nuevoEstadoId);
        }
    }

    // Actualizar estado del pedido
    function actualizarEstadoPedido(pedidoId, estadoId) {
        const formData = new FormData();
        formData.append('pedido_id', pedidoId);
        formData.append('estado_id', estadoId);

        fetch('admin-pedidos-api?action=cambiar-estado', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Estado actualizado correctamente');
                cargarPedidos();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar el estado');
        });
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
