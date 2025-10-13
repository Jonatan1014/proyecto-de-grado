<?php 

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/HistorialClinico.php'; 
require_once __DIR__ . '/../Models/Paciente.php'; 
require_once __DIR__ . '/../Models/Doctor.php'; 

class HistorialClinicoController {

    public function pagesAddHistorial() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        
        $pacientes = Paciente::getAllPaciente();
        include __DIR__ . '/../Views/admin/pages-add-historial-clinico.php';
    }

    public function readHistorial() {
        AuthService::requireLogin();
        
        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        
        $historiales = HistorialClinico::read();
        include __DIR__ . '/../Views/admin/pages-get-historial-clinico.php';
    }

    public function editHistorial() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $historialId = $_GET['id'] ?? null;

        if (!$historialId) {
            $_SESSION['error'] = 'ID de historial clínico no válido.';
            header("Location: pages-get-historial-clinico");
            exit;
        }

        $historial = HistorialClinico::findById($historialId);
        
        if (!$historial) {
            $_SESSION['error'] = 'Historial clínico no encontrado.';
            header("Location: pages-get-historial-clinico");
            exit;
        }

        $pacientes = Paciente::getAllPaciente();
        $doctores = Doctor::getAll();

        include __DIR__ . '/../Views/admin/pages-upd-historial-clinico.php';
    }

    public function addHistorial() {
        AuthService::requireLogin();
        
        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // VALIDAR PACIENTE
            if (empty($_POST['patient_id'])) {
                $_SESSION['error'] = 'Debe seleccionar un paciente.';
                header("Location: pages-add-historial-clinico");
                exit;
            }

            // 1. PROCESAR ODONTOGRAMA
            $odontogram = [];
            if (isset($_POST['tooth_number']) && is_array($_POST['tooth_number'])) {
                foreach ($_POST['tooth_number'] as $tooth) {
                    $toothData = [
                        'tooth_number' => $tooth,
                        'status' => $_POST["tooth_status_{$tooth}"] ?? '',
                        'condition_code' => $_POST["condition_code_{$tooth}"] ?? '',
                        'observations' => $_POST["tooth_observations_{$tooth}"] ?? ''
                    ];
                    
                    // Solo agregar si tiene algún dato
                    if (!empty($toothData['status']) || !empty($toothData['condition_code']) || !empty($toothData['observations'])) {
                        $odontogram[] = $toothData;
                    }
                }
            }

            // 2. PROCESAR PLAN DE TRATAMIENTO
            $treatment_plan = [];
            if (isset($_POST['treatment_description']) && is_array($_POST['treatment_description'])) {
                $count = count($_POST['treatment_description']);
                
                for ($i = 0; $i < $count; $i++) {
                    $description = $_POST['treatment_description'][$i] ?? '';
                    
                    // Solo agregar si tiene descripción
                    if (!empty($description)) {
                        $treatment_plan[] = [
                            'description' => $description,
                            'tooth' => $_POST['tooth_involved'][$i] ?? '',
                            'cost' => floatval($_POST['estimated_cost'][$i] ?? 0),
                            'date' => $_POST['estimated_date'][$i] ?? ''
                        ];
                    }
                }
            }

            // 3. PREPARAR DATOS PARA INSERTAR
            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_SESSION['user_id'] ?? 1, // ID del usuario logueado o doctor por defecto
                'appointment_id' => null, // Puedes vincularlo con una cita si es necesario
                'history_number' => $_POST['history_number'] ?? null,
                'registration_date' => date('Y-m-d'),
                'reason_consultation' => trim($_POST['reason_consultation'] ?? ''),
                'current_illness' => trim($_POST['current_illness'] ?? ''),
                'medical_history' => trim($_POST['medical_history'] ?? ''),
                'family_history' => trim($_POST['family_history'] ?? ''),
                'general_exam' => trim($_POST['general_exam'] ?? ''),
                'local_exam' => trim($_POST['local_exam'] ?? ''),
                'odontogram' => $odontogram,
                'main_diagnosis' => trim($_POST['main_diagnosis'] ?? ''),
                'secondary_diagnosis' => trim($_POST['secondary_diagnosis'] ?? ''),
                'treatment_plan' => $treatment_plan,
                'final_observations' => trim($_POST['final_observations'] ?? '')
            ];

            // Depuración: Ver datos procesados (QUITAR EN PRODUCCIÓN)
            error_log("=== DATOS PROCESADOS ===");
            error_log("Patient ID: " . $data['patient_id']);
            error_log("Odontogram: " . json_encode($odontogram));
            error_log("Treatment Plan: " . json_encode($treatment_plan));

            // 4. INSERTAR EN BASE DE DATOS
            $id = HistorialClinico::create($data);
            
            if ($id) {
                $_SESSION['exito'] = 'Historia clínica registrada correctamente con ID: ' . $id;
                
                // Si se solicitó generar PDF
                if (isset($_POST['generate_pdf']) && $_POST['generate_pdf'] == '1') {
                    // Aquí implementarías la generación del PDF
                    // Por ahora solo redirigimos
                    $_SESSION['info'] = 'Funcionalidad de PDF en desarrollo.';
                }
                
                header("Location: pages-get-historial-clinico");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo registrar la historia clínica. Revise los logs para más detalles.';
                header("Location: pages-add-historial-clinico");
                exit;
            }
        }
        
        // Si no es POST, redirigir
        header("Location: pages-add-historial-clinico");
        exit;
    }

    public function updateHistorial() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID de historial clínico no válido.';
                header("Location: pages-get-historial-clinico");
                exit;
            }

            // 1. PROCESAR ODONTOGRAMA
            $odontogram = [];
            if (isset($_POST['tooth_number']) && is_array($_POST['tooth_number'])) {
                foreach ($_POST['tooth_number'] as $tooth) {
                    $toothData = [
                        'tooth_number' => $tooth,
                        'status' => $_POST["tooth_status_{$tooth}"] ?? '',
                        'condition_code' => $_POST["condition_code_{$tooth}"] ?? '',
                        'observations' => $_POST["tooth_observations_{$tooth}"] ?? ''
                    ];
                    
                    // Solo agregar si tiene algún dato
                    if (!empty($toothData['status']) || !empty($toothData['condition_code']) || !empty($toothData['observations'])) {
                        $odontogram[] = $toothData;
                    }
                }
            }

            // 2. PROCESAR PLAN DE TRATAMIENTO
            $treatment_plan = [];
            if (isset($_POST['treatment_description']) && is_array($_POST['treatment_description'])) {
                $count = count($_POST['treatment_description']);
                
                for ($i = 0; $i < $count; $i++) {
                    $description = $_POST['treatment_description'][$i] ?? '';
                    
                    // Solo agregar si tiene descripción
                    if (!empty($description)) {
                        $treatment_plan[] = [
                            'description' => $description,
                            'tooth' => $_POST['tooth_involved'][$i] ?? '',
                            'cost' => floatval($_POST['estimated_cost'][$i] ?? 0),
                            'date' => $_POST['estimated_date'][$i] ?? ''
                        ];
                    }
                }
            }

            // 3. PREPARAR DATOS PARA ACTUALIZAR
            $data = [
                'patient_id' => $_POST['patient_id'],
                'doctor_id' => $_POST['doctor_id'] ?? $_SESSION['user_id'],
                'appointment_id' => $_POST['appointment_id'] ?? null,
                'history_number' => $_POST['history_number'] ?? null,
                'registration_date' => $_POST['registration_date'] ?? date('Y-m-d'),
                'reason_consultation' => trim($_POST['reason_consultation'] ?? ''),
                'current_illness' => trim($_POST['current_illness'] ?? ''),
                'medical_history' => trim($_POST['medical_history'] ?? ''),
                'family_history' => trim($_POST['family_history'] ?? ''),
                'general_exam' => trim($_POST['general_exam'] ?? ''),
                'local_exam' => trim($_POST['local_exam'] ?? ''),
                'odontogram' => $odontogram,
                'main_diagnosis' => trim($_POST['main_diagnosis'] ?? ''),
                'secondary_diagnosis' => trim($_POST['secondary_diagnosis'] ?? ''),
                'treatment_plan' => $treatment_plan,
                'final_observations' => trim($_POST['final_observations'] ?? '')
            ];

            // 4. ACTUALIZAR EN BASE DE DATOS
            $success = HistorialClinico::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Historia clínica actualizada correctamente.';
                header("Location: pages-get-historial-clinico");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar la historia clínica. Es posible que no haya cambios.';
                header("Location: pages-upd-historial-clinico?id=" . $id);
                exit;
            }
        }
        
        // Si no es POST, redirigir
        header("Location: pages-get-historial-clinico");
        exit;
    }

    public function deleteHistorial() {
        AuthService::requireLogin();
        
        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
        
            if (!$id) {
                $_SESSION['error'] = 'ID de historial clínico no válido.';
                header("Location: pages-get-historial-clinico");
                exit;
            }
        
            $success = HistorialClinico::delete($id);
        
            if ($success) {
                $_SESSION['exito'] = 'Historia clínica eliminada correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar la historia clínica.';
            }
        
            header("Location: pages-get-historial-clinico");
            exit;
        }
        
        // Si no es POST, redirigir
        header("Location: pages-get-historial-clinico");
        exit;
    }


    public function downloadPdf() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'ID de historial clínico no válido.';
            header("Location: pages-get-historial-clinico");
            exit;
        }

        $historial = HistorialClinico::findById($id);

        if (!$historial) {
            $_SESSION['error'] = 'Historial clínico no encontrado.';
            header("Location: pages-get-historial-clinico");
            exit;
        }

        // Cargar paciente y doctor para el PDF
        $paciente = Paciente::findById($historial->patient_id);
        $doctor = Doctor::findById($historial->doctor_id);

        // Generar PDF
        $this->generatePdf($historial, $paciente, $doctor);
    }

    private function generatePdf($historial, $paciente, $doctor) {
        // Cargar TCPDF
        $autoloadPath = __DIR__ . '/../../../vendor/autoload.php';
        
        if (!file_exists($autoloadPath)) {
            die('ERROR: No se encontró la librería TCPDF.<br>Ruta esperada: ' . $autoloadPath . '<br>Por favor ejecuta: composer require tecnickcom/tcpdf');
        }
        
        require_once $autoloadPath;

        // Crear PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Configuración del documento
        $pdf->SetCreator('SonriArte');
        $pdf->SetAuthor('Sistema Médico');
        $pdf->SetTitle('Historia Clínica - ' . $paciente->name . ' ' . $paciente->lastname);
        $pdf->SetSubject('Historia Clínica Odontológica');

        // Quitar encabezado y pie de página predeterminados (método correcto)
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Márgenes
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);

        // Fuente
        $pdf->SetFont('helvetica', '', 10);

        // Agregar página
        $pdf->AddPage();

        // Contenido HTML
        $html = $this->buildPdfContent($historial, $paciente, $doctor);

        // Escribir HTML
        $pdf->writeHTML($html, true, false, true, false, '');

        // Nombre del archivo
        $fileName = 'historia_clinica_' . $paciente->idnumber . '_' . date('Ymd') . '.pdf';

        // Salida del PDF (descargar)
        $pdf->Output($fileName, 'D');
        exit;
    }

    private function buildPdfContent($historial, $paciente, $doctor) {
        // Preparar datos
        $nombreCompleto = htmlspecialchars($paciente->name . ' ' . $paciente->lastname);
        $documento = htmlspecialchars($paciente->idnumber ?? 'N/A');
        $fechaNac = $paciente->birth_date ? date('d/m/Y', strtotime($paciente->birth_date)) : 'N/A';
        $edad = $paciente->birth_date ? (date('Y') - date('Y', strtotime($paciente->birth_date))) : 'N/A';
        $genero = $paciente->gender ?? 'N/A';
        $telefono = htmlspecialchars($paciente->phone ?? 'N/A');
        $direccion = htmlspecialchars($paciente->address ?? 'N/A');
        $emergenciaNombre = htmlspecialchars($paciente->emergency_contact_name ?? 'N/A');
        $emergenciaTel = htmlspecialchars($paciente->emergency_contact_phone ?? 'N/A');
        
        $motivoConsulta = htmlspecialchars($historial->reason_consultation ?? 'N/A');
        $enfermedadActual = htmlspecialchars($historial->current_illness ?? 'N/A');
        $antecedentesMedicos = htmlspecialchars($historial->medical_history ?? 'N/A');
        $antecedentesFamiliares = htmlspecialchars($historial->family_history ?? 'N/A');
        $examenGeneral = htmlspecialchars($historial->general_exam ?? 'N/A');
        $examenLocal = htmlspecialchars($historial->local_exam ?? 'N/A');
        $diagnosticoPrincipal = htmlspecialchars($historial->main_diagnosis ?? 'N/A');
        $diagnosticoSecundario = htmlspecialchars($historial->secondary_diagnosis ?? 'N/A');
        $observaciones = htmlspecialchars($historial->final_observations ?? 'N/A');

        $nombreDoctor = htmlspecialchars($doctor->name ?? 'N/A');
        $especialidad = htmlspecialchars($doctor->specialization ?? 'N/A');

        // Odontograma
        $odontogramaHtml = '<h4>Odontograma</h4>';
        if (!empty($historial->odontogram) && is_array($historial->odontogram)) {
            $odontogramaHtml .= '<table border="1" cellpadding="3" style="width:100%; font-size:8pt;">';
            $odontogramaHtml .= '<tr><th>Diente</th><th>Estado</th><th>Código</th><th>Observaciones</th></tr>';
            foreach ($historial->odontogram as $diente) {
                $odontogramaHtml .= '<tr>';
                $odontogramaHtml .= '<td>' . htmlspecialchars($diente['tooth_number'] ?? 'N/A') . '</td>';
                $odontogramaHtml .= '<td>' . htmlspecialchars($diente['status'] ?? 'N/A') . '</td>';
                $odontogramaHtml .= '<td>' . htmlspecialchars($diente['condition_code'] ?? 'N/A') . '</td>';
                $odontogramaHtml .= '<td>' . htmlspecialchars($diente['observations'] ?? 'N/A') . '</td>';
                $odontogramaHtml .= '</tr>';
            }
            $odontogramaHtml .= '</table>';
        } else {
            $odontogramaHtml .= '<p>Sin datos del odontograma</p>';
        }

        // Plan de tratamiento
        $tratamientoHtml = '<h4>Plan de Tratamiento</h4>';
        if (!empty($historial->treatment_plan) && is_array($historial->treatment_plan)) {
            $tratamientoHtml .= '<table border="1" cellpadding="3" style="width:100%; font-size:8pt;">';
            $tratamientoHtml .= '<tr><th>Descripción</th><th>Diente</th><th>Costo</th><th>Fecha</th></tr>';
            foreach ($historial->treatment_plan as $tratamiento) {
                $tratamientoHtml .= '<tr>';
                $tratamientoHtml .= '<td>' . htmlspecialchars($tratamiento['description'] ?? 'N/A') . '</td>';
                $tratamientoHtml .= '<td>' . htmlspecialchars($tratamiento['tooth'] ?? 'N/A') . '</td>';
                $tratamientoHtml .= '<td>$' . number_format($tratamiento['cost'] ?? 0, 2) . '</td>';
                $tratamientoHtml .= '<td>' . htmlspecialchars($tratamiento['date'] ?? 'N/A') . '</td>';
                $tratamientoHtml .= '</tr>';
            }
            $tratamientoHtml .= '</table>';
        } else {
            $tratamientoHtml .= '<p>Sin plan de tratamiento</p>';
        }

        // HTML completo
        $html = <<<HTML
<style>
    h2 { color: #2c3e50; text-align: center; margin-bottom: 10px; }
    h3 { color: #34495e; margin-top: 15px; margin-bottom: 5px; background-color: #ecf0f1; padding: 5px; }
    h4 { color: #34495e; margin-top: 10px; margin-bottom: 5px; }
    table { border-collapse: collapse; margin-top: 5px; margin-bottom: 10px; }
    th { background-color: #3498db; color: white; text-align: left; }
    td, th { padding: 5px; }
    .info-row { margin-bottom: 5px; }
    .label { font-weight: bold; color: #2c3e50; }
</style>

<h2>HISTORIA CLÍNICA ODONTOLÓGICA</h2>
<p style="text-align:center; font-size:9pt; color:#7f8c8d;">SonriArte - Fecha: {$this->formatDate(date('Y-m-d'))}</p>

<hr>

<h3>1. DATOS DEL PACIENTE</h3>
<div class="info-row"><span class="label">Nombre Completo:</span> {$nombreCompleto}</div>
<div class="info-row"><span class="label">Documento:</span> {$documento}</div>
<div class="info-row"><span class="label">Fecha Nacimiento:</span> {$fechaNac} <span class="label">Edad:</span> {$edad} años</div>
<div class="info-row"><span class="label">Género:</span> {$genero}</div>
<div class="info-row"><span class="label">Teléfono:</span> {$telefono}</div>
<div class="info-row"><span class="label">Dirección:</span> {$direccion}</div>
<div class="info-row"><span class="label">Contacto Emergencia:</span> {$emergenciaNombre} - {$emergenciaTel}</div>

<h3>2. MOTIVO DE CONSULTA</h3>
<p>{$motivoConsulta}</p>

<h3>3. ENFERMEDAD ACTUAL</h3>
<p>{$enfermedadActual}</p>

<h3>4. ANTECEDENTES</h3>
<h4>Antecedentes Médicos:</h4>
<p>{$antecedentesMedicos}</p>
<h4>Antecedentes Familiares:</h4>
<p>{$antecedentesFamiliares}</p>

<h3>5. EXAMEN CLÍNICO</h3>
<h4>Examen General:</h4>
<p>{$examenGeneral}</p>
<h4>Examen Local:</h4>
<p>{$examenLocal}</p>

<h3>6. ODONTOGRAMA</h3>
{$odontogramaHtml}

<h3>7. DIAGNÓSTICO</h3>
<h4>Diagnóstico Principal:</h4>
<p>{$diagnosticoPrincipal}</p>
<h4>Diagnóstico Secundario:</h4>
<p>{$diagnosticoSecundario}</p>

<h3>8. PLAN DE TRATAMIENTO</h3>
{$tratamientoHtml}

<h3>9. OBSERVACIONES FINALES</h3>
<p>{$observaciones}</p>

<br><br>
<hr>
<p style="text-align:right;">
    <strong>Doctor:</strong> {$nombreDoctor}<br>
    <strong>Especialidad:</strong> {$especialidad}<br>
    <strong>Fecha:</strong> {$this->formatDate(date('Y-m-d'))}
</p>
HTML;

        return $html;
    }

    private function formatDate($date) {
        if (empty($date)) return 'N/A';
        return date('d/m/Y', strtotime($date));
    }
}
    



