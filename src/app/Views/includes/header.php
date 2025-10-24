<?php
// Obtener contador del carrito
session_start();
require_once __DIR__ . '/../../Models/Carrito.php';

// Obtener ID del carrito (usuario logueado o sesión temporal)
if (isset($_SESSION['usuario_id'])) {
    $carritoId = $_SESSION['usuario_id'];
} else {
    if (!isset($_SESSION['carrito_temp_id'])) {
        $_SESSION['carrito_temp_id'] = 'temp_' . uniqid() . '_' . time();
    }
    $carritoId = $_SESSION['carrito_temp_id'];
}

$totalItemsCarrito = Carrito::contarItems($carritoId);
?>
<!-- Start Header Area -->
    <header class="header_area sticky-header">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light main_box">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="home"><img src="img/logo.png" alt=""></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto">
                            <li class="nav-item active"><a class="nav-link" href="home">Home</a></li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Shop</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="category">Shop Category</a></li>
                                    <li class="nav-item"><a class="nav-link" href="single-product">Product
                                            Details</a></li>
                                    <li class="nav-item"><a class="nav-link" href="checkout">Product Checkout</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="cart">Shopping Cart</a></li>
                                    <li class="nav-item"><a class="nav-link" href="confirmation">Confirmation</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item submenu dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">Pages</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class="nav-link" href="login">Login</a></li>
                                    <li class="nav-item"><a class="nav-link" href="tracking">Tracking</a></li>
                                    <li class="nav-item"><a class="nav-link" href="elements">Elements</a></li>
                                </ul>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="contact">Contact</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="nav-item">
                                <a href="cart" class="cart" style="position: relative;">
                                    <span class="ti-bag"></span>
                                    <span class="cart-count" data-cart-count id="cart-count" style="
                                        position: absolute;
                                        top: -5px;
                                        right: -10px;
                                        background: #ffba00;
                                        color: #fff;
                                        border-radius: 50%;
                                        width: 18px;
                                        height: 18px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-size: 11px;
                                        font-weight: bold;
                                        <?php echo $totalItemsCarrito > 0 ? '' : 'display: none;'; ?>
                                        "><?php echo $totalItemsCarrito; ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="search_input" id="search_input_box">
            <div class="container">
                <form class="d-flex justify-content-between">
                    <input type="text" class="form-control" id="search_input" placeholder="Search Here">
                    <button type="submit" class="btn"></button>
                    <span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
                </form>
            </div>
        </div>
    </header>
    <!-- End Header Area -->