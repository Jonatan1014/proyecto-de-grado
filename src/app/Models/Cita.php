<?php
// src/app/Models/Cita.php

require_once __DIR__ . '/../../config/database.php';

class Cita {
    public $id;
    public $patient_id;
    public $doctor_id;
    public $service_id;
    public $appointment_date;
    public $status;
    public $notes;
    public $created_at;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->patient_id = $data['patient_id'];
        $this->doctor_id = $data['doctor_id'];
        $this->service_id = $data['service_id'];
        $this->appointment_date = $data['appointment_date'];
        $this->status = $data['status'] ?? 'scheduled';
        $this->notes = $data['notes'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }

    public static function read() {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT a.*, 
                   p.name as patient_name, 
                   d.name as doctor_name, 
                   s.name as service_name 
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN services s ON a.service_id = s.id
            ORDER BY a.appointment_date DESC
        ");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $citas = [];
            foreach ($results as $data) {
                $citas[] = new Cita($data);
            }

            return $citas;
        } catch (Exception $e) {
            error_log("Error al consultar citas: " . $e->getMessage());
            return [];
        }
    }

    public static function getAll() {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT a.id, 
                   a.appointment_date, 
                   a.status,
                   CONCAT(p.name, ' - ', s.name) as title,
                   p.name as patient_name,
                   d.name as doctor_name,
                   s.name as service_name
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.status != 'cancelled'
            ORDER BY a.appointment_date DESC
        ");
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error al consultar citas: " . $e->getMessage());
            return [];
        }
    }

    public static function findById($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT a.*, 
                   p.name as patient_name, 
                   d.name as doctor_name, 
                   s.name as service_name 
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.id = ?
        ");
        
        try {
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? new Cita($data) : null;
        } catch (Exception $e) {
            error_log("Error al consultar cita por ID: " . $e->getMessage());
            return null;
        }
    }

    public static function create($data) {
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, status, notes) VALUES (?, ?, ?, ?, ?, ?)");
        
        try {
            $stmt->execute([
                $data['patient_id'],
                $data['doctor_id'],
                $data['service_id'],
                $data['appointment_date'],
                $data['status'] ?? 'scheduled',
                $data['notes'] ?? null
            ]);

            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al insertar cita: " . $e->getMessage());
            return false;
        }
    }

    public static function update($id, $data) {
        $db = Database::getConnection();

        $stmt = $db->prepare("UPDATE appointments SET patient_id = ?, doctor_id = ?, service_id = ?, appointment_date = ?, status = ?, notes = ? WHERE id = ?");
        
        try {
            $stmt->execute([
                $data['patient_id'],
                $data['doctor_id'],
                $data['service_id'],
                $data['appointment_date'],
                $data['status'] ?? 'scheduled',
                $data['notes'] ?? null,
                $id
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al actualizar cita: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM appointments WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar cita: " . $e->getMessage());
            return false;
        }
    }

    public static function getForCalendar() {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT a.id, 
                   a.appointment_date as start, 
                   a.status,
                   p.name as patient_name, 
                   d.name as doctor_name, 
                   s.name as service_name,
                   a.notes
            FROM appointments a
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN services s ON a.service_id = s.id
            WHERE a.status != 'cancelled'
        ");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $events = [];
            foreach ($results as $data) {
                $events[] = [
                    'id' => $data['id'],
                    'title' => $data['patient_name'] . ' - ' . $data['service_name'],
                    'start' => $data['start'],
                    'extendedProps' => [
                        'doctor' => $data['doctor_name'],
                        'status' => $data['status'],
                        'notes' => $data['notes'],
                        'patient_id' => $data['patient_id'],
                        'doctor_id' => $data['doctor_id'],
                        'service_id' => $data['service_id']
                    ]
                ];
            }

            return $events;
        } catch (Exception $e) {
            error_log("Error al consultar citas para calendario: " . $e->getMessage());
            return [];
        }
    }
}