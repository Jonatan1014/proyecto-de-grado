<?php
// src/app/Controllers/AuthController.php

require_once __DIR__ . '/../Services/AuthService.php';

class AuthController {

    public function handleLogin() {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            include __DIR__ . '/../Views/login.php';
        } elseif ($method === 'POST') {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;

            if (!$email || !$password) {
                header("Location: login?error=1");
                exit;
            }

            if (AuthService::login($email, $password)) {
                header("Location: admin");
                exit;
            } else {
                header("Location: login?error=1");
            }
        }
    }

    public function logout() {
        AuthService::logout();
        header("Location: login");
    }
}