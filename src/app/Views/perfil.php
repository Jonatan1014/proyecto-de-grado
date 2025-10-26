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
    .perfil-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .perfil-card {
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
    }

    .section-title i {
        margin-right: 10px;
        color: #ffba00;
    }

    .perfil-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 48px;
        margin: 0 auto 20px;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .perfil-nombre {
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .perfil-email {
        text-align: center;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .perfil-stats {
        display: flex;
        justify-content: space-around;
        padding: 20px 0;
        border-top: 1px solid #e9ecef;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 20px;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: #ffba00;
    }

    .stat-label {
        color: #6c757d;
        font-size: 14px;
    }

    .nav-tabs-perfil {
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 30px;
    }

    .nav-tabs-perfil .nav-link {
        border: none;
        color: #6c757d;
        padding: 15px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .nav-tabs-perfil .nav-link:hover {
        color: #ffba00;
    }

    .nav-tabs-perfil .nav-link.active {
        color: #ffba00;
        border-bottom: 3px solid #ffba00;
        background: transparent;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .direccion-card {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s;
        position: relative;
    }

    .direccion-card:hover {
        border-color: #ffba00;
        box-shadow: 0 2px 10px rgba(255, 186, 0, 0.1);
    }

    .direccion-principal {
        border-color: #ffba00;
        background: #fffbf0;
    }

    .badge-principal {
        background: #ffba00;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .btn-direccion {
        padding: 8px 15px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        margin-right: 8px;
        font-size: 13px;
    }

    .btn-principal {
        background: #28a745;
        color: white;
    }

    .btn-principal:hover {
        background: #218838;
    }

    .btn-editar {
        background: #007bff;
        color: white;
    }

    .btn-editar:hover {
        background: #0056b3;
    }

    .btn-eliminar {
        background: #dc3545;
        color: white;
    }

    .btn-eliminar:hover {
        background: #c82333;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #ffba00 0%, #ff9000 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 186, 0, 0.3);
    }

    .pedido-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }

    .pedido-item:hover {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .pedido-numero {
        font-size: 18px;
        font-weight: 700;
        color: #333;
    }

    .pedido-fecha {
        color: #6c757d;
        font-size: 14px;
    }

    .pedido-total {
        font-size: 20px;
        font-weight: 700;
        color: #ffba00;
    }

    .estado-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
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
                    <h1>Mi Perfil</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="#">Perfil</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Perfil Section -->
    <section class="perfil-section">
        <div class="container">
            <div class="row">
                <!-- Sidebar de Perfil -->
                <div class="col-lg-4">
                    <div class="perfil-card text-center">
                        <div class="perfil-avatar">
                            <?php
                            $nombre = $_SESSION['user']['nombre'] ?? '';
                            $apellido = $_SESSION['user']['apellido'] ?? '';
                            $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                            echo htmlspecialchars($iniciales);
                            ?>
                        </div>
                        <div class="perfil-nombre">
                            <?php echo htmlspecialchars($nombre . ' ' . $apellido); ?>
                        </div>
                        <div class="perfil-email">
                            <?php echo htmlspecialchars($_SESSION['user']['email'] ?? ''); ?>
                        </div>

                        <div class="perfil-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?php echo count($pedidos ?? []); ?></div>
                                <div class="stat-label">Pedidos</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number"><?php echo count($direcciones ?? []); ?></div>
                                <div class="stat-label">Direcciones</div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="ti-user mr-1"></i>
                                Miembro desde
                                <?php echo date('M Y', strtotime($usuario['fecha_registro'] ?? 'now')); ?>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Contenido Principal -->
                <div class="col-lg-8">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-perfil" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-informacion">
                                <i class="ti-user mr-2"></i>
                                Información Personal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-direcciones">
                                <i class="ti-location-pin mr-2"></i>
                                Mis Direcciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-seguridad">
                                <i class="ti-lock mr-2"></i>
                                Seguridad
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-pedidos">
                                <i class="ti-package mr-2"></i>
                                Mis Pedidos
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Información Personal -->
                        <div id="tab-informacion" class="tab-pane fade show active">
                            <div class="perfil-card">
                                <h3 class="section-title">
                                    <i class="ti-id-badge"></i>
                                    Información Personal
                                </h3>

                                <div id="mensaje-info"></div>

                                <form id="formInformacionPersonal">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nombre">Nombre *</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre"
                                                    value="<?php echo htmlspecialchars($usuario['nombre'] ?? ''); ?>"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="apellido">Apellido *</label>
                                                <input type="text" class="form-control" id="apellido" name="apellido"
                                                    value="<?php echo htmlspecialchars($usuario['apellido'] ?? ''); ?>"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?php echo htmlspecialchars($usuario['email'] ?? ''); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="telefono">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" name="telefono"
                                            value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>"
                                            placeholder="3001234567">
                                    </div>

                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="ti-save mr-2"></i>
                                        Guardar Cambios
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Mis Direcciones -->
                        <div id="tab-direcciones" class="tab-pane fade">
                            <div class="perfil-card">
                                <h3 class="section-title">
                                    <i class="ti-map-alt"></i>
                                    Mis Direcciones
                                </h3>

                                <div id="mensaje-direccion"></div>

                                <div id="lista-direcciones">
                                    <?php if (empty($direcciones)): ?>
                                    <div class="alert alert-info alert-custom">
                                        <i class="ti-info-alt mr-2"></i>
                                        No tienes direcciones guardadas. Agrega una para facilitar tus compras.
                                    </div>
                                    <?php else: ?>
                                    <?php foreach ($direcciones as $direccion): ?>
                                    <div
                                        class="direccion-card <?php echo $direccion['es_principal'] ? 'direccion-principal' : ''; ?>">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h5 class="mb-2">
                                                    <i class="ti-home mr-2"></i>
                                                    <?php echo htmlspecialchars($direccion['direccion']); ?>
                                                </h5>
                                                <p class="text-muted mb-0">
                                                    <?php echo htmlspecialchars($direccion['ciudad']); ?>,
                                                    <?php echo htmlspecialchars($direccion['departamento']); ?>
                                                    <?php if ($direccion['codigo_postal']): ?>
                                                    - CP: <?php echo htmlspecialchars($direccion['codigo_postal']); ?>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <?php if ($direccion['es_principal']): ?>
                                            <span class="badge-principal">PRINCIPAL</span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="text-right">
                                            <?php if (!$direccion['es_principal']): ?>
                                            <button class="btn btn-direccion btn-principal"
                                                onclick="establecerPrincipal(<?php echo $direccion['id']; ?>)">
                                                <i class="ti-star mr-1"></i>
                                                Hacer Principal
                                            </button>
                                            <?php endif; ?>
                                            <button class="btn btn-direccion btn-editar"
                                                onclick="editarDireccion(<?php echo $direccion['id']; ?>, '<?php echo htmlspecialchars($direccion['direccion'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($direccion['ciudad'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($direccion['departamento'], ENT_QUOTES); ?>', '<?php echo htmlspecialchars($direccion['codigo_postal'] ?? '', ENT_QUOTES); ?>', <?php echo $direccion['es_principal']; ?>)">
                                                <i class="ti-pencil mr-1"></i>
                                                Editar
                                            </button>
                                            <button class="btn btn-direccion btn-eliminar"
                                                onclick="eliminarDireccion(<?php echo $direccion['id']; ?>)">
                                                <i class="ti-trash mr-1"></i>
                                                Eliminar
                                            </button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                                <button class="btn btn-primary-custom mt-3" data-toggle="modal"
                                    data-target="#modalNuevaDireccion">
                                    <i class="ti-plus mr-2"></i>
                                    Agregar Nueva Dirección
                                </button>
                            </div>
                        </div>

                        <!-- Seguridad -->
                        <div id="tab-seguridad" class="tab-pane fade">
                            <div class="perfil-card">
                                <h3 class="section-title">
                                    <i class="ti-shield"></i>
                                    Cambiar Contraseña
                                </h3>

                                <div id="mensaje-password"></div>

                                <form id="formCambiarPassword">
                                    <div class="form-group">
                                        <label for="password_actual">Contraseña Actual *</label>
                                        <input type="password" class="form-control" id="password_actual"
                                            name="password_actual" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_nuevo">Nueva Contraseña *</label>
                                        <input type="password" class="form-control" id="password_nuevo"
                                            name="password_nuevo" required minlength="6">
                                        <small class="text-muted">Mínimo 6 caracteres</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmar">Confirmar Nueva Contraseña *</label>
                                        <input type="password" class="form-control" id="password_confirmar"
                                            name="password_confirmar" required minlength="6">
                                    </div>

                                    <button type="submit" class="btn btn-primary-custom">
                                        <i class="ti-lock mr-2"></i>
                                        Actualizar Contraseña
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Mis Pedidos -->
                        <div id="tab-pedidos" class="tab-pane fade">
                            <div class="perfil-card">
                                <h3 class="section-title">
                                    <i class="ti-shopping-cart"></i>
                                    Historial de Pedidos
                                </h3>

                                <?php if (empty($pedidos)): ?>
                                <div class="alert alert-info alert-custom">
                                    <i class="ti-info-alt mr-2"></i>
                                    Aún no has realizado ningún pedido.
                                </div>
                                <?php else: ?>
                                <?php 
                                // Función para formatear precio (declarada una sola vez)
                                if (!function_exists('formatearPrecio')) {
                                    function formatearPrecio($precio) {
                                        return '$' . number_format($precio, 0, ',', '.');
                                    }
                                }
                                ?>
                                <?php foreach ($pedidos as $pedido): ?>
                                <div class="pedido-item">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <div class="pedido-numero">#<?php echo $pedido['numero_pedido']; ?></div>
                                            <div class="pedido-fecha">
                                                <i class="ti-calendar mr-1"></i>
                                                <?php echo date('d/m/Y', strtotime($pedido['fecha_pedido'])); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <span
                                                class="estado-badge estado-<?php echo isset($pedido['estado_nombre']) ? strtolower($pedido['estado_nombre']) : 'pendiente'; ?>">
                                                <?php echo isset($pedido['estado_nombre']) ? ucfirst($pedido['estado_nombre']) : 'Pendiente'; ?>
                                            </span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="pedido-total">
                                                <?php echo formatearPrecio($pedido['total']); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <a href="detalle-pedido?id=<?php echo $pedido['id']; ?>"
                                                class="btn btn-sm btn-outline-warning">
                                                <i class="ti-eye mr-1"></i>
                                                Ver Detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
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
                            <label for="direccion">Dirección Completa *</label>
                            <input type="text" class="form-control" name="direccion"
                                placeholder="Ej: Calle 123 #45-67 Apto 301" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ciudad">Ciudad *</label>
                                    <input type="text" class="form-control" name="ciudad" placeholder="Ej: Bogotá"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departamento">Departamento *</label>
                                    <input type="text" class="form-control" name="departamento"
                                        placeholder="Ej: Cundinamarca" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo_postal">Código Postal</label>
                                    <input type="text" class="form-control" name="codigo_postal" placeholder="110111">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="es_principal"
                                            name="es_principal">
                                        <label class="custom-control-label" for="es_principal">
                                            Establecer como principal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary-custom" onclick="guardarDireccion()">
                        <i class="ti-save mr-2"></i>
                        Guardar Dirección
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Dirección -->
    <div class="modal fade" id="modalEditarDireccion" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti-pencil mr-2"></i>
                        Editar Dirección
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditarDireccion">
                        <input type="hidden" id="edit_direccion_id" name="direccion_id">

                        <div class="form-group">
                            <label for="edit_direccion">Dirección Completa *</label>
                            <input type="text" class="form-control" id="edit_direccion" name="direccion"
                                placeholder="Ej: Calle 123 #45-67 Apto 301" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_ciudad">Ciudad *</label>
                                    <input type="text" class="form-control" id="edit_ciudad" name="ciudad"
                                        placeholder="Ej: Bogotá" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_departamento">Departamento *</label>
                                    <input type="text" class="form-control" id="edit_departamento" name="departamento"
                                        placeholder="Ej: Cundinamarca" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_codigo_postal">Código Postal</label>
                                    <input type="text" class="form-control" id="edit_codigo_postal" name="codigo_postal"
                                        placeholder="110111">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="edit_es_principal"
                                            name="es_principal">
                                        <label class="custom-control-label" for="edit_es_principal">
                                            Establecer como principal
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary-custom" onclick="actualizarDireccion()">
                        <i class="ti-save mr-2"></i>
                        Actualizar Dirección
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
    // Actualizar información personal
    document.getElementById('formInformacionPersonal').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('perfil/actualizar-informacion', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensaje = document.getElementById('mensaje-info');
                if (data.success) {
                    mensaje.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="ti-check mr-2"></i>
                            ${data.message}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    `;

                    // Actualizar header si cambió el nombre
                    setTimeout(() => location.reload(), 2000);
                } else {
                    mensaje.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="ti-alert mr-2"></i>
                            ${data.message}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la información');
            });
    });

    // Cambiar contraseña
    document.getElementById('formCambiarPassword').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('perfil/cambiar-password', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensaje = document.getElementById('mensaje-password');
                if (data.success) {
                    mensaje.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="ti-check mr-2"></i>
                            ${data.message}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    `;
                    this.reset();
                } else {
                    mensaje.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="ti-alert mr-2"></i>
                            ${data.message}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cambiar la contraseña');
            });
    });

    // Guardar nueva dirección
    function guardarDireccion() {
        const form = document.getElementById('formNuevaDireccion');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);

        fetch('perfil/agregar-direccion', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#modalNuevaDireccion').modal('hide');
                    location.reload();
                } else {
                    alert(data.message || 'Error al agregar la dirección');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al agregar la dirección');
            });
    }

    // Eliminar dirección
    function eliminarDireccion(id) {
        if (!confirm('¿Estás seguro de eliminar esta dirección?')) {
            return;
        }

        const formData = new FormData();
        formData.append('direccion_id', id);

        fetch('perfil/eliminar-direccion', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error al eliminar la dirección');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar la dirección');
            });
    }

    // Establecer dirección principal
    function establecerPrincipal(id) {
        const formData = new FormData();
        formData.append('direccion_id', id);

        fetch('perfil/establecer-principal', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error al establecer dirección principal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al establecer dirección principal');
            });
    }

    // Abrir modal de editar dirección
    function editarDireccion(id, direccion, ciudad, departamento, codigoPostal, esPrincipal) {
        // Llenar el formulario con los datos actuales
        document.getElementById('edit_direccion_id').value = id;
        document.getElementById('edit_direccion').value = direccion;
        document.getElementById('edit_ciudad').value = ciudad;
        document.getElementById('edit_departamento').value = departamento;
        document.getElementById('edit_codigo_postal').value = codigoPostal;
        document.getElementById('edit_es_principal').checked = esPrincipal == 1;

        // Abrir el modal
        $('#modalEditarDireccion').modal('show');
    }

    // Actualizar dirección
    function actualizarDireccion() {
        const form = document.getElementById('formEditarDireccion');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);

        fetch('perfil/actualizar-direccion', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#modalEditarDireccion').modal('hide');
                    location.reload();
                } else {
                    alert(data.message || 'Error al actualizar la dirección');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la dirección');
            });
    }
    </script>
</body>

</html>