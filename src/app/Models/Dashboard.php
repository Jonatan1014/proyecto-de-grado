<?php
// src/app/Models/Dashboard.php

require_once __DIR__ . '/../../config/database.php';

class Dashboard {
    public static function getStats() {
        $db = Database::getConnection();

        // Contar pacientes
        $stmt = $db->query("SELECT COUNT(*) AS total FROM patients");
        $totalPacientes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar citas
        $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments");
        $totalCitas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar citas completadas
        $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments WHERE status = 'completed'");
        $citasCompletadas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar citas pendientes
        $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments WHERE status = 'scheduled'");
        $citasPendientes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar citas canceladas
        $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments WHERE status = 'cancelled'");
        $citasCanceladas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar doctores
        $stmt = $db->query("SELECT COUNT(*) AS total FROM doctors");
        $totalDoctores = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar servicios
        $stmt = $db->query("SELECT COUNT(*) AS total FROM services WHERE status = 'active'");
        $totalServicios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Contar historias clínicas
        $stmt = $db->query("SELECT COUNT(*) AS total FROM dental_clinical_records");
        $totalHistoriales = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Ingresos estimados (basado en citas completadas y servicios)
        $stmt = $db->query("
            SELECT SUM(s.price) AS total
            FROM appointments a
            JOIN services s ON a.service_id = s.id
            WHERE a.status = 'completed'
        ");
        $ingresosCompletados = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Ingresos pendientes (basado en citas programadas y servicios)
        $stmt = $db->query("
            SELECT SUM(s.price) AS total
            FROM appointments a
            JOIN services s ON a.service_id = s.id
            WHERE a.status = 'scheduled'
        ");
        $ingresosPendientes = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Servicios más solicitados
        $stmt = $db->query("
            SELECT s.name, COUNT(a.id) AS count
            FROM appointments a
            JOIN services s ON a.service_id = s.id
            GROUP BY s.id
            ORDER BY count DESC
            LIMIT 5
        ");
        $serviciosPopulares = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Doctores con más citas
        $stmt = $db->query("
            SELECT d.name, COUNT(a.id) AS count
            FROM appointments a
            JOIN doctors d ON a.doctor_id = d.id
            GROUP BY d.id
            ORDER BY count DESC
            LIMIT 5
        ");
        $doctoresConMasCitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pacientes por género
        $stmt = $db->query("
            SELECT gender, COUNT(*) AS count
            FROM patients
            GROUP BY gender
        ");
        $pacientesPorGenero = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Citas por estado
        $stmt = $db->query("
            SELECT status, COUNT(*) AS count
            FROM appointments
            GROUP BY status
        ");
        $citasPorEstado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'totalPacientes' => $totalPacientes,
            'totalCitas' => $totalCitas,
            'citasCompletadas' => $citasCompletadas,
            'citasPendientes' => $citasPendientes,
            'citasCanceladas' => $citasCanceladas,
            'totalDoctores' => $totalDoctores,
            'totalServicios' => $totalServicios,
            'totalHistoriales' => $totalHistoriales,
            'ingresosCompletados' => $ingresosCompletados,
            'ingresosPendientes' => $ingresosPendientes,
            'serviciosPopulares' => $serviciosPopulares,
            'doctoresConMasCitas' => $doctoresConMasCitas,
            'pacientesPorGenero' => $pacientesPorGenero,
            'citasPorEstado' => $citasPorEstado
        ];
    }
}