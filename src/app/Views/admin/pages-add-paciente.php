<?php
$success = isset($_GET['success']);
$error = isset($_GET['error']);
?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/hyper/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jul 2025 15:13:40 GMT -->

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
                                        <li class="breadcrumb-item active">Registrar Paciente</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Formulario Paciente</h4>
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
                                        Ingrese a continuación los datos del <code>paciente</code> que se quiere
                                        <code>registrar</code>
                                    </p>

                                    <ul class="nav nav-tabs nav-bordered mb-3">


                                    </ul> <!-- end nav-->
                                    <!-- Mensajes de éxito o error -->
                                    <?php

                                // Mostrar alerta de éxito si existe
                                if (isset($_SESSION['exito'])) {
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="autoCloseAlert">
                                                <i class="ri-check-line me-1 align-middle font-16"></i> ' .
                                                                            htmlspecialchars($_SESSION['exito']) . '
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                                    unset($_SESSION['exito']);
                                }

                                // Mostrar alerta de error si existe
                                if (isset($_SESSION['error'])) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoCloseAlert">
                                        <i class="ri-close-line me-1 align-middle font-16"></i> ' .
                                                                    htmlspecialchars($_SESSION['error']) . '
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                                    unset($_SESSION['error']);
                                }
                                ?>
                                    <!-- Controldador de alerta -->
                                    <script>
                                    // Ocultar automáticamente después de 2 segundos
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const alert = document.getElementById('autoCloseAlert');
                                        if (alert) {
                                            setTimeout(() => {
                                                const bootstrapAlert = new bootstrap.Alert(alert);
                                                bootstrapAlert.close();
                                            }, 3000);
                                        }
                                    });
                                    </script>



                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="/admin/add-paciente" method="POST">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre</label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="birth_date" class="form-label">Fecha de
                                                                        Nacimiento</label>
                                                                    <input type="date" id="birth_date" name="birth_date"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone"
                                                                        class="form-label">Teléfono</label>
                                                                    <input type="text" id="phone" name="phone"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="gender"
                                                                        class="form-label">Género</label>
                                                                    <select id="gender" name="gender"
                                                                        class="form-control">
                                                                        <option value="">Seleccionar</option>
                                                                        <option value="M">Masculino</option>
                                                                        <option value="F">Femenino</option>
                                                                        <option value="Otro">Otro</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Correo</label>
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="address"
                                                                        class="form-label">Dirección</label>
                                                                    <input type="text" id="address" name="address"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="emergency_contact_name"
                                                                        class="form-label">Nombre de Contacto de
                                                                        Emergencia</label>
                                                                    <input type="text" id="emergency_contact_name"
                                                                        name="emergency_contact_name"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="emergency_contact_phone"
                                                                        class="form-label">Teléfono de Contacto de
                                                                        Emergencia</label>
                                                                    <input type="text" id="emergency_contact_phone"
                                                                        name="emergency_contact_phone"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Registrar
                                                            Paciente</button>
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


<!-- Mirrored from coderthemes.com/hyper/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jul 2025 15:13:40 GMT -->

</html>