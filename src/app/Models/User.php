<?php
// src/app/Models/User.php

require_once __DIR__ . '/../../config/database.php';

class User {
    public $id;
    public $username;
    public $email;
    public $role;
    public $is_active;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->role = $data['role'];
        $this->is_active = $data['is_active'];
    }

    /**
     * Autenticar usuario por email y contraseña
     */
    public static function authenticate($email, $password) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            return new User($userData);
        }

        return false;
    }

    /**
     * Crear un nuevo usuario
     */
    public static function create($data) {
        $db = Database::getConnection();

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (username, email, password, role, is_active) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['username'],
            $data['email'],
            $hashedPassword,
            $data['role'],
            $data['is_active']
        ]);

        return $db->lastInsertId();
    }

    /**
     * Leer todos los usuarios
     */
    public static function read() {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT id, username, email, role, is_active, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Buscar usuario por ID
     */
    public static function findById($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT id, username, email, role, is_active FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualizar usuario
     */
    public static function update($id, $data) {
        $db = Database::getConnection();

        if (!empty($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ?, role = ?, is_active = ? WHERE id = ?");
            return $stmt->execute([
                $data['username'],
                $data['email'],
                $hashedPassword,
                $data['role'],
                $data['is_active'],
                $id
            ]);
        } else {
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, role = ?, is_active = ? WHERE id = ?");
            return $stmt->execute([
                $data['username'],
                $data['email'],
                $data['role'],
                $data['is_active'],
                $id
            ]);
        }
    }

    /**
     * Eliminar usuario
     */
    public static function delete($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Verificar si un email ya existe
     */
    public static function emailExists($email, $excludeId = null) {
        $db = Database::getConnection();

        if ($excludeId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $excludeId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
        }

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Verificar si un username ya existe
     */
    public static function usernameExists($username, $excludeId = null) {
        $db = Database::getConnection();

        if ($excludeId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id != ?");
            $stmt->execute([$username, $excludeId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
        }

        return $stmt->fetchColumn() > 0;
    }
}