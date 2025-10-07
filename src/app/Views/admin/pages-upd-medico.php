<?php
require_once __DIR__ . '/../../Services/AuthService.php';

AuthService::requireLogin();

if (!AuthService::isAdminOrRoot()) {
    header("Location: login");
    exit;
}

$doctorId = $_GET['id'] ?? null;

if (!$doctorId) {
    header("Location: pages-get-medico");
    exit;
}

$doctor = Doctor::findById($doctorId);

if (!$doctor) {
    header("Location:pages-get-medico");
    exit;
}
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
                                    // Ocultar automáticamente después de 3 segundos
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const alerts = document.querySelectorAll('.alert');
                                        alerts.forEach(function(alert) {
                                            setTimeout(() => {
                                                const bootstrapAlert = new bootstrap.Alert(
                                                    alert);
                                                bootstrapAlert.close();
                                            }, 3000);
                                        });
                                    });
                                    </script>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="update-medico" method="POST">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $doctor->id; ?>">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre</label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($doctor->name); ?>"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="specialization"
                                                                        class="form-label">Especialización</label>
                                                                    <input type="text" id="specialization"
                                                                        name="specialization" class="form-control"
                                                                        value="<?php echo htmlspecialchars($doctor->specialization); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone"
                                                                        class="form-label">Teléfono</label>
                                                                    <input type="text" id="phone" name="phone"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($doctor->phone); ?>">
                                                                </div>
                                                            </div>
                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Correo</label>
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($doctor->email); ?>"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="license_number"
                                                                        class="form-label">Número de
                                                                        Licencia</label>
                                                                    <input type="text" id="license_number"
                                                                        name="license_number" class="form-control"
                                                                        value="<?php echo htmlspecialchars($doctor->license_number); ?>"
                                                                        required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Actualizar
                                                            Médico</button>
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


<!-- Mirrored from coderthemes.com/hyper/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jul 2025 15:13:40 GMT -->

</html>