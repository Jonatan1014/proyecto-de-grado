<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Gestión de Citas | Sistema Clínica Dental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de citas médicas - Clínica Dental" name="description" />
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
                                        <li class="breadcrumb-item"><a href="pages-get-cita">Citas</a></li>
                                        <li class="breadcrumb-item active">Lista de Citas</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="mdi mdi-calendar-clock me-1"></i> Gestión de Citas Médicas
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
                                                <i class="mdi mdi-format-list-bulleted text-primary me-1"></i>
                                                Registro de Citas
                                            </h4>
                                            <p class="text-muted font-13">
                                                Visualice y gestione todas las citas médicas programadas. 
                                                Puede filtrar, buscar y exportar la información.
                                            </p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <a href="pages-add-cita" class="btn btn-success mb-2">
                                                <i class="mdi mdi-plus-circle me-1"></i> Agendar Nueva Cita
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Filtros rápidos -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="btn-group" role="group" aria-label="Filtros de estado">
                                                <button type="button" class="btn btn-sm btn-outline-secondary active" onclick="filterByStatus('all')">
                                                    <i class="mdi mdi-eye me-1"></i> Todas
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-warning" onclick="filterByStatus('scheduled')">
                                                    <i class="mdi mdi-clock-outline me-1"></i> Programadas
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="filterByStatus('completed')">
                                                    <i class="mdi mdi-check-circle me-1"></i> Completadas
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="filterByStatus('cancelled')">
                                                    <i class="mdi mdi-close-circle me-1"></i> Canceladas
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="basic-datatable"
                                        class="table table-striped table-hover dt-responsive nowrap w-100 mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th><i class="mdi mdi-account me-1"></i>Paciente</th>
                                                <th><i class="mdi mdi-doctor me-1"></i>Médico</th>
                                                <th><i class="mdi mdi-medical-bag me-1"></i>Servicio</th>
                                                <th><i class="mdi mdi-calendar-clock me-1"></i>Fecha y Hora</th>
                                                <th class="text-center"><i class="mdi mdi-flag me-1"></i>Estado</th>
                                                <th><i class="mdi mdi-note-text me-1"></i>Observaciones</th>
                                                <th class="text-center"><i class="mdi mdi-tools me-1"></i>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($appointments as $appointment): ?>
                                            <!-- Cita -->
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge badge-outline-primary"><?php echo htmlspecialchars($appointment->idnumber) ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title bg-soft-info text-info rounded-circle">
                                                                <?php 
                                                                    $initials = strtoupper(substr($appointment->patient_name, 0, 1) . substr($appointment->patient_lastname, 0, 1));
                                                                    echo $initials; 
                                                                ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0 font-14"><?php echo htmlspecialchars($appointment->patient_name.' '.$appointment->patient_lastname) ?></h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <i class="mdi mdi-stethoscope text-primary me-1"></i>
                                                    <?php echo htmlspecialchars($appointment->doctor_name) ?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-soft-secondary">
                                                        <?php echo htmlspecialchars($appointment->service_name) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="mdi mdi-calendar text-muted me-1"></i>
                                                        <strong><?php echo date('d/m/Y', strtotime($appointment->appointment_date)) ?></strong>
                                                    </div>
                                                    <div class="text-muted small">
                                                        <i class="mdi mdi-clock-outline me-1"></i>
                                                        <?php echo date('h:i A', strtotime($appointment->appointment_date)) ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <?php
                                                        $statusClass = '';
                                                        $statusText = '';
                                                        $statusIcon = '';
                                                        switch($appointment->status) {
                                                            case 'scheduled':
                                                                $statusClass = 'badge bg-warning text-dark';
                                                                $statusText = 'Programada';
                                                                $statusIcon = 'mdi mdi-clock-outline';
                                                                break;
                                                            case 'completed':
                                                                $statusClass = 'badge bg-success';
                                                                $statusText = 'Completada';
                                                                $statusIcon = 'mdi mdi-check-circle';
                                                                break;
                                                            case 'cancelled':
                                                                $statusClass = 'badge bg-danger';
                                                                $statusText = 'Cancelada';
                                                                $statusIcon = 'mdi mdi-close-circle';
                                                                break;
                                                            default:
                                                                $statusClass = 'badge bg-secondary';
                                                                $statusText = ucfirst($appointment->status);
                                                                $statusIcon = 'mdi mdi-information';
                                                        }
                                                        ?>
                                                    <span class="<?php echo $statusClass; ?>">
                                                        <i class="<?php echo $statusIcon; ?> me-1"></i>
                                                        <?php echo htmlspecialchars($statusText); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $notes = $appointment->notes ?? '';
                                                        if(strlen($notes) > 50) {
                                                            echo '<span title="' . htmlspecialchars($notes) . '">' . htmlspecialchars(substr($notes, 0, 50)) . '...</span>';
                                                        } else {
                                                            echo htmlspecialchars($notes ?: 'Sin observaciones');
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Botón Ver/Editar -->
                                                        <a href="pages-upd-cita?id=<?php echo $appointment->id ?>"
                                                            class="btn btn-sm btn-info"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top" 
                                                            title="Editar cita">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>

                                                        <!-- Botón Eliminar -->
                                                        <form action="delete-cita" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('⚠️ ¿Está seguro de eliminar esta cita?\n\nPaciente: <?php echo htmlspecialchars($appointment->patient_name.' '.$appointment->patient_lastname) ?>\nFecha: <?php echo date('d/m/Y h:i A', strtotime($appointment->appointment_date)) ?>\n\nEsta acción no se puede deshacer.');">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $appointment->id; ?>">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top" 
                                                                title="Eliminar cita">
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

        <!-- Script para filtros de estado -->
        <script>
            // Inicializar tooltips de Bootstrap
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Función para filtrar por estado
            function filterByStatus(status) {
                var table = $('#basic-datatable').DataTable();
                
                // Remover clase active de todos los botones
                document.querySelectorAll('.btn-group button').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Agregar clase active al botón clickeado
                event.target.closest('button').classList.add('active');
                
                // Filtrar tabla
                if (status === 'all') {
                    table.search('').columns().search('').draw();
                } else {
                    // Buscar en la columna de estado (columna 5)
                    var statusText = {
                        'scheduled': 'Programada',
                        'completed': 'Completada',
                        'cancelled': 'Cancelada'
                    };
                    table.column(5).search(statusText[status]).draw();
                }
            }

            
        </script>

</body>



</html>