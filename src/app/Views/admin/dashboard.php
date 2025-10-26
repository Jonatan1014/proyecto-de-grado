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
    <title>Panel Administrativo - Tennis y Zapatos</title>
    
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

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
            margin: 5px 0 0 0;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
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
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Topbar */
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

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        .user-role {
            font-size: 12px;
            color: #6c757d;
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #ff9a56 0%, #ff6a00 100%);
            color: white;
        }

        .stat-icon.red {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #333;
        }

        /* Content Card */
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

        .btn-success-custom {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, #ffba00 0%, #ff9000 100%);
            color: white;
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
            <li>
                <a href="admin-dashboard" class="active">
                    <i class="ti-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="admin-productos">
                    <i class="ti-package"></i>
                    <span>Productos</span>
                </a>
            </li>
            <li>
                <a href="admin-categorias">
                    <i class="ti-folder"></i>
                    <span>Categorías</span>
                </a>
            </li>
            <li>
                <a href="admin-marcas">
                    <i class="ti-tag"></i>
                    <span>Marcas</span>
                </a>
            </li>
            <li>
                <a href="admin-pedidos">
                    <i class="ti-receipt"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <li>
                <a href="admin-clientes">
                    <i class="ti-user"></i>
                    <span>Clientes</span>
                </a>
            </li>
            <?php if ($usuario['rol'] === 'administrador'): ?>
            <li>
                <a href="admin-usuarios">
                    <i class="ti-id-badge"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li>
                <a href="admin-reportes">
                    <i class="ti-bar-chart"></i>
                    <span>Reportes</span>
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="admin-configuracion">
                    <i class="ti-settings"></i>
                    <span>Configuración</span>
                </a>
            </li>
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
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-left">
                <h2>Dashboard</h2>
            </div>
            <div class="topbar-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php
                        $iniciales = strtoupper(substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1));
                        echo htmlspecialchars($iniciales);
                        ?>
                    </div>
                    <div>
                        <div class="user-name"><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></div>
                        <div class="user-role"><?php echo ucfirst(htmlspecialchars($usuario['rol'])); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="ti-package"></i>
                    </div>
                    <div class="stat-label">Total Productos</div>
                    <div class="stat-value"><?php echo $stats['total_productos'] ?? 0; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="ti-receipt"></i>
                    </div>
                    <div class="stat-label">Pedidos Hoy</div>
                    <div class="stat-value"><?php echo $stats['pedidos_hoy'] ?? 0; ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="ti-money"></i>
                    </div>
                    <div class="stat-label">Ventas del Mes</div>
                    <div class="stat-value">$<?php echo number_format($stats['ventas_mes'] ?? 0, 0, ',', '.'); ?></div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="ti-alert"></i>
                    </div>
                    <div class="stat-label">Stock Bajo</div>
                    <div class="stat-value"><?php echo $stats['stock_bajo'] ?? 0; ?></div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="content-card">
                <h3 class="card-title">Acciones Rápidas</h3>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="admin-productos?action=nuevo" class="btn btn-primary-custom btn-block">
                            <i class="ti-plus mr-2"></i>
                            Nuevo Producto
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="admin-pedidos" class="btn btn-success-custom btn-block">
                            <i class="ti-clipboard mr-2"></i>
                            Ver Pedidos
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="admin-categorias" class="btn btn-warning-custom btn-block">
                            <i class="ti-folder mr-2"></i>
                            Gestionar Categorías
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="admin-reportes" class="btn btn-primary-custom btn-block">
                            <i class="ti-bar-chart mr-2"></i>
                            Ver Reportes
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="content-card">
                <h3 class="card-title">Pedidos Recientes</h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N° Pedido</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pedidos_recientes)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay pedidos recientes</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($pedidos_recientes as $pedido): ?>
                            <tr>
                                <td><strong>#<?php echo htmlspecialchars($pedido['numero_pedido']); ?></strong></td>
                                <td><?php echo htmlspecialchars($pedido['usuario_nombre']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></td>
                                <td>$<?php echo number_format($pedido['total'], 0, ',', '.'); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo strtolower($pedido['estado_nombre']); ?>">
                                        <?php echo htmlspecialchars($pedido['estado_nombre']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admin-pedido-detalle?id=<?php echo $pedido['id']; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class="ti-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
</body>

</html>
