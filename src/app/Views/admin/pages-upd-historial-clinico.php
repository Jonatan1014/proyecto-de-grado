<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Editar Historia Clínica | Sistema de Gestión Médica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">
    <script src="assets/admin/assets/js/hyper-config.js"></script>
    <link href="assets/admin/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/admin/assets/css/unicons/css/unicons.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />

    <style>
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
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                                        <li class="breadcrumb-item"><a href="pages-get-historial-clinico">Historiales</a></li>
                                        <li class="breadcrumb-item active">Editar Historia Clínica</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Editar Historia Clínica</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Actualizar Información Clínica</h4>
                                    <?php include 'includes/alertEvent.php'; ?>

                                    <form id="dentalHistoryForm" action="update-historial-clinico" method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($historial->id); ?>">
                                        <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($historial->doctor_id); ?>">

                                        <!-- SECCIÓN 1: DATOS DEL PACIENTE -->
                                        <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                            <strong>1.</strong> DATOS DEL PACIENTE
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="patient_id" class="form-label">Paciente</label>
                                                        <select class="form-control" id="patient_id" name="patient_id" required disabled>
                                                            <option value="<?php echo $historial->patient_id; ?>" selected>
                                                                <?php echo htmlspecialchars($historial->patient_name . ' ' . $historial->patient_lastname); ?>
                                                            </option>
                                                        </select>
                                                        <input type="hidden" name="patient_id" value="<?php echo $historial->patient_id; ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="history_number" class="form-label">Nº Historia Clínica</label>
                                                        <input type="text" class="form-control" name="history_number" id="history_number" 
                                                               value="<?php echo htmlspecialchars($historial->history_number ?? $historial->patient_idnumber); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Nombre</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($historial->patient_name); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Apellido</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($historial->patient_lastname); ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Fecha de Nacimiento</label>
                                                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($historial->patient_birth_date ?? ''); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Género</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($historial->patient_gender ?? ''); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Teléfono</label>
                                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($historial->patient_phone ?? ''); ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Dirección Residencial</label>
                                                    <textarea class="form-control" rows="2" readonly><?php echo htmlspecialchars($historial->patient_address ?? ''); ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Contacto de Emergencia</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($historial->patient_emergency_name ?? ''); ?>" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Teléfono de Emergencia</label>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($historial->patient_emergency_phone ?? ''); ?>" readonly>
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
                                                <textarea class="form-control" name="reason_consultation" rows="3"><?php echo htmlspecialchars($historial->reason_consultation ?? ''); ?></textarea>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="form-label">Enfermedad Actual</label>
                                                <textarea class="form-control" name="current_illness" rows="3"><?php echo htmlspecialchars($historial->current_illness ?? ''); ?></textarea>
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
                                                    <textarea class="form-control" name="medical_history" rows="3"><?php echo htmlspecialchars($historial->medical_history ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Antecedentes Familiares</label>
                                                    <textarea class="form-control" name="family_history" rows="3"><?php echo htmlspecialchars($historial->family_history ?? ''); ?></textarea>
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
                                                    <textarea class="form-control" name="general_exam" rows="3"><?php echo htmlspecialchars($historial->general_exam ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Examen Local</label>
                                                    <textarea class="form-control" name="local_exam" rows="3"><?php echo htmlspecialchars($historial->local_exam ?? ''); ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SECCIÓN 5: ODONTOGRAMA -->
                                        <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                            <strong>5.</strong> ODONTOGRAMA
                                        </div>
                                        <br>
                                        <div class="odontogram-container container text-center my-3">
                                            <div class="bg-body-tertiary p-3 rounded shadow-sm">
                                                <div class="tooth-diagram d-flex flex-wrap justify-content-center gap-2">
                                                    <!-- Fila superior -->
                                                    <?php 
                                                    $upperTeeth = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
                                                    foreach($upperTeeth as $tooth): 
                                                    ?>
                                                    <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold" data-tooth="<?php echo $tooth; ?>">
                                                        <?php echo $tooth; ?>
                                                    </div>
                                                    <?php if($tooth == 11): ?>
                                                    <div class="w-100 my-2 border-top"></div>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>

                                                    <div class="w-100 my-3 border-top"></div>

                                                    <!-- Fila inferior -->
                                                    <?php 
                                                    $lowerTeeth = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
                                                    foreach($lowerTeeth as $tooth): 
                                                    ?>
                                                    <div class="tooth-item btn btn-outline-secondary rounded-3 fw-semibold" data-tooth="<?php echo $tooth; ?>">
                                                        <?php echo $tooth; ?>
                                                    </div>
                                                    <?php if($tooth == 41): ?>
                                                    <div class="w-100 my-2 border-top"></div>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="toothDetailsContainer" class="mt-3"></div>

                                        <!-- SECCIÓN 6: DIAGNÓSTICO -->
                                        <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                            <strong>6.</strong> DIAGNÓSTICO
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Diagnóstico Principal</label>
                                                <textarea class="form-control" name="main_diagnosis" rows="3"><?php echo htmlspecialchars($historial->main_diagnosis ?? ''); ?></textarea>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Diagnóstico Secundario</label>
                                                <textarea class="form-control" name="secondary_diagnosis" rows="3"><?php echo htmlspecialchars($historial->secondary_diagnosis ?? ''); ?></textarea>
                                            </div>
                                        </div>

                                        <!-- SECCIÓN 7: PLAN DE TRATAMIENTO -->
                                        <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                            <strong>7.</strong> PLAN DE TRATAMIENTO
                                        </div>
                                        <br>
                                        <div id="treatmentPlanContainer">
                                            <?php 
                                            $treatments = $historial->treatment_plan ?? [];
                                            if (empty($treatments)): 
                                            ?>
                                            <div class="treatment-item border p-3 mb-3 rounded">
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
                                                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeTreatment(this)">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <?php foreach($treatments as $treatment): ?>
                                            <div class="treatment-item border p-3 mb-3 rounded">
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Descripción del Tratamiento</label>
                                                        <input type="text" class="form-control" name="treatment_description[]" value="<?php echo htmlspecialchars($treatment['description'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Diente(s)</label>
                                                        <input type="text" class="form-control" name="tooth_involved[]" value="<?php echo htmlspecialchars($treatment['tooth'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Costo Estimado</label>
                                                        <input type="number" class="form-control" name="estimated_cost[]" value="<?php echo htmlspecialchars($treatment['cost'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">Fecha Estimada</label>
                                                        <input type="date" class="form-control" name="estimated_date[]" value="<?php echo htmlspecialchars($treatment['date'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeTreatment(this)">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="btn btn-primary mb-3" id="addTreatmentBtn">Agregar Tratamiento</button>

                                        <!-- SECCIÓN 8: OBSERVACIONES FINALES -->
                                        <div class="bg-primary p-2 text-dark bg-opacity-10 text-center">
                                            <strong>8.</strong> OBSERVACIONES FINALES
                                        </div>
                                        <br>
                                        <div class="mb-3">
                                            <textarea class="form-control" name="final_observations" rows="4"><?php echo htmlspecialchars($historial->final_observations ?? ''); ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success"><i class="uil-save"></i> Actualizar Historia Clínica</button>
                                            <a href="pages-get-historial-clinico" class="btn btn-secondary"><i class="uil-arrow-left"></i> Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'includes/footer.php'; ?>
        </div>
    </div>

    <?php include 'includes/theme.php'; ?>

    <script src="assets/admin/assets/js/vendor.min.js"></script>
    <script src="assets/admin/assets/js/app.js"></script>

    <script>
    // Datos existentes del odontograma
    const existingOdontogram = <?php echo json_encode($historial->odontogram ?? []); ?>;
    const selectedTeeth = new Set();

    // Cargar dientes seleccionados existentes
    document.addEventListener('DOMContentLoaded', function() {
        if (existingOdontogram && Array.isArray(existingOdontogram)) {
            existingOdontogram.forEach(tooth => {
                const toothNumber = tooth.tooth_number;
                selectedTeeth.add(toothNumber);
                
                const toothElement = document.querySelector(`[data-tooth="${toothNumber}"]`);
                if (toothElement) {
                    toothElement.classList.add('selected');
                }
                
                addToothDetail(toothNumber, tooth);
            });
        }
    });

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
    function addToothDetail(toothNumber, existingData = {}) {
        const container = document.getElementById('toothDetailsContainer');
        
        // Verificar si ya existe
        if (document.getElementById(`tooth-detail-${toothNumber}`)) {
            return;
        }
        
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
                    <option value="Sano" ${existingData.status === 'Sano' ? 'selected' : ''}>Sano</option>
                    <option value="Caries" ${existingData.status === 'Caries' ? 'selected' : ''}>Caries</option>
                    <option value="Obturado" ${existingData.status === 'Obturado' ? 'selected' : ''}>Obturado</option>
                    <option value="Corona" ${existingData.status === 'Corona' ? 'selected' : ''}>Corona</option>
                    <option value="Ausente" ${existingData.status === 'Ausente' ? 'selected' : ''}>Ausente</option>
                    <option value="Fracturado" ${existingData.status === 'Fracturado' ? 'selected' : ''}>Fracturado</option>
                    <option value="Endodoncia" ${existingData.status === 'Endodoncia' ? 'selected' : ''}>Endodoncia</option>
                    <option value="Implante" ${existingData.status === 'Implante' ? 'selected' : ''}>Implante</option>
                    <option value="Extracción Indicada" ${existingData.status === 'Extracción Indicada' ? 'selected' : ''}>Extracción Indicada</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label class="form-label">Código de Condición</label>
                <input type="text" class="form-control form-control-sm" name="condition_code_${toothNumber}" 
                       value="${existingData.condition_code || ''}" placeholder="Código">
            </div>
            <div class="col-md-6 mb-2">
                <label class="form-label">Observaciones</label>
                <input type="text" class="form-control form-control-sm" name="tooth_observations_${toothNumber}" 
                       value="${existingData.observations || ''}" placeholder="Observaciones del diente">
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

    // Agregar más tratamientos
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
                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeTreatment(this)">Eliminar</button>
                </div>
            </div>
        `;
        container.appendChild(newTreatment);
    });

    // Función para eliminar tratamiento
    function removeTreatment(button) {
        button.closest('.treatment-item').remove();
    }

    // Validación antes de enviar
    document.getElementById('dentalHistoryForm').addEventListener('submit', function(e) {
        const patientId = document.querySelector('input[name="patient_id"]').value;
        if (!patientId) {
            e.preventDefault();
            alert('Error: No se encontró el ID del paciente');
            return false;
        }
    });
    </script>
</body>

</html>