<!DOCTYPE html>
<html lang="es">



<head>
    <meta charset="utf-8" />
    <title>Gestión de Pacientes | Sistema Clínica Dental</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema de gestión de pacientes - Clínica Dental" name="description" />
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
                                        <li class="breadcrumb-item"><a href="pages-get-paciente">Pacientes</a></li>
                                        <li class="breadcrumb-item active">Lista de Pacientes</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">
                                    <i class="mdi mdi-account-multiple me-1"></i> Gestión de Pacientes
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
                                                <i class="mdi mdi-account-group text-primary me-1"></i>
                                                Registro de Pacientes
                                            </h4>
                                            <p class="text-muted font-13">
                                                Administre la información de todos los pacientes registrados en la clínica.
                                                Puede buscar, filtrar y exportar los datos.
                                            </p>
                                        </div>
                                        <div class="col-sm-4 text-sm-end">
                                            <a href="pages-add-paciente" class="btn btn-success mb-2">
                                                <i class="mdi mdi-account-plus me-1"></i> Registrar Nuevo Paciente
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Estadísticas rápidas -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-info bg-info text-white border-0 mb-0" role="alert">
                                                <i class="mdi mdi-information-outline me-2"></i>
                                                <strong>Total de pacientes registrados: <?php echo count($pacientes); ?></strong>
                                            </div>
                                        </div>
                                    </div>

                                    <table id="basic-datatable"
                                        class="table table-striped table-hover dt-responsive nowrap w-100 mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th><i class="mdi mdi-account me-1"></i>Paciente</th>
                                                <th><i class="mdi mdi-card-account-details me-1"></i>Cédula/ID</th>
                                                <th><i class="mdi mdi-cake-variant me-1"></i>Edad</th>
                                                <th><i class="mdi mdi-gender-male-female me-1"></i>Género</th>
                                                <th><i class="mdi mdi-phone me-1"></i>Contacto</th>
                                                <th><i class="mdi mdi-email me-1"></i>Email</th>
                                                <th><i class="mdi mdi-phone-alert me-1"></i>Emergencia</th>
                                                <th class="text-center"><i class="mdi mdi-tools me-1"></i>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php foreach($pacientes as $paciente): ?>
                                            <tr>
                                                <td class="text-center">
                                                    <span class="badge badge-outline-primary"><?php echo htmlspecialchars($paciente->id) ?></span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        
                                                        <div>
                                                            <h5 class="mb-0 font-14">
                                                                <?php echo htmlspecialchars($paciente->name. ' '.$paciente->lastname) ?>
                                                            </h5>
                                                            <?php if($paciente->birth_date): ?>
                                                            <small class="text-muted">
                                                                <i class="mdi mdi-calendar-blank me-1"></i>
                                                                <?php echo date('d/m/Y', strtotime($paciente->birth_date)) ?>
                                                            </small>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-soft-secondary">
                                                        <?php echo htmlspecialchars($paciente->idnumber ?: 'No registrada') ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($paciente->birth_date) {
                                                            $birthDate = new DateTime($paciente->birth_date);
                                                            $today = new DateTime();
                                                            $age = $today->diff($birthDate)->y;
                                                            echo '<span class="badge badge-outline-info">' . $age . ' años</span>';
                                                        } else {
                                                            echo '<span class="text-muted">-</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $genderIcon = '';
                                                        $genderText = '';
                                                        $genderClass = '';
                                                        switch($paciente->gender) {
                                                            case 'M':
                                                                $genderIcon = 'mdi mdi-gender-male';
                                                                $genderText = 'Masculino';
                                                                $genderClass = 'text-primary';
                                                                break;
                                                            case 'F':
                                                                $genderIcon = 'mdi mdi-gender-female';
                                                                $genderText = 'Femenino';
                                                                $genderClass = 'text-danger';
                                                                break;
                                                            default:
                                                                $genderIcon = 'mdi mdi-help-circle';
                                                                $genderText = 'Otro';
                                                                $genderClass = 'text-secondary';
                                                        }
                                                    ?>
                                                    <i class="<?php echo $genderIcon . ' ' . $genderClass; ?> me-1"></i>
                                                    <span class="<?php echo $genderClass; ?>"><?php echo $genderText; ?></span>
                                                </td>
                                                <td>
                                                    <?php if($paciente->phone): ?>
                                                        <a href="tel:<?php echo htmlspecialchars($paciente->phone) ?>" class="text-decoration-none">
                                                            <i class="mdi mdi-phone text-success me-1"></i>
                                                            <?php echo htmlspecialchars($paciente->phone) ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No registrado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($paciente->email): ?>
                                                        <a href="mailto:<?php echo htmlspecialchars($paciente->email) ?>" class="text-decoration-none">
                                                            <i class="mdi mdi-email text-info me-1"></i>
                                                            <?php echo htmlspecialchars($paciente->email) ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted">No registrado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- Contacto de Emergencia -->
                                                <td>
                                                    <?php if (!empty($paciente->emergency_contact_name)): ?>
                                                        <div class="d-flex align-items-start">
                                                            <i class="mdi mdi-phone-alert text-warning me-1 mt-1"></i>
                                                            <div>
                                                                <div class="font-13">
                                                                    <strong><?php echo htmlspecialchars($paciente->emergency_contact_name) ?></strong>
                                                                </div>
                                                                <?php if($paciente->emergency_contact_phone): ?>
                                                                <small class="text-muted">
                                                                    <?php echo htmlspecialchars($paciente->emergency_contact_phone) ?>
                                                                </small>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <span class="text-muted">No registrado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Botón Ver/Editar -->
                                                        <a href="pages-upd-paciente?id=<?php echo $paciente->id ?>"
                                                            class="btn btn-sm btn-info"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="Editar paciente">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>

                                                        <!-- Botón Eliminar -->
                                                        <form action="delete-paciente" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('⚠️ ¿Está seguro de eliminar este paciente?\n\nPaciente: <?php echo htmlspecialchars($paciente->name.' '.$paciente->lastname) ?>\nCédula: <?php echo htmlspecialchars($paciente->idnumber ?: 'No registrada') ?>\n\n⚠️ ADVERTENCIA: Se eliminarán todos los registros asociados:\n• Citas médicas\n• Historiales clínicos\n• Eventos del calendario\n\nEsta acción no se puede deshacer.');">
                                                            <input type="hidden" name="id"
                                                                value="<?php echo $paciente->id; ?>">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Eliminar paciente">
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

</body>



</html>