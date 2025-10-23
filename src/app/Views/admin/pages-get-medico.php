<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Gestión de Médicos | Sistema Clínica Dental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de médicos y especialistas dentales" name="description" />
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
                                        <li class="breadcrumb-item"><a href="pages-get-medico">Médicos</a></li>
                                        <li class="breadcrumb-item active">Lista de Médicos</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="mdi mdi-doctor text-primary me-1"></i>
                                    Gestión de Médicos y Especialistas
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
                                                <i class="mdi mdi-account-multiple-plus text-primary me-1"></i>
                                                Directorio de Médicos Odontólogos
                                            </h4>
                                            <p class="text-muted font-13">
                                                Administre la información de todos los médicos y especialistas registrados en la clínica dental.
                                                Puede buscar, filtrar y exportar los datos.
                                            </p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <a href="pages-add-medico" class="btn btn-success mb-2">
                                                <i class="mdi mdi-account-plus me-1"></i> Registrar Nuevo Médico
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Estadísticas rápidas -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-success bg-success text-white border-0 mb-0" role="alert">
                                                <i class="mdi mdi-check-circle-outline me-2"></i>
                                                <strong>Total de médicos registrados: <?php echo count($doctors); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="basic-datatable"
                                        class="table table-striped table-hover dt-responsive nowrap w-100 mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th><i class="mdi mdi-doctor me-1"></i>Médico</th>
                                                <th><i class="mdi mdi-certificate me-1"></i>Especialización</th>
                                                <th><i class="mdi mdi-phone me-1"></i>Contacto</th>
                                                <th><i class="mdi mdi-email me-1"></i>Email</th>
                                                <th><i class="mdi mdi-card-account-details me-1"></i>Licencia</th>
                                                <th class="text-center"><i class="mdi mdi-tools me-1"></i>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($doctors as $doctor): ?>
                                            <!-- Médico -->
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge badge-outline-primary"><?php echo htmlspecialchars($doctor->id) ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title bg-soft-success text-success rounded-circle">
                                                                <i class="mdi mdi-doctor fs-4"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0 font-14">
                                                                Dr. <?php echo htmlspecialchars($doctor->name) ?>
                                                            </h5>
                                                            <?php if($doctor->idnumber): ?>
                                                            <small class="text-muted">
                                                                <i class="mdi mdi-card-account-details me-1"></i>
                                                                <?php echo htmlspecialchars($doctor->idnumber) ?>
                                                            </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if($doctor->specialization): ?>
                                                    <span class="badge bg-soft-primary text-primary fs-6">
                                                        <i class="mdi mdi-school me-1"></i>
                                                        <?php echo htmlspecialchars($doctor->specialization) ?>
                                                    </span>
                                                    <?php else: ?>
                                                    <span class="text-muted">No especificada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($doctor->phone): ?>
                                                    <a href="tel:<?php echo htmlspecialchars($doctor->phone) ?>" class="text-decoration-none">
                                                        <i class="mdi mdi-phone text-success me-1"></i>
                                                        <?php echo htmlspecialchars($doctor->phone) ?>
                                                    </a>
                                                    <?php else: ?>
                                                    <span class="text-muted">No registrado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($doctor->email): ?>
                                                    <a href="mailto:<?php echo htmlspecialchars($doctor->email) ?>" class="text-decoration-none">
                                                        <i class="mdi mdi-email text-info me-1"></i>
                                                        <?php echo htmlspecialchars($doctor->email) ?>
                                                    </a>
                                                    <?php else: ?>
                                                    <span class="text-muted">No registrado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($doctor->license_number): ?>
                                                    <div>
                                                        <span class="badge badge-soft-warning">
                                                            <i class="mdi mdi-certificate me-1"></i>
                                                            <?php echo htmlspecialchars($doctor->license_number) ?>
                                                        </span>
                                                        <?php if($doctor->created_at): ?>
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="mdi mdi-calendar-clock me-1"></i>
                                                                Desde: <?php echo date('d/m/Y', strtotime($doctor->created_at)); ?>
                                                            </small>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php else: ?>
                                                    <span class="text-muted">No registrada</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Formulario para Editar -->
                                                        <a href="pages-upd-medico?id=<?php echo $doctor->id ?>"
                                                            class="btn btn-sm btn-info"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar información del médico">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>

                                                        <!-- Formulario para Eliminar -->
                                                        <form action="delete-medico" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('⚠️ ¿Está seguro de eliminar este médico?\n\nMédico: Dr. <?php echo htmlspecialchars($doctor->name) ?>\nEspecialización: <?php echo htmlspecialchars($doctor->specialization ?? 'No especificada') ?>\n\n⚠️ ADVERTENCIA: Se eliminarán todas las citas asociadas a este médico.\n\nEsta acción no se puede deshacer.');">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $doctor->id; ?>">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Eliminar médico">
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

        <!-- Script personalizado para médicos -->
        <script>
            // Inicializar tooltips de Bootstrap
            document.addEventListener('DOMContentLoaded', function() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                });

                // Configuración personalizada de DataTables
                $('#basic-datatable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                    },
                    "pageLength": 25,
                    "order": [[1, "asc"]], // Ordenar por nombre ascendente
                    "columnDefs": [
                        { "orderable": false, "targets": 6 }, // Deshabilitar orden en columna de acciones
                        { "width": "5%", "targets": 0 },     // # ID
                        { "width": "25%", "targets": 1 },    // Médico
                        { "width": "18%", "targets": 2 },    // Especialización
                        { "width": "13%", "targets": 3 },    // Contacto
                        { "width": "15%", "targets": 4 },    // Email
                        { "width": "14%", "targets": 5 },    // Licencia
                        { "width": "10%", "targets": 6 }     // Acciones
                    ],
                    "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                    "responsive": true
                });
            });
        </script>

</body>



</html>