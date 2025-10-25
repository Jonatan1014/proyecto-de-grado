<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener contador del carrito
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
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="category">Tienda</a></li>
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
                        

                        <?php if (isset($_SESSION['usuario_id']) && isset($_SESSION['user'])): ?>
                        <!-- Usuario logueado - Menú de perfil -->
                        <li class="nav-item submenu dropdown">
                            <a href="#" class="nav-link dropdown-toggle user-profile-link" data-toggle="dropdown"
                                role="button" aria-haspopup="true" aria-expanded="false" style="padding: 0;">
                                <div class="user-avatar" style="
                                        width: 36px;
                                        height: 36px;
                                        border-radius: 50%;
                                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                        color: #fff;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-weight: bold;
                                        font-size: 14px;
                                        margin: 0 10px;
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
                                    ">
                                    <?php 
                                        $nombre = $_SESSION['user']['nombre'] ?? '';
                                        $apellido = $_SESSION['user']['apellido'] ?? '';
                                        $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                                        echo htmlspecialchars($iniciales);
                                        ?>
                                </div>
                            </a>
                            <ul class="dropdown-menu" style="min-width: 180px;">
                                <li class="nav-item" style="padding: 10px 20px; border-bottom: 1px solid #eee;">
                                    <div style="font-weight: bold; color: #333; font-size: 14px;">
                                        <?php echo htmlspecialchars($nombre . ' ' . $apellido); ?>
                                    </div>
                                    <div style="font-size: 12px; color: #999;">
                                        <?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="perfil" style="padding: 10px 20px;">
                                        <i class="ti-user" style="margin-right: 8px;"></i>
                                        Mi Perfil
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout" style="padding: 10px 20px; color: #e74c3c;">
                                        <i class="ti-power-off" style="margin-right: 8px;"></i>
                                        Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php else: ?>
                        <!-- Usuario no logueado - Botón de login -->
                        <li class="nav-item">
                            <a href="login" class="nav-link" style="
                                    background: #ffba00;
                                    color: #fff;
                                    padding: 8px 20px;
                                    border-radius: 20px;
                                    margin-left: 10px;
                                    font-weight: 500;
                                    transition: all 0.3s ease;
                                ">
                                <i class="ti-user" style="margin-right: 5px;"></i>
                                Iniciar Sesión
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
</header>
<!-- End Header Area -->

<style>
/* Estilos para el avatar de usuario */
.user-avatar:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5) !important;
}

/* Estilos para el menú desplegable de usuario */
.user-profile-link+.dropdown-menu {
    right: 0;
    left: auto;
    margin-top: 10px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    border: none;
    padding: 0;
    overflow: hidden;
}

.user-profile-link+.dropdown-menu .nav-item:not(:first-child) .nav-link:hover {
    background: #f8f9fa;
    color: #667eea !important;
}

.user-profile-link+.dropdown-menu .nav-item:last-child .nav-link:hover {
    background: #fee;
    color: #e74c3c !important;
}

/* Botón de login cuando no está logueado */
.nav-item a[href="login"]:hover {
    background: #e6a800 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 186, 0, 0.3);
}

/* Animación del dropdown */
.user-profile-link+.dropdown-menu {
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
}

.user-profile-link.show+.dropdown-menu,
.dropdown.show>.dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
</style>