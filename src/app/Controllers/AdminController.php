<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';

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

            $id = Doctor::create($data);

            if ($id) {
                header("Location: add-medico?success=1");
                exit;
            } else {
                header("Location: add-medico?error=1");
                exit;
            }
        }
    }
}