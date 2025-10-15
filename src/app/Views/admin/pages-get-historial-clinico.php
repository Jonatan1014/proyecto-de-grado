<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Datatables | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
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
                                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                        <li class="breadcrumb-item active">Lista de Historial Clinico</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Lista de Historial Clinico</h4>
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
                                    <h4 class="header-title">Basic Data Table</h4>
                                    <p class="text-muted font-14 mb-4">
                                        DataTables has most features enabled by default, so all you need to do to use it
                                        with your own tables is to call the construction
                                        function:
                                        <code>$().DataTable();</code>. KeyTable provides Excel like cell navigation on
                                        any table. Events (focus, blur, action etc) can be assigned to individual
                                        cells, columns, rows or all cells.
                                    </p>

                                    <!-- Tabla de historiales clínicos -->
                                    <table id="basic-datatable"
                                        class="table table-striped dt-responsive nowrap w-100 mb-0">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nº Historia</th>
                                                <th>Paciente</th>
                                                <th>Doctor</th>
                                                <th>Fecha Registro</th>
                                                <th>Diagnóstico Principal</th>
                                                <th>Tratamientos</th>
                                                <th>Estado Odontograma</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($historiales as $historial): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($historial->id) ?></td>
                                                <td>
                                                    <span class="badge bg-primary">
                                                        <?php echo htmlspecialchars($historial->history_number ?? 'N/A') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($historial->patient_name) && !empty($historial->patient_lastname)): ?>
                                                    <strong><?php echo htmlspecialchars($historial->patient_name . ' ' . $historial->patient_lastname) ?></strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?php echo htmlspecialchars($historial->patient_idnumber ?? '') ?>
                                                    </small>
                                                    <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($historial->doctor_name)): ?>
                                                    <?php echo htmlspecialchars($historial->doctor_name) ?>
                                                    <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                $fecha = $historial->registration_date ?? $historial->created_at;
                if ($fecha) {
                    $fechaObj = new DateTime($fecha);
                    echo htmlspecialchars($fechaObj->format('d/m/Y'));
                } else {
                    echo 'N/A';
                }
                ?>
                                                </td>
                                                <td>
                                                    <?php if (!empty($historial->main_diagnosis)): ?>
                                                    <div class="text-truncate" style="max-width: 200px;"
                                                        title="<?php echo htmlspecialchars($historial->main_diagnosis); ?>">
                                                        <?php echo htmlspecialchars(substr($historial->main_diagnosis, 0, 60)) . (strlen($historial->main_diagnosis) > 60 ? '...' : '') ?>
                                                    </div>
                                                    <?php else: ?>
                                                    <span class="text-muted">Sin diagnóstico</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php 
                $treatmentPlan = $historial->treatment_plan;
                // ✅ CORRECCIÓN: Asegurarse de que sea un array antes de usar count o foreach
                if (!empty($treatmentPlan) && is_array($treatmentPlan)) {
                    $totalTreatments = count($treatmentPlan);
                    $totalCost = 0;
                    foreach($treatmentPlan as $treatment) {
                        // ✅ CORRECCIÓN: Verificar que $treatment sea un array/objeto y que tenga la clave 'cost'
                        $cost = is_array($treatment) ? ($treatment['cost'] ?? 0) : (is_object($treatment) ? ($treatment->cost ?? 0) : 0);
                        $totalCost += floatval($cost);
                    }
                    ?>
                                                    <span class="badge bg-info">
                                                        <?php echo $totalTreatments; ?>
                                                        tratamiento<?php echo $totalTreatments > 1 ? 's' : ''; ?>
                                                    </span>
                                                    <?php if ($totalCost > 0): ?>
                                                    <br>
                                                    <small class="text-success">
                                                        <strong>$<?php echo number_format($totalCost, 2); ?></strong>
                                                    </small>
                                                    <?php endif; ?>
                                                    <?php } else { ?>
                                                    <span class="text-muted">Sin tratamientos</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php 
                $odontogram = $historial->odontogram;
                // ✅ CORRECCIÓN: Asegurarse de que sea un array antes de usar count o foreach
                if (!empty($odontogram) && is_array($odontogram)) {
                    $totalTeeth = count($odontogram);
                    
                    // Contar dientes por estado
                    $withIssues = 0;
                    $healthy = 0;
                    foreach($odontogram as $tooth) {
                        // ✅ CORRECCIÓN: Verificar que $tooth sea un array/objeto y que tenga la clave 'status'
                        $status = is_array($tooth) ? ($tooth['status'] ?? '') : (is_object($tooth) ? ($tooth->status ?? '') : '');
                        if ($status === 'Sano') {
                            $healthy++;
                        } elseif (!empty($status)) {
                            $withIssues++;
                        }
                    }
                    ?>
                                                    <span class="badge bg-secondary"><?php echo $totalTeeth; ?>
                                                        dientes</span>
                                                    <?php if ($withIssues > 0): ?>
                                                    <br>
                                                    <small class="text-warning">
                                                        <i class="uil-exclamation-triangle"></i>
                                                        <?php echo $withIssues; ?> con problemas
                                                    </small>
                                                    <?php endif; ?>
                                                    <?php } else { ?>
                                                    <span class="text-muted">Sin datos</span>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-nowrap">
                                                    <!-- Botón Ver/Editar -->
                                                    <a href="pages-upd-historial-clinico?id=<?php echo $historial->id ?>"
                                                        class="btn btn-sm btn-outline-info rounded-pill mb-1"
                                                        title="Editar historial">
                                                        <i class="uil-eye"></i> Ver
                                                    </a>

                                                    <!-- Botón Eliminar -->
                                                    <form action="delete-historial-clinico" method="POST"
                                                        style="display:inline-block;"
                                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este historial clínico?\n\nPaciente: <?php echo htmlspecialchars($historial->patient_name . ' ' . $historial->patient_lastname); ?>\nNº Historia: <?php echo htmlspecialchars($historial->history_number ?? 'N/A'); ?>');">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $historial->id; ?>">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger rounded-pill mb-1"
                                                            title="Eliminar historial">
                                                            <i class="uil-trash-alt"></i> Eliminar
                                                        </button>
                                                    </form>

                                                    <!-- Botón Descargar PDF -->
                                                    <a href="download-historial-pdf?id=<?php echo $historial->id; ?>"
                                                        class="btn btn-sm btn-outline-success rounded-pill mb-1"
                                                        title="Descargar historial en PDF">
                                                        <i class="uil-download-alt"></i> Descargar
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>

                                    <script>
                                    // Función para ver detalles del historial (opcional)
                                    function viewHistorialDetails(id) {
                                        // Opción 1: Abrir en modal
                                        // $('#historialModal').modal('show');
                                        // cargarDatosHistorial(id);

                                        // Opción 2: Abrir en nueva pestaña (solo lectura)
                                        window.open('view-historial-clinico?id=' + id, '_blank');

                                        // Opción 3: Redirigir a página de detalles
                                        // window.location.href = 'view-historial-clinico?id=' + id;
                                    }
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