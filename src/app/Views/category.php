<?php 

// Función para verificar si un filtro está activo
function filtroActivo($nombre, $valor) {
    return isset($_GET[$nombre]) && $_GET[$nombre] == $valor;
}

// Función para construir URL con filtros
function construirUrlFiltro($nuevosParams) {
    $params = $_GET;
    foreach ($nuevosParams as $key => $value) {
        if ($value === null || $value === '') {
            unset($params[$key]);
        } else {
            $params[$key] = $value;
        }
    }
    return 'category' . (count($params) > 0 ? '?' . http_build_query($params) : '');
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
    <meta name="description" content="Catálogo de calzado deportivo y casual">
    <!-- Meta Keyword -->
    <meta name="keywords" content="zapatos, tenis, calzado, deportivo">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Catálogo de Productos - Tennis y Fragancias</title>

    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body id="category">

    <!-- Start Header Area -->
    <?php include 'includes/header.php'; ?>
    <!-- End Header Area -->

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Catálogo de Calzado</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category">Catálogo</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5">
                <!-- Barra de Búsqueda -->
                <div class="sidebar-categories mb-4">
                    <div class="head">Buscar Productos</div>
                    <form action="category" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Buscar calzado..."
                                value="<?php echo htmlspecialchars($filtros['busqueda'] ?? ''); ?>">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <?php foreach($_GET as $key => $value): ?>
                        <?php if($key != 'q' && $key != 'pagina'): ?>
                        <input type="hidden" name="<?php echo htmlspecialchars($key); ?>"
                            value="<?php echo htmlspecialchars($value); ?>">
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </form>
                </div>

                <!-- Categorías -->
                <div class="sidebar-categories">
                    <div class="head">Categorías</div>
                    <ul class="main-categories">
                        <li class="main-nav-list">
                            <a href="<?php echo construirUrlFiltro(['categoria' => null, 'pagina' => null]); ?>"
                                class="<?php echo !isset($filtros['categoria_id']) || $filtros['categoria_id'] === null ? 'active' : ''; ?>">
                                Todas las categorías
                            </a>
                        </li>
                        <?php if (!empty($categorias)): ?>
                        <?php foreach($categorias as $categoria): ?>
                        <li class="main-nav-list">
                            <a href="<?php echo construirUrlFiltro(['categoria' => $categoria['id'], 'pagina' => null]); ?>"
                                class="<?php echo filtroActivo('categoria', $categoria['id']) ? 'active' : ''; ?>">
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                                <span class="number">(<?php echo $categoria['total_productos'] ?? 0; ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <li class="main-nav-list">
                            <a href="#">No hay categorías disponibles</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Filtros -->
                <div class="sidebar-filter mt-50">
                    <div class="top-filter-head">Filtros de Productos</div>

                    <!-- Marcas -->
                    <?php if (!empty($marcas)): ?>
                    <div class="common-filter">
                        <div class="head">Marcas</div>
                        <ul>
                            <?php foreach($marcas as $marca): ?>
                            <li class="filter-list">
                                <a href="<?php echo construirUrlFiltro(['marca' => $marca['id'], 'pagina' => null]); ?>"
                                    class="<?php echo filtroActivo('marca', $marca['id']) ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($marca['nombre']); ?>
                                    <span
                                        class="badge badge-secondary"><?php echo $marca['total_productos'] ?? 0; ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if(isset($filtros['marca_id']) && $filtros['marca_id']): ?>
                        <a href="<?php echo construirUrlFiltro(['marca' => null, 'pagina' => null]); ?>"
                            class="btn btn-sm btn-outline-secondary mt-2">
                            <i class="fa fa-times"></i> Limpiar marca
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Género -->
                    <?php if (!empty($generos)): ?>
                    <div class="common-filter">
                        <div class="head">Género</div>
                        <ul>
                            <?php foreach($generos as $genero): ?>
                            <li class="filter-list">
                                <a href="<?php echo construirUrlFiltro(['genero' => $genero['id'], 'pagina' => null]); ?>"
                                    class="<?php echo filtroActivo('genero', $genero['id']) ? 'active' : ''; ?>">
                                    <?php echo htmlspecialchars($genero['nombre']); ?>
                                    <span
                                        class="badge badge-secondary"><?php echo $genero['total_productos'] ?? 0; ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if(isset($filtros['genero_id']) && $filtros['genero_id']): ?>
                        <a href="<?php echo construirUrlFiltro(['genero' => null, 'pagina' => null]); ?>"
                            class="btn btn-sm btn-outline-secondary mt-2">
                            <i class="fa fa-times"></i> Limpiar género
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Tallas -->
                    <?php if (!empty($tallas)): ?>
                    <div class="common-filter">
                        <div class="head">Tallas</div>
                        <ul class="tallas-grid">
                            <?php foreach($tallas as $talla): ?>
                            <li class="filter-list-inline">
                                <a href="<?php echo construirUrlFiltro(['talla' => $talla['id'], 'pagina' => null]); ?>"
                                    class="btn btn-sm <?php echo filtroActivo('talla', $talla['id']) ? 'btn-primary' : 'btn-outline-primary'; ?>"
                                    title="<?php echo $talla['total_productos'] ?? 0; ?> producto(s) disponible(s)">
                                    <?php echo htmlspecialchars($talla['nombre']); ?>
                                    <?php if (filtroActivo('talla', $talla['id'])): ?>
                                    <span
                                        class="badge badge-light ml-1"><?php echo $talla['total_productos'] ?? 0; ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if(isset($filtros['talla_id']) && $filtros['talla_id']): ?>
                        <a href="<?php echo construirUrlFiltro(['talla' => null, 'pagina' => null]); ?>"
                            class="btn btn-sm btn-outline-secondary mt-2">
                            <i class="fa fa-times"></i> Limpiar talla
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Colores -->
                    <?php if (!empty($colores)): ?>
                    <div class="common-filter">
                        <div class="head">Colores</div>
                        <ul class="colores-grid">
                            <?php foreach($colores as $color): ?>
                            <li class="filter-list-inline">
                                <a href="<?php echo construirUrlFiltro(['color' => $color['id'], 'pagina' => null]); ?>"
                                    class="color-option <?php echo filtroActivo('color', $color['id']) ? 'active' : ''; ?>"
                                    style="background-color: <?php echo htmlspecialchars($color['codigo_hex']); ?>;"
                                    title="<?php echo htmlspecialchars($color['nombre']); ?> (<?php echo $color['total_productos'] ?? 0; ?> productos)">
                                    <?php if(filtroActivo('color', $color['id'])): ?>
                                    <i class="fa fa-check"></i>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if(isset($filtros['color_id']) && $filtros['color_id']): ?>
                        <a href="<?php echo construirUrlFiltro(['color' => null, 'pagina' => null]); ?>"
                            class="btn btn-sm btn-outline-secondary mt-2">
                            <i class="fa fa-times"></i> Limpiar color
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Rango de Precio -->
                    <div class="common-filter">
                        <div class="head">Rango de Precio</div>
                        <form action="category" method="GET" class="price-filter-form">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" name="precio_min" class="form-control form-control-sm"
                                        placeholder="Min"
                                        value="<?php echo htmlspecialchars($filtros['precio_min'] ?? ''); ?>">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="precio_max" class="form-control form-control-sm"
                                        placeholder="Max"
                                        value="<?php echo htmlspecialchars($filtros['precio_max'] ?? ''); ?>">
                                </div>
                            </div>
                            <?php foreach($_GET as $key => $value): ?>
                            <?php if($key != 'precio_min' && $key != 'precio_max' && $key != 'pagina'): ?>
                            <input type="hidden" name="<?php echo htmlspecialchars($key); ?>"
                                value="<?php echo htmlspecialchars($value); ?>">
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">
                                Aplicar Filtro
                            </button>
                        </form>
                        <?php if(isset($filtros['precio_min']) || isset($filtros['precio_max'])): ?>
                        <a href="<?php echo construirUrlFiltro(['precio_min' => null, 'precio_max' => null, 'pagina' => null]); ?>"
                            class="btn btn-sm btn-outline-secondary mt-2 w-100">
                            <i class="fa fa-times"></i> Limpiar precios
                        </a>
                        <?php endif; ?>
                    </div>

                    <!-- Limpiar todos los filtros -->
                    <?php if(!empty(array_filter($filtros))): ?>
                    <div class="mt-3">
                        <a href="category" class="btn btn-danger btn-block">
                            <i class="fa fa-trash"></i> Limpiar Todos los Filtros
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-7">
                <!-- Start Filter Bar -->
                <div class="filter-bar d-flex flex-wrap align-items-center mb-4">
                    <div class="sorting">
                        <form action="category" method="GET" id="ordenForm">
                            <?php foreach($_GET as $key => $value): ?>
                            <?php if($key != 'orden' && $key != 'pagina'): ?>
                            <input type="hidden" name="<?php echo htmlspecialchars($key); ?>"
                                value="<?php echo htmlspecialchars($value); ?>">
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <select name="orden" onchange="this.form.submit()">
                                <option value="reciente"
                                    <?php echo ($filtros['orden'] ?? 'reciente') == 'reciente' ? 'selected' : ''; ?>>
                                    Más Recientes
                                </option>
                                <option value="precio_asc"
                                    <?php echo ($filtros['orden'] ?? '') == 'precio_asc' ? 'selected' : ''; ?>>
                                    Precio: Menor a Mayor
                                </option>
                                <option value="precio_desc"
                                    <?php echo ($filtros['orden'] ?? '') == 'precio_desc' ? 'selected' : ''; ?>>
                                    Precio: Mayor a Menor
                                </option>
                                <option value="nombre_asc"
                                    <?php echo ($filtros['orden'] ?? '') == 'nombre_asc' ? 'selected' : ''; ?>>
                                    Nombre: A-Z
                                </option>
                                <option value="nombre_desc"
                                    <?php echo ($filtros['orden'] ?? '') == 'nombre_desc' ? 'selected' : ''; ?>>
                                    Nombre: Z-A
                                </option>
                                <option value="popular"
                                    <?php echo ($filtros['orden'] ?? '') == 'popular' ? 'selected' : ''; ?>>
                                    Más Populares
                                </option>
                            </select>
                        </form>
                    </div>
                    <div class="sorting mr-auto">
                        <span class="text-muted">
                            Mostrando <?php echo count($productos); ?> de <?php echo $totalProductos; ?> productos
                        </span>
                    </div>

                    <!-- Paginación Superior -->
                    <?php if($totalPaginas > 1): ?>
                    <div class="pagination">
                        <?php if($paginaActual > 1): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $paginaActual - 1]); ?>" class="prev-arrow">
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>

                        <?php
                        $rangoInicio = max(1, $paginaActual - 2);
                        $rangoFin = min($totalPaginas, $paginaActual + 2);
                        
                        if($rangoInicio > 1): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => 1]); ?>">1</a>
                        <?php if($rangoInicio > 2): ?>
                        <span class="dot-dot">...</span>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php for($i = $rangoInicio; $i <= $rangoFin; $i++): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $i]); ?>"
                            class="<?php echo $i == $paginaActual ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                        <?php endfor; ?>

                        <?php if($rangoFin < $totalPaginas): ?>
                        <?php if($rangoFin < $totalPaginas - 1): ?>
                        <span class="dot-dot">...</span>
                        <?php endif; ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $totalPaginas]); ?>">
                            <?php echo $totalPaginas; ?>
                        </a>
                        <?php endif; ?>

                        <?php if($paginaActual < $totalPaginas): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $paginaActual + 1]); ?>" class="next-arrow">
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- End Filter Bar -->

                <!-- Start Best Seller -->
                <section class="lattest-product-area pb-40 category-list">
                    <div class="row">
                        <?php if (!empty($productos)): ?>
                        <?php foreach($productos as $producto): ?>
                        <!-- single product -->
                        <div class="col-lg-4 col-md-6">
                            <div class="single-product">
                                <img class="img-fluid" src="img/product/<?php echo obtenerImagenProducto($producto); ?>"
                                    alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <div class="product-details">
                                    <h6>
                                        <a href="producto-detalle?id=<?php echo $producto['id']; ?>"
                                            class="social-info"> <?php echo truncarTexto($producto['nombre'], 50); ?>
                                        </a>
                                    </h6>

                                    <!-- Información adicional -->
                                    <div class="product-meta mb-2">
                                        <small class="text-muted">
                                            <?php if(!empty($producto['marca_nombre'])): ?>
                                            <span class="badge badge-secondary">
                                                <?php echo htmlspecialchars($producto['marca_nombre']); ?>
                                            </span>
                                            <?php endif; ?>
                                            <?php if(!empty($producto['genero_nombre'])): ?>
                                            <span class="badge badge-info">
                                                <?php echo htmlspecialchars($producto['genero_nombre']); ?>
                                            </span>
                                            <?php endif; ?>
                                        </small>
                                    </div>

                                    <!-- Precio -->
                                    <div class="price">
                                        <?php if(tieneDescuento($producto)): ?>
                                        <h6><?php echo formatearPrecio($producto['precio_oferta']); ?></h6>
                                        <h6 class="l-through"><?php echo formatearPrecio($producto['precio']); ?></h6>
                                        <?php else: ?>
                                        <h6><?php echo formatearPrecio($producto['precio']); ?></h6>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Acciones -->
                                    <div class="prd-bottom">
                                        <a href="#" class="social-info btn-add-to-cart"
                                            data-producto-id="<?php echo $producto['id']; ?>" data-cantidad="1">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">Agregar al Carrito</p>
                                        </a>
                                        <a href="producto-detalle?id=<?php echo $producto['id']; ?>"
                                            class="social-info"> <span class="lnr lnr-move"></span>
                                            <p class="hover-text">Ver Detalles</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <!-- No hay productos -->
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <h4><i class="fa fa-info-circle"></i> No se encontraron productos</h4>
                                <p>Intenta cambiar los filtros o realiza una búsqueda diferente.</p>
                                <a href="category" class="btn btn-primary mt-3">
                                    <i class="fa fa-refresh"></i> Ver Todos los Productos
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
                <!-- End Best Seller -->

                <!-- Start Filter Bar (Bottom Pagination) -->
                <?php if($totalPaginas > 1): ?>
                <div class="filter-bar d-flex flex-wrap align-items-center">
                    <div class="sorting mr-auto">
                        <span class="text-muted">
                            Página <?php echo $paginaActual; ?> de <?php echo $totalPaginas; ?>
                        </span>
                    </div>
                    <div class="pagination">
                        <?php if($paginaActual > 1): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $paginaActual - 1]); ?>" class="prev-arrow">
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>

                        <?php
                        $rangoInicio = max(1, $paginaActual - 2);
                        $rangoFin = min($totalPaginas, $paginaActual + 2);
                        
                        if($rangoInicio > 1): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => 1]); ?>">1</a>
                        <?php if($rangoInicio > 2): ?>
                        <span class="dot-dot">...</span>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php for($i = $rangoInicio; $i <= $rangoFin; $i++): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $i]); ?>"
                            class="<?php echo $i == $paginaActual ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                        <?php endfor; ?>

                        <?php if($rangoFin < $totalPaginas): ?>
                        <?php if($rangoFin < $totalPaginas - 1): ?>
                        <span class="dot-dot">...</span>
                        <?php endif; ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $totalPaginas]); ?>">
                            <?php echo $totalPaginas; ?>
                        </a>
                        <?php endif; ?>

                        <?php if($paginaActual < $totalPaginas): ?>
                        <a href="<?php echo construirUrlFiltro(['pagina' => $paginaActual + 1]); ?>" class="next-arrow">
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                <!-- End Filter Bar -->
            </div>
        </div>
    </div>



    <!-- start footer Area -->
    <?php include 'includes/footer.php'; ?>
    <!-- End footer Area -->

    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../../cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/carrito.js"></script>

    <style>
    /* Estilos para filtros de tallas */
    .tallas-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        list-style: none;
        padding: 0;
    }

    .filter-list-inline {
        display: inline-block;
    }

    .tallas-grid .btn {
        min-width: 45px;
        padding: 5px 10px;
    }

    /* Estilos para filtros de colores */
    .colores-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        list-style: none;
        padding: 0;
    }

    .color-option {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        color: #fff;
        text-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
        cursor: pointer;
    }

    .color-option:hover {
        transform: scale(1.1);
        border-color: #ffba00;
    }

    .color-option.active {
        border-width: 3px;
        border-color: #ffba00;
        box-shadow: 0 0 10px rgba(255, 186, 0, 0.5);
    }

    /* Filtros activos */
    .filter-list a.active {
        color: #ffba00;
        font-weight: bold;
    }

    .main-nav-list a.active {
        color: #ffba00;
    }

    /* Badges de producto */
    .product-meta .badge {
        font-size: 10px;
        padding: 3px 6px;
        margin-right: 3px;
    }

    /* Badges en filtros */
    .filter-list a .badge {
        float: right;
        background-color: #6c757d;
        color: white;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 5px;
    }

    .filter-list a.active .badge {
        background-color: #ffba00;
        color: #222;
    }

    /* Talla con contador */
    .tallas-grid .btn .badge {
        font-size: 9px;
        padding: 1px 4px;
    }

    /* Búsqueda */
    .search-form .input-group {
        margin-bottom: 0;
    }

    .search-form .btn {
        border-radius: 0 3px 3px 0;
    }

    /* Paginación mejorada */
    .pagination .dot-dot {
        padding: 5px 10px;
        color: #666;
    }

    /* Tooltip mejorado para tallas */
    .tallas-grid .btn:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #333;
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        white-space: nowrap;
        font-size: 11px;
        z-index: 1000;
        margin-bottom: 5px;
    }

    .filter-list-inline {
        position: relative;
    }
    </style>
</body>

</html>