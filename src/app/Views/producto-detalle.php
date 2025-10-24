<?php
require_once __DIR__ . '/../Utils/Helpers.php';

// Obtener datos del producto (ya vienen del controlador)
// $producto, $imagenes, $productosRelacionados
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
        content="<?= htmlspecialchars($producto['nombre']) ?> - <?= htmlspecialchars($producto['marca']) ?>">
    <!-- Meta Keyword -->
    <meta name="keywords"
        content="<?= htmlspecialchars($producto['nombre']) ?>, <?= htmlspecialchars($producto['marca']) ?>, <?= htmlspecialchars($producto['categoria']) ?>">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title><?= htmlspecialchars($producto['nombre']) ?> | Tennis y Fragancias</title>
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
    <link rel="stylesheet" href="css/main.css">

    <style>
    .s_Product_carousel .owl-item img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #ffba00;
        color: #222;
        padding: 5px 15px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 12px;
        z-index: 1;
    }

    .size-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 15px 0;
    }

    .size-option {
        padding: 8px 16px;
        border: 2px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .size-option:hover,
    .size-option.active {
        border-color: #ffba00;
        background: #ffba00;
        color: #222;
    }

    .size-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .stock-info {
        margin: 10px 0;
        font-size: 14px;
    }

    .stock-info.in-stock {
        color: #28a745;
    }

    .stock-info.low-stock {
        color: #ffc107;
    }

    .stock-info.out-stock {
        color: #dc3545;
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
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="catalogo">Tienda<span class="lnr lnr-arrow-right"></span></a>
                        <a href="catalogo?categoria=<?= $producto['categoria_id'] ?>"><?= htmlspecialchars($producto['categoria']) ?><span
                                class="lnr lnr-arrow-right"></span></a>
                        <a href="#"><?= htmlspecialchars(truncarTexto($producto['nombre'], 30)) ?></a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Single Product Area =================-->
    <div class="product_image_area">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <div class="s_Product_carousel">
                        <?php if (!empty($imagenes)): ?>
                        <?php foreach ($imagenes as $imagen): ?>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="<?= htmlspecialchars($imagen['url']) ?>"
                                alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="single-prd-item">
                            <img class="img-fluid" src="<?= obtenerImagenProducto($producto) ?>"
                                alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>

                        <?php if (tieneDescuento($producto)): ?>
                        <h2>
                            <span style="text-decoration: line-through; color: #999; font-size: 0.8em;">
                                <?= formatearPrecio(calcularPrecioOriginal($producto)) ?>
                            </span>
                            <span style="color: #ffba00;"><?= formatearPrecio($producto['precio']) ?></span>
                            <span class="badge badge-warning ml-2" style="background: #ffba00; color: #222;">
                                -<?= $producto['descuento'] ?>%
                            </span>
                        </h2>
                        <?php else: ?>
                        <h2><?= formatearPrecio($producto['precio']) ?></h2>
                        <?php endif; ?>

                        <ul class="list">
                            <li><a class="active" href="/catalogo?categoria=<?= $producto['categoria_id'] ?>">
                                    <span>Categoría</span> : <?= htmlspecialchars($producto['categoria']) ?>
                                </a></li>
                            <li><a href="catalogo?marca=<?= $producto['marca_id'] ?>">
                                    <span>Marca</span> : <?= htmlspecialchars($producto['marca']) ?>
                                </a></li>
                            <?php if (!empty($producto['genero'])): ?>
                            <li><a href="catalogo?genero=<?= $producto['genero_id'] ?>">
                                    <span>Género</span> : <?= htmlspecialchars($producto['genero']) ?>
                                </a></li>
                            <?php endif; ?>
                            <li>
                                <?php
                                $stock = intval($producto['stock'] ?? 0);
                                $stockClass = 'out-stock';
                                $stockText = 'Agotado';
                                
                                if ($stock > 10) {
                                    $stockClass = 'in-stock';
                                    $stockText = 'En Stock (' . $stock . ' disponibles)';
                                } elseif ($stock > 0) {
                                    $stockClass = 'low-stock';
                                    $stockText = 'Últimas unidades (' . $stock . ' disponibles)';
                                }
                                ?>
                                <span class="stock-info <?= $stockClass ?>">
                                    <span>Disponibilidad</span> : <?= $stockText ?>
                                </span>
                            </li>
                        </ul>

                        <?php if (!empty($producto['descripcion'])): ?>
                        <p><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
                        <?php endif; ?>

                        <?php if (!empty($producto['talla'])): ?>
                        <div class="size-selector">
                            <label style="width: 100%; font-weight: 600; margin-bottom: 10px;">Talla:</label>
                            <button class="size-option active" data-talla="<?= htmlspecialchars($producto['talla']) ?>">
                                <?= htmlspecialchars($producto['talla']) ?>
                            </button>
                        </div>
                        <?php endif; ?>

                        <?php if ($stock > 0): ?>
                        <div class="product_count">
                            <label for="qty">Cantidad:</label>
                            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:"
                                class="input-text qty" data-max="<?= $stock ?>">
                            <button onclick="incrementarCantidad()" class="increase items-count" type="button"><i
                                    class="lnr lnr-chevron-up"></i></button>
                            <button onclick="decrementarCantidad()" class="reduced items-count" type="button"><i
                                    class="lnr lnr-chevron-down"></i></button>
                        </div>

                        <div class="card_area d-flex align-items-center">
                            <a class="primary-btn" href="#" onclick="agregarAlCarritoDetalle(event)">Agregar al
                                Carrito</a>
                            <a class="icon_btn" href="favoritos" title="Agregar a favoritos"><i
                                    class="lnr lnr lnr-heart"></i></a>
                        </div>
                        <?php else: ?>
                        <div class="alert alert-danger mt-3">
                            <i class="fa fa-exclamation-triangle"></i> Este producto está temporalmente agotado.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->

    <!--================Product Description Area =================-->
    <section class="product_description_area">
        <div class="container">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Description</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                        aria-controls="profile" aria-selected="false">Specification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                        aria-controls="contact" aria-selected="false">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab"
                        aria-controls="review" aria-selected="false">Reviews</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <p>Beryl Cook is one of Britain’s most talented and amusing artists .Beryl’s pictures feature women
                        of all shapes
                        and sizes enjoying themselves .Born between the two world wars, Beryl Cook eventually left
                        Kendrick School in
                        Reading at the age of 15, where she went to secretarial school and then into an insurance
                        office. After moving to
                        London and then Hampton, she eventually married her next door neighbour from Reading, John Cook.
                        He was an
                        officer in the Merchant Navy and after he left the sea in 1956, they bought a pub for a year
                        before John took a
                        job in Southern Rhodesia with a motor company. Beryl bought their young son a box of
                        watercolours, and when
                        showing him how to use it, she decided that she herself quite enjoyed painting. John
                        subsequently bought her a
                        child’s painting set for her birthday and it was with this that she produced her first
                        significant work, a
                        half-length portrait of a dark-skinned lady with a vacant expression and large drooping breasts.
                        It was aptly
                        named ‘Hangover’ by Beryl’s husband and</p>
                    <p>It is often frustrating to attempt to plan meals that are designed for one. Despite this fact, we
                        are seeing
                        more and more recipe books and Internet websites that are dedicated to the act of cooking for
                        one. Divorce and
                        the death of spouses or grown children leaving for college are all reasons that someone
                        accustomed to cooking for
                        more than one would suddenly need to learn how to adjust all the cooking practices utilized
                        before into a
                        streamlined plan of cooking that is more efficient for one person creating less</p>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <h5>Width</h5>
                                    </td>
                                    <td>
                                        <h5>128mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Height</h5>
                                    </td>
                                    <td>
                                        <h5>508mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Depth</h5>
                                    </td>
                                    <td>
                                        <h5>85mm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Weight</h5>
                                    </td>
                                    <td>
                                        <h5>52gm</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Quality checking</h5>
                                    </td>
                                    <td>
                                        <h5>yes</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Freshness Duration</h5>
                                    </td>
                                    <td>
                                        <h5>03days</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>When packeting</h5>
                                    </td>
                                    <td>
                                        <h5>Without touch of hand</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5>Each Box contains</h5>
                                    </td>
                                    <td>
                                        <h5>60pcs</h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="comment_list">
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/product/review-1.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <h5>12th Feb, 2018 at 05:56 pm</h5>
                                            <a class="reply_btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                                <div class="review_item reply">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/product/review-2.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <h5>12th Feb, 2018 at 05:56 pm</h5>
                                            <a class="reply_btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/product/review-3.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <h5>12th Feb, 2018 at 05:56 pm</h5>
                                            <a class="reply_btn" href="#">Reply</a>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Post a comment</h4>
                                <form class="row contact_form"
                                    action="https://themewagon.github.io/karma/contact_process.php" method="post"
                                    id="contactForm" novalidate="novalidate">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Your Full name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="number" name="number"
                                                placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" id="message" rows="1"
                                                placeholder="Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" value="submit" class="btn primary-btn">Submit Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row total_rate">
                                <div class="col-6">
                                    <div class="box_total">
                                        <h5>Overall</h5>
                                        <h4>4.0</h4>
                                        <h6>(03 Reviews)</h6>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="rating_list">
                                        <h3>Based on 3 Reviews</h3>
                                        <ul class="list">
                                            <li><a href="#">5 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="#">4 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="#">3 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="#">2 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                            <li><a href="#">1 Star <i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i><i
                                                        class="fa fa-star"></i><i class="fa fa-star"></i> 01</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list">
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/product/review-1.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/product/review-2.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                                <div class="review_item">
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="img/product/review-3.png" alt="">
                                        </div>
                                        <div class="media-body">
                                            <h4>Blake Ruiz</h4>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et
                                        dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                        laboris nisi ut aliquip ex ea
                                        commodo</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="review_box">
                                <h4>Add a Review</h4>
                                <p>Your Rating:</p>
                                <ul class="list">
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                </ul>
                                <p>Outstanding</p>
                                <form class="row contact_form"
                                    action="https://themewagon.github.io/karma/contact_process.php" method="post"
                                    id="contactForm" novalidate="novalidate">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Your Full name" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Your Full name'">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email Address" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Email Address'">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="number" name="number"
                                                placeholder="Phone Number" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Phone Number'">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" id="message" rows="1"
                                                placeholder="Review" onfocus="this.placeholder = ''"
                                                onblur="this.placeholder = 'Review'"></textarea></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <button type="submit" value="submit" class="primary-btn">Submit Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Product Description Area =================-->

    <!-- Start related-product Area -->
    <section class="related-product-area section_gap_bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="section-title">
                        <h1>Productos Relacionados</h1>
                        <p>Descubre otros productos similares que podrían interesarte</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <?php if (!empty($productosRelacionados)): ?>
                        <?php foreach ($productosRelacionados as $relacionado): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-20">
                            <div class="single-related-product d-flex">
                                <a href="producto/detalle?id=<?= $relacionado['id'] ?>">
                                    <img src="<?= obtenerImagenProducto($relacionado) ?>"
                                        alt="<?= htmlspecialchars($relacionado['nombre']) ?>"
                                        style="width: 70px; height: 70px; object-fit: cover;">
                                </a>
                                <div class="desc">
                                    <a href="producto/detalle?id=<?= $relacionado['id'] ?>" class="title">
                                        <?= htmlspecialchars(truncarTexto($relacionado['nombre'], 40)) ?>
                                    </a>
                                    <div class="price">
                                        <?php if (tieneDescuento($relacionado)): ?>
                                        <h6><?= formatearPrecio($relacionado['precio']) ?></h6>
                                        <h6 class="l-through">
                                            <?= formatearPrecio(calcularPrecioOriginal($relacionado)) ?></h6>
                                        <?php else: ?>
                                        <h6><?= formatearPrecio($relacionado['precio']) ?></h6>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="col-12 text-center">
                            <p>No hay productos relacionados disponibles en este momento.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End related-product Area -->

    <!-- start footer Area -->
    <?php include 'includes/footer.php'; ?>
    <!-- End footer Area -->

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
    <script src="js/carrito.js"></script>

    <script>
    // Inicializar el carousel de imágenes del producto
    $(document).ready(function() {
        $('.s_Product_carousel').owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: false,
            navText: ['<i class="lnr lnr-chevron-left"></i>', '<i class="lnr lnr-chevron-right"></i>']
        });
    });

    // Funciones para incrementar/decrementar cantidad
    function incrementarCantidad() {
        var result = document.getElementById('sst');
        var sst = parseInt(result.value);
        var max = parseInt(result.getAttribute('data-max'));

        if (!isNaN(sst) && sst < max) {
            result.value = sst + 1;
        } else if (sst >= max) {
            mostrarNotificacion('No hay más stock disponible', 'warning');
        }
        return false;
    }

    function decrementarCantidad() {
        var result = document.getElementById('sst');
        var sst = parseInt(result.value);

        if (!isNaN(sst) && sst > 1) {
            result.value = sst - 1;
        }
        return false;
    }

    // Función para agregar al carrito desde la página de detalles
    function agregarAlCarritoDetalle(event) {
        event.preventDefault();

        var cantidad = parseInt(document.getElementById('sst').value);
        var productoId = <?= $producto['id'] ?>;
        var stock = <?= $producto['stock'] ?? 0 ?>;

        // Validar cantidad
        if (isNaN(cantidad) || cantidad < 1) {
            mostrarNotificacion('Por favor ingresa una cantidad válida', 'error');
            return;
        }

        if (cantidad > stock) {
            mostrarNotificacion('No hay suficiente stock disponible', 'error');
            return;
        }

        // Agregar al carrito
        agregarAlCarrito(productoId, cantidad);
    }

    // Mostrar notificación (si no está en carrito.js)
    function mostrarNotificacion(mensaje, tipo = 'success') {
        var icono = tipo === 'success' ? '✓' : tipo === 'warning' ? '⚠' : '✗';
        var color = tipo === 'success' ? '#28a745' : tipo === 'warning' ? '#ffc107' : '#dc3545';

        var notificacion = $('<div class="notificacion-carrito">')
            .html(icono + ' ' + mensaje)
            .css({
                'position': 'fixed',
                'top': '20px',
                'right': '20px',
                'background': color,
                'color': 'white',
                'padding': '15px 25px',
                'border-radius': '4px',
                'box-shadow': '0 2px 5px rgba(0,0,0,0.2)',
                'z-index': '9999',
                'font-weight': 'bold'
            });

        $('body').append(notificacion);

        setTimeout(function() {
            notificacion.fadeOut(function() {
                $(this).remove();
            });
        }, 3000);
    }
    </script>

</body>

</html>