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
}