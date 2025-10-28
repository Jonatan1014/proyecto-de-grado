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
    <title>Reportes - Panel Administrativo</title>
    
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

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        .top-bar {
            background: white;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h2 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Filtros */
        .filters-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .filters-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-success-custom {
            background: #28a745;
            color: white;
        }

        .btn-success-custom:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-info-custom {
            background: #17a2b8;
            color: white;
        }

        .btn-info-custom:hover {
            background: #138496;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
        }

        .btn-warning-custom {
            background: #ffc107;
            color: #000;
        }

        .btn-warning-custom:hover {
            background: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }

        /* Cards de estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-info h3 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .stat-info p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #f09819 0%, #edde5d 100%);
            color: white;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            color: white;
        }

        /* Tablas */
        .table-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .table-card h3 {
            margin: 0 0 20px 0;
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #f8f9fa;
        }

        .data-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            font-size: 14px;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            color: #666;
            font-size: 14px;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Charts */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .chart-card h3 {
            margin: 0 0 20px 0;
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        /* Loading */
        .loading {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .loading i {
            font-size: 48px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .filters-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>🛍️ Tennis & Zapatos</h3>
            <p>Panel de Administración</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin-dashboard"><i class="ti-dashboard"></i> Dashboard</a></li>
            <li><a href="admin-productos"><i class="ti-package"></i> Productos</a></li>
            <li><a href="admin-categorias"><i class="ti-folder"></i> Categorías</a></li>
            <li><a href="admin-marcas"><i class="ti-tag"></i> Marcas</a></li>
            <li><a href="admin-pedidos"><i class="ti-shopping-cart"></i> Pedidos</a></li>
            <li><a href="admin-clientes"><i class="ti-user"></i> Clientes</a></li>
            <?php if ($usuario['rol'] === 'administrador'): ?>
                <li><a href="admin-usuarios"><i class="ti-id-badge"></i> Usuarios</a></li>
            <?php endif; ?>
            <li><a href="admin-reportes" class="active"><i class="ti-bar-chart"></i> Reportes</a></li>
            <li><a href="logout"><i class="ti-power-off"></i> Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h2>📊 Reportes y Estadísticas</h2>
            <div class="user-info">
                <span><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></span>
                <div class="user-avatar"><?php echo strtoupper(substr($usuario['nombre'], 0, 1)); ?></div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-card">
            <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700;">🔍 Filtros de Reporte</h3>
            <div class="filters-row">
                <div class="filter-group">
                    <label>Tipo de Reporte</label>
                    <select id="tipo-reporte">
                        <option value="general">📊 Reporte General</option>
                        <option value="ventas">💰 Ventas</option>
                        <option value="productos">🛍️ Productos</option>
                        <option value="clientes">👥 Clientes</option>
                        <option value="inventario">📦 Inventario</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Período</label>
                    <select id="periodo">
                        <option value="hoy">Hoy</option>
                        <option value="semana">Esta Semana</option>
                        <option value="mes" selected>Este Mes</option>
                        <option value="trimestre">Este Trimestre</option>
                        <option value="anio">Este Año</option>
                        <option value="personalizado">Personalizado</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Fecha Inicio</label>
                    <input type="date" id="fecha-inicio">
                </div>
                <div class="filter-group">
                    <label>Fecha Fin</label>
                    <input type="date" id="fecha-fin">
                </div>
            </div>
            <div class="btn-group">
                <button class="btn-custom btn-primary-custom" onclick="generarReporte()">
                    <i class="ti-reload"></i> Generar Reporte
                </button>
                <button class="btn-custom btn-success-custom" onclick="exportarExcel()">
                    <i class="ti-download"></i> Exportar Excel
                </button>
                <button class="btn-custom btn-info-custom" onclick="exportarPDF()">
                    <i class="ti-file"></i> Exportar PDF
                </button>
                <button class="btn-custom btn-warning-custom" onclick="imprimirReporte()">
                    <i class="ti-printer"></i> Imprimir
                </button>
            </div>
        </div>

        <!-- Estadísticas Principales -->
        <div id="estadisticas-principales" class="stats-grid">
            <!-- Se llenará dinámicamente -->
        </div>

        <!-- Gráficos -->
        <div id="graficos-container" class="charts-grid">
            <!-- Se llenará dinámicamente -->
        </div>

        <!-- Tablas de Datos -->
        <div id="tablas-container">
            <!-- Se llenará dinámicamente -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="../js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../js/vendor/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Variables globales
        let reporteActual = null;
        let chartInstances = {};

        // Cargar reporte al iniciar
        document.addEventListener('DOMContentLoaded', function() {
            // Establecer fechas por defecto (mes actual)
            const hoy = new Date();
            const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
            document.getElementById('fecha-inicio').value = primerDiaMes.toISOString().split('T')[0];
            document.getElementById('fecha-fin').value = hoy.toISOString().split('T')[0];
            
            // Generar reporte inicial
            generarReporte();
        });

        // Actualizar fechas según período
        document.getElementById('periodo').addEventListener('change', function() {
            const periodo = this.value;
            const hoy = new Date();
            let fechaInicio, fechaFin;

            switch(periodo) {
                case 'hoy':
                    fechaInicio = hoy;
                    fechaFin = hoy;
                    break;
                case 'semana':
                    fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth(), hoy.getDate() - 7);
                    fechaFin = hoy;
                    break;
                case 'mes':
                    fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
                    fechaFin = hoy;
                    break;
                case 'trimestre':
                    fechaInicio = new Date(hoy.getFullYear(), hoy.getMonth() - 3, 1);
                    fechaFin = hoy;
                    break;
                case 'anio':
                    fechaInicio = new Date(hoy.getFullYear(), 0, 1);
                    fechaFin = hoy;
                    break;
                default:
                    return;
            }

            if (periodo !== 'personalizado') {
                document.getElementById('fecha-inicio').value = fechaInicio.toISOString().split('T')[0];
                document.getElementById('fecha-fin').value = fechaFin.toISOString().split('T')[0];
                generarReporte();
            }
        });

        // Generar reporte
        function generarReporte() {
            const tipoReporte = document.getElementById('tipo-reporte').value;
            const fechaInicio = document.getElementById('fecha-inicio').value;
            const fechaFin = document.getElementById('fecha-fin').value;

            // Mostrar loading
            mostrarLoading();

            // Hacer petición AJAX
            fetch(`admin-reportes-api?action=generar&tipo=${tipoReporte}&inicio=${fechaInicio}&fin=${fechaFin}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        reporteActual = data.reporte;
                        mostrarReporte(data.reporte);
                    } else {
                        mostrarError('Error al generar el reporte: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarError('Error al cargar el reporte');
                });
        }

        // Mostrar reporte
        function mostrarReporte(reporte) {
            // Mostrar estadísticas principales
            mostrarEstadisticas(reporte.estadisticas);
            
            // Mostrar gráficos
            mostrarGraficos(reporte.graficos);
            
            // Mostrar tablas
            mostrarTablas(reporte.tablas);
        }

        // Mostrar estadísticas
        function mostrarEstadisticas(stats) {
            const container = document.getElementById('estadisticas-principales');
            
            let html = '';
            stats.forEach(stat => {
                html += `
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>${stat.valor}</h3>
                            <p>${stat.titulo}</p>
                        </div>
                        <div class="stat-icon ${stat.color}">
                            <i class="${stat.icono}"></i>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // Mostrar gráficos
        function mostrarGraficos(graficos) {
            const container = document.getElementById('graficos-container');
            
            // Destruir gráficos anteriores
            Object.values(chartInstances).forEach(chart => chart.destroy());
            chartInstances = {};
            
            let html = '';
            graficos.forEach((grafico, index) => {
                html += `
                    <div class="chart-card">
                        <h3>${grafico.titulo}</h3>
                        <div class="chart-container">
                            <canvas id="chart-${index}"></canvas>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            
            // Crear gráficos
            setTimeout(() => {
                graficos.forEach((grafico, index) => {
                    const ctx = document.getElementById(`chart-${index}`).getContext('2d');
                    chartInstances[`chart-${index}`] = new Chart(ctx, {
                        type: grafico.tipo,
                        data: grafico.data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                });
            }, 100);
        }

        // Mostrar tablas
        function mostrarTablas(tablas) {
            const container = document.getElementById('tablas-container');
            
            let html = '';
            tablas.forEach(tabla => {
                html += `
                    <div class="table-card">
                        <h3>${tabla.titulo}</h3>
                        <div style="overflow-x: auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        ${tabla.columnas.map(col => `<th>${col}</th>`).join('')}
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tabla.datos.map(fila => `
                                        <tr>
                                            ${fila.map(valor => `<td>${valor}</td>`).join('')}
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // Mostrar loading
        function mostrarLoading() {
            document.getElementById('estadisticas-principales').innerHTML = '<div class="loading"><i class="ti-reload"></i><p>Generando reporte...</p></div>';
            document.getElementById('graficos-container').innerHTML = '';
            document.getElementById('tablas-container').innerHTML = '';
        }

        // Mostrar error
        function mostrarError(mensaje) {
            document.getElementById('estadisticas-principales').innerHTML = `
                <div class="empty-state">
                    <i class="ti-alert"></i>
                    <h3>Error</h3>
                    <p>${mensaje}</p>
                </div>
            `;
            document.getElementById('graficos-container').innerHTML = '';
            document.getElementById('tablas-container').innerHTML = '';
        }

        // Exportar a Excel
        function exportarExcel() {
            if (!reporteActual) {
                alert('Primero debes generar un reporte');
                return;
            }

            const tipoReporte = document.getElementById('tipo-reporte').value;
            const fechaInicio = document.getElementById('fecha-inicio').value;
            const fechaFin = document.getElementById('fecha-fin').value;

            window.location.href = `admin-exportar-reporte?formato=excel&tipo=${tipoReporte}&inicio=${fechaInicio}&fin=${fechaFin}`;
        }

        // Exportar a PDF
        function exportarPDF() {
            if (!reporteActual) {
                alert('Primero debes generar un reporte');
                return;
            }

            const tipoReporte = document.getElementById('tipo-reporte').value;
            const fechaInicio = document.getElementById('fecha-inicio').value;
            const fechaFin = document.getElementById('fecha-fin').value;

            window.location.href = `admin-exportar-reporte?formato=pdf&tipo=${tipoReporte}&inicio=${fechaInicio}&fin=${fechaFin}`;
        }

        // Imprimir reporte
        function imprimirReporte() {
            if (!reporteActual) {
                alert('Primero debes generar un reporte');
                return;
            }

            window.print();
        }

        // Estilos de impresión
        const printStyles = `
            @media print {
                .sidebar, .top-bar, .filters-card, .btn-group {
                    display: none !important;
                }
                .main-content {
                    margin-left: 0 !important;
                    padding: 20px !important;
                }
                .stat-card, .chart-card, .table-card {
                    break-inside: avoid;
                    box-shadow: none !important;
                    border: 1px solid #ddd;
                }
            }
        `;
        const style = document.createElement('style');
        style.textContent = printStyles;
        document.head.appendChild(style);
    </script>
</body>
</html>
