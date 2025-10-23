<!DOCTYPE html>
<html lang="es">


<head>
    <meta charset="utf-8" />
    <title>Categorías de Servicios | Sistema Clínica Dental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de categorías de servicios dentales" name="description" />
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
                                        <li class="breadcrumb-item active">Categorías</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="mdi mdi-tag-multiple text-primary me-1"></i>
                                    Gestión de Categorías de Servicios
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
                                                <i class="mdi mdi-folder-open text-primary me-1"></i>
                                                Categorías de Servicios Odontológicos
                                            </h4>
                                            <p class="text-muted font-13">
                                                Organice los servicios dentales en categorías para una mejor clasificación.
                                                Puede crear, editar y eliminar categorías según sea necesario.
                                            </p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <a href="pages-add-service-category" class="btn btn-primary mb-2">
                                                <i class="mdi mdi-plus-circle me-1"></i> Nueva Categoría
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Estadísticas rápidas -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-info bg-info text-white border-0 mb-0" role="alert">
                                                <i class="mdi mdi-information-outline me-2"></i>
                                                <strong>Total de categorías registradas: <?php echo count($categories); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="basic-datatable"
                                        class="table table-striped table-hover dt-responsive nowrap w-100 mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 8%">#</th>
                                                <th style="width: 45%"><i class="mdi mdi-tag me-1"></i>Nombre de Categoría</th>
                                                <th style="width: 20%"><i class="mdi mdi-calendar-clock me-1"></i>Fecha Creación</th>
                                                <th style="width: 20%"><i class="mdi mdi-update me-1"></i>Última Actualización</th>
                                                <th class="text-center" style="width: 12%"><i class="mdi mdi-tools me-1"></i>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($categories as $category): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge badge-outline-primary fs-6"><?php echo htmlspecialchars($category->id); ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        
                                                        <div>
                                                            <h5 class="mb-0 font-15 fw-semibold">
                                                                <?php echo htmlspecialchars($category->name); ?>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="mdi mdi-calendar-plus text-success me-1"></i>
                                                        <span class="text-muted">
                                                            <?php echo date('d/m/Y', strtotime($category->created_at)); ?>
                                                        </span>
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="mdi mdi-clock-outline me-1"></i>
                                                        <?php echo date('h:i A', strtotime($category->created_at)); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $created = new DateTime($category->created_at);
                                                        $updated = new DateTime($category->updated_at);
                                                        $wasUpdated = $created->format('Y-m-d H:i:s') !== $updated->format('Y-m-d H:i:s');
                                                    ?>
                                                    <?php if($wasUpdated): ?>
                                                    <div>
                                                        <i class="mdi mdi-pencil text-warning me-1"></i>
                                                        <span class="text-muted">
                                                            <?php echo date('d/m/Y', strtotime($category->updated_at)); ?>
                                                        </span>
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="mdi mdi-clock-outline me-1"></i>
                                                        <?php echo date('h:i A', strtotime($category->updated_at)); ?>
                                                    </small>
                                                    <?php else: ?>
                                                    <span class="badge bg-soft-secondary text-secondary">
                                                        <i class="mdi mdi-information-outline me-1"></i>
                                                        Sin modificaciones
                                                    </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <a href="pages-upd-service-category?id=<?php echo $category->id; ?>"
                                                            class="btn btn-sm btn-info"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar categoría">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>

                                                        <form action="delete-service-category" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('⚠️ ¿Está seguro de eliminar esta categoría?\n\nCategoría: <?php echo htmlspecialchars($category->name); ?>\n\n⚠️ ADVERTENCIA: Esta acción eliminará todos los servicios asociados a esta categoría.\n\nEsta acción no se puede deshacer.');">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $category->id; ?>">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Eliminar categoría">
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

        <!-- Script personalizado para categorías -->
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