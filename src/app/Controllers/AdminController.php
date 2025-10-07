<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Doctor.php';
require_once __DIR__ . '/../Models/Paciente.php'; 


class AdminController {

    public function index() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/dashboard.php';
    }
    public function appsCalendar() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/apps-calendar.php';
    }

    public function appsTasks() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/apps-tasks.php';
    }

    public function pagesProfile() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-profile.php';
    }

    public function pagesAddPaciente() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-add-paciente.php';
    }
    public function pagesAddMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-add-medico.php';
    }
    public function pagesGetMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-get-medico.php';
    }

    public function addMedico() {
    AuthService::requireLogin();

    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'] ?? '',
            'specialization' => $_POST['specialization'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'license_number' => $_POST['license_number'] ?? ''
        ];

        // Depuración: Ver qué datos se reciben
        error_log("Datos recibidos: " . print_r($data, true));

        $id = Doctor::create($data);

        if ($id) {
            $_SESSION['exito'] = 'Médico registrado correctamente.';
            header("Location:  pages-add-medico");
            exit;
        } else {
            $_SESSION['error'] = 'No se pudo registrar el médico. Intente nuevamente.';
            header("Location:  pages-add-medico");
            exit;
        }
    }
}
   public function readMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $doctors = Doctor::read(); // Llama al método del modelo que creamos antes

        include __DIR__ . '/../Views/admin/pages-get-medico.php';
    }

    public function editMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $doctorId = $_GET['id'] ?? null;

        if (!$doctorId) {
            header("Location: pages-get-medico");
            exit;
        }

        $doctor = Doctor::findById($doctorId);

        if (!$doctor) {
            header("Location: pages-upd-medico");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-upd-medico.php';
    }

    public function updateMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'] ?? '',
                'specialization' => $_POST['specialization'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'license_number' => $_POST['license_number'] ?? ''
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de médico no válido.';
                header("Location: edit-medico?id=" . $id);
                exit;
            }

            $success = Doctor::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Médico actualizado correctamente.';
                header("Location: pages-upd-medico?id=" . $id);
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el médico. Intente nuevamente.';
                header("Location: pages-upd-medico?id=" . $id);
                exit;
            }
        }
    }

    public function deleteMedico() {
    AuthService::requireLogin();

    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'ID de médico no válido.';
            header("Location: pages-get-medico");
            exit;
        }

        $success = Doctor::delete($id);

        if ($success) {
            $_SESSION['exito'] = 'Médico eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el médico. Intente nuevamente.';
        }

        header("Location: pages-get-medico");
        exit;
    }
}

   public function readPaciente() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $pacientes = Paciente::read(); // Llama al método del modelo que creamos antes

        include __DIR__ . '/../Views/admin/pages-get-paciente.php';
    }

    public function addPaciente() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? null,
                'gender' => $_POST['gender'] ?? null,
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'address' => $_POST['address'] ?? '',
                'emergency_contact_name' => $_POST['emergency_contact_name'] ?? '',
                'emergency_contact_phone' => $_POST['emergency_contact_phone'] ?? ''
            ];

            // Depuración: Ver qué datos se reciben
            error_log("Datos recibidos: " . print_r($data, true));

            $id = Paciente::create($data);

            if ($id) {
                $_SESSION['exito'] = 'Paciente registrado correctamente.';
                header("Location: pages-add-paciente");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo registrar el paciente. Intente nuevamente.';
                header("Location: pages-add-paciente");
                exit;
            }
        }
    }

}