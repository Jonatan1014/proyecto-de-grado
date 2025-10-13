<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Editar Cita | Sistema de Citas Médicas</title>
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

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="admin">Home</a></li>
                                        <li class="breadcrumb-item"><a href="pages-get-cita">Lista de Citas</a></li>
                                        <li class="breadcrumb-item active">Editar Cita</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Editar Cita</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Actualizar Información de la Cita</h4>
                                    <p class="text-muted font-14">
                                        Modifique los datos de la <code>cita médica</code> seleccionada
                                    </p>

                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="update-cita" method="POST">
                                                        <!-- ID oculto -->
                                                        <input type="hidden" name="id"
                                                            value="<?php echo htmlspecialchars($cita->id); ?>">

                                                        <div class="row">
                                                            <!-- Primera columna -->
                                                            <div class="col-lg-6">
                                                                <!-- Paciente -->
                                                                <div class="mb-3">
                                                                    <label for="patient_id" class="form-label">Paciente
                                                                        <span class="text-danger">*</span></label>
                                                                    <input id="patient_id" name="patient_id"
                                                                        value="<?php echo htmlspecialchars($cita->patient_name . ' ' . $cita->patient_lastname); ?>"
                                                                        class="form-control" disabled required>

                                                                    </input>
                                                                </div>

                                                                <!-- Doctor -->
                                                                <div class="mb-3">
                                                                    <label for="doctor_id" class="form-label">Médico
                                                                        <span class="text-danger">*</span></label>
                                                                    <select id="doctor_id" name="doctor_id"
                                                                        class="form-control" required>
                                                                        <option value="">Seleccionar médico</option>
                                                                        <?php foreach ($doctores as $doctor): ?>
                                                                        <option
                                                                            value="<?php echo htmlspecialchars($doctor['id']); ?>"
                                                                            <?php echo ($cita->doctor_id == $doctor['id']) ? 'selected' : ''; ?>>
                                                                            <?php echo htmlspecialchars($doctor['name']); ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>

                                                                <!-- Servicio -->
                                                                <div class="mb-3">
                                                                    <label for="service_id" class="form-label">Servicio
                                                                        <span class="text-danger">*</span></label>
                                                                    <select id="service_id" name="service_id"
                                                                        class="form-control" required>
                                                                        <option value="">Seleccionar servicio</option>
                                                                        <?php foreach ($servicios as $servicio): ?>
                                                                        <option
                                                                            value="<?php echo htmlspecialchars($servicio['id']); ?>"
                                                                            data-price="<?php echo htmlspecialchars($servicio['price']); ?>"
                                                                            data-duration="<?php echo htmlspecialchars($servicio['duration_minutes']); ?>"
                                                                            <?php echo (isset($cita) && $cita->service_id == $servicio['id']) ? 'selected' : ''; ?>>
                                                                            <?php echo htmlspecialchars($servicio['name']); ?>
                                                                            <?php if (isset($servicio['duration_minutes'])): ?>
                                                                            (<?php echo $servicio['duration_minutes']; ?>
                                                                            min)
                                                                            <?php endif; ?>
                                                                        </option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Segunda columna -->
                                                            <div class="col-lg-6">
                                                                <!-- Fecha y Hora -->
                                                                <div class="mb-3">
                                                                    <label for="appointment_date"
                                                                        class="form-label">Fecha y Hora de la Cita <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="datetime-local" id="appointment_date"
                                                                        name="appointment_date" class="form-control"
                                                                        required
                                                                        value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($cita->appointment_date))); ?>">
                                                                </div>
                                                                <!-- Precio de servicio -->
                                                                <div class="mb-3">
                                                                    <label for="price_service" class="form-label">Precio
                                                                        del servicio <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="number" id="price_service"
                                                                        name="price_service" class="form-control"
                                                                        value="<?php echo isset($cita) ? htmlspecialchars($cita->price_service ?? $cita->service_price ?? '') : ''; ?>"
                                                                        step="0.01" min="0" required>
                                                                    <small class="text-muted">Precio base: <span
                                                                            id="base_price_display">N/A</span></small>
                                                                </div>

                                                                <!-- Estado -->
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">
                                                                        Estado de la Cita <span
                                                                            class="text-danger">*</span>
                                                                    </label>
                                                                    <!-- Estado -->
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Estado
                                                                            <span class="text-danger">*</span></label>
                                                                        <select id="status" name="status"
                                                                            class="form-select" required>
                                                                            <option value="">Seleccionar estado</option>
                                                                            <option value="scheduled"
                                                                                <?php echo (isset($cita) && $cita->status == 'scheduled') ? 'selected' : ''; ?>>
                                                                                📅 Programada</option>
                                                                            <option value="completed"
                                                                                <?php echo (isset($cita) && $cita->status == 'completed') ? 'selected' : ''; ?>>
                                                                                ✅ Completada</option>
                                                                            <option value="cancelled"
                                                                                <?php echo (isset($cita) && $cita->status == 'cancelled') ? 'selected' : ''; ?>>
                                                                                ❌ Cancelada</option>
                                                                        </select>
                                                                    </div>




                                                                    

                                                                </div>


                                                                <!-- Notas -->
                                                                <div class="mb-3">
                                                                    <label for="notes" class="form-label">Notas /
                                                                        Observaciones</label>
                                                                    <textarea id="notes" name="notes"
                                                                        class="form-control" rows="3"
                                                                        placeholder="Ingrese observaciones o notas adicionales..."><?php echo htmlspecialchars($cita->notes ?? ''); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Información adicional de la cita -->
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <div class="alert alert-info">
                                                                    <h5 class="alert-heading">Información Actual de la
                                                                        Cita</h5>
                                                                    <hr>
                                                                    <p class="mb-1">
                                                                        <strong># Identificacion:</strong>
                                                                        <?php echo htmlspecialchars($cita->idnumber ?? $cita->id); ?>
                                                                    </p>
                                                                    <p class="mb-1">
                                                                        <strong>Paciente Actual:</strong>
                                                                        <?php echo htmlspecialchars($cita->patient_name . ' ' . $cita->patient_lastname); ?>
                                                                    </p>
                                                                    <p class="mb-1">
                                                                        <strong>Médico Actual:</strong>
                                                                        <?php echo htmlspecialchars($cita->doctor_name); ?>
                                                                    </p>
                                                                    <p class="mb-1">
                                                                        <strong>Servicio Actual:</strong>
                                                                        <?php echo htmlspecialchars($cita->service_name); ?>
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        <strong>Fecha de Registro:</strong>
                                                                        <?php echo htmlspecialchars($cita->created_at); ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Botones de acción -->
                                                        <div class="row mt-3">
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="uil-check me-1"></i> Actualizar Cita
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div> <!-- end tab-content-->
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
    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <?php include 'includes/theme.php'; ?>

    <!-- Vendor js -->
    <script src="assets/admin/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/admin/assets/js/app.js"></script>

    <!-- Validación y funcionalidad del formulario -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editCitaForm');

        // Validación antes de enviar
        form.addEventListener('submit', function(e) {
            const appointmentDate = document.getElementById('appointment_date').value;

            // Validar que la fecha no sea muy antigua (opcional)
            const selectedDate = new Date(appointmentDate);
            const today = new Date();
            const oneYearAgo = new Date();
            oneYearAgo.setFullYear(today.getFullYear() - 1);

            if (selectedDate < oneYearAgo) {
                const confirmOld = window.confirm(
                    '⚠️ La fecha seleccionada es muy antigua (más de 1 año atrás). ¿Desea continuar?'
                );
                if (!confirmOld) {
                    e.preventDefault();
                    return false;
                }
            }

            // Confirmación final
            const confirmSubmit = window.confirm('¿Está seguro de actualizar esta cita?');
            if (!confirmSubmit) {
                e.preventDefault();
                return false;
            }

            return true;
        });




    });


    document.addEventListener('DOMContentLoaded', function() {
        const serviceSelect = document.getElementById('service_id');
        const priceInput = document.getElementById('price_service');
        const basePriceDisplay = document.getElementById('base_price_display');

        // Función para formatear a moneda COP
        function formatCOP(value) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0
            }).format(value);
        }

        // Función para actualizar el precio
        function updateServicePrice() {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];

            if (selectedOption.value) {
                const basePrice = selectedOption.getAttribute('data-price');

                // Mostrar precio base formateado
                if (basePrice) {
                    basePriceDisplay.textContent = formatCOP(basePrice);

                    // Autocompletar el input si está vacío o marcado
                    if (!priceInput.value || priceInput.dataset.autoFilled === 'true') {
                        priceInput.value = parseFloat(basePrice).toFixed(2);
                        priceInput.dataset.autoFilled = 'true';
                    }
                } else {
                    basePriceDisplay.textContent = 'N/A';
                }
            } else {
                basePriceDisplay.textContent = 'N/A';
                if (priceInput.dataset.autoFilled === 'true') {
                    priceInput.value = '';
                    priceInput.dataset.autoFilled = 'true';
                }
            }
        }

        // Eventos
        serviceSelect.addEventListener('change', updateServicePrice);
        priceInput.addEventListener('input', () => priceInput.dataset.autoFilled = 'false');

        // Inicializar al cargar
        updateServicePrice();
    });
    </script>
</body>

</html>