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
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- <h4 class="header-title">Scroll - Vertical</h4> -->

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="scroll-vertical-preview">
                                            <table id="scroll-vertical-datatable"
                                                class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nombre</th>
                                                        <th>Especialización</th>
                                                        <th>Teléfono</th>
                                                        <th>Correo</th>
                                                        <th>Licencia</th>
                                                        <th>Fecha de Registro</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php foreach($doctors as $doctor): ?>
                                                    <!-- Médico -->
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($doctor->id) ?></td>
                                                        <td><?php echo htmlspecialchars($doctor->name) ?></td>
                                                        <td><?php echo htmlspecialchars($doctor->specialization) ?></td>
                                                        <td><?php echo htmlspecialchars($doctor->phone) ?></td>
                                                        <td><?php echo htmlspecialchars($doctor->email) ?></td>
                                                        <td><?php echo htmlspecialchars($doctor->license_number) ?></td>
                                                        <td><?php echo htmlspecialchars($doctor->created_at) ?></td>
                                                        <td>
                                                            <!-- Formulario para Editar -->
                                                            <a href="pages-udp-medico?id=<?php echo $doctor->id ?>"
                                                                class="btn btn-outline-info rounded-pill">
                                                                <i class="uil-edit"></i> Editar
                                                            </a>

                                                            <!-- Formulario para Eliminar -->
                                                            <!-- <form action="/admin/delete-doctor" method="POST"
                                                style="display:inline-block;">
                                                <input type="hidden" name="id" value="<?php echo $doctor->id ?>">
                                                <button type="submit"
                                                    class="btn btn-outline-danger rounded-pill"><i
                                                        class="uil-trash"></i> Eliminar</button>
                                            </form> -->
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div><!-- end row-->
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

        <!-- App js -->
        <script src="assets/admin/assets/js/app.js"></script>

</body>


<!-- Mirrored from coderthemes.com/hyper/layouts/pages-starter.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 15 Jul 2025 15:13:40 GMT -->

</html>