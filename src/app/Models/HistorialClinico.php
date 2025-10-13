<?php
// src/app/Models/HistorialClinico.php

require_once __DIR__ . '/../../config/database.php';

class HistorialClinico {
    public $id;
    public $patient_id;
    public $doctor_id;
    public $appointment_id;
    public $history_number;
    public $registration_date;
    public $reason_consultation;
    public $current_illness;
    public $medical_history;
    public $family_history;
    public $general_exam;
    public $local_exam;
    public $odontogram;
    public $main_diagnosis;
    public $secondary_diagnosis;
    public $treatment_plan;
    public $final_observations;
    public $created_at;
    public $updated_at;
    
    // Datos relacionados
    public $patient_name;
    public $patient_lastname;
    public $patient_idnumber;
    public $patient_birth_date;
    public $patient_gender;
    public $patient_phone;
    public $patient_email;
    public $patient_address;
    public $patient_emergency_name;
    public $patient_emergency_phone;
    public $doctor_name;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->patient_id = $data['patient_id'] ?? null;
        $this->doctor_id = $data['doctor_id'] ?? null;
        $this->appointment_id = $data['appointment_id'] ?? null;
        $this->history_number = $data['history_number'] ?? null;
        $this->registration_date = $data['registration_date'] ?? null;
        $this->reason_consultation = $data['reason_consultation'] ?? null;
        $this->current_illness = $data['current_illness'] ?? null;
        $this->medical_history = $data['medical_history'] ?? null;
        $this->family_history = $data['family_history'] ?? null;
        $this->general_exam = $data['general_exam'] ?? null;
        $this->local_exam = $data['local_exam'] ?? null;
        
        // Decodificar JSON si es string
        $this->odontogram = is_string($data['odontogram'] ?? null) 
            ? json_decode($data['odontogram'], true) 
            : ($data['odontogram'] ?? []);
        
        $this->main_diagnosis = $data['main_diagnosis'] ?? null;
        $this->secondary_diagnosis = $data['secondary_diagnosis'] ?? null;
        
        $this->treatment_plan = is_string($data['treatment_plan'] ?? null) 
            ? json_decode($data['treatment_plan'], true) 
            : ($data['treatment_plan'] ?? []);
        
        $this->final_observations = $data['final_observations'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
        
        // Datos relacionados
        $this->patient_name = $data['patient_name'] ?? null;
        $this->patient_lastname = $data['patient_lastname'] ?? null;
        $this->patient_idnumber = $data['patient_idnumber'] ?? null;
        $this->patient_birth_date = $data['patient_birth_date'] ?? null;
        $this->patient_gender = $data['patient_gender'] ?? null;
        $this->patient_phone = $data['patient_phone'] ?? null;
        $this->patient_email = $data['patient_email'] ?? null;
        $this->patient_address = $data['patient_address'] ?? null;
        $this->patient_emergency_name = $data['patient_emergency_name'] ?? null;
        $this->patient_emergency_phone = $data['patient_emergency_phone'] ?? null;
        $this->doctor_name = $data['doctor_name'] ?? null;
    }

    public static function read() {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT 
                dcr.*,
                p.name AS patient_name,
                p.lastname AS patient_lastname,
                p.idnumber AS patient_idnumber,
                p.birth_date AS patient_birth_date,
                p.gender AS patient_gender,
                p.phone AS patient_phone,
                p.email AS patient_email,
                p.address AS patient_address,
                p.emergency_contact_name AS patient_emergency_name,
                p.emergency_contact_phone AS patient_emergency_phone,
                d.name AS doctor_name
            FROM dental_clinical_records dcr
            LEFT JOIN patients p ON dcr.patient_id = p.id
            LEFT JOIN doctors d ON dcr.doctor_id = d.id
            ORDER BY dcr.registration_date DESC
        ");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $historiales = [];
            foreach ($results as $data) {
                $historiales[] = new HistorialClinico($data);
            }

            return $historiales;
        } catch (Exception $e) {
            error_log("Error al consultar historiales clínicos: " . $e->getMessage());
            return [];
        }
    }

    public static function create($data) {
        $db = Database::getConnection();

        // Preparar datos JSON
        $odontogram = isset($data['odontogram']) ? json_encode($data['odontogram']) : json_encode([]);
        $treatment_plan = isset($data['treatment_plan']) ? json_encode($data['treatment_plan']) : json_encode([]);

        $stmt = $db->prepare("
            INSERT INTO dental_clinical_records (
                patient_id, doctor_id, appointment_id, history_number, registration_date,
                reason_consultation, current_illness, medical_history, family_history,
                general_exam, local_exam, odontogram, main_diagnosis, secondary_diagnosis,
                treatment_plan, final_observations
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        try {
            $stmt->execute([
                $data['patient_id'],
                $data['doctor_id'] ?? null,
                $data['appointment_id'] ?? null,
                $data['history_number'] ?? null,
                $data['registration_date'] ?? date('Y-m-d'),
                $data['reason_consultation'] ?? null,
                $data['current_illness'] ?? null,
                $data['medical_history'] ?? null,
                $data['family_history'] ?? null,
                $data['general_exam'] ?? null,
                $data['local_exam'] ?? null,
                $odontogram,
                $data['main_diagnosis'] ?? null,
                $data['secondary_diagnosis'] ?? null,
                $treatment_plan,
                $data['final_observations'] ?? null
            ]);

            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al insertar historial clínico: " . $e->getMessage());
            return false;
        }
    }

    public static function findById($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("
            SELECT 
                dcr.*,
                p.name AS patient_name,
                p.lastname AS patient_lastname,
                p.idnumber AS patient_idnumber,
                p.birth_date AS patient_birth_date,
                p.gender AS patient_gender,
                p.phone AS patient_phone,
                p.email AS patient_email,
                p.address AS patient_address,
                p.emergency_contact_name AS patient_emergency_name,
                p.emergency_contact_phone AS patient_emergency_phone,
                d.name AS doctor_name
            FROM dental_clinical_records dcr
            LEFT JOIN patients p ON dcr.patient_id = p.id
            LEFT JOIN doctors d ON dcr.doctor_id = d.id
            WHERE dcr.id = ?
        ");
        
        try {
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? new HistorialClinico($data) : null;
        } catch (Exception $e) {
            error_log("Error al consultar historial clínico por ID: " . $e->getMessage());
            return null;
        }
    }

    public static function update($id, $data) {
        $db = Database::getConnection();

        // Preparar datos JSON
        $odontogram = isset($data['odontogram']) ? json_encode($data['odontogram']) : json_encode([]);
        $treatment_plan = isset($data['treatment_plan']) ? json_encode($data['treatment_plan']) : json_encode([]);

        $stmt = $db->prepare("
            UPDATE dental_clinical_records 
            SET patient_id = ?, doctor_id = ?, appointment_id = ?, history_number = ?,
                registration_date = ?, reason_consultation = ?, current_illness = ?,
                medical_history = ?, family_history = ?, general_exam = ?, local_exam = ?,
                odontogram = ?, main_diagnosis = ?, secondary_diagnosis = ?,
                treatment_plan = ?, final_observations = ?
            WHERE id = ?
        ");
        
        try {
            $stmt->execute([
                $data['patient_id'],
                $data['doctor_id'] ?? null,
                $data['appointment_id'] ?? null,
                $data['history_number'] ?? null,
                $data['registration_date'] ?? date('Y-m-d'),
                $data['reason_consultation'] ?? null,
                $data['current_illness'] ?? null,
                $data['medical_history'] ?? null,
                $data['family_history'] ?? null,
                $data['general_exam'] ?? null,
                $data['local_exam'] ?? null,
                $odontogram,
                $data['main_diagnosis'] ?? null,
                $data['secondary_diagnosis'] ?? null,
                $treatment_plan,
                $data['final_observations'] ?? null,
                $id
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al actualizar historial clínico: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM dental_clinical_records WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar historial clínico: " . $e->getMessage());
            return false;
        }
    }
}