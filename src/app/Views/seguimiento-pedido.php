<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="img/fav.png">
    <meta name="author" content="CodePixar">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta charset="UTF-8">
    <title>Seguimiento de Pedido - Tennis y Zapatos</title>
    
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/main.css">

    <style>
        .seguimiento-section {
            padding: 60px 0;
            background: #f8f9fa;
        }

        .pedido-header {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .pedido-numero {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .pedido-fecha {
            color: #6c757d;
            font-size: 14px;
        }

        .timeline-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 40px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            z-index: 2;
        }

        .timeline-line {
            position: absolute;
            left: 24px;
            top: 50px;
            width: 2px;
            height: calc(100% + 40px);
            background: #e9ecef;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-content {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .timeline-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .timeline-description {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .timeline-date {
            color: #999;
            font-size: 13px;
        }

        /* Estados */
        .estado-pendiente {
            background: #ffc107;
        }

        .estado-confirmado {
            background: #17a2b8;
        }

        .estado-preparacion {
            background: #fd7e14;
        }

        .estado-enviado {
            background: #20c997;
        }

        .estado-entregado {
            background: #28a745;
        }

        .estado-cancelado {
            background: #dc3545;
        }

        .estado-actual {
            box-shadow: 0 0 0 4px rgba(255, 186, 0, 0.2);
            animation: pulse 2s infinite;
        }

        .estado-completado .timeline-icon {
            opacity: 1;
        }

        .estado-pendiente-icono .timeline-icon {
            opacity: 0.3;
            background: #e9ecef !important;
            color: #999 !important;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 186, 0, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 186, 0, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 186, 0, 0);
            }
        }

        .pedido-info {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .info-section {
            margin-bottom: 30px;
        }

        .info-section:last-child {
            margin-bottom: 0;
        }

        .info-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ffba00;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6c757d;
            font-weight: 600;
        }

        .info-value {
            color: #333;
            font-weight: 500;
        }

        .producto-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .producto-item:last-child {
            border-bottom: none;
        }

        .producto-imagen {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .producto-info {
            flex: 1;
        }

        .producto-nombre {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .producto-cantidad {
            color: #6c757d;
            font-size: 14px;
        }

        .producto-precio {
            font-weight: 700;
            color: #ffba00;
        }

        .total-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .total-row.final {
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 10px;
        }

        .total-label {
            font-weight: 600;
            color: #333;
        }

        .total-value {
            font-weight: 700;
            color: #333;
        }

        .total-row.final .total-value {
            font-size: 24px;
            color: #ffba00;
        }

        .btn-volver {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-volver:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            color: white;
            text-decoration: none;
        }

        .alert-info-custom {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            color: #004085;
        }
    </style>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- Breadcrumb -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Seguimiento de Pedido</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="perfil">Mi Cuenta<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Seguimiento</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Seguimiento Section -->
    <section class="seguimiento-section">
        <div class="container">
            <?php if ($pedido): ?>
                <!-- Header del Pedido -->
                <div class="pedido-header">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="pedido-numero"><?php echo htmlspecialchars($pedido['numero_pedido']); ?></div>
                            <div class="pedido-fecha">
                                <i class="ti-calendar mr-2"></i>
                                Realizado el <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="perfil" class="btn-volver">
                                <i class="ti-arrow-left mr-2"></i>Volver a Mi Cuenta
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Timeline de Seguimiento -->
                    <div class="col-lg-7">
                        <div class="timeline-container">
                            <h3 class="mb-4">
                                <i class="ti-package mr-2" style="color: #ffba00;"></i>
                                Estado del Pedido
                            </h3>

                            <?php
                            // Estados del pedido
                            $estados_timeline = [
                                1 => ['nombre' => 'Pendiente', 'descripcion' => 'Tu pedido ha sido recibido y está pendiente de confirmación', 'icono' => 'ti-time', 'clase' => 'estado-pendiente'],
                                2 => ['nombre' => 'Confirmado', 'descripcion' => 'Tu pedido ha sido confirmado y será procesado', 'icono' => 'ti-check', 'clase' => 'estado-confirmado'],
                                3 => ['nombre' => 'En Preparación', 'descripcion' => 'Estamos preparando tu pedido para el envío', 'icono' => 'ti-package', 'clase' => 'estado-preparacion'],
                                4 => ['nombre' => 'Enviado', 'descripcion' => 'Tu pedido está en camino', 'icono' => 'ti-truck', 'clase' => 'estado-enviado'],
                                5 => ['nombre' => 'Entregado', 'descripcion' => 'Tu pedido ha sido entregado exitosamente', 'icono' => 'ti-check-box', 'clase' => 'estado-entregado'],
                                6 => ['nombre' => 'Cancelado', 'descripcion' => 'El pedido ha sido cancelado', 'icono' => 'ti-close', 'clase' => 'estado-cancelado']
                            ];

                            $estado_actual_id = $pedido['estado_pedido_id'];
                            ?>

                            <div class="timeline">
                                <?php foreach ($estados_timeline as $id => $estado): ?>
                                    <?php 
                                    // Determinar si el estado está completado, es el actual, o está pendiente
                                    $es_actual = ($id == $estado_actual_id);
                                    $es_completado = ($id < $estado_actual_id && $estado_actual_id != 6); // Si no está cancelado
                                    $es_pendiente = ($id > $estado_actual_id && $estado_actual_id != 6);
                                    
                                    // Si está cancelado, solo mostrar Pendiente, Confirmado (si llegó) y Cancelado
                                    if ($estado_actual_id == 6 && $id != 1 && $id != 6 && $id > 2) {
                                        continue;
                                    }
                                    
                                    $clase_estado = $es_completado ? 'estado-completado' : ($es_actual ? 'estado-actual' : 'estado-pendiente-icono');
                                    ?>
                                    
                                    <div class="timeline-item <?php echo $clase_estado; ?>">
                                        <div class="timeline-icon <?php echo $estado['clase']; ?>">
                                            <i class="<?php echo $estado['icono']; ?>"></i>
                                        </div>
                                        <?php if ($id < count($estados_timeline)): ?>
                                            <div class="timeline-line"></div>
                                        <?php endif; ?>
                                        <div class="timeline-content">
                                            <div class="timeline-title"><?php echo $estado['nombre']; ?></div>
                                            <div class="timeline-description"><?php echo $estado['descripcion']; ?></div>
                                            <?php if ($es_actual || $es_completado): ?>
                                                <div class="timeline-date">
                                                    <i class="ti-time mr-1"></i>
                                                    <?php 
                                                    if ($es_completado || $es_actual) {
                                                        echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido']));
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php if ($pedido['observaciones']): ?>
                                <div class="alert-info-custom mt-4">
                                    <strong><i class="ti-info-alt mr-2"></i>Observaciones:</strong>
                                    <p class="mb-0 mt-2"><?php echo htmlspecialchars($pedido['observaciones']); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Información del Pedido -->
                    <div class="col-lg-5">
                        <div class="pedido-info">
                            <!-- Productos -->
                            <div class="info-section">
                                <div class="info-title">
                                    <i class="ti-shopping-cart mr-2"></i>Productos
                                </div>
                                <?php foreach ($items as $item): ?>
                                    <div class="producto-item">
                                        <img src="img/product/<?php echo htmlspecialchars($item['producto_imagen'] ?? 'default.jpg'); ?>" 
                                             alt="<?php echo htmlspecialchars($item['producto_nombre']); ?>" 
                                             class="producto-imagen">
                                        <div class="producto-info">
                                            <div class="producto-nombre"><?php echo htmlspecialchars($item['producto_nombre']); ?></div>
                                            <div class="producto-cantidad">Cantidad: <?php echo $item['cantidad']; ?></div>
                                        </div>
                                        <div class="producto-precio">
                                            $<?php echo number_format($item['subtotal'], 0, ',', '.'); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Resumen de Pago -->
                            <div class="info-section">
                                <div class="info-title">
                                    <i class="ti-money mr-2"></i>Resumen de Pago
                                </div>
                                <div class="total-section">
                                    <div class="total-row">
                                        <span class="total-label">Subtotal:</span>
                                        <span class="total-value">$<?php echo number_format($pedido['subtotal'], 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="total-row">
                                        <span class="total-label">Impuestos:</span>
                                        <span class="total-value">$<?php echo number_format($pedido['impuestos'], 0, ',', '.'); ?></span>
                                    </div>
                                    <div class="total-row">
                                        <span class="total-label">Envío:</span>
                                        <span class="total-value">
                                            <?php echo $pedido['costo_envio'] > 0 ? '$' . number_format($pedido['costo_envio'], 0, ',', '.') : 'GRATIS'; ?>
                                        </span>
                                    </div>
                                    <div class="total-row final">
                                        <span class="total-label">Total:</span>
                                        <span class="total-value">$<?php echo number_format($pedido['total'], 0, ',', '.'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Información de Envío -->
                            <div class="info-section">
                                <div class="info-title">
                                    <i class="ti-location-pin mr-2"></i>Información de Envío
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Nombre:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($pedido['usuario_nombre'] . ' ' . $pedido['usuario_apellido']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Email:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($pedido['usuario_email']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Teléfono:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($pedido['usuario_telefono']); ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Método de Pago:</span>
                                    <span class="info-value"><?php echo htmlspecialchars($pedido['metodo_pago_nombre']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="alert alert-warning text-center">
                    <h4>Pedido no encontrado</h4>
                    <p>No se encontró el pedido solicitado o no tienes permiso para verlo.</p>
                    <a href="perfil" class="btn-volver mt-3">
                        <i class="ti-arrow-left mr-2"></i>Volver a Mi Cuenta
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../../cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/carrito.js"></script>
</body>

</html>
