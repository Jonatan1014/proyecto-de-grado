<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Gestión de Servicios | Sistema Clínica Dental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de servicios odontológicos" name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">

    <!-- Datatables css -->
    <link href="assets/admin/assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <!-- For checkbox Select-->
    <link href="assets/admin/assets/vendor/datatables/select.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <!-- For Buttons -->
    <link href="assets/admin/assets/vendor/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <!-- Fixe header-->
    <link href="assets/admin/assets/vendor/datatables/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css">


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
                                        <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="pages-get-service">Servicios</a></li>
                                        <li class="breadcrumb-item active">Lista de Servicios</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="mdi mdi-tooth text-primary me-1"></i>
                                    Catálogo de Servicios Odontológicos
                                </h4>
                                <!-- Mensajes de éxito o error -->
                                <?php include 'includes/alertEvent.php'; ?>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-8">
                                            <h4 class="header-title mb-1">
                                                <i class="mdi mdi-medical-bag text-primary me-1"></i>
                                                Servicios y Tratamientos Dentales
                                            </h4>
                                            <p class="text-muted font-13">
                                                Administre el catálogo completo de servicios odontológicos ofrecidos por la clínica.
                                                Incluye precios, duración y categorización.
                                            </p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <a href="pages-add-service" class="btn btn-success mb-2">
                                                <i class="mdi mdi-plus-circle me-1"></i> Nuevo Servicio
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Estadísticas rápidas -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-primary bg-primary text-white border-0 mb-0" role="alert">
                                                <i class="mdi mdi-information-outline me-2"></i>
                                                <strong>Total de servicios registrados: <?php echo count($services); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="basic-datatable"
                                        class="table table-striped table-hover dt-responsive nowrap w-100 mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 5%">#</th>
                                                <th style="width: 30%"><i class="mdi mdi-tooth me-1"></i>Servicio/Tratamiento</th>
                                                <th style="width: 10%"><i class="mdi mdi-clock-outline me-1"></i>Duración</th>
                                                <th style="width: 12%"><i class="mdi mdi-currency-usd me-1"></i>Precio</th>
                                                <th style="width: 18%"><i class="mdi mdi-tag me-1"></i>Categoría</th>
                                                <th class="text-center" style="width: 12%"><i class="mdi mdi-toggle-switch me-1"></i>Estado</th>
                                                <th class="text-center" style="width: 13%"><i class="mdi mdi-tools me-1"></i>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($services as $service): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge badge-outline-primary"><?php echo htmlspecialchars($service->id) ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <h5 class="mb-0 font-14 fw-semibold">
                                                                <?php echo htmlspecialchars($service->name) ?>
                                                            </h5>
                                                            <?php if(!empty($service->description)): ?>
                                                            <small class="text-muted text-truncate d-block" style="max-width: 250px;">
                                                                <?php echo htmlspecialchars(substr($service->description, 0, 50)) . (strlen($service->description) > 50 ? '...' : ''); ?>
                                                            </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($service->duration_minutes): ?>
                                                    <span class="badge bg-soft-info text-info">
                                                        <i class="mdi mdi-timer-outline me-1"></i>
                                                        <?php echo htmlspecialchars($service->duration_minutes) ?> min
                                                    </span>
                                                    <?php else: ?>
                                                    <span class="text-muted">No especificada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($service->price): ?>
                                                    <div class="fw-bold text-success">
                                                        <i class="mdi mdi-cash-multiple me-1"></i>
                                                        $<?php echo number_format($service->price, 0, ',', '.') ?> COP
                                                    </div>
                                                    <?php else: ?>
                                                    <span class="text-muted">No especificado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($service->category_name): ?>
                                                    <span class="badge bg-soft-secondary text-secondary fs-6">
                                                        <i class="mdi mdi-folder-outline me-1"></i>
                                                        <?php echo htmlspecialchars($service->category_name) ?>
                                                    </span>
                                                    <?php else: ?>
                                                    <span class="text-muted">Sin categoría</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                        $statusClass = '';
                                                        $statusIcon = '';
                                                        $statusText = '';
                                                        
                                                        switch($service->status) {
                                                            case 'active':
                                                                $statusClass = 'bg-soft-success text-success';
                                                                $statusIcon = 'mdi-check-circle';
                                                                $statusText = 'Activo';
                                                                break;
                                                            case 'inactive':
                                                                $statusClass = 'bg-soft-danger text-danger';
                                                                $statusIcon = 'mdi-close-circle';
                                                                $statusText = 'Inactivo';
                                                                break;
                                                            default:
                                                                $statusClass = 'bg-soft-secondary text-secondary';
                                                                $statusIcon = 'mdi-help-circle';
                                                                $statusText = ucfirst($service->status);
                                                        }
                                                    ?>
                                                    <span class="badge <?php echo $statusClass; ?>">
                                                        <i class="mdi <?php echo $statusIcon; ?> me-1"></i>
                                                        <?php echo $statusText; ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Formulario para Editar -->
                                                        <a href="pages-upd-service?id=<?php echo $service->id ?>"
                                                            class="btn btn-sm btn-info"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar servicio">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>

                                                        <form action="delete-service" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('⚠️ ¿Está seguro de eliminar este servicio?\n\nServicio: <?php echo htmlspecialchars($service->name); ?>\nPrecio: $<?php echo number_format($service->price, 0); ?> COP\n\n⚠️ ADVERTENCIA: Se eliminarán todas las citas asociadas a este servicio.\n\nEsta acción no se puede deshacer.');">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $service->id; ?>">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Eliminar servicio">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        </form>
                                                    </div>
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

        <!-- App js -->
        <script src="assets/admin/assets/js/app.js"></script>

        <!-- Code Highlight js -->
        <script src="assets/admin/assets/vendor/prismjs/prism.js"></script>
        <script src="assets/admin/assets/vendor/prismjs/prism-normalize-whitespace.min.js"></script>
        <script src="assets/admin/assets/vendor/clipboard/clipboard.min.js"></script>
        <script src="assets/admin/assets/js/hyper-syntax.js"></script>

        <!-- Datatables js -->
        <script src="assets/admin/assets/vendor/datatables/dataTables.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/responsive.bootstrap5.min.js"></script>
        <!-- Buttons -->
        <script src="assets/admin/assets/vendor/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/buttons.bootstrap5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/buttons.html5.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/buttons.print.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/jszip.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/pdfmake.min.js"></script>
        <script src="assets/admin/assets/vendor/datatables/vfs_fonts.js"></script>
        <!-- Select-->
        <script src="assets/admin/assets/vendor/datatables/dataTables.select.min.js"></script>
        <!-- Fixed Header-->
        <script src="assets/admin/assets/vendor/datatables/dataTables.fixedHeader.min.js"></script>

        <!-- Datatable Custom js -->
        <script src="assets/admin/assets/js/pages/demo.datatable-init.js"></script>

        <!-- Script personalizado para servicios -->
        <script>
            // Inicializar tooltips de Bootstrap
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });

            });
        </script>

</body>



</html>