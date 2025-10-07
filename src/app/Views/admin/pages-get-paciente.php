<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/hyper/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jul 2025 15:13:40 GMT -->

<head>
    <meta charset="utf-8" />
    <title>List Books</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">

    <!-- Datatables css -->
    <link href="assets/admin/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/admin/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css"
        rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="assets/admin/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Theme Config Js -->
    <script src="assets/admin/assets/js/hyper-config.js"></script>

    <!-- App css -->
    <link href="assets/admin/assets/css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

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
                                        <li class="breadcrumb-item active">Lista de Médicos</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Lista de Médicos</h4>
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
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Basic Data Table</h4>
                                    <p class="text-muted font-14 mb-4">
                                        DataTables has most features enabled by default, so all you need to do to use it
                                        with your own tables is to call the construction
                                        function:
                                        <code>$().DataTable();</code>. KeyTable provides Excel like cell navigation on
                                        any table. Events (focus, blur, action etc) can be assigned to individual
                                        cells, columns, rows or all cells.
                                    </p>

                                    <table id="basic-datatable"
                                        class="table table-striped dt-responsive nowrap w-100 mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Nacimiento</th>
                                                <th>Género</th>
                                                <th>Teléfono</th>
                                                <th>Correo</th>
                                                <th>Dirección</th>
                                                <th>Contacto Emergencia</th>
                                                <th>Fecha Registro</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($pacientes as $paciente): ?>
                                            <tr>

                                                <td><?php echo htmlspecialchars($paciente->id) ?></td>
                                                <td><?php echo htmlspecialchars($paciente->name) ?></td>
                                                <td><?php echo htmlspecialchars($paciente->birth_date) ?></td>
                                                <td><?php echo htmlspecialchars($paciente->gender) ?></td>
                                                <td><?php echo htmlspecialchars($paciente->phone) ?></td>
                                                <td><?php echo htmlspecialchars($paciente->email) ?></td>
                                                <td><?php echo htmlspecialchars($paciente->address) ?></td>
                                                <!-- Contacto de Emergencia -->
                                                <td>
                                                    <?php if (!empty($paciente->emergency_contact_name)): ?>
                                                    <strong>Nombre:</strong>
                                                    <?php echo htmlspecialchars($paciente->emergency_contact_name) ?><br>
                                                    <strong>Teléfono:</strong>
                                                    <?php echo htmlspecialchars($paciente->emergency_contact_phone) ?>
                                                    <?php else: ?>
                                                    N/A
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($paciente->created_at) ?></td>
                                                <td>
                                                    <!-- Formulario para Editar -->
                                                    <a href="/admin/pages-upd-paciente?id=<?php echo $paciente->id ?>"
                                                        class="btn btn-outline-info rounded-pill">
                                                        <i class="uil-edit"></i> Editar
                                                    </a>

                                                    <form action="/admin/delete-paciente" method="POST"
                                                        style="display:inline-block;"
                                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este paciente?');">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $paciente->id; ?>">
                                                        <button type="submit"
                                                            class="btn btn-outline-danger rounded-pill">
                                                            <i class="uil-trash-alt"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>

                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div> <!-- end row-->
                </div> <!-- container -->

                <!-- Footer Start -->
                <?php include 'includes/footer.php'; ?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <!-- Theme Settings -->
        <!-- Theme Settings -->
        <?php include 'includes/theme.php'; ?>

        <!-- Vendor js -->
        <script src="assets/admin/assets/js/vendor.min.js"></script>

        <!-- Code Highlight js -->
        <script src="assets/admin/assets/vendor/highlightjs/highlight.pack.min.js"></script>
        <script src="assets/admin/assets/vendor/clipboard/clipboard.min.js"></script>
        <script src="assets/admin/assets/js/hyper-syntax.js"></script>

        <!-- Datatables js -->
        <script src="assets/admin/assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js">
        </script>
        <script src="assets/admin/assets/vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>

        <!-- Datatable Demo Aapp js -->
        <script src="assets/admin/assets/js/pages/demo.datatable-init.js"></script>

        <!-- App js -->
        <script src="assets/admin/assets/js/app.min.js"></script>

</body>


<!-- Mirrored from coderthemes.com/hyper/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jul 2025 15:13:40 GMT -->

</html>