<?php
// src/app/Controllers/UserController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/User.php';

class UserController {

    public function pagesAddUser() {
        AuthService::requireLogin();

        if (!AuthService::isRoot()) {
            header("Location: dashboard");
            exit;
        }

        $isRoot = AuthService::isRoot();
        include __DIR__ . '/../Views/admin/pages-add-admin.php';
    }

    public function addUser() {
        AuthService::requireLogin();

        if (!AuthService::isRoot()) {
            $_SESSION['error'] = 'No tienes permisos para crear usuarios.';
            header("Location: dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            $role = $_POST['role'] ?? 'admin';
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            // Validaciones
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header("Location: pages-add-admin");
                exit;
            }

            if ($password !== $password_confirm) {
                $_SESSION['error'] = 'Las contraseñas no coinciden.';
                header("Location: pages-add-admin");
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres.';
                header("Location: pages-add-admin");
                exit;
            }

            if (User::emailExists($email)) {
                $_SESSION['error'] = 'El email ya está registrado.';
                header("Location: pages-add-admin");
                exit;
            }

            if (User::usernameExists($username)) {
                $_SESSION['error'] = 'El nombre de usuario ya existe.';
                header("Location: pages-add-admin");
                exit;
            }

            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => $role,
                'is_active' => $is_active
            ];

            $id = User::create($data);

            if ($id) {
                $_SESSION['exito'] = 'Usuario registrado correctamente.';
                header("Location: pages-get-admin");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo registrar el usuario.';
                header("Location: pages-add-admin");
                exit;
            }
        }
    }

    public function readUser() {
        AuthService::requireLogin();

        if (!AuthService::isRoot()) {
            header("Location: dashboard");
            exit;
        }

        $users = User::read();
        $isRoot = AuthService::isRoot();

        include __DIR__ . '/../Views/admin/pages-get-admin.php';
    }

    public function editUser() {
        AuthService::requireLogin();

        if (!AuthService::isRoot()) {
            header("Location: dashboard");
            exit;
        }

        $userId = $_GET['id'] ?? null;

        if (!$userId) {
            header("Location: pages-get-admin");
            exit;
        }

        $user = User::findById($userId);

        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado.';
            header("Location: pages-get-admin");
            exit;
        }

        $isRoot = AuthService::isRoot();
        include __DIR__ . '/../Views/admin/pages-upd-admin.php';
    }

    public function updateUser() {
        AuthService::requireLogin();

        if (!AuthService::isRoot()) {
            $_SESSION['error'] = 'No tienes permisos para actualizar usuarios.';
            header("Location: dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';
            $role = $_POST['role'] ?? 'admin';
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            if (!$id || empty($username) || empty($email)) {
                $_SESSION['error'] = 'Datos incompletos.';
                header("Location: pages-upd-admin?id=" . $id);
                exit;
            }

            // Validar contraseña solo si se proporciona
            if (!empty($password)) {
                if ($password !== $password_confirm) {
                    $_SESSION['error'] = 'Las contraseñas no coinciden.';
                    header("Location: pages-upd-admin?id=" . $id);
                    exit;
                }

                if (strlen($password) < 6) {
                    $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres.';
                    header("Location: pages-upd-admin?id=" . $id);
                    exit;
                }
            }

            if (User::emailExists($email, $id)) {
                $_SESSION['error'] = 'El email ya está registrado por otro usuario.';
                header("Location: pages-upd-admin?id=" . $id);
                exit;
            }

            if (User::usernameExists($username, $id)) {
                $_SESSION['error'] = 'El nombre de usuario ya existe.';
                header("Location: pages-upd-admin?id=" . $id);
                exit;
            }

            $data = [
                'username' => $username,
                'email' => $email,
                'role' => $role,
                'is_active' => $is_active
            ];

            if (!empty($password)) {
                $data['password'] = $password;
            }

            $success = User::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Usuario actualizado correctamente.';
                header("Location: pages-upd-admin?id=" . $id);
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el usuario.';
                header("Location: pages-upd-admin?id=" . $id);
                exit;
            }
        }
    }

    public function deleteUser() {
        AuthService::requireLogin();

        if (!AuthService::isRoot()) {
            $_SESSION['error'] = 'No tienes permisos para eliminar usuarios.';
            header("Location: dashboard");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID de usuario no válido.';
                header("Location: pages-get-admin");
                exit;
            }

            // No permitir eliminar el propio usuario
            if ($id == $_SESSION['user_id']) {
                $_SESSION['error'] = 'No puedes eliminar tu propia cuenta.';
                header("Location: pages-get-admin");
                exit;
            }

            $success = User::delete($id);

            if ($success) {
                $_SESSION['exito'] = 'Usuario eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar el usuario.';
            }

            header("Location: pages-get-admin");
            exit;
        }
    }
}
