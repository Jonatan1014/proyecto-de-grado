<?php
// src/app/Services/AuthService.php

require_once __DIR__ . '/../Models/User.php';

class AuthService {

    public static function login($email, $password) {
        $user = User::authenticate($email, $password);

        if ($user) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user'] = [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role' => $user->role
            ];
            return true;
        }

        return false;
    }

    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        session_destroy();
    }

    public static function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user']);
    }

    public static function getUserRole() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['user']['role'] ?? null;
    }

    public static function isAdminOrRoot() {
        $role = self::getUserRole();
        return $role === 'admin' || $role === 'root';
    }

    public static function isRoot() {
        $role = self::getUserRole();
        return $role === 'root';
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: login");
            exit;
        }
    }
}