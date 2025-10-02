<?php
// src/app/Models/Doctor.php

require_once __DIR__ . '/../../config/database.php';

class Doctor {
    public $id;
    public $name;
    public $specialization;
    public $phone;
    public $email;
    public $license_number;
    public $created_at;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->specialization = $data['specialization'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->license_number = $data['license_number'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public static function create($data) {
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO doctors (name, specialization, phone, email, license_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['name'],
            $data['specialization'],
            $data['phone'],
            $data['email'],
            $data['license_number']
        ]);

        return $db->lastInsertId();
    }
}