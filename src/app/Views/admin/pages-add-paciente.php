<!DOCTYPE html>
<html lang="es">



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
                                        <li class="breadcrumb-item active">Nuevo Registro</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Registrar Nuevo Paciente</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Información del Paciente</h4>
                                    <p class="text-muted font-14">
                                        Complete los siguientes campos con los datos personales y de contacto del paciente. Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                                    </p>

                                    <ul class="nav nav-tabs nav-bordered mb-3">


                                    </ul> <!-- end nav-->
                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>



                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="add-paciente" method="POST">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="row">
                                                                    <!-- Datos Personales -->
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="name" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                                                                        <input type="text" id="name" name="name"
                                                                            class="form-control" placeholder="Ej: Juan Carlos" required>
                                                                    </div>

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="lastname" class="form-label">Apellido(s) <span class="text-danger">*</span></label>
                                                                        <input type="text" id="lastname" name="lastname"
                                                                            class="form-control" placeholder="Ej: Pérez García" required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">

                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="idnumber" class="form-label">Cédula / ID</label>
                                                                        <input type="text" id="idnumber" name="idnumber"
                                                                            class="form-control" placeholder="Ej: 1234567890">
                                                                        <small class="form-text text-muted">Número único de identificación</small>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                                                                        <input type="date" id="birth_date" name="birth_date"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="gender" class="form-label">Género</label>
                                                                        <select id="gender" name="gender" class="form-control">
                                                                            <option value="">-- Seleccione --</option>
                                                                            <option value="M">Masculino</option>
                                                                            <option value="F">Femenino</option>
                                                                            <option value="Otro">Otro</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="phone" class="form-label">Teléfono</label>
                                                                        <input type="tel" id="phone" name="phone"
                                                                            class="form-control" placeholder="Ej: 0987654321">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Datos de Contacto -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control" placeholder="ejemplo@correo.com" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="address" class="form-label">Dirección de Residencia</label>
                                                                    <textarea id="address" name="address" class="form-control" rows="2" 
                                                                        placeholder="Calle, número, sector, ciudad"></textarea>
                                                                </div>
                                                                
                                                                <!-- Contacto de Emergencia -->
                                                                <div class="alert alert-info bg-info text-white border-0 mb-3" role="alert">
                                                                    <strong><i class="mdi mdi-phone-alert me-1"></i> Contacto de Emergencia</strong>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="emergency_contact_name" class="form-label">Nombre Completo</label>
                                                                    <input type="text" id="emergency_contact_name"
                                                                        name="emergency_contact_name"
                                                                        class="form-control" placeholder="Ej: María Pérez">
                                                                    <small class="form-text text-muted">Persona a contactar en caso de emergencia</small>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="emergency_contact_phone" class="form-label">Teléfono</label>
                                                                    <input type="tel" id="emergency_contact_phone"
                                                                        name="emergency_contact_phone"
                                                                        class="form-control" placeholder="Ej: 0999888777">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="text-end mt-3">
                                                            <a href="pages-get-paciente" class="btn btn-light me-2">
                                                                <i class="mdi mdi-arrow-left me-1"></i> Cancelar
                                                            </a>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="mdi mdi-content-save me-1"></i> Guardar Paciente
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div> <!-- end preview-->


                                    </div> <!-- end tab-content-->
                                </div> <!-- end card-body -->
                            </div> <!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->






                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include 'includes/footer.php'; ?>
            <!-- end Footer -->
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

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