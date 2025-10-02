<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Doctor.php';


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
            header("Location: pages-read-medico");
            exit;
        }

        $doctor = Doctor::findById($doctorId);

        if (!$doctor) {
            header("Location: pages-read-medico");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-edit-medico.php';
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
                header("Location: pages-read-medico");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el médico. Intente nuevamente.';
                header("Location: edit-medico?id=" . $id);
                exit;
            }
        }
    }

}