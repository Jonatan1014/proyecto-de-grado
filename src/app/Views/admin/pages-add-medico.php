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

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                        <li class="breadcrumb-item active">Registrar Médico</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Formulario Médico</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Ingresar Información</h4>
                                    <p class="text-muted font-14">
                                        Ingrese a continuación los datos del <code>médico</code> que se quiere
                                        <code>registrar</code>
                                    </p>

                                    <ul class="nav nav-tabs nav-bordered mb-3">


                                    </ul> <!-- end nav-->
                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>



                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="add-medico" method="POST">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="idnumber" class="form-label">Cédula/Identificación</label>
                                                                    <input type="text" id="idnumber" name="idnumber"
                                                                        class="form-control" 
                                                                        placeholder="Ej: 1234567890">
                                                                    <small class="text-muted">Campo opcional</small>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control" 
                                                                        placeholder="Ej: Dr. Juan Pérez"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="specialization"
                                                                        class="form-label">Especialización</label>
                                                                    <input type="text" id="specialization"
                                                                        name="specialization" 
                                                                        class="form-control"
                                                                        placeholder="Ej: Ortodoncia">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone"
                                                                        class="form-label">Teléfono</label>
                                                                    <input type="text" id="phone" name="phone"
                                                                        class="form-control"
                                                                        placeholder="Ej: 310-1234567">
                                                                </div>
                                                            </div>
                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control" 
                                                                        placeholder="Ej: doctor@clinica.com"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="license_number"
                                                                        class="form-label">Número de Licencia <span class="text-danger">*</span></label>
                                                                    <input type="text" id="license_number"
                                                                        name="license_number" 
                                                                        class="form-control"
                                                                        placeholder="Ej: ODO-12345"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="pages-get-medico" class="btn btn-secondary">
                                                                <i class="mdi mdi-arrow-left me-1"></i> Cancelar
                                                            </a>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="mdi mdi-content-save me-1"></i> Registrar Médico
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <?php if (isset($_GET['error'])): ?>
                                                    <p class="text-danger mt-3">Credenciales incorrectas.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div> <!-- end preview-->


                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->






                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include 'includes/footer.php'; ?>
            <!-- end Footer -->
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

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