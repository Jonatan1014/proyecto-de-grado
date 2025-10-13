<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Historia Clínica | Sistema de Gestión Médica</title>
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

    <style>
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .checkbox-item {
        flex: 0 0 calc(33.333% - 10px);
    }


    .tooth-diagram {
        display: grid;
        grid-template-columns: repeat(16, 1fr);
        gap: 5px;
        margin: 10px 0;
    }

    .tooth-item {
        border: 2px solid #ddd;
        padding: 8px 4px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .tooth-item.selected {
        background-color: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
    }
    </style>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Topbar Start ========== -->
        <?php include 'includes/navbar.php'; ?>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include 'includes/sidebar.php'; ?>
        <!-- ========== Left Sidebar End ========== -->

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
                                        <li class="breadcrumb-item"><a href="pages-get-paciente">Pacientes</a></li>
                                        <li class="breadcrumb-item active">Historia Clínica</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Formulario de Historia Clínica</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Ingresar Información Clínica</h4>
                                    <p class="text-muted font-14">
                                        Ingrese a continuación los datos clínicos del <code>paciente</code> para su
                                        <code>historia clínica</code>
                                    </p>

                                    <!-- Mensajes de éxito o error -->
                                    <?php include 'includes/alertEvent.php'; ?>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="input-types-preview">
                                            <form id="dentalHistoryForm" action="add-historial-clinico" method="POST">
                                                <!-- SECCIÓN 1: DATOS DEL PACIENTE -->
                                                <div class="section-title">1. DATOS DEL PACIENTE</div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="patient_id" class="form-label">Seleccionar
                                                                    Paciente Existente</label>
                                                                <select class="form-control select2" id="patient_id"
                                                                    name="patient_id" required data-toggle="select2" onchange="fillPatientData()" >
                                                                    <option value="">-- Seleccionar --</option>
                                                                    <!-- Aquí irá el código PHP para cargar pacientes -->
                                                                    <?php 
                                                                        // Asegúrate de tener los pacientes disponibles en esta vista
                                                                        // Por ejemplo, pasándolos desde el controlador
                                                                        foreach ($pacientes as $paciente): 
                                                                        ?>
                                                                    <option value="<?php echo $paciente['id']; ?>"
                                                                        data-idnumber="<?php echo htmlspecialchars($paciente['idnumber']); ?>"
                                                                        data-name="<?php echo htmlspecialchars($paciente['name']); ?>"
                                                                        data-lastname="<?php echo htmlspecialchars($paciente['lastname']); ?>"
                                                                        data-birth-date="<?php echo htmlspecialchars($paciente['birth_date']); ?>"
                                                                        data-gender="<?php echo htmlspecialchars($paciente['gender']); ?>"
                                                                        data-phone="<?php echo htmlspecialchars($paciente['phone']); ?>"
                                                                        data-email="<?php echo htmlspecialchars($paciente['email']); ?>"
                                                                        data-address="<?php echo htmlspecialchars($paciente['address']); ?>"
                                                                        data-emergency-name="<?php echo htmlspecialchars($paciente['emergency_contact_name']); ?>"
                                                                        data-emergency-phone="<?php echo htmlspecialchars($paciente['emergency_contact_phone']); ?>">
                                                                        <?php echo htmlspecialchars($paciente['idnumber'] . ' - ' . $paciente['name'] . ' ' . $paciente['lastname']); ?>
                                                                    </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="history_number" class="form-label">Nº
                                                                    Historia Clínica (ID Number)</label>
                                                                <input type="text" class="form-control"
                                                                    name="history_number" id="history_number" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="name" class="form-label">Nombre</label>
                                                                <input type="text" class="form-control" name="name"
                                                                    id="name" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="lastname"
                                                                    class="form-label">Apellido</label>
                                                                <input type="text" class="form-control" name="lastname"
                                                                    id="lastname" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="birth_date" class="form-label">Fecha de
                                                                    Nacimiento</label>
                                                                <input type="date" class="form-control"
                                                                    name="birth_date" id="birth_date" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="age" class="form-label">Edad</label>
                                                                <input type="text" class="form-control" name="age"
                                                                    id="age" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="gender" class="form-label">Género</label>
                                                            <input type="text" class="form-control" name="gender"
                                                                id="gender" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Teléfono</label>
                                                            <input type="text" class="form-control" name="phone"
                                                                id="phone" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="residential_address"
                                                                class="form-label">Dirección Residencial</label>
                                                            <textarea class="form-control" name="residential_address"
                                                                id="residential_address" rows="2" readonly></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="responsible_name" class="form-label">Nombre
                                                                    del Responsable</label>
                                                                <input type="text" class="form-control"
                                                                    name="responsible_name" id="responsible_name">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="responsible_phone"
                                                                    class="form-label">Teléfono del Responsable</label>
                                                                <input type="text" class="form-control"
                                                                    name="responsible_phone" id="responsible_phone">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- SECCIÓN 2: MOTIVO DE CONSULTA -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>2.</strong> MOTIVO DE CONSULTA
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">Motivo de Consulta</label>
                                                        <textarea class="form-control" name="reason_consultation"
                                                            rows="3"
                                                            placeholder="Describa el motivo de la consulta..."></textarea>
                                                    </div>
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">Enfermedad Actual</label>
                                                        <textarea class="form-control" name="current_illness" rows="3"
                                                            placeholder="Describa la enfermedad actual..."></textarea>
                                                    </div>
                                                </div>

                                                <!-- SECCIÓN 3: ANTECEDENTES -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>3.</strong> ANTECEDENTES MÉDICOS Y FAMILIARES
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Antecedentes Médicos</label>
                                                            <textarea class="form-control" name="medical_history"
                                                                rows="3"
                                                                placeholder="Antecedentes médicos..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Antecedentes Familiares</label>
                                                            <textarea class="form-control" name="family_history"
                                                                rows="3"
                                                                placeholder="Antecedentes familiares..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- SECCIÓN 4: EXAMEN CLÍNICO -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>4.</strong> EXAMEN CLÍNICO
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Examen General</label>
                                                            <textarea class="form-control" name="general_exam" rows="3"
                                                                placeholder="Examen general..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Examen Local</label>
                                                            <textarea class="form-control" name="local_exam" rows="3"
                                                                placeholder="Examen local..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- SECCIÓN 5: ODOGRAMA -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>5.</strong> ODOGRAMA
                                                </div>
                                                <br>
                                                <!-- Odontograma -->
                                                <div class="odontogram-container container text-center my-3">
                                                    <div class="bg-body-tertiary p-3 rounded shadow-sm">
                                                        <div
                                                            class="tooth-diagram d-flex flex-wrap justify-content-center gap-2">

                                                            <!-- Fila superior -->
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="18">18</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="17">17</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="16">16</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="15">15</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="14">14</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="13">13</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="12">12</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="11">11</div>

                                                            <!-- Separador central -->
                                                            <div class="w-100 my-2 border-top"></div>

                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="21">21</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="22">22</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="23">23</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="24">24</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="25">25</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="26">26</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="27">27</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="28">28</div>

                                                            <!-- Separador -->
                                                            <div class="w-100 my-3 border-top"></div>

                                                            <!-- Fila inferior -->
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="48">48</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="47">47</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="46">46</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="45">45</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="44">44</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="43">43</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="42">42</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="41">41</div>

                                                            <!-- Separador -->
                                                            <div class="w-100 my-2 border-top"></div>

                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="31">31</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="32">32</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="33">33</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="34">34</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="35">35</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="36">36</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="37">37</div>
                                                            <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold"
                                                                data-tooth="38">38</div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Contenedor dinámico de detalles -->
                                                <div id="toothDetailsContainer" class="mt-3"></div>


                                                <!-- SECCIÓN 6: DIAGNÓSTICO -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>6.</strong> DIAGNÓSTICO
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Diagnóstico Principal</label>
                                                        <textarea class="form-control" name="main_diagnosis" rows="3"
                                                            placeholder="Diagnóstico principal..."></textarea>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Diagnóstico Secundario</label>
                                                        <textarea class="form-control" name="secondary_diagnosis"
                                                            rows="3" placeholder="Diagnóstico secundario..."></textarea>
                                                    </div>
                                                </div>

                                                <!-- SECCIÓN 7: PLAN DE TRATAMIENTO -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>7.</strong> PLAN DE TRATAMIENTO
                                                </div>
                                                <br>
                                                <div id="treatmentPlanContainer">
                                                    <div class="treatment-item border p-3 mb-3 rounded">
                                                        <div class="row">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Descripción del
                                                                    Tratamiento</label>
                                                                <input type="text" class="form-control"
                                                                    name="treatment_description[]"
                                                                    placeholder="Ej: Extracción dental">
                                                            </div>
                                                            <div class="col-md-2 mb-3">
                                                                <label class="form-label">Diente(s)</label>
                                                                <input type="text" class="form-control"
                                                                    name="tooth_involved[]" placeholder="Ej: 18, 28">
                                                            </div>
                                                            <div class="col-md-2 mb-3">
                                                                <label class="form-label">Costo Estimado</label>
                                                                <input type="number" class="form-control"
                                                                    name="estimated_cost[]" placeholder="Ej: 100.00">
                                                            </div>
                                                            <div class="col-md-2 mb-3">
                                                                <label class="form-label">Fecha Estimada</label>
                                                                <input type="date" class="form-control"
                                                                    name="estimated_date[]">
                                                            </div>
                                                            <div class="col-md-2 mb-3">
                                                                <label class="form-label">&nbsp;</label>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm w-100"
                                                                    onclick="this.parentElement.parentElement.parentElement.remove()">Eliminar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-primary mb-3"
                                                    id="addTreatmentBtn">Agregar Tratamiento</button>

                                                <!-- SECCIÓN 8: OBSERVACIONES FINALES -->
                                                <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                                    <strong>8.</strong> OBSERVACIONES FINALES
                                                </div>
                                                <br>
                                                <div class="mb-3">
                                                    <textarea class="form-control" name="final_observations" rows="4"
                                                        placeholder="Observaciones finales..."></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="uil-save"></i> Guardar Historia Clínica</button>
                                                    <button type="button" class="btn btn-success"
                                                        id="saveAndPrintBtn"><i class="uil-print"></i> Guardar y Generar
                                                        PDF</button>
                                                </div>
                                            </form>
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
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <?php include 'includes/theme.php'; ?>

    <!-- Vendor js -->
    <script src="assets/admin/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/admin/assets/js/app.js"></script>

    <script>
    // Datos de dientes seleccionados
    const selectedTeeth = new Set();

    // Manejar selección de dientes
    document.querySelectorAll('.tooth-item').forEach(item => {
        item.addEventListener('click', function() {
            const toothNumber = this.getAttribute('data-tooth');

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedTeeth.delete(toothNumber);
                removeToothDetail(toothNumber);
            } else {
                this.classList.add('selected');
                selectedTeeth.add(toothNumber);
                addToothDetail(toothNumber);
            }
        });
    });

    // Agregar detalle de diente
    function addToothDetail(toothNumber) {
        const container = document.getElementById('toothDetailsContainer');
        const detailDiv = document.createElement('div');
        detailDiv.className = 'row border-top pt-3 mt-3 tooth-detail';
        detailDiv.id = `tooth-detail-${toothNumber}`;
        detailDiv.innerHTML = `
                <div class="col-md-12 mb-2">
                    <h6>Diente ${toothNumber}</h6>
                </div>
                <input type="hidden" name="tooth_number[]" value="${toothNumber}">
                <div class="col-md-3 mb-2">
                    <label class="form-label">Estado</label>
                    <select class="form-control form-control-sm" name="tooth_status_${toothNumber}">
                        <option value="">Seleccionar</option>
                        <option value="Sano">Sano</option>
                        <option value="Caries">Caries</option>
                        <option value="Obturado">Obturado</option>
                        <option value="Corona">Corona</option>
                        <option value="Ausente">Ausente</option>
                        <option value="Fracturado">Fracturado</option>
                        <option value="Endodoncia">Endodoncia</option>
                        <option value="Implante">Implante</option>
                        <option value="Extracción Indicada">Extracción Indicada</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2">
                    <label class="form-label">Código de Condición</label>
                    <input type="text" class="form-control form-control-sm" name="condition_code_${toothNumber}" placeholder="Código">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Observaciones</label>
                    <input type="text" class="form-control form-control-sm" name="tooth_observations_${toothNumber}" placeholder="Observaciones del diente">
                </div>
            `;
        container.appendChild(detailDiv);
    }

    // Remover detalle de diente
    function removeToothDetail(toothNumber) {
        const detailDiv = document.getElementById(`tooth-detail-${toothNumber}`);
        if (detailDiv) {
            detailDiv.remove();
        }
    }



    // Agregar más tratamientos al plan
    document.getElementById('addTreatmentBtn').addEventListener('click', function() {
        const container = document.getElementById('treatmentPlanContainer');
        const newTreatment = document.createElement('div');
        newTreatment.className = 'treatment-item border p-3 mb-3 rounded';
        newTreatment.innerHTML = `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Descripción del Tratamiento</label>
                        <input type="text" class="form-control" name="treatment_description[]" placeholder="Ej: Extracción dental">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Diente(s)</label>
                        <input type="text" class="form-control" name="tooth_involved[]" placeholder="Ej: 18, 28">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Costo Estimado</label>
                        <input type="number" class="form-control" name="estimated_cost[]" placeholder="Ej: 100.00">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Fecha Estimada</label>
                        <input type="date" class="form-control" name="estimated_date[]">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="this.parentElement.parentElement.parentElement.remove()">Eliminar</button>
                    </div>
                </div>
            `;
        container.appendChild(newTreatment);
    });

    // Validación de formulario antes de enviar
    document.getElementById('dentalHistoryForm').addEventListener('submit', function(e) {
        const patientId = document.getElementById('patient_id').value;
        if (!patientId) {
            e.preventDefault();
            alert('Por favor seleccione un paciente');
            return false;
        }
    });

    // Funcionalidad para guardar y generar PDF
    document.getElementById('saveAndPrintBtn').addEventListener('click', function() {
        const form = document.getElementById('dentalHistoryForm');
        const formData = new FormData(form);
        formData.append('generate_pdf', '1');

        // Validar formulario
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Enviar datos
        fetch('add-historial-clinico', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Historia clínica guardada exitosamente');
                    // Abrir PDF en nueva ventana
                    window.open(data.pdf_url, '_blank');
                } else {
                    alert('Error al guardar: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
    });


    // Función para autocompletar datos del paciente
    function fillPatientData() {
        const select = document.getElementById('patient_id');
        const selectedOption = select.options[select.selectedIndex];

        if (selectedOption.value) {
            // Autocompletar campos con datos del paciente
            document.getElementById('history_number').value = selectedOption.getAttribute('data-idnumber');
            document.getElementById('name').value = selectedOption.getAttribute('data-name');
            document.getElementById('lastname').value = selectedOption.getAttribute('data-lastname');
            document.getElementById('birth_date').value = selectedOption.getAttribute('data-birth-date');
            document.getElementById('gender').value = selectedOption.getAttribute('data-gender');
            document.getElementById('phone').value = selectedOption.getAttribute('data-phone');
            document.getElementById('residential_address').value = selectedOption.getAttribute('data-address');
            document.getElementById('responsible_name').value = selectedOption.getAttribute('data-emergency-name');
            document.getElementById('responsible_phone').value = selectedOption.getAttribute('data-emergency-phone');

            // Calcular edad (opcional)
            const birthDate = new Date(selectedOption.getAttribute('data-birth-date'));
            if (birthDate) {
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.getElementById('age').value = age;
            }
        } else {
            // Limpiar campos si no hay paciente seleccionado
            document.getElementById('history_number').value = '';
            document.getElementById('name').value = '';
            document.getElementById('lastname').value = '';
            document.getElementById('birth_date').value = '';
            document.getElementById('age').value = '';
            document.getElementById('gender').value = '';
            document.getElementById('phone').value = '';
            document.getElementById('residential_address').value = '';
            document.getElementById('responsible_name').value = '';
            document.getElementById('responsible_phone').value = '';
        }
    }

    // Agregar evento onChange al select de paciente
    document.getElementById('patient_id').addEventListener('change', fillPatientData);
    </script>
</body>

</html>