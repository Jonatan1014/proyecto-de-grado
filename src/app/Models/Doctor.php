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
        
        try {
            $stmt->execute([
                $data['name'],
                $data['specialization'],
                $data['phone'],
                $data['email'],
                $data['license_number']
            ]);

            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al insertar médico: " . $e->getMessage());
            return false;
        }
    }
        public static function read() {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM doctors ORDER BY created_at DESC");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convertir cada resultado en objeto Doctor
            $doctors = [];
            foreach ($results as $data) {
                $doctors[] = new Doctor($data);
            }

            return $doctors;
        } catch (Exception $e) {
            error_log("Error al consultar médicos: " . $e->getMessage());
            return [];
        }
    }

    public static function update($id, $data) {
        $db = Database::getConnection();

        $stmt = $db->prepare("UPDATE doctors SET name = ?, specialization = ?, phone = ?, email = ?, license_number = ? WHERE id = ?");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['specialization'],
                $data['phone'],
                $data['email'],
                $data['license_number'],
                $id
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al actualizar médico: " . $e->getMessage());
            return false;
        }
    }

        public static function delete($id) {
            $db = Database::getConnection();

            $stmt = $db->prepare("DELETE FROM doctors WHERE id = ?");
            
            try {
                return $stmt->execute([$id]);
            } catch (Exception $e) {
                error_log("Error al eliminar médico: " . $e->getMessage());
                return false;
            }
        }

    public static function findById($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM doctors WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? new Doctor($data) : null;
        } catch (Exception $e) {
            error_log("Error al consultar médico por ID: " . $e->getMessage());
            return null;
        }
    }

}