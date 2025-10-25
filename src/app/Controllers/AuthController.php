<?php
// src/app/Controllers/AuthController.php

require_once __DIR__ . '/../Services/AuthService.php';

class AuthController {

    /**
     * Manejar login (GET muestra formulario, POST procesa login)
     */
    public function handleLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            // Mostrar formulario de login
            $error = $_GET['error'] ?? null;
            $mensaje = $_GET['mensaje'] ?? $_SESSION['mensaje_login'] ?? null;
            unset($_SESSION['mensaje_login']);
            
            include __DIR__ . '/../Views/login.php';
        } elseif ($method === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error_login'] = 'Por favor ingresa tu email y contraseña';
                header("Location: login?error=campos_vacios");
                exit;
            }

            // Intentar login
            $usuario = AuthService::login($email, $password);

            if ($usuario) {
                // Debug: Verificar sesión después del login
                error_log("AuthController - Login exitoso");
                error_log("AuthController - Session ID: " . session_id());
                error_log("AuthController - usuario_id: " . ($_SESSION['usuario_id'] ?? 'NULL'));
                error_log("AuthController - user: " . json_encode($_SESSION['user'] ?? 'NULL'));
                
                // Login exitoso - redirigir según rol
                $redirectUrl = $this->obtenerRedirectSegunRol($usuario['rol']);
                
                // Si había una URL guardada para redirigir (ej: checkout)
                if (isset($_SESSION['redirect_after_login'])) {
                    $redirectUrl = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                }

                header("Location: $redirectUrl");
                exit;
            } else {
                $_SESSION['error_login'] = 'Email o contraseña incorrectos';
                header("Location: login?error=credenciales_invalidas");
                exit;
            }
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        AuthService::logout();
        $_SESSION['mensaje_login'] = 'Has cerrado sesión correctamente';
        header("Location: login");
        exit;
    }

    /**
     * Obtener URL de redirección según el rol del usuario
     */
    private function obtenerRedirectSegunRol($rol) {
        switch ($rol) {
            case 'administrador':
                return 'admin';
            case 'empleado':
                return 'admin';
            case 'cliente':
            default:
                return 'home';
        }
    }
}