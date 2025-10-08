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

    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, name, phone, email, address FROM patients ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
     public static function delete($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM patients WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar paciente: " . $e->getMessage());
            return false;
        }
    }

    public static function findById($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM patients WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? new Paciente($data) : null;
        } catch (Exception $e) {
            error_log("Error al consultar paciente por ID: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        $db = Database::getConnection();

        $stmt = $db->prepare("UPDATE patients SET name = ?, birth_date = ?, gender = ?, phone = ?, email = ?, address = ?, emergency_contact_name = ?, emergency_contact_phone = ? WHERE id = ?");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['birth_date'],
                $data['gender'],
                $data['phone'],
                $data['email'],
                $data['address'],
                $data['emergency_contact_name'],
                $data['emergency_contact_phone'],
                $id
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al actualizar paciente: " . $e->getMessage());
            return false;
        }
    }
}