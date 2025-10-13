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
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                        <li class="breadcrumb-item active">Registrar Cita</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Formulario de Cita</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Ingresar Información</h4>
                                    <p class="text-muted font-14">
                                        Seleccione un <code>paciente</code>, el <code>servicio</code> y el
                                        <code>doctor</code> para programar la cita
                                    </p>

                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>


                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="add-cita" method="POST">
                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="patient_id"
                                                                        class="form-label">Paciente</label>
                                                                    <!-- Single Select -->
                                                                    <select id="patient_id" name="patient_id"
                                                                        class="form-control select2" required
                                                                        onchange="fillPatientData()"
                                                                        data-toggle="select2">
                                                                        <option value="">Seleccionar paciente</option>
                                                                        <?php
                                                                        foreach ($pacientes as $paciente):
                                                                        ?>
                                                                        <option value="<?php echo $paciente['id']; ?>"
                                                                            data-name="<?php echo htmlspecialchars($paciente['name']. ' '. $paciente['lastname']); ?>"
                                                                            data-phone="<?php echo htmlspecialchars($paciente['phone']); ?>"
                                                                            data-email="<?php echo htmlspecialchars($paciente['email']); ?>"
                                                                            data-address="<?php echo htmlspecialchars($paciente['address']); ?>">
                                                                            <?php echo htmlspecialchars($paciente['idnumber'] . ' - ' . $paciente['name']); ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="name" class="form-label">Nombre</label>
                                                                    <input type="text" id="name" name="name"
                                                                        class="form-control" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone"
                                                                        class="form-label">Teléfono</label>
                                                                    <input type="text" id="phone" name="phone"
                                                                        class="form-control" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="email" class="form-label">Correo</label>
                                                                    <input type="email" id="email" name="email"
                                                                        class="form-control" readonly>
                                                                </div>
                                                            </div>
                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="service_id"
                                                                        class="form-label">Servicio</label>
                                                                    <select id="service_id" name="service_id"
                                                                        class="form-control" required>
                                                                        <option value="">Seleccionar servicio</option>
                                                                        <?php
                                                                        foreach ($servicios as $servicio):
                                                                        ?>
                                                                        <option value="<?php echo $servicio['id']; ?>"
                                                                            data-duration="<?php echo $servicio['duration_minutes']; ?>">
                                                                            <?php echo htmlspecialchars($servicio['name']); ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="doctor_id"
                                                                        class="form-label">Doctor</label>
                                                                    <select id="doctor_id" name="doctor_id"
                                                                        class="form-control" required>
                                                                        <option value="">Seleccionar doctor</option>
                                                                        <?php
                                                                        foreach ($doctores as $doctor):
                                                                        ?>
                                                                        <option value="<?php echo $doctor['id']; ?>">
                                                                            <?php echo htmlspecialchars($doctor['name'] . ' - ' . $doctor['specialization']); ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="appointment_date"
                                                                        class="form-label">Fecha y Hora</label>
                                                                    <input type="datetime-local" id="appointment_date"
                                                                        name="appointment_date" class="form-control"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="notes" class="form-label">Notas</label>
                                                                    <textarea id="notes" name="notes"
                                                                        class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-success">Registrar
                                                            Cita</button>
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

            <!-- END wrapper -->

            <!-- Theme Settings -->
            <?php include 'includes/theme.php'; ?>


            <!-- Vendor js -->
            <script src="assets/admin/assets/js/vendor.min.js"></script>

            <!-- App js -->
            <script src="assets/admin/assets/js/app.js"></script>
            <script>
            function fillPatientData() {
                const select = document.getElementById('patient_id');
                const selectedOption = select.options[select.selectedIndex];

                if (selectedOption.value) {
                    document.getElementById('name').value = selectedOption.getAttribute('data-name');
                    document.getElementById('phone').value = selectedOption.getAttribute('data-phone');
                    document.getElementById('email').value = selectedOption.getAttribute('data-email');
                } else {
                    document.getElementById('name').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('email').value = '';
                }
            }
            </script>

</body>



</html>