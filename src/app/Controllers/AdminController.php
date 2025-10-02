<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';

class AdminController {

    public function index() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        include __DIR__ . '/../Views/admin.php';
    }
}