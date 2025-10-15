<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Cita.php';
require_once __DIR__ . '/../Models/Paciente.php';
require_once __DIR__ . '/../Models/Doctor.php';
require_once __DIR__ . '/../Models/Service.php';

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
                'status' => $_POST['status'] ?? 'scheduled',
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

        $pacientes = Paciente::getAll();
        $servicios = Service::getAll();
        $doctores = Doctor::getAll();

        include __DIR__ . '/../Views/admin/pages-add-cita.php';
    }


    public function readCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $appointments = Cita::read();

        include __DIR__ . '/../Views/admin/pages-get-cita.php';
    }
    public function editCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $citaId = $_GET['id'] ?? null;

        if (!$citaId) {
            $_SESSION['error'] = 'ID de cita no válido.';
            header("Location: pages-get-cita");
            exit;
        }

        // Obtener la cita específica
        $cita = Cita::findById($citaId);

        if (!$cita) {
            $_SESSION['error'] = 'Cita no encontrada.';
            header("Location: pages-get-cita");
            exit;
        }

        // Obtener TODAS las opciones disponibles para los selects
        $pacientes = Paciente::getAll();
        $servicios = Service::getAll();
        $doctores = Doctor::getAll();

        include __DIR__ . '/../Views/admin/pages-upd-cita.php';
    }

    public function updateCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'doctor_id' => $_POST['doctor_id'] ?? null,
                'service_id' => $_POST['service_id'] ?? null,
                'appointment_date' => $_POST['appointment_date'] ?? null,
                'status' => $_POST['status'] ?? 'scheduled',
                'notes' => $_POST['notes'] ?? null
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de cita no válido.';
                header("Location: pages-get-citas");
                exit;
            }

            // Validar que todos los campos requeridos estén presentes
            if (!$data['patient_id'] || !$data['doctor_id'] || !$data['service_id'] || !$data['appointment_date']) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header("Location: pages-edit-cita?id=" . $id);
                exit;
            }

            $success = Cita::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Cita actualizada correctamente.';
                header("Location: pages-get-citas");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar la cita. Intente nuevamente.';
                header("Location: pages-edit-cita?id=" . $id);
                exit;
            }
        }
    }

    public function deleteCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID de cita no válido.';
                header("Location: pages-get-citas");
                exit;
            }

            $success = Cita::delete($id);

            if ($success) {
                $_SESSION['exito'] = 'Cita eliminada correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar la cita. Intente nuevamente.';
            }

            header("Location: pages-get-citas");
            exit;
        }
    }

    public function calendar() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        include __DIR__ . '/../Views/admin/calendar.php';
    }

    public function getEvents() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("HTTP/1.1 403 Forbidden");
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode(Cita::getForCalendar());
    }
}