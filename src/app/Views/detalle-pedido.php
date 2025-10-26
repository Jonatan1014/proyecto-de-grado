<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Detalle del Pedido - Karma Shop</title>
    <!--
		CSS
		============================================= -->
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
    .detalle-pedido-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .pedido-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #ffba00;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .section-title i {
        margin-right: 10px;
        color: #ffba00;
    }

    .pedido-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .pedido-numero-grande {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .pedido-fecha-grande {
        font-size: 16px;
        opacity: 0.9;
    }

    .estado-badge-grande {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .estado-pendiente {
        background: #ffc107;
        color: #000;
    }

    .estado-procesando {
        background: #17a2b8;
        color: white;
    }

    .estado-enviado {
        background: #007bff;
        color: white;
    }

    .estado-entregado {
        background: #28a745;
        color: white;
    }

    .estado-cancelado {
        background: #dc3545;
        color: white;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #6c757d;
    }

    .info-value {
        color: #333;
        font-weight: 500;
    }

    .producto-item {
        display: flex;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .producto-item:last-child {
        border-bottom: none;
    }

    .producto-imagen {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 20px;
    }

    .producto-info {
        flex: 1;
    }

    .producto-nombre {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .producto-sku {
        font-size: 12px;
        color: #6c757d;
    }

    .producto-cantidad {
        color: #6c757d;
        margin-right: 20px;
    }

    .producto-precio {
        font-size: 18px;
        font-weight: 700;
        color: #ffba00;
        text-align: right;
        min-width: 120px;
    }

    .resumen-total {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 16px;
    }

    .total-row.total-final {
        border-top: 2px solid #dee2e6;
        margin-top: 10px;
        padding-top: 15px;
        font-size: 20px;
        font-weight: 700;
        color: #ffba00;
    }

    .timeline {
        position: relative;
        padding-left: 40px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 30px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -34px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: white;
        border: 3px solid #e9ecef;
    }

    .timeline-item.active::before {
        border-color: #ffba00;
        background: #ffba00;
    }

    .timeline-fecha {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .timeline-estado {
        font-weight: 600;
        color: #333;
    }

    .btn-custom {
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
    }

    .btn-warning-custom {
        background: linear-gradient(135deg, #ffba00 0%, #ff9000 100%);
        color: white;
    }

    .btn-warning-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 186, 0, 0.3);
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .btn-danger-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-custom {
        background: white;
        border: 2px solid #ffba00;
        color: #ffba00;
    }

    .btn-outline-custom:hover {
        background: #ffba00;
        color: white;
    }

    .direccion-envio {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        border-left: 4px solid #ffba00;
    }

    .direccion-envio i {
        color: #ffba00;
        margin-right: 10px;
    }

    .alert-custom {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
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
                    <h1>Detalle del Pedido</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="perfil">Perfil<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Pedido #<?php echo htmlspecialchars($pedido['numero_pedido']); ?></a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Detalle Pedido Section -->
    <section class="detalle-pedido-section">
        <div class="container">
            <!-- Header del Pedido -->
            <div class="pedido-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="pedido-numero-grande">
                            <i class="ti-receipt mr-2"></i>
                            Pedido #<?php echo htmlspecialchars($pedido['numero_pedido']); ?>
                        </div>
                        <div class="pedido-fecha-grande">
                            <i class="ti-calendar mr-2"></i>
                            Realizado el <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <span class="estado-badge-grande estado-<?php echo strtolower($pedido['estado_nombre']); ?>">
                            <?php echo htmlspecialchars($pedido['estado_nombre']); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Columna Principal -->
                <div class="col-lg-8">
                    <!-- Productos del Pedido -->
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <span><i class="ti-package"></i> Productos (<?php echo count($items); ?>)</span>
                        </h3>

                        <?php foreach ($items as $item): ?>
                        <div class="producto-item">
                            <img src="img/product/<?php echo htmlspecialchars($item['producto_imagen'] ?? 'img/product/default.jpg'); ?>"
                                alt="<?php echo htmlspecialchars($item['producto_nombre']); ?>"
                                class="producto-imagen">
                            <div class="producto-info">
                                <div class="producto-nombre">
                                    <?php echo htmlspecialchars($item['producto_nombre']); ?>
                                </div>
                                <div class="producto-sku">
                                    SKU: <?php echo htmlspecialchars($item['producto_sku']); ?>
                                </div>
                            </div>
                            <div class="producto-cantidad">
                                <strong>Cantidad:</strong> <?php echo $item['cantidad']; ?>
                            </div>
                            <div class="producto-precio">
                                $<?php echo number_format($item['precio_unitario'], 0, ',', '.'); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Resumen de Totales -->
                        <div class="resumen-total">
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span>$<?php echo number_format($pedido['subtotal'], 0, ',', '.'); ?></span>
                            </div>
                            <?php if ($pedido['descuento'] > 0): ?>
                            <div class="total-row">
                                <span>Descuento:</span>
                                <span class="text-success">-$<?php echo number_format($pedido['descuento'], 0, ',', '.'); ?></span>
                            </div>
                            <?php endif; ?>
                            <div class="total-row">
                                <span>Impuestos (IVA):</span>
                                <span>$<?php echo number_format($pedido['impuestos'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="total-row total-final">
                                <span>TOTAL:</span>
                                <span>$<?php echo number_format($pedido['total'], 0, ',', '.'); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Dirección de Envío -->
                    <?php if (!empty($pedido['direccion_envio'])): ?>
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <i class="ti-location-pin"></i> Dirección de Envío
                        </h3>
                        <div class="direccion-envio">
                            <p class="mb-1">
                                <i class="ti-home"></i>
                                <strong><?php echo htmlspecialchars($pedido['direccion_envio']); ?></strong>
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="ti-map-alt"></i>
                                <?php echo htmlspecialchars($pedido['ciudad_envio'] ?? ''); ?>,
                                <?php echo htmlspecialchars($pedido['departamento_envio'] ?? ''); ?>
                                <?php if (!empty($pedido['codigo_postal_envio'])): ?>
                                - CP: <?php echo htmlspecialchars($pedido['codigo_postal_envio']); ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Observaciones -->
                    <?php if (!empty($pedido['observaciones'])): ?>
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <i class="ti-comment"></i> Observaciones
                        </h3>
                        <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($pedido['observaciones'])); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Columna Lateral -->
                <div class="col-lg-4">
                    <!-- Información del Pedido -->
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <i class="ti-info-alt"></i> Información
                        </h3>

                        <div class="info-row">
                            <span class="info-label">Número de Pedido:</span>
                            <span class="info-value">#<?php echo htmlspecialchars($pedido['numero_pedido']); ?></span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Estado:</span>
                            <span class="info-value">
                                <span class="badge badge-<?php echo strtolower($pedido['estado_nombre']); ?>">
                                    <?php echo htmlspecialchars($pedido['estado_nombre']); ?>
                                </span>
                            </span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Método de Pago:</span>
                            <span class="info-value"><?php echo htmlspecialchars($pedido['metodo_pago_nombre']); ?></span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Tipo de Pedido:</span>
                            <span class="info-value"><?php echo ucfirst(htmlspecialchars($pedido['tipo_pedido'])); ?></span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Total Items:</span>
                            <span class="info-value"><?php echo count($items); ?> producto(s)</span>
                        </div>
                    </div>

                    <!-- Timeline del Pedido -->
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <i class="ti-time"></i> Historial
                        </h3>

                        <div class="timeline">
                            <div class="timeline-item active">
                                <div class="timeline-fecha">
                                    <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?>
                                </div>
                                <div class="timeline-estado">Pedido Realizado</div>
                            </div>

                            <?php if ($pedido['estado_pedido_id'] >= 2): ?>
                            <div class="timeline-item active">
                                <div class="timeline-fecha">
                                    <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_actualizacion'] ?? $pedido['fecha_pedido'])); ?>
                                </div>
                                <div class="timeline-estado">En Procesamiento</div>
                            </div>
                            <?php endif; ?>

                            <?php if ($pedido['estado_pedido_id'] >= 3): ?>
                            <div class="timeline-item active">
                                <div class="timeline-fecha">
                                    <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_actualizacion'] ?? $pedido['fecha_pedido'])); ?>
                                </div>
                                <div class="timeline-estado">Enviado</div>
                            </div>
                            <?php endif; ?>

                            <?php if ($pedido['estado_pedido_id'] == 4): ?>
                            <div class="timeline-item active">
                                <div class="timeline-fecha">
                                    <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_actualizacion'] ?? $pedido['fecha_pedido'])); ?>
                                </div>
                                <div class="timeline-estado">Entregado</div>
                            </div>
                            <?php endif; ?>

                            <?php if ($pedido['estado_pedido_id'] == 5): ?>
                            <div class="timeline-item active">
                                <div class="timeline-fecha">
                                    <?php echo date('d/m/Y H:i', strtotime($pedido['fecha_actualizacion'] ?? $pedido['fecha_pedido'])); ?>
                                </div>
                                <div class="timeline-estado text-danger">Cancelado</div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <i class="ti-settings"></i> Acciones
                        </h3>

                        <a href="perfil" class="btn btn-outline-custom btn-block mb-3">
                            <i class="ti-arrow-left mr-2"></i>
                            Volver a Mis Pedidos
                        </a>

                        <?php if ($pedido['estado_pedido_id'] == 1): ?>
                        <button class="btn btn-danger-custom btn-block" onclick="cancelarPedido(<?php echo $pedido['id']; ?>)">
                            <i class="ti-close mr-2"></i>
                            Cancelar Pedido
                        </button>
                        <?php endif; ?>

                        <button class="btn btn-warning-custom btn-block" onclick="window.print()">
                            <i class="ti-printer mr-2"></i>
                            Imprimir Pedido
                        </button>
                    </div>

                    <!-- Ayuda -->
                    <div class="pedido-card">
                        <h3 class="section-title">
                            <i class="ti-help-alt"></i> ¿Necesitas Ayuda?
                        </h3>
                        <p class="text-muted mb-3">Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
                        <a href="contact" class="btn btn-outline-custom btn-block">
                            <i class="ti-headphone-alt mr-2"></i>
                            Contactar Soporte
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../../cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    // Cancelar pedido
    function cancelarPedido(pedidoId) {
        if (!confirm('¿Estás seguro de que deseas cancelar este pedido?')) {
            return;
        }

        const formData = new FormData();
        formData.append('pedido_id', pedidoId);

        fetch('pedido/cancelar', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pedido cancelado exitosamente');
                    location.reload();
                } else {
                    alert(data.message || 'Error al cancelar el pedido');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cancelar el pedido');
            });
    }
    </script>
</body>

</html>
