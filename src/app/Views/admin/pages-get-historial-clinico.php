<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Historiales Clínicos | Sistema Clínica Dental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de historiales clínicos dentales" name="description" />
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
                                        <li class="breadcrumb-item"><a href="pages-get-historial-clinico">Historiales Clínicos</a></li>
                                        <li class="breadcrumb-item active">Lista de Historiales</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="mdi mdi-clipboard-text-multiple text-primary me-1"></i>
                                    Gestión de Historiales Clínicos
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
                                                Registro de Historiales Clínicos Dentales
                                            </h4>
                                            <p class="text-muted font-13">
                                                Gestione los historiales médicos odontológicos de todos los pacientes.
                                                Incluye diagnósticos, tratamientos y odontogramas.
                                            </p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <a href="pages-add-historial-clinico" class="btn btn-success mb-2">
                                                <i class="mdi mdi-plus-circle me-1"></i> Crear Nuevo Historial
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Estadísticas rápidas -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-primary bg-primary text-white border-0 mb-0" role="alert">
                                                <i class="mdi mdi-information-outline me-2"></i>
                                                <strong>Total de historiales registrados: <?php echo count($historiales); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de historiales clínicos -->
                                    <table id="basic-datatable"
                                        class="table table-striped table-hover dt-responsive nowrap w-100 mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th><i class="mdi mdi-folder-account me-1"></i>Nº Historia</th>
                                                <th><i class="mdi mdi-account me-1"></i>Paciente</th>
                                                <th><i class="mdi mdi-doctor me-1"></i>Doctor</th>
                                                <th><i class="mdi mdi-calendar me-1"></i>Fecha</th>
                                                <th><i class="mdi mdi-stethoscope me-1"></i>Diagnóstico</th>
                                                <th><i class="mdi mdi-pill me-1"></i>Tratamientos</th>
                                                <th><i class="mdi mdi-tooth me-1"></i>Odontograma</th>
                                                <th class="text-center"><i class="mdi mdi-tools me-1"></i>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($historiales as $historial): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge badge-outline-primary"><?php echo htmlspecialchars($historial->id) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-soft-primary text-primary fs-6">
                                                        <i class="mdi mdi-file-document me-1"></i>
                                                        <?php echo htmlspecialchars($historial->history_number ?? 'N/A') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($historial->patient_name) && !empty($historial->patient_lastname)): ?>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title bg-soft-info text-info rounded-circle">
                                                                <?php
                                                                    $initials = strtoupper(substr($historial->patient_name, 0, 1) . substr($historial->patient_lastname, 0, 1));
                                                                    echo $initials;
                                                                ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0 font-14">
                                                                <?php echo htmlspecialchars($historial->patient_name . ' ' . $historial->patient_lastname) ?>
                                                            </h5>
                                                            <small class="text-muted">
                                                                <i class="mdi mdi-card-account-details me-1"></i>
                                                                <?php echo htmlspecialchars($historial->patient_idnumber ?? 'Sin cédula') ?>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($historial->doctor_name)): ?>
                                                    <div>
                                                        <i class="mdi mdi-doctor text-primary me-1"></i>
                                                        <span class="fw-semibold"><?php echo htmlspecialchars($historial->doctor_name) ?></span>
                                                    </div>
                                                    <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $fecha = $historial->registration_date ?? $historial->created_at;
                                                        if ($fecha) {
                                                            $fechaObj = new DateTime($fecha);
                                                            echo '<span class="text-muted">';
                                                            echo '<i class="mdi mdi-calendar-clock me-1"></i>';
                                                            echo htmlspecialchars($fechaObj->format('d/m/Y'));
                                                            echo '</span>';
                                                        } else {
                                                            echo '<span class="text-muted">N/A</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($historial->main_diagnosis)): ?>
                                                    <div class="text-truncate" style="max-width: 250px;"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top"
                                                        title="<?php echo htmlspecialchars($historial->main_diagnosis); ?>">
                                                        <i class="mdi mdi-file-document-outline text-info me-1"></i>
                                                        <?php echo htmlspecialchars(substr($historial->main_diagnosis, 0, 50)) . (strlen($historial->main_diagnosis) > 50 ? '...' : '') ?>
                                                    </div>
                                                    <?php else: ?>
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-alert-circle-outline me-1"></i>
                                                        Sin diagnóstico
                                                    </span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $treatmentPlan = $historial->treatment_plan;
                                                        if (!empty($treatmentPlan) && is_array($treatmentPlan)) {
                                                            $totalTreatments = count($treatmentPlan);
                                                            $totalCost = 0;
                                                            foreach($treatmentPlan as $treatment) {
                                                                $cost = is_array($treatment) ? ($treatment['cost'] ?? 0) : (is_object($treatment) ? ($treatment->cost ?? 0) : 0);
                                                                $totalCost += floatval($cost);
                                                            }
                                                    ?>
                                                    <div>
                                                        <span class="badge bg-soft-info text-info">
                                                            <i class="mdi mdi-medical-bag me-1"></i>
                                                            <?php echo $totalTreatments; ?>
                                                            <?php echo $totalTreatments > 1 ? 'tratamientos' : 'tratamiento'; ?>
                                                        </span>
                                                        <?php if ($totalCost > 0): ?>
                                                        <div class="mt-1">
                                                            <span class="badge bg-soft-success text-success">
                                                                <i class="mdi mdi-currency-usd"></i>
                                                                <?php echo number_format($totalCost, 0); ?> COP
                                                            </span>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php } else { ?>
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-close-circle-outline me-1"></i>
                                                        Sin tratamientos
                                                    </span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $odontogram = $historial->odontogram;
                                                        if (!empty($odontogram) && is_array($odontogram)) {
                                                            $totalTeeth = count($odontogram);
                                                            
                                                            // Contar dientes por estado
                                                            $withIssues = 0;
                                                            $healthy = 0;
                                                            foreach($odontogram as $tooth) {
                                                                $status = is_array($tooth) ? ($tooth['status'] ?? '') : (is_object($tooth) ? ($tooth->status ?? '') : '');
                                                                if ($status === 'Sano') {
                                                                    $healthy++;
                                                                } elseif (!empty($status)) {
                                                                    $withIssues++;
                                                                }
                                                            }
                                                    ?>
                                                    <div>
                                                        <span class="badge bg-soft-secondary text-secondary">
                                                            <i class="mdi mdi-tooth me-1"></i>
                                                            <?php echo $totalTeeth; ?> dientes
                                                        </span>
                                                        <?php if ($healthy > 0): ?>
                                                        <div class="mt-1">
                                                            <span class="badge bg-soft-success text-success">
                                                                <i class="mdi mdi-check-circle me-1"></i>
                                                                <?php echo $healthy; ?> sanos
                                                            </span>
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php if ($withIssues > 0): ?>
                                                        <div class="mt-1">
                                                            <span class="badge bg-soft-warning text-warning">
                                                                <i class="mdi mdi-alert me-1"></i>
                                                                <?php echo $withIssues; ?> con problemas
                                                            </span>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php } else { ?>
                                                    <span class="text-muted">
                                                        <i class="mdi mdi-alert-circle-outline me-1"></i>
                                                        Sin datos
                                                    </span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group-vertical" role="group">
                                                        <!-- Botón Ver/Editar -->
                                                        <a href="pages-upd-historial-clinico?id=<?php echo $historial->id ?>"
                                                            class="btn btn-sm btn-info mb-1"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Ver y editar historial">
                                                            <i class="mdi mdi-eye"></i> Ver
                                                        </a>

                                                        <!-- Botón Descargar PDF -->
                                                        <a href="download-historial-pdf?id=<?php echo $historial->id; ?>"
                                                            class="btn btn-sm btn-success mb-1"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Descargar historial en PDF">
                                                            <i class="mdi mdi-download"></i> PDF
                                                        </a>

                                                        <!-- Botón Eliminar -->
                                                        <form action="delete-historial-clinico" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('⚠️ ¿Está seguro de eliminar este historial clínico?\n\nPaciente: <?php echo htmlspecialchars($historial->patient_name . ' ' . $historial->patient_lastname); ?>\nNº Historia: <?php echo htmlspecialchars($historial->history_number ?? 'N/A'); ?>\n\n⚠️ ADVERTENCIA: Esta acción no se puede deshacer.');">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $historial->id; ?>">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Eliminar historial">
                                                                <i class="mdi mdi-delete"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <script>
                                    // Inicializar tooltips de Bootstrap
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                                        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                            return new bootstrap.Tooltip(tooltipTriggerEl)
                                        });

                                        
                                    });
                                    </script>

                                    <style>
                                    /* Estilos adicionales para mejorar la presentación */
                                    .table td {
                                        vertical-align: middle;
                                    }

                                    .text-truncate {
                                        white-space: nowrap;
                                        overflow: hidden;
                                        text-overflow: ellipsis;
                                    }

                                    /* Mejorar espaciado de badges */
                                    .badge {
                                        font-size: 0.75rem;
                                        padding: 0.35em 0.65em;
                                    }

                                    /* Responsive: Hacer scroll horizontal en móviles */
                                    @media (max-width: 768px) {
                                        .table-responsive {
                                            overflow-x: auto;
                                            -webkit-overflow-scrolling: touch;
                                        }

                                        .btn-sm {
                                            font-size: 0.7rem;
                                            padding: 0.25rem 0.5rem;
                                        }
                                    }

                                    /* Tooltip personalizado */
                                    [title]:hover {
                                        cursor: help;
                                    }
                                    </style>

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

</body>



</html>