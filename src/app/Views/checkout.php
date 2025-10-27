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
    <title>Karma Shop</title>
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
    .checkout-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .checkout-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #ffba00;
    }

    .direccion-item,
    .metodo-pago-item {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .direccion-item:hover,
    .metodo-pago-item:hover {
        border-color: #ffba00;
        background: #fffbf0;
    }

    .direccion-item.selected,
    .metodo-pago-item.selected {
        border-color: #ffba00;
        background: #fffbf0;
        box-shadow: 0 0 0 3px rgba(255, 186, 0, 0.1);
    }

    .direccion-item input[type="radio"],
    .metodo-pago-item input[type="radio"] {
        margin-right: 12px;
    }

    .product-mini {
        display: flex;
        align-items: center;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 12px;
    }

    .product-mini img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 15px;
    }

    .product-mini-info {
        flex: 1;
    }

    .product-mini-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .product-mini-price {
        color: #ffba00;
        font-weight: 600;
    }

    .order-summary {
        background: white;
        border-radius: 12px;
        padding: 25px;
        position: sticky;
        top: 20px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-total {
        font-size: 24px;
        font-weight: 700;
        color: #ffba00;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px solid #ffba00;
    }

    .btn-finalizar {
        width: 100%;
        padding: 18px;
        font-size: 18px;
        font-weight: 700;
        background: linear-gradient(135deg, #ffba00 0%, #ff9000 100%);
        color: white;
        border: none;
        border-radius: 50px;
        margin-top: 20px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 186, 0, 0.3);
    }

    .btn-finalizar:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 186, 0, 0.4);
    }

    .btn-finalizar:disabled {
        background: #ccc;
        cursor: not-allowed;
        box-shadow: none;
    }

    .badge-envio-gratis {
        background: #28a745;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .alert-info-custom {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    /* Controles de cantidad */
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-qty {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        width: 30px;
        height: 30px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-qty:hover {
        background: #ffba00;
        border-color: #ffba00;
        color: white;
    }

    .qty-input {
        width: 50px;
        height: 30px;
        text-align: center;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-weight: 600;
    }

    /* Botón eliminar */
    .btn-eliminar-item {
        background: transparent;
        border: none;
        color: #dc3545;
        padding: 5px 10px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-eliminar-item:hover {
        color: #c82333;
        transform: scale(1.1);
    }

    /* Formulario de tarjeta */
    #formulario-tarjeta {
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
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
                    <h1>Finalizar Compra</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="cart">Carrito<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Checkout</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Checkout -->
    <section class="checkout-section">
        <div class="container">
            <div class="row">
                <!-- Formulario de Checkout -->
                <div class="col-lg-8">
                    <!-- Información de envío -->
                    <div class="checkout-card">
                        <h3 class="section-title">
                            <i class="ti-location-pin mr-2"></i>
                            Dirección de Envío
                        </h3>

                        <?php if (empty($direcciones)): ?>
                        <div class="alert alert-warning">
                            <i class="ti-info-alt mr-2"></i>
                            No tienes direcciones guardadas. Por favor agrega una dirección para continuar.
                        </div>
                        <?php else: ?>
                        <?php foreach ($direcciones as $direccion): ?>
                        <div class="direccion-item <?php echo $direccion['es_principal'] ? 'selected' : ''; ?>"
                            onclick="seleccionarDireccion(<?php echo $direccion['id']; ?>)">
                            <div class="d-flex align-items-start">
                                <input type="radio" name="direccion_id" value="<?php echo $direccion['id']; ?>"
                                    <?php echo $direccion['es_principal'] ? 'checked' : ''; ?> required>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold mb-2">
                                        <?php echo htmlspecialchars($direccion['direccion']); ?>
                                    </div>
                                    <div class="text-muted">
                                        <?php echo htmlspecialchars($direccion['ciudad']); ?>,
                                        <?php echo htmlspecialchars($direccion['departamento']); ?>
                                        <?php if ($direccion['codigo_postal']): ?>
                                        - CP: <?php echo htmlspecialchars($direccion['codigo_postal']); ?>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($direccion['es_principal']): ?>
                                    <span class="badge badge-success mt-2">Dirección Principal</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Botón agregar nueva dirección -->
                        <button type="button" class="btn btn-outline-warning btn-block mt-3" data-toggle="modal"
                            data-target="#modalNuevaDireccion">
                            <i class="ti-plus mr-2"></i>
                            Agregar Nueva Dirección
                        </button>
                    </div>

                    <!-- Método de Pago -->
                    <div class="checkout-card">
                        <h3 class="section-title">
                            <i class="ti-credit-card mr-2"></i>
                            Método de Pago
                        </h3>

                        <?php foreach ($metodosPago as $metodo): ?>
                        <div class="metodo-pago-item"
                            onclick="seleccionarMetodoPago(<?php echo $metodo['id']; ?>, '<?php echo htmlspecialchars($metodo['nombre']); ?>')">
                            <div class="d-flex align-items-center">
                                <input type="radio" name="metodo_pago_id" value="<?php echo $metodo['id']; ?>"
                                    data-nombre="<?php echo htmlspecialchars($metodo['nombre']); ?>" required>
                                <div class="flex-grow-1">
                                    <div class="font-weight-bold">
                                        <?php echo htmlspecialchars($metodo['nombre']); ?>
                                    </div>
                                    <?php if ($metodo['descripcion']): ?>
                                    <div class="text-muted small mt-1">
                                        <?php echo htmlspecialchars($metodo['descripcion']); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php
                                    // Iconos según el método de pago
                                    $iconos = [
                                        'Efectivo' => 'ti-money',
                                        'Tarjeta de Crédito' => 'ti-credit-card',
                                        'Tarjeta Débito' => 'ti-credit-card',
                                        'Tarjeta' => 'ti-credit-card',
                                        'Transferencia Bancaria' => 'ti-exchange-vertical',
                                        'MercadoPago' => 'ti-wallet'
                                    ];
                                    $icono = $iconos[$metodo['nombre']] ?? 'ti-wallet';
                                    ?>
                                <i class="<?php echo $icono; ?> text-warning" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- Formulario de Tarjeta (oculto por defecto) -->
                        <div id="formulario-tarjeta" class="mt-4" style="display: none;">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <i class="ti-credit-card mr-2"></i>
                                    <strong>Datos de la Tarjeta</strong>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="titular_tarjeta">Nombre del Titular *</label>
                                        <input type="text" class="form-control" id="titular_tarjeta"
                                            name="titular_tarjeta" placeholder="Ej: Juan Pérez"
                                            pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo letras y espacios">
                                    </div>

                                    <div class="form-group">
                                        <label for="numero_tarjeta">Número de Tarjeta *</label>
                                        <input type="text" class="form-control" id="numero_tarjeta"
                                            name="numero_tarjeta" placeholder="1234 5678 9012 3456" maxlength="19"
                                            pattern="[0-9\s]{13,19}" title="Solo números (13-19 dígitos)">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_expiracion">Fecha de Expiración *</label>
                                                <input type="text" class="form-control" id="fecha_expiracion"
                                                    name="fecha_expiracion" placeholder="MM/AA" maxlength="5"
                                                    pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Formato: MM/AA">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cvv">CVV/CVC *</label>
                                                <input type="text" class="form-control" id="cvv" name="cvv"
                                                    placeholder="123" maxlength="4" pattern="[0-9]{3,4}"
                                                    title="Código de seguridad (3-4 dígitos)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-info mb-0">
                                        <i class="ti-info-alt mr-2"></i>
                                        <small>
                                            Tus datos están protegidos y encriptados. No almacenamos información de
                                            tarjetas.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="checkout-card">
                        <h3 class="section-title">
                            <i class="ti-comment-alt mr-2"></i>
                            Notas del Pedido (Opcional)
                        </h3>
                        <textarea class="form-control" name="observaciones" rows="4"
                            placeholder="¿Alguna instrucción especial para la entrega?"></textarea>
                    </div>
                </div>

                <!-- Resumen del Pedido -->
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h3 class="section-title">Resumen del Pedido</h3>

                        <!-- Productos -->
                        <div class="mb-4" id="productos-resumen">
                            <?php foreach ($itemsCarrito as $item): ?>
                            <?php
                                    $precioFinal = $item['precio_oferta'] ?? $item['precio'];
                                    $subtotalItem = $precioFinal * $item['cantidad'];
                                    $tieneOferta = !empty($item['precio_oferta']) && $item['precio_oferta'] < $item['precio'];
                                    
                                    // Calcular porcentaje de descuento
                                    $porcentajeDescuento = 0;
                                    if ($tieneOferta) {
                                        $porcentajeDescuento = round((($item['precio'] - $item['precio_oferta']) / $item['precio']) * 100);
                                    }
                                ?>
                            <div class="product-mini" data-carrito-id="<?php echo $item['id']; ?>">
                                <img src="img/product/<?php echo htmlspecialchars($item['imagen_principal'] ?? 'default.jpg'); ?>"
                                    alt="<?php echo htmlspecialchars($item['producto_nombre']); ?>">
                                <div class="product-mini-info">
                                    <div class="product-mini-name">
                                        <?php echo htmlspecialchars($item['producto_nombre']); ?>
                                    </div>

                                    <!-- Control de cantidad -->
                                    <div class="quantity-control mt-2 mb-2">
                                        <button type="button" class="btn-qty"
                                            onclick="cambiarCantidad(<?php echo $item['id']; ?>, -1)">
                                            <i class="ti-minus"></i>
                                        </button>
                                        <input type="number" class="qty-input" id="qty-<?php echo $item['id']; ?>"
                                            value="<?php echo $item['cantidad']; ?>" min="1"
                                            max="<?php echo $item['stock']; ?>" readonly>
                                        <button type="button" class="btn-qty"
                                            onclick="cambiarCantidad(<?php echo $item['id']; ?>, 1)">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Precio con oferta visual -->
                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="product-mini-price mr-2">
                                                <?php echo formatearPrecio($subtotalItem); ?>
                                            </div>

                                            <?php if ($tieneOferta): ?>
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted"
                                                    style="text-decoration: line-through; font-size: 12px;">
                                                    <?php echo formatearPrecio($item['precio'] * $item['cantidad']); ?>
                                                </span>
                                                <span class="badge badge-success ml-1"
                                                    style="font-size: 10px; padding: 3px 6px;">
                                                    -<?php echo $porcentajeDescuento; ?>%
                                                </span>
                                            </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Botón eliminar -->
                                        <button type="button" class="btn-eliminar-item"
                                            onclick="eliminarItem(<?php echo $item['id']; ?>)"
                                            title="Eliminar producto">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                        <style>
                        /* Asegurar que el precio con oferta se vea bien en todas las pantallas */
                        .product-mini-price {
                            color: #ffba00;
                            font-weight: 600;
                            font-size: 16px;
                        }

                        .badge-success {
                            background-color: #28a745 !important;
                        }

                        /* Responsive para pantallas pequeñas */
                        @media (max-width: 576px) {
                            .product-mini-info .d-flex.justify-content-between {
                                flex-direction: column;
                                align-items: flex-start !important;
                            }

                            .product-mini-info .d-flex.justify-content-between>div:first-child {
                                margin-bottom: 8px;
                            }

                            .btn-eliminar-item {
                                align-self: flex-end;
                                margin-top: -30px;
                            }
                        }
                        </style>

                        <!-- Totales con IDs únicos para JavaScript -->
                        <div class="summary-row" id="summary-subtotal">
                            <span>Subtotal:</span>
                            <strong id="valor-subtotal"><?php echo formatearPrecio($subtotal); ?></strong>
                        </div>

                        <div class="summary-row" id="summary-iva">
                            <span>IVA (19%):</span>
                            <strong id="valor-iva"><?php echo formatearPrecio($impuestos); ?></strong>
                        </div>

                        <div class="summary-row" id="summary-envio">
                            <span>Envío:</span>
                            <strong id="valor-envio">
                                <?php if ($envio == 0): ?>
                                <span class="badge-envio-gratis">GRATIS</span>
                                <?php else: ?>
                                <?php echo formatearPrecio($envio); ?>
                                <?php endif; ?>
                            </strong>
                        </div>

                        <?php if ($subtotal < 150000): ?>
                        <div class="alert-info-custom small mt-3" id="alerta-envio-gratis">
                            <i class="ti-truck mr-2"></i>
                            Envío gratis en compras mayores a $150.000
                        </div>
                        <?php endif; ?>

                        <div class="summary-row summary-total" id="summary-total">
                            <span>Total:</span>
                            <strong id="valor-total"><?php echo formatearPrecio($total); ?></strong>
                        </div>

                        <!-- Botón Finalizar -->
                        <button type="button" class="btn btn-finalizar" id="btnFinalizarPedido"
                            onclick="finalizarPedido()">
                            <i class="ti-check mr-2"></i>
                            Finalizar Pedido
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="ti-lock mr-1"></i>
                                Pago 100% seguro
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Nueva Dirección -->
    <div class="modal fade" id="modalNuevaDireccion" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti-location-pin mr-2"></i>
                        Nueva Dirección
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNuevaDireccion">
                        <div class="form-group">
                            <label>Dirección Completa *</label>
                            <input type="text" class="form-control" name="direccion"
                                placeholder="Ej: Calle 123 #45-67 Apto 301" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ciudad *</label>
                                    <input type="text" class="form-control" name="ciudad"
                                        placeholder="Ej: Barrancabermeja" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Departamento *</label>
                                    <input type="text" class="form-control" name="departamento"
                                        placeholder="Ej: Santander" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Código Postal</label>
                                    <input type="text" class="form-control" name="codigo_postal"
                                        placeholder="Ej: 687031">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>País</label>
                                    <input type="text" class="form-control" name="pais" value="Colombia" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="esPrincipal"
                                    name="es_principal">
                                <label class="custom-control-label" for="esPrincipal">
                                    Establecer como dirección principal
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-warning" onclick="guardarDireccion()">
                        <i class="ti-save mr-2"></i>
                        Guardar Dirección
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/carrito.js"></script>

    <script>
    // ============================================================
    // FUNCIONES DE CHECKOUT - VERSIÓN CORREGIDA
    // ============================================================

    // Seleccionar dirección
    function seleccionarDireccion(id) {
        // Remover clase selected de todas
        document.querySelectorAll('.direccion-item').forEach(item => {
            item.classList.remove('selected');
        });

        // Agregar clase selected a la seleccionada
        event.currentTarget.classList.add('selected');

        // Marcar radio button
        const radio = document.querySelector(`input[name="direccion_id"][value="${id}"]`);
        if (radio) radio.checked = true;
    }

    // Seleccionar método de pago
    function seleccionarMetodoPago(id, nombre) {
        // Remover clase selected de todos
        document.querySelectorAll('.metodo-pago-item').forEach(item => {
            item.classList.remove('selected');
        });

        // Agregar clase selected al seleccionado
        event.currentTarget.classList.add('selected');

        // Marcar radio button
        const radio = document.querySelector(`input[name="metodo_pago_id"][value="${id}"]`);
        if (radio) radio.checked = true;

        // Mostrar/ocultar formulario de tarjeta
        const formularioTarjeta = document.getElementById('formulario-tarjeta');
        if (formularioTarjeta) {
            const esTarjeta = nombre.toLowerCase().includes('tarjeta');
            formularioTarjeta.style.display = esTarjeta ? 'block' : 'none';

            // Hacer campos requeridos si es tarjeta
            const camposTarjeta = formularioTarjeta.querySelectorAll('input[type="text"]');
            camposTarjeta.forEach(campo => {
                campo.required = esTarjeta;
            });
        }
    }

    // Guardar nueva dirección
    function guardarDireccion() {
        const form = document.getElementById('formNuevaDireccion');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);

        fetch('api/guardar-direccion', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Dirección guardada exitosamente');
                    location.reload();
                } else {
                    alert(data.message || 'Error al guardar la dirección');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la dirección');
            });
    }

    // Actualizar totales en el resumen
    function actualizarTotales(data) {
        const formatoPrecio = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        });

        try {
            // Actualizar subtotal
            const subtotalElement = document.getElementById('valor-subtotal');
            if (subtotalElement) {
                subtotalElement.textContent = formatoPrecio.format(data.subtotal);
            }

            // Actualizar IVA
            const ivaElement = document.getElementById('valor-iva');
            if (ivaElement) {
                ivaElement.textContent = formatoPrecio.format(data.iva);
            }

            // Actualizar envío
            const envioElement = document.getElementById('valor-envio');
            if (envioElement) {
                if (data.envio === 0 || data.envio === '0') {
                    envioElement.innerHTML = '<span class="badge-envio-gratis">GRATIS</span>';
                } else {
                    envioElement.textContent = formatoPrecio.format(data.envio);
                }
            }

            // Actualizar total
            const totalElement = document.getElementById('valor-total');
            if (totalElement) {
                totalElement.textContent = formatoPrecio.format(data.total);
            }

            // Mostrar/ocultar alerta de envío gratis
            const alertaEnvio = document.getElementById('alerta-envio-gratis');
            if (alertaEnvio) {
                if (data.subtotal >= 150000) {
                    alertaEnvio.style.display = 'none';
                } else {
                    alertaEnvio.style.display = 'block';
                }
            }

            console.log('✅ Totales actualizados correctamente');

        } catch (error) {
            console.error('❌ Error al actualizar totales:', error);
        }
    }

    // Cambiar cantidad de producto
    function cambiarCantidad(carritoId, cambio) {
        const inputQty = document.getElementById('qty-' + carritoId);
        if (!inputQty) return;

        const cantidadActual = parseInt(inputQty.value);
        const nuevaCantidad = cantidadActual + cambio;
        const stockMax = parseInt(inputQty.max);

        // Validar límites
        if (nuevaCantidad < 1) {
            alert('La cantidad mínima es 1');
            return;
        }

        if (nuevaCantidad > stockMax) {
            alert('Stock máximo alcanzado (' + stockMax + ' unidades)');
            return;
        }

        // Actualizar visualmente primero
        inputQty.value = nuevaCantidad;

        // Enviar petición al servidor
        const formData = new FormData();
        formData.append('carrito_id', carritoId);
        formData.append('cantidad', nuevaCantidad);

        fetch('api/actualizar-cantidad', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('✅ Cantidad actualizada:', data);

                    // Actualizar totales con los datos del servidor
                    actualizarTotales({
                        subtotal: data.subtotal,
                        iva: data.iva,
                        envio: data.envio,
                        total: data.total
                    });

                    // Actualizar precio del item individual
                    const productMini = document.querySelector(`[data-carrito-id="${carritoId}"]`);
                    if (productMini && data.precio_item) {
                        const precioElement = productMini.querySelector('.product-mini-price');
                        if (precioElement) {
                            precioElement.textContent = new Intl.NumberFormat('es-CO', {
                                style: 'currency',
                                currency: 'COP',
                                minimumFractionDigits: 0
                            }).format(data.precio_item);
                        }
                    }

                    // Actualizar contador del carrito en header
                    if (data.total_items !== undefined) {
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.total_items;
                            cartCount.style.display = data.total_items > 0 ? 'flex' : 'none';
                        }
                    }

                } else {
                    alert(data.message || 'Error al actualizar cantidad');
                    // Revertir cambio visual
                    inputQty.value = cantidadActual;
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                alert('Error al actualizar cantidad');
                // Revertir cambio visual
                inputQty.value = cantidadActual;
            });
    }

    // Eliminar item del carrito
    function eliminarItem(carritoId) {
        if (!confirm('¿Estás seguro de eliminar este producto del carrito?')) {
            return;
        }

        const formData = new FormData();
        formData.append('carrito_id', carritoId);

        fetch('api/eliminar-item', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('✅ Item eliminado:', data);

                    // Eliminar elemento del DOM con animación
                    const productMini = document.querySelector(`[data-carrito-id="${carritoId}"]`);
                    if (productMini) {
                        productMini.style.transition = 'opacity 0.3s, transform 0.3s';
                        productMini.style.opacity = '0';
                        productMini.style.transform = 'translateX(-20px)';

                        setTimeout(() => {
                            productMini.remove();
                        }, 300);
                    }

                    // Actualizar totales
                    actualizarTotales({
                        subtotal: data.subtotal,
                        iva: data.iva,
                        envio: data.envio,
                        total: data.total
                    });

                    // Actualizar contador del carrito
                    if (data.itemsCount !== undefined) {
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.itemsCount;
                            cartCount.style.display = data.itemsCount > 0 ? 'flex' : 'none';
                        }
                    }

                    // Si el carrito está vacío, redirigir después de un momento
                    if (data.itemsCount === 0) {
                        setTimeout(() => {
                            window.location.href = 'cart';
                        }, 1000);
                    }

                } else {
                    alert(data.message || 'Error al eliminar producto');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                alert('Error al eliminar producto');
            });
    }

    // Finalizar pedido
    function finalizarPedido() {
        const btnFinalizar = document.getElementById('btnFinalizarPedido');

        // Validar dirección
        const direccionSeleccionada = document.querySelector('input[name="direccion_id"]:checked');
        if (!direccionSeleccionada) {
            alert('Por favor selecciona una dirección de envío');
            return;
        }

        // Validar método de pago
        const metodoPagoSeleccionado = document.querySelector('input[name="metodo_pago_id"]:checked');
        if (!metodoPagoSeleccionado) {
            alert('Por favor selecciona un método de pago');
            return;
        }

        // Validar datos de tarjeta si es necesario
        const formularioTarjeta = document.getElementById('formulario-tarjeta');
        if (formularioTarjeta && formularioTarjeta.style.display !== 'none') {
            const titular = document.getElementById('titular_tarjeta').value;
            const numero = document.getElementById('numero_tarjeta').value;
            const fecha = document.getElementById('fecha_expiracion').value;
            const cvv = document.getElementById('cvv').value;

            if (!titular || !numero || !fecha || !cvv) {
                alert('Por favor completa todos los datos de la tarjeta');
                return;
            }
        }

        // Deshabilitar botón
        btnFinalizar.disabled = true;
        btnFinalizar.innerHTML = '<i class="ti-reload mr-2 rotate"></i> Procesando...';

        // Agregar animación de rotación
        const style = document.createElement('style');
        style.textContent = `
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .rotate { animation: rotate 1s linear infinite; }
    `;
        document.head.appendChild(style);

        // Obtener datos
        const formData = new FormData();
        formData.append('direccion_id', direccionSeleccionada.value);
        formData.append('metodo_pago_id', metodoPagoSeleccionado.value);

        const observaciones = document.querySelector('textarea[name="observaciones"]').value;
        if (observaciones) {
            formData.append('observaciones', observaciones);
        }

        // Enviar petición
        fetch('api/procesar-pedido', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    btnFinalizar.innerHTML = '<i class="ti-check mr-2"></i> ¡Pedido Confirmado!';
                    btnFinalizar.style.background = '#28a745';

                    // Abrir WhatsApp con el mensaje del pedido
                    if (data.whatsapp_url) {
                        // Mostrar modal de confirmación antes de abrir WhatsApp
                        if (confirm('¡Pedido registrado exitosamente! ¿Deseas enviar los detalles del pedido por WhatsApp para confirmar tu pago?')) {
                            // Abrir WhatsApp en nueva pestaña
                            window.open(data.whatsapp_url, '_blank');
                        }
                    }

                    // Redirigir a página de confirmación después de 2 segundos
                    setTimeout(() => {
                        window.location.href = `confirmation?pedido=${data.numero_pedido}`;
                    }, 2000);
                } else {
                    alert(data.message || 'Error al procesar el pedido');
                    btnFinalizar.disabled = false;
                    btnFinalizar.innerHTML = '<i class="ti-check mr-2"></i> Finalizar Pedido';
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                alert('Error al procesar el pedido. Por favor intenta nuevamente.');
                btnFinalizar.disabled = false;
                btnFinalizar.innerHTML = '<i class="ti-check mr-2"></i> Finalizar Pedido';
            });
    }

    // Auto-seleccionar opciones al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🚀 Página de checkout cargada');

        // Auto-seleccionar primera dirección si no hay ninguna seleccionada
        const direccionChecked = document.querySelector('input[name="direccion_id"]:checked');
        if (!direccionChecked) {
            const primeraDireccion = document.querySelector('input[name="direccion_id"]');
            if (primeraDireccion) {
                primeraDireccion.checked = true;
                primeraDireccion.closest('.direccion-item').classList.add('selected');
            }
        }

        // Auto-seleccionar primer método de pago
        const metodoPagoChecked = document.querySelector('input[name="metodo_pago_id"]:checked');
        if (!metodoPagoChecked) {
            const primerMetodo = document.querySelector('input[name="metodo_pago_id"]');
            if (primerMetodo) {
                primerMetodo.checked = true;
                primerMetodo.closest('.metodo-pago-item').classList.add('selected');
            }
        }

        // Formatear entrada de número de tarjeta
        const numeroTarjeta = document.getElementById('numero_tarjeta');
        if (numeroTarjeta) {
            numeroTarjeta.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
            });
        }

        // Formatear entrada de fecha de expiración
        const fechaExpiracion = document.getElementById('fecha_expiracion');
        if (fechaExpiracion) {
            fechaExpiracion.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2, 4);
                }
                e.target.value = value;
            });
        }

        // Solo números en CVV
        const cvv = document.getElementById('cvv');
        if (cvv) {
            cvv.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }
    });
    </script>
</body>

</html>