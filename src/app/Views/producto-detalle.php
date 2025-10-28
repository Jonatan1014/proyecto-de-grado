<?php
// Incluir el archivo de helpers
require_once __DIR__ . '/../Utils/Helpers.php';
// Aseguramos que $producto, $imagenes y $productosRelacionados estén disponibles
// (Estos datos vienen del controlador ProductoController::detalle)
if (!isset($producto, $imagenes, $productosRelacionados)) {
    // Manejar error si no se reciben los datos esperados
    error_log("single-product.php: Variables \$producto, \$imagenes o \$productosRelacionados no definidas.");
    header('Location: 404');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="Tennis y Fragancias">
    <!-- Meta Description -->
    <meta name="description"
        content="<?= htmlspecialchars($producto['nombre']) ?> - <?= htmlspecialchars($producto['descripcion'] ?? '') ?>">
    <!-- Meta Keyword -->
    <meta name="keywords"
        content="calzado, <?= htmlspecialchars($producto['nombre']) ?>, <?= htmlspecialchars($producto['marca_nombre'] ?? '') ?>">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title><?= htmlspecialchars($producto['nombre']) ?> - Tennis y Fragancias</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">

    <style>
    /* Diseño profesional para página de producto */
    .product-detail-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .product-image-wrapper {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 100px;
    }

    .product-image-wrapper img {
        border-radius: 8px;
        width: 100%;
        height: auto;
        object-fit: contain;
    }

    .product-info-wrapper {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    }

    .product-title {
        font-size: 32px;
        font-weight: 700;
        color: #222;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .product-brand {
        display: inline-block;
        background: #f0f0f0;
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        margin-bottom: 20px;
    }

    .product-rating {
        margin-bottom: 20px;
    }

    .product-rating .stars {
        color: #ffba00;
        font-size: 18px;
        margin-right: 10px;
    }

    .product-rating .reviews {
        color: #999;
        font-size: 14px;
    }

    .price-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 25px;
        border-radius: 10px;
        margin: 25px 0;
    }

    .price-section.discount {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .current-price {
        font-size: 42px;
        font-weight: 800;
        color: white;
        margin: 0;
        line-height: 1;
    }

    .original-price {
        font-size: 24px;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: line-through;
        margin-right: 15px;
    }

    .discount-badge {
        display: inline-block;
        background: #ff4444;
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 700;
        margin-top: 10px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .product-features {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin: 25px 0;
    }

    .feature-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .feature-item:last-child {
        border-bottom: none;
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: #ffba00;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .feature-icon i {
        color: white;
        font-size: 18px;
    }

    .feature-label {
        font-weight: 600;
        color: #666;
        margin-right: 10px;
        min-width: 100px;
    }

    .feature-value {
        color: #222;
        font-weight: 500;
    }

    .feature-value a {
        color: #667eea;
        text-decoration: none;
        transition: all 0.3s;
    }

    .feature-value a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 14px;
        margin: 20px 0;
    }

    .stock-badge.in-stock {
        background: #d4edda;
        color: #155724;
        border: 2px solid #c3e6cb;
    }

    .stock-badge.low-stock {
        background: #fff3cd;
        color: #856404;
        border: 2px solid #ffeaa7;
    }

    .stock-badge.out-stock {
        background: #f8d7da;
        color: #721c24;
        border: 2px solid #f5c6cb;
    }

    .stock-badge i {
        margin-right: 8px;
        font-size: 16px;
    }

    /* Selector de Tallas */
    .size-selector {
        margin: 30px 0;
    }

    .size-label {
        display: block;
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 15px;
        color: #222;
    }

    .size-options {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 10px;
    }

    .size-option {
        position: relative;
        min-width: 60px;
        height: 50px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        color: #333;
        cursor: pointer;
        transition: all 0.3s;
        padding: 8px 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .size-option:hover:not(.disabled) {
        border-color: #ffba00;
        background: #fff8e6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 186, 0, 0.2);
    }

    .size-option.selected {
        border-color: #ffba00;
        background: #ffba00;
        color: white;
        box-shadow: 0 4px 12px rgba(255, 186, 0, 0.3);
    }

    .size-option.disabled {
        background: #f5f5f5;
        color: #999;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .sold-out-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        font-size: 9px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .low-stock-badge {
        position: absolute;
        bottom: -8px;
        right: -8px;
        background: #ff9800;
        color: white;
        font-size: 9px;
        padding: 2px 6px;
        border-radius: 10px;
        font-weight: 600;
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 8px;
        padding: 8px 12px;
        background: #f8d7da;
        border-radius: 6px;
        border-left: 3px solid #dc3545;
    }

    .error-message i {
        margin-right: 6px;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        margin: 25px 0;
    }

    .quantity-label {
        font-weight: 600;
        font-size: 16px;
        margin-right: 20px;
        color: #222;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }

    .quantity-btn {
        background: white;
        border: none;
        width: 45px;
        height: 45px;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s;
        color: #666;
    }

    .quantity-btn:hover {
        background: #ffba00;
        color: white;
    }

    .quantity-input {
        border: none;
        border-left: 2px solid #e0e0e0;
        border-right: 2px solid #e0e0e0;
        width: 70px;
        height: 45px;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
    }

    .cta-buttons {
        display: flex;
        gap: 15px;
        margin: 30px 0;
    }

    .btn-add-cart {
        flex: 1;
        background: linear-gradient(135deg, #ffba00 0%, #ff9900 100%);
        color: white;
        padding: 18px 35px;
        border: none;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(255, 186, 0, 0.3);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 186, 0, 0.4);
    }

    .btn-add-cart i {
        margin-right: 10px;
    }

    .btn-wishlist {
        width: 60px;
        height: 60px;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-wishlist:hover {
        border-color: #ff4444;
        background: #ff4444;
        color: white;
    }

    .btn-wishlist i {
        font-size: 24px;
    }

    .product-description {
        background: white;
        border-radius: 12px;
        padding: 40px;
        margin-top: 40px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #222;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 3px solid #ffba00;
        display: inline-block;
    }

    .description-text {
        color: #666;
        font-size: 16px;
        line-height: 1.8;
    }

    .specifications-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    .spec-item {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #ffba00;
    }

    .spec-label {
        font-weight: 600;
        color: #666;
        font-size: 14px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .spec-value {
        font-size: 18px;
        color: #222;
        font-weight: 600;
    }

    .related-products {
        background: white;
        border-radius: 12px;
        padding: 40px;
        margin-top: 40px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
    }

    .related-product-card {
        background: #f8f9fa;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
        cursor: pointer;
        height: 100%;
    }

    .related-product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .related-product-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .related-product-info {
        padding: 20px;
    }

    .related-product-name {
        font-size: 16px;
        font-weight: 600;
        color: #222;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .related-product-price {
        font-size: 20px;
        font-weight: 700;
        color: #667eea;
    }

    .trust-badges {
        display: flex;
        gap: 20px;
        margin: 30px 0;
        padding: 25px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .trust-badge {
        flex: 1;
        text-align: center;
    }

    .trust-badge i {
        font-size: 32px;
        color: #ffba00;
        margin-bottom: 10px;
    }

    .trust-badge-text {
        font-size: 13px;
        color: #666;
        font-weight: 600;
    }

    /* Breadcrumb mejorado */
    .banner-area.organic-breadcrumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 0;
    }

    .breadcrumb-banner h1 {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .breadcrumb-banner nav a {
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    .breadcrumb-banner nav a:hover {
        color: white;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .product-image-wrapper {
            position: relative;
            top: 0;
            margin-bottom: 30px;
        }

        .product-info-wrapper {
            padding: 30px 20px;
        }

        .product-title {
            font-size: 24px;
        }

        .current-price {
            font-size: 32px;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .trust-badges {
            flex-direction: column;
            gap: 15px;
        }
    }
    </style>
</head>

<body>

    <!-- Start Header Area -->
    <?php include 'includes/header.php'; ?>
    <!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1><?= htmlspecialchars($producto['nombre']) ?></h1>
                    <nav class="d-flex align-items-center">
                        <a href="/">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="/category">Catálogo<span class="lnr lnr-arrow-right"></span></a>
                        <a
                            href="/category?categoria=<?= $producto['categoria_id'] ?>"><?= htmlspecialchars($producto['categoria_nombre'] ?? 'Sin Categoría') ?></a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Single Product Area =================-->
    <section class="product-detail-section">
        <div class="container">
            <div class="row">
                <!-- Columna de Imagen -->
                <div class="col-lg-6 mb-4">
                    <div class="product-image-wrapper">
                        <div class="owl-carousel s_Product_carousel">
                            <?php if (!empty($imagenes)): ?>
                            <?php foreach ($imagenes as $imagen): ?>
                            <div class="single-prd-item">
                                <img src="img/product/<?= htmlspecialchars($imagen['url']) ?>"
                                    alt="<?= htmlspecialchars($producto['nombre']) ?>">
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="single-prd-item">
                                <img src="img/product/<?= obtenerImagenProducto($producto) ?>"
                                    alt="<?= htmlspecialchars($producto['nombre']) ?>">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Columna de Información del Producto -->
                <div class="col-lg-6">
                    <div class="product-info-wrapper">
                        <!-- Marca -->
                        <?php if (!empty($producto['marca_nombre'])): ?>
                        <span class="product-brand">
                            <i class="fa fa-tag"></i> <?= htmlspecialchars($producto['marca_nombre']) ?>
                        </span>
                        <?php endif; ?>

                        <!-- Título -->
                        <h1 class="product-title"><?= htmlspecialchars($producto['nombre']) ?></h1>

                        <!-- Rating (simulado por ahora) -->
                        <div class="product-rating">
                            <span class="stars">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </span>
                            <span class="reviews">(4.5 - 128 valoraciones)</span>
                        </div>

                        <!-- Precio -->
                        <div class="price-section <?= tieneDescuento($producto) ? 'discount' : '' ?>">
                            <?php if (tieneDescuento($producto)): ?>
                            <div>
                                <span class="original-price"><?= formatearPrecio($producto['precio']) ?></span>
                                <h2 class="current-price"><?= formatearPrecio($producto['precio_oferta']) ?></h2>
                                <span class="discount-badge">
                                    <i class="fa fa-bolt"></i>
                                    ¡AHORRA <?= number_format(calcularPorcentajeDescuento($producto), 0) ?>%!
                                </span>
                            </div>
                            <?php else: ?>
                            <h2 class="current-price"><?= formatearPrecio($producto['precio']) ?></h2>
                            <?php endif; ?>
                        </div>

                        <!-- Estado de Stock -->
                        <?php
                        $stock = intval($producto['stock'] ?? 0);
                        $stockClass = 'out-stock';
                        $stockText = 'Agotado';
                        $stockIcon = 'fa-times-circle';
                        
                        if ($stock > 10) {
                            $stockClass = 'in-stock';
                            $stockText = 'Disponible - ' . $stock . ' unidades';
                            $stockIcon = 'fa-check-circle';
                        } elseif ($stock > 0) {
                            $stockClass = 'low-stock';
                            $stockText = '¡Últimas ' . $stock . ' unidades!';
                            $stockIcon = 'fa-exclamation-circle';
                        }
                        ?>
                        <div class="stock-badge <?= $stockClass ?>">
                            <i class="fa <?= $stockIcon ?>"></i>
                            <?= $stockText ?>
                        </div>

                        <!-- Características Principales -->
                        <div class="product-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <span class="feature-label">Categoría:</span>
                                <span class="feature-value">
                                    <a href="/category?categoria=<?= $producto['categoria_id'] ?>">
                                        <?= htmlspecialchars($producto['categoria_nombre'] ?? 'Sin Categoría') ?>
                                    </a>
                                </span>
                            </div>

                            <?php if (!empty($producto['genero_nombre'])): ?>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <span class="feature-label">Género:</span>
                                <span class="feature-value">
                                    <a href="/category?genero=<?= $producto['genero_id'] ?>">
                                        <?= htmlspecialchars($producto['genero_nombre']) ?>
                                    </a>
                                </span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($producto['talla_nombre'])): ?>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa fa-expand"></i>
                                </div>
                                <span class="feature-label">Talla:</span>
                                <span class="feature-value"><?= htmlspecialchars($producto['talla_nombre']) ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($producto['color_nombre'])): ?>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa fa-paint-brush"></i>
                                </div>
                                <span class="feature-label">Color:</span>
                                <span class="feature-value"><?= htmlspecialchars($producto['color_nombre']) ?></span>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($producto['codigo_sku'])): ?>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa fa-barcode"></i>
                                </div>
                                <span class="feature-label">SKU:</span>
                                <span class="feature-value"><?= htmlspecialchars($producto['codigo_sku']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($stock > 0): ?>
                        
                        <!-- Selector de Talla -->
                        <?php if (!empty($tallasDisponibles)): ?>
                        <div class="size-selector">
                            <span class="size-label">Selecciona tu talla:</span>
                            <div class="size-options">
                                <?php foreach ($tallasDisponibles as $talla): ?>
                                <button type="button" 
                                        class="size-option <?= $talla['stock'] > 0 ? '' : 'disabled' ?>" 
                                        data-talla-id="<?= $talla['id'] ?>"
                                        data-talla-nombre="<?= htmlspecialchars($talla['nombre']) ?>"
                                        data-stock="<?= $talla['stock'] ?>"
                                        <?= $talla['stock'] == 0 ? 'disabled' : '' ?>>
                                    <?= htmlspecialchars($talla['nombre']) ?>
                                    <?php if ($talla['stock'] == 0): ?>
                                    <span class="sold-out-badge">Agotado</span>
                                    <?php elseif ($talla['stock'] < 5): ?>
                                    <span class="low-stock-badge"><?= $talla['stock'] ?> disponibles</span>
                                    <?php endif; ?>
                                </button>
                                <?php endforeach; ?>
                            </div>
                            <div id="talla-error" class="error-message" style="display: none;">
                                <i class="fa fa-exclamation-circle"></i> Por favor, selecciona una talla
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Selector de Cantidad -->
                        <div class="quantity-selector">
                            <span class="quantity-label">Cantidad:</span>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn btn-decrease">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="number" id="qty" class="quantity-input" value="1" min="1"
                                    max="<?= $stock ?>" readonly>
                                <button type="button" class="quantity-btn btn-increase">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="cta-buttons">
                            <button type="button" class="btn-add-cart" id="btn-add-to-cart"
                                data-producto-id="<?= $producto['id'] ?>" data-stock="<?= $stock ?>">
                                <i class="fa fa-shopping-cart"></i>
                                Agregar al Carrito
                            </button>
                            <button type="button" class="btn-wishlist" title="Agregar a favoritos">
                                <i class="fa fa-heart-o"></i>
                            </button>
                        </div>
                        <?php else: ?>
                        <!-- Producto Agotado -->
                        <div class="alert alert-danger" style="border-radius: 8px; padding: 20px; margin-top: 20px;">
                            <h5><i class="fa fa-exclamation-triangle"></i> Producto Agotado</h5>
                            <p class="mb-0">Este producto no está disponible en este momento. ¡Vuelve pronto!</p>
                        </div>
                        <?php endif; ?>

                        <!-- Badges de Confianza -->
                        <div class="trust-badges">
                            <div class="trust-badge">
                                <i class="fa fa-truck"></i>
                                <div class="trust-badge-text">Envío Gratis<br>a partir de $50.000</div>
                            </div>
                            <div class="trust-badge">
                                <i class="fa fa-shield"></i>
                                <div class="trust-badge-text">Compra<br>Segura</div>
                            </div>
                            <div class="trust-badge">
                                <i class="fa fa-refresh"></i>
                                <div class="trust-badge-text">Garantía<br>de Satisfacción</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Descripción y Especificaciones -->
            <div class="row">
                <div class="col-12">
                    <div class="product-description">
                        <h2 class="section-title">Descripción del Producto</h2>
                        <div class="description-text">
                            <?php if (!empty($producto['descripcion'])): ?>
                            <?= nl2br(htmlspecialchars($producto['descripcion'])) ?>
                            <?php else: ?>
                            <p>Este producto de alta calidad de
                                <?= htmlspecialchars($producto['marca_nombre'] ?? 'nuestra marca') ?>
                                es perfecto para tu estilo de vida activo. Diseñado con los mejores materiales y
                                la última tecnología en calzado deportivo.</p>
                            <?php endif; ?>
                        </div>

                        <h3 class="section-title mt-5">Especificaciones Técnicas</h3>
                        <div class="specifications-grid">
                            <div class="spec-item">
                                <div class="spec-label"><i class="fa fa-list-alt"></i> Categoría</div>
                                <div class="spec-value"><?= htmlspecialchars($producto['categoria_nombre'] ?? 'N/A') ?>
                                </div>
                            </div>
                            <div class="spec-item">
                                <div class="spec-label"><i class="fa fa-tag"></i> Marca</div>
                                <div class="spec-value"><?= htmlspecialchars($producto['marca_nombre'] ?? 'N/A') ?>
                                </div>
                            </div>
                            <?php if (!empty($producto['genero_nombre'])): ?>
                            <div class="spec-item">
                                <div class="spec-label"><i class="fa fa-user"></i> Género</div>
                                <div class="spec-value"><?= htmlspecialchars($producto['genero_nombre']) ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($producto['talla_nombre'])): ?>
                            <div class="spec-item">
                                <div class="spec-label"><i class="fa fa-expand"></i> Talla</div>
                                <div class="spec-value"><?= htmlspecialchars($producto['talla_nombre']) ?></div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($producto['color_nombre'])): ?>
                            <div class="spec-item">
                                <div class="spec-label"><i class="fa fa-paint-brush"></i> Color</div>
                                <div class="spec-value"><?= htmlspecialchars($producto['color_nombre']) ?></div>
                            </div>
                            <?php endif; ?>
                            <div class="spec-item">
                                <div class="spec-label"><i class="fa fa-cubes"></i> Disponibilidad</div>
                                <div class="spec-value"><?= $stock ?> unidades</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos Relacionados -->
            <?php if (!empty($productosRelacionados)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="related-products">
                        <h2 class="section-title">También te puede interesar</h2>
                        <p class="mb-4" style="color: #666;">Descubre otros productos similares que nuestros clientes
                            también compraron</p>

                        <div class="row">
                            <?php foreach ($productosRelacionados as $relacionado): ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <a href="producto-detalle?id=<?= $relacionado['id'] ?>" style="text-decoration: none;">
                                    <div class="related-product-card">
                                        <img src="img/product/<?= obtenerImagenProducto($relacionado) ?>"
                                            alt="<?= htmlspecialchars($relacionado['nombre']) ?>"
                                            class="related-product-image">
                                        <div class="related-product-info">
                                            <div class="related-product-name">
                                                <?= htmlspecialchars(truncarTexto($relacionado['nombre'], 50)) ?>
                                            </div>
                                            <div class="related-product-price">
                                                <?php if (tieneDescuento($relacionado)): ?>
                                                <?= formatearPrecio($relacionado['precio_oferta']) ?>
                                                <small
                                                    style="text-decoration: line-through; color: #999; font-size: 14px; display: block;">
                                                    <?= formatearPrecio($relacionado['precio']) ?>
                                                </small>
                                                <?php else: ?>
                                                <?= formatearPrecio($relacionado['precio']) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <!--================End Single Product Area =================-->

    <!-- start footer Area -->
    <?php include 'includes/footer.php'; ?>
    <!-- End footer Area -->

    <!-- Scripts -->
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/carrito.js"></script> <!-- Asegúrate de que este archivo gestione el carrito -->

    <script>
    $(document).ready(function() {
        // Variable para almacenar la talla seleccionada
        let tallaSeleccionada = null;
        let stockTallaSeleccionada = 0;

        // Inicializar el carousel de imágenes del producto
        $('.s_Product_carousel').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
        });

        // Funcionalidad de Selector de Tallas
        $('.size-option').on('click', function() {
            // No hacer nada si el botón está deshabilitado
            if ($(this).hasClass('disabled')) {
                return;
            }

            // Remover selección previa
            $('.size-option').removeClass('selected');

            // Marcar este botón como seleccionado
            $(this).addClass('selected');

            // Guardar la talla seleccionada
            tallaSeleccionada = $(this).data('talla-id');
            stockTallaSeleccionada = parseInt($(this).data('stock'));

            // Ocultar mensaje de error si existe
            $('#talla-error').hide();

            // Actualizar el stock máximo del input de cantidad
            const qtyInput = $('#qty');
            qtyInput.attr('max', stockTallaSeleccionada);

            // Si la cantidad actual es mayor al stock disponible, ajustar
            if (parseInt(qtyInput.val()) > stockTallaSeleccionada) {
                qtyInput.val(stockTallaSeleccionada > 0 ? 1 : 0);
            }

            // Actualizar el atributo data-stock del botón de agregar al carrito
            $('#btn-add-to-cart').data('stock', stockTallaSeleccionada);

            console.log('Talla seleccionada:', tallaSeleccionada, 'Stock:', stockTallaSeleccionada);
        });

        // Control de cantidad - Botón Decrementar
        $('.btn-decrease').on('click', function() {
            const input = $('#qty');
            const currentVal = parseInt(input.val());
            if (currentVal > 1) {
                input.val(currentVal - 1);
            }
        });

        // Control de cantidad - Botón Incrementar
        $('.btn-increase').on('click', function() {
            const input = $('#qty');
            const currentVal = parseInt(input.val());
            const maxStock = parseInt(input.attr('max'));
            if (currentVal < maxStock) {
                input.val(currentVal + 1);
            }
        });

        // Manejo del botón "Agregar al Carrito"
        $('#btn-add-to-cart').on('click', function(e) {
            e.preventDefault();
            const btn = $(this);
            const productoId = btn.data('producto-id');
            const cantidad = parseInt($('#qty').val());
            const stock = parseInt(btn.data('stock'));

            // Verificar si hay tallas disponibles y si se seleccionó una
            const haySelectorTallas = $('.size-selector').length > 0;
            if (haySelectorTallas && !tallaSeleccionada) {
                $('#talla-error').show().text('Por favor, selecciona una talla antes de agregar al carrito');
                $('html, body').animate({
                    scrollTop: $('.size-selector').offset().top - 100
                }, 500);
                return;
            }

            // Validar cantidad
            if (isNaN(cantidad) || cantidad < 1) {
                mostrarNotificacion('Por favor, ingresa una cantidad válida.', 'error');
                return;
            }

            // Si hay talla seleccionada, validar contra el stock de esa talla
            const stockValidar = haySelectorTallas ? stockTallaSeleccionada : stock;
            
            if (cantidad > stockValidar) {
                mostrarNotificacion('La cantidad solicitada excede el stock disponible (' + stockValidar +
                    ' unidades).', 'error');
                return;
            }

            // Deshabilitar botón temporalmente
            btn.prop('disabled', true);
            const originalText = btn.html();
            btn.html('<i class="fa fa-spinner fa-spin"></i> Agregando...');

            // Llamar a la función del carrito con talla_id si está disponible
            if (typeof agregarAlCarrito === 'function') {
                // Extender la función agregarAlCarrito para incluir talla
                const datosProducto = {
                    producto_id: productoId,
                    cantidad: cantidad
                };
                
                if (haySelectorTallas && tallaSeleccionada) {
                    datosProducto.talla_id = tallaSeleccionada;
                }

                agregarAlCarrito(productoId, cantidad, function(success) {
                    if (success) {
                        // Resetear cantidad a 1
                        $('#qty').val(1);

                        // Limpiar selección de talla
                        $('.size-option').removeClass('selected');
                        tallaSeleccionada = null;
                        stockTallaSeleccionada = 0;

                        // Mostrar mensaje de éxito personalizado
                        mostrarNotificacion('¡Producto agregado al carrito exitosamente!',
                            'success');
                    }

                    // Rehabilitar botón
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }, tallaSeleccionada);
            } else {
                // Fallback: llamada AJAX directa si carrito.js no está disponible
                const ajaxData = {
                    producto_id: productoId,
                    cantidad: cantidad
                };
                
                if (haySelectorTallas && tallaSeleccionada) {
                    ajaxData.talla_id = tallaSeleccionada;
                }

                $.ajax({
                    url: '/carrito/agregar',
                    method: 'POST',
                    data: ajaxData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            mostrarNotificacion('¡Producto agregado al carrito!',
                                'success');

                            // Actualizar contador del carrito
                            if (response.totalItems) {
                                $('.cart-count').text(response.totalItems);
                            }

                            // Resetear cantidad y talla
                            $('#qty').val(1);
                            $('.size-option').removeClass('selected');
                            tallaSeleccionada = null;
                            stockTallaSeleccionada = 0;
                        } else {
                            mostrarNotificacion('Error: ' + (response.message ||
                                'No se pudo agregar el producto'), 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX:', error);
                        mostrarNotificacion(
                            'Error al agregar al carrito. Por favor intenta nuevamente.',
                            'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false);
                        btn.html(originalText);
                    }
                });
            }
        });

        // Botón de favoritos
        $('.btn-wishlist').on('click', function(e) {
            e.preventDefault();
            const icon = $(this).find('i');

            if (icon.hasClass('fa-heart-o')) {
                icon.removeClass('fa-heart-o').addClass('fa-heart');
                $(this).css('color', '#e74c3c');
                mostrarNotificacion('Producto agregado a favoritos', 'success');
            } else {
                icon.removeClass('fa-heart').addClass('fa-heart-o');
                $(this).css('color', '');
                mostrarNotificacion('Producto eliminado de favoritos', 'info');
            }
        });

        // Función para mostrar notificaciones
        function mostrarNotificacion(mensaje, tipo) {
            const colores = {
                'success': '#28a745',
                'error': '#dc3545',
                'info': '#17a2b8',
                'warning': '#ffc107'
            };

            const iconos = {
                'success': 'fa-check-circle',
                'error': 'fa-times-circle',
                'info': 'fa-info-circle',
                'warning': 'fa-exclamation-triangle'
            };

            const toast = $('<div class="custom-toast"></div>')
                .html('<i class="fa ' + iconos[tipo] + '"></i> ' + mensaje)
                .css({
                    position: 'fixed',
                    top: '20px',
                    right: '20px',
                    backgroundColor: colores[tipo],
                    color: 'white',
                    padding: '15px 25px',
                    borderRadius: '8px',
                    boxShadow: '0 4px 12px rgba(0,0,0,0.15)',
                    zIndex: 9999,
                    fontSize: '16px',
                    fontWeight: '500',
                    minWidth: '250px',
                    animation: 'slideInRight 0.3s ease-out'
                })
                .appendTo('body')
                .fadeIn()
                .delay(3000)
                .fadeOut(function() {
                    $(this).remove();
                });
        }

        // Agregar animación CSS
        if (!$('#toast-animation-style').length) {
            $('<style id="toast-animation-style">@keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }</style>')
                .appendTo('head');
        }
    });
    </script>
</body>

</html>