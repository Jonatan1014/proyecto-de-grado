<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Starter Page | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/admin/assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="assets/admin/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/admin/assets/css/unicons/css/unicons.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <?php include 'includes/navbar.php'; ?>
        <!-- ========== Topbar End ========== -->
        <?php include 'includes/sidebar.php'; ?>


        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                        <li class="breadcrumb-item"><a href="/admin/pages-get-medico">Lista de
                                                Médicos</a></li>
                                        <li class="breadcrumb-item active">Editar Médico</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Editar Médico</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Actualizar Información</h4>
                                    <p class="text-muted font-14">
                                        Actualice a continuación los datos del <code>médico</code> seleccionado
                                    </p>

                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="update-service-category" method="POST">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $category->id; ?>">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre de la
                                                                        Categoría</label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($category->name); ?>"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Categoría y servicio
                                                                        asociado</label>
                                                                    <div class="border rounded p-2 bg-light">

                                                                        <div>
                                                                            <strong>→
                                                                                <?php echo htmlspecialchars($category->name ?? "Sin nombre"); ?></strong>
                                                                        </div>

                                                                        <?php if (!empty($category->service)): ?>
                                                                        <div class="ms-3 mb-2">
                                                                            <span>• <b>Servicio:</b>
                                                                                <?php echo htmlspecialchars($category->service['name'] ?? "Sin datos"); ?></span><br>
                                                                            <span>• <b>Precio:</b>
                                                                                $<?php echo htmlspecialchars($category->service['price'] ?? "Sin datos"); ?></span><br>
                                                                            <span>• <b>Duración:</b>
                                                                                <?php echo htmlspecialchars($category->service['duration'] ?? "Sin datos"); ?>
                                                                                min</span><br>
                                                                            <span>• <b>Estado:</b>
                                                                                <?php echo htmlspecialchars($category->service['status'] ?? "Sin datos"); ?></span><br>
                                                                            <span>• <b>Características:</b>
                                                                                <?php echo !empty($category->service['features']) && is_array($category->service['features']) 
                                                                                            ? htmlspecialchars(implode(', ', $category->service['features'])) 
                                                                                            : "Sin datos";
                                                                                    ?>
                                                                            </span>
                                                                        </div>
                                                                        <?php else: ?>
                                                                        <div class="ms-3 text-muted mb-2">Sin servicios
                                                                            asociados</div>
                                                                        <?php endif; ?>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <button type="submit" class="btn btn-success">Actualizar
                                                            Categoría</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Start -->
            <?php include 'includes/footer.php'; ?>
            <!-- end Footer -->

        </div>
        <!-- END wrapper -->

        <!-- Theme Settings -->
        <?php include 'includes/theme.php'; ?>


        <!-- Vendor js -->
        <script src="assets/admin/assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/admin/assets/js/app.js"></script>

</body>



</html>