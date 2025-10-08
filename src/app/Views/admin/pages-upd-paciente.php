<?php
require_once __DIR__ . '/../../Services/AuthService.php';

AuthService::requireLogin();

if (!AuthService::isAdminOrRoot()) {
    header("Location: login");
    exit;
}

$pacienteId = $_GET['id'] ?? null;

if (!$pacienteId) {
    header("Location: pages-get-paciente");
    exit;
}

$paciente = Paciente::findById($pacienteId);

if (!$paciente) {
    header("Location:pages-get-paciente");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">



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
                                    <?php include 'includes/alertEvent.php'; ?>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="update-paciente" method="POST">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $paciente->id; ?>">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre</label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->name); ?>"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="birth_date" class="form-label">Fecha de
                                                                        Nacimiento</label>
                                                                    <input type="date" id="birth_date" name="birth_date"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->birth_date); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone"
                                                                        class="form-label">Teléfono</label>
                                                                    <input type="text" id="phone" name="phone"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->phone); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="gender"
                                                                        class="form-label">Género</label>
                                                                    <select id="gender" name="gender"
                                                                        class="form-control">
                                                                        <option value="">Seleccionar</option>
                                                                        <option value="M"
                                                                            <?php echo $paciente->gender === 'M' ? 'selected' : ''; ?>>
                                                                            Masculino</option>
                                                                        <option value="F"
                                                                            <?php echo $paciente->gender === 'F' ? 'selected' : ''; ?>>
                                                                            Femenino</option>
                                                                        <option value="Otro"
                                                                            <?php echo $paciente->gender === 'Otro' ? 'selected' : ''; ?>>
                                                                            Otro</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Correo</label>
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->email); ?>"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="address"
                                                                        class="form-label">Dirección</label>
                                                                    <input type="text" id="address" name="address"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->address); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="emergency_contact_name"
                                                                        class="form-label">Nombre de Contacto de
                                                                        Emergencia</label>
                                                                    <input type="text" id="emergency_contact_name"
                                                                        name="emergency_contact_name"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->emergency_contact_name); ?>">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="emergency_contact_phone"
                                                                        class="form-label">Teléfono de Contacto de
                                                                        Emergencia</label>
                                                                    <input type="text" id="emergency_contact_phone"
                                                                        name="emergency_contact_phone"
                                                                        class="form-control"
                                                                        value="<?php echo htmlspecialchars($paciente->emergency_contact_phone); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Actualizar
                                                            Paciente</button>
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



</html>