<?php
// src/app/Models/EventCalendar.php

class EventCalendar
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO events_calendar (title, description, start_datetime, end_datetime, event_type, appointment_id, patient_id, doctor_id, reminder_datetime)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['start_datetime'],
            $data['end_datetime'],
            $data['event_type'],
            $data['appointment_id'],
            $data['patient_id'],
            $data['doctor_id'],
            $data['reminder_datetime']
        ]);
    }

    public function getAll()
    {
        // Consulta para eventos del calendario
        $stmt = $this->db->query("
            SELECT 
                events_calendar.id,
                events_calendar.title,
                events_calendar.start_datetime AS start,
                events_calendar.end_datetime AS end,
                events_calendar.description,
                events_calendar.event_type AS type,
                events_calendar.appointment_id,
                patients.name AS patient_name,
                doctors.name AS doctor_name,
                events_calendar.reminder_datetime,
                events_calendar.created_at,
                events_calendar.updated_at,
                'event' AS source
            FROM events_calendar
            LEFT JOIN appointments ON events_calendar.appointment_id = appointments.id
            LEFT JOIN patients ON events_calendar.patient_id = patients.id
            LEFT JOIN doctors ON events_calendar.doctor_id = doctors.id

            UNION ALL

            -- Consulta para citas de la tabla appointments
            SELECT 
                appointments.id,
                CONCAT('Cita: ', patients.name, ' - ', doctors.name) AS title,
                appointments.appointment_date AS start,
                DATE_ADD(appointments.appointment_date, INTERVAL services.duration_minutes MINUTE) AS end,
                appointments.notes AS description,
                appointments.status AS type, -- Usar el status de la cita
                appointments.id AS appointment_id,
                patients.name AS patient_name,
                doctors.name AS doctor_name,
                NULL AS reminder_datetime,
                appointments.created_at,
                appointments.updated_at,
                'appointment' AS source
            FROM appointments
            LEFT JOIN patients ON appointments.patient_id = patients.id
            LEFT JOIN doctors ON appointments.doctor_id = doctors.id
            LEFT JOIN services ON appointments.service_id = services.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE events_calendar
            SET title = ?, description = ?, start_datetime = ?, end_datetime = ?, event_type = ?, appointment_id = ?, patient_id = ?, doctor_id = ?, reminder_datetime = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['title'],
            $data['description'],
            $data['start_datetime'],
            $data['end_datetime'],
            $data['event_type'],
            $data['appointment_id'],
            $data['patient_id'],
            $data['doctor_id'],
            $data['reminder_datetime'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM events_calendar WHERE id = ?");
        return $stmt->execute([$id]);
    }
}