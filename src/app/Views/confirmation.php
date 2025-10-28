<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Tennis y Zapatos">
    <meta name="description" content="Confirmación de pedido">
    <title>Pedido Confirmado - Tennis y Zapatos</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/main.css">

    <style>
    .confirmation-section {
        padding: 60px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .confirmation-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .success-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 30px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: scaleIn 0.5s ease-out;
        box-shadow: 0 10px 40px rgba(40, 167, 69, 0.3);
    }

    .success-icon i {
        font-size: 50px;
        color: white;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }

        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .confirmation-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-bottom: 30px;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .order-number {
        font-size: 32px;
        font-weight: 700;
        color: #ffba00;
        margin-bottom: 10px;
    }

    .order-status {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
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

    .product-item {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }

    .product-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
    }

    .product-meta {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        font-size: 14px;
        color: #6c757d;
    }

    .product-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .talla-badge {
        background: #ffba00;
        color: white;
        padding: 4px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 700;
    }

    .product-price {
        text-align: right;
        flex-shrink: 0;
    }

    .price-value {
        font-size: 18px;
        font-weight: 700;
        color: #28a745;
    }

    .price-quantity {
        font-size: 12px;
        color: #6c757d;
    }

    .address-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #ffba00;
    }

    .address-box i {
        color: #ffba00;
        font-size: 20px;
        margin-right: 10px;
    }

    .totals-section {
        background: linear-gradient(135deg, #ffba00 0%, #ff9000 100%);
        color: white;
        padding: 25px;
        border-radius: 10px;
        margin-top: 20px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 16px;
    }

    .total-row.grand-total {
        border-top: 2px solid rgba(255, 255, 255, 0.3);
        margin-top: 10px;
        padding-top: 15px;
        font-size: 24px;
        font-weight: 700;
    }

    .redirect-notice {
        text-align: center;
        padding: 20px;
        background: #e3f2fd;
        border-radius: 10px;
        margin-top: 20px;
    }

    .redirect-notice i {
        font-size: 24px;
        color: #2196f3;
        margin-bottom: 10px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .countdown {
        font-size: 36px;
        font-weight: 700;
        color: #2196f3;
        margin: 10px 0;
    }

    .btn-action {
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s;
        margin: 10px;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #ffba00 0%, #ff9000 100%);
        color: white;
        border: none;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(255, 186, 0, 0.4);
    }

    .btn-secondary-custom {
        background: white;
        color: #333;
        border: 2px solid #dee2e6;
    }

    .btn-secondary-custom:hover {
        background: #f8f9fa;
        border-color: #ffba00;
        color: #ffba00;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ffba00;
    }

    @media (max-width: 768px) {
        .confirmation-card {
            padding: 25px 20px;
        }

        .order-number {
            font-size: 24px;
        }

        .product-item {
            flex-direction: column;
        }

        .product-price {
            text-align: left;
        }

        .btn-action {
            width: 100%;
            margin: 5px 0;
        }
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
                    <h1>Confirmación de Pedido</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="checkout">Checkout<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Confirmación</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Confirmación -->
    <section class="confirmation-section">
        <div class="container confirmation-container">
            <!-- Icono de éxito -->
            <div class="text-center">
                <div class="success-icon">
                    <i class="ti-check"></i>
                </div>
                <h1 style="font-size: 36px; font-weight: 700; color: #333; margin-bottom: 10px;">
                    ¡Pedido Confirmado!
                </h1>
                <p style="font-size: 18px; color: #6c757d; margin-bottom: 30px;">
                    Gracias por tu compra. Hemos recibido tu pedido correctamente.
                </p>
            </div>

            <!-- Información del Pedido -->
            <div class="confirmation-card">
                <div class="text-center mb-4">
                    <div class="order-number">
                        #<?php echo htmlspecialchars($pedido['numero_pedido']); ?>
                    </div>
                    <span class="order-status status-pending">
                        <i class="ti-time"></i>
                        <?php echo htmlspecialchars($pedido['estado_nombre']); ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="ti-calendar"></i> Fecha del pedido:</span>
                    <span class="info-value">
                        <?php 
                        $fecha = new DateTime($pedido['fecha_pedido']);
                        echo $fecha->format('d/m/Y H:i'); 
                        ?>
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="ti-credit-card"></i> Método de pago:</span>
                    <span class="info-value"><?php echo htmlspecialchars($metodoPago['nombre']); ?></span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="ti-email"></i> Correo electrónico:</span>
                    <span class="info-value"><?php echo htmlspecialchars($pedido['usuario_email']); ?></span>
                </div>

                <?php if (!empty($pedido['usuario_telefono'])): ?>
                <div class="info-row">
                    <span class="info-label"><i class="ti-mobile"></i> Teléfono:</span>
                    <span class="info-value"><?php echo htmlspecialchars($pedido['usuario_telefono']); ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Dirección de Envío -->
            <?php if ($direccion && is_array($direccion)): ?>
            <div class="confirmation-card">
                <h3 class="section-title">
                    <i class="ti-location-pin"></i>
                    Dirección de Envío
                </h3>
                <div class="address-box">
                    <i class="ti-home"></i>
                    <strong><?php echo htmlspecialchars($direccion['direccion']); ?></strong>
                    <br>
                    <?php echo htmlspecialchars($direccion['ciudad']); ?>,
                    <?php echo htmlspecialchars($direccion['departamento']); ?>
                    <?php if (!empty($direccion['codigo_postal'])): ?>
                    - CP: <?php echo htmlspecialchars($direccion['codigo_postal']); ?>
                    <?php endif; ?>
                    <br>
                    <?php echo htmlspecialchars($direccion['pais'] ?? 'Colombia'); ?>
                </div>
            </div>
            <?php else: ?>
            <div class="confirmation-card">
                <h3 class="section-title">
                    <i class="ti-location-pin"></i>
                    Dirección de Envío
                </h3>
                <div class="address-box">
                    <i class="ti-info"></i>
                    <em>Dirección de envío no especificada</em>
                    <br>
                    <small class="text-muted">Este pedido fue creado antes de la implementación del sistema de direcciones.</small>
                </div>
            </div>
            <?php endif; ?>

            <!-- Productos del Pedido -->
            <div class="confirmation-card">
                <h3 class="section-title">
                    <i class="ti-package"></i>
                    Productos (<?php echo count($detalles); ?>)
                </h3>

                <?php foreach ($detalles as $detalle): ?>
                <div class="product-item">
                    <img src="img/product/<?php echo htmlspecialchars($detalle['imagen_principal'] ?? 'default.jpg'); ?>"
                        alt="<?php echo htmlspecialchars($detalle['producto_nombre']); ?>" class="product-image">

                    <div class="product-details">
                        <div class="product-name">
                            <?php echo htmlspecialchars($detalle['producto_nombre']); ?>
                        </div>
                        <div class="product-meta">
                            <?php if (!empty($detalle['talla_nombre'])): ?>
                            <div class="product-meta-item">
                                <span class="talla-badge">
                                    <i class="ti-ruler-alt-2"></i>
                                    Talla: <?php echo htmlspecialchars($detalle['talla_nombre']); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                            <div class="product-meta-item">
                                <i class="ti-package"></i>
                                Cantidad: <?php echo $detalle['cantidad']; ?>
                            </div>
                            <div class="product-meta-item">
                                <i class="ti-money"></i>
                                Precio unit.: <?php echo formatearPrecio($detalle['precio_unitario']); ?>
                            </div>
                        </div>
                    </div>

                    <div class="product-price">
                        <div class="price-value">
                            <?php echo formatearPrecio($detalle['subtotal']); ?>
                        </div>
                        <div class="price-quantity">
                            <?php echo $detalle['cantidad']; ?>
                            <?php echo $detalle['cantidad'] > 1 ? 'unidades' : 'unidad'; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Totales -->
                <div class="totals-section">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <strong><?php echo formatearPrecio($pedido['subtotal']); ?></strong>
                    </div>
                    <div class="total-row">
                        <span>IVA (19%):</span>
                        <strong><?php echo formatearPrecio($pedido['impuestos']); ?></strong>
                    </div>
                    <div class="total-row">
                        <span>Envío:</span>
                        <strong>
                            <?php 
                            if ($pedido['costo_envio'] == 0) {
                                echo '<span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 15px;">GRATIS</span>';
                            } else {
                                echo formatearPrecio($pedido['costo_envio']);
                            }
                            ?>
                        </strong>
                    </div>
                    <div class="total-row grand-total">
                        <span>TOTAL:</span>
                        <strong><?php echo formatearPrecio($pedido['total']); ?></strong>
                    </div>
                </div>

                <?php if (!empty($pedido['observaciones'])): ?>
                <div class="mt-4 p-3" style="background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 5px;">
                    <strong><i class="ti-comment-alt"></i> Notas del pedido:</strong>
                    <p class="mb-0 mt-2"><?php echo nl2br(htmlspecialchars($pedido['observaciones'])); ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Aviso de Redirección -->
            <div class="redirect-notice">
                <i class="ti-reload"></i>
                <p style="font-size: 16px; margin: 10px 0;">
                    Serás redirigido a tu perfil en
                </p>
                <div class="countdown" id="countdown">3</div>
                <p style="font-size: 14px; color: #6c757d;">
                    segundos...
                </p>
            </div>

            <!-- Botones de Acción -->
            <div class="text-center mt-4">
                <a href="perfil?seccion=pedidos" class="btn btn-action btn-primary-custom">
                    <i class="ti-user"></i>
                    Ir a Mis Pedidos Ahora
                </a>
                <a href="home" class="btn btn-action btn-secondary-custom">
                    <i class="ti-home"></i>
                    Volver al Inicio
                </a>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <script>
    // Cuenta regresiva y redirección automática
    let segundos = 120;
    const countdownElement = document.getElementById('countdown');

    const intervalo = setInterval(() => {
        segundos--;
        countdownElement.textContent = segundos;

        if (segundos <= 0) {
            clearInterval(intervalo);
            // Redirigir a perfil - sección pedidos
            window.location.href = 'perfil?seccion=pedidos';
        }
    }, 1000);

    // Permitir que el usuario cancele la redirección automática
    document.addEventListener('click', function(e) {
        // Si hace click en cualquier lugar excepto los botones, pausar redirección
        if (!e.target.closest('.btn-action')) {
            clearInterval(intervalo);
            countdownElement.textContent = '∞';
            document.querySelector('.redirect-notice p').innerHTML =
                '<small>Redirección automática cancelada</small>';
        }
    });
    </script>
</body>

</html>