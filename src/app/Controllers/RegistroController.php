<?php
// src/app/Controllers/RegistroController.php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Services/AuthService.php';

class RegistroController {
    
    /**
     * Mostrar formulario de registro o procesar registro
     */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Si es POST, procesar el registro
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->procesarRegistro();
            return;
        }
        
        // Si es GET, mostrar el formulario
        include __DIR__ . '/../Views/registration.php';
    }
    
    /**
     * Procesar el registro de un nuevo cliente
     */
    private function procesarRegistro() {
        // Validar datos recibidos
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        // Validaciones
        if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
            $_SESSION['error_registro'] = 'Todos los campos obligatorios deben ser completados';
            header("Location: registration");
            exit;
        }
        
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_registro'] = 'El correo electrónico no es válido';
            header("Location: registration");
            exit;
        }
        
        // Validar longitud de contraseña
        if (strlen($password) < 6) {
            $_SESSION['error_registro'] = 'La contraseña debe tener al menos 6 caracteres';
            header("Location: registration");
            exit;
        }
        
        // Validar que las contraseñas coincidan
        if ($password !== $passwordConfirm) {
            $_SESSION['error_registro'] = 'Las contraseñas no coinciden';
            header("Location: registration");
            exit;
        }
        
        // Verificar si el email ya existe
        if (User::existeEmail($email)) {
            $_SESSION['error_registro'] = 'Este correo electrónico ya está registrado';
            header("Location: registration");
            exit;
        }
        
        // Crear el usuario
        $resultado = User::crear([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'telefono' => $telefono,
            'password' => $password,
            'rol' => 'cliente'
        ]);
        
        if ($resultado) {
            $_SESSION['mensaje_login'] = 'Registro exitoso. Ahora puedes iniciar sesión';
            header("Location: login");
        } else {
            $_SESSION['error_registro'] = 'Error al crear la cuenta. Por favor intenta nuevamente';
            header("Location: registration");
        }
        exit;
    }
}
