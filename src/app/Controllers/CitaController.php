<?php 

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Cita.php'; 


class CitaController {



    public function addCita() {
    AuthService::requireLogin();

    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'patient_id' => $_POST['patient_id'] ?? null,
            'doctor_id' => $_POST['doctor_id'] ?? null,
            'service_id' => $_POST['service_id'] ?? null,
            'appointment_date' => $_POST['appointment_date'] ?? null,
            'status' => 'scheduled',
            'notes' => $_POST['notes'] ?? null
        ];

        // Validar que todos los campos requeridos estén presentes
        if (!$data['patient_id'] || !$data['doctor_id'] || !$data['service_id'] || !$data['appointment_date']) {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header("Location: pages-add-cita");
            exit;
        }

        $id = Cita::create($data);

        if ($id) {
            $_SESSION['exito'] = 'Cita registrada correctamente.';
            header("Location: pages-add-cita");
            exit;
        } else {
            $_SESSION['error'] = 'No se pudo registrar la cita. Intente nuevamente.';
            header("Location: pages-add-cita");
            exit;
        }
    }
}

public function pagesAddCita() {
    AuthService::requireLogin();

    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }

    include __DIR__ . '/../Views/admin/pages-add-cita.php';
}



}



