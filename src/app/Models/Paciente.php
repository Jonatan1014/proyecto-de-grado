<?php
// src/app/Models/Paciente.php

require_once __DIR__ . '/../../config/database.php';

class Paciente {
    public $id;
    public $name;
    public $birth_date;
    public $gender;
    public $phone;
    public $email;
    public $address;
    public $emergency_contact_name;
    public $emergency_contact_phone;
    public $created_at;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->birth_date = $data['birth_date'] ?? null;
        $this->gender = $data['gender'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->address = $data['address'] ?? null;
        $this->emergency_contact_name = $data['emergency_contact_name'] ?? null;
        $this->emergency_contact_phone = $data['emergency_contact_phone'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public static function read() {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM patients ORDER BY created_at DESC");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convertir cada resultado en objeto Paciente
            $pacientes = [];
            foreach ($results as $data) {
                $pacientes[] = new Paciente($data);
            }

            return $pacientes;
        } catch (Exception $e) {
            error_log("Error al consultar pacientes: " . $e->getMessage());
            return [];
        }
    }

    public static function create($data) {
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO patients (name, birth_date, gender, phone, email, address, emergency_contact_name, emergency_contact_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['birth_date'],
                $data['gender'],
                $data['phone'],
                $data['email'],
                $data['address'],
                $data['emergency_contact_name'],
                $data['emergency_contact_phone']
            ]);

            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al insertar paciente: " . $e->getMessage());
            return false;
        }
    }
}