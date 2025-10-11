<?php
// src/app/Controllers/CalendarController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/EventCalendar.php';
require_once __DIR__ . '/../Services/WebhookService.php';
require_once __DIR__ . '/../../config/database.php';

class CalendarController {

    private $eventModel;
    private $webhookService;

    public function __construct() {
        $db = Database::getConnection();
        $this->eventModel = new EventCalendar($db);
        $this->webhookService = new WebhookService($_ENV['WEBHOOK_URL'] ?? null);
    }

    public function appsCalendar() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/apps-calendar.php';
    }

    // API para obtener eventos
    public function getEvents() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado']);
            exit;
        }

        $events = $this->eventModel->getAll();
        $calendarEvents = [];

        foreach ($events as $event) {
            // Determinar el color según el tipo de evento o status de la cita
            $className = 'bg-warning'; // Por defecto

            if ($event['source'] === 'appointment') {
                // Si es una cita, usar el status para determinar el color
                if ($event['type'] === 'scheduled') {
                    $className = 'bg-success'; // Cita programada
                } elseif ($event['type'] === 'completed') {
                    $className = 'bg-secondary'; // Cita completada
                } elseif ($event['type'] === 'cancelled') {
                    $className = 'bg-danger'; // Cita cancelada
                }
            } else {
                // Si es un evento del calendario, usar el tipo
                if ($event['type'] === 'appointment') {
                    $className = 'bg-success'; // Evento de cita
                } elseif ($event['type'] === 'reminder') {
                    $className = 'bg-info'; // Recordatorio
                } elseif ($event['type'] === 'cancelled') {
                    $className = 'bg-danger'; // Evento cancelado
                } elseif ($event['type'] === 'other') {
                    $className = 'bg-warning'; // Otro tipo
                }
            }

            $calendarEvents[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'start' => $event['start'],
                'end' => $event['end'],
                'extendedProps' => [
                    'description' => $event['description'],
                    'type' => $event['type'],
                    'appointment_id' => $event['appointment_id'],
                    'patient_name' => $event['patient_name'],
                    'doctor_name' => $event['doctor_name'],
                    'source' => $event['source'], // 'event' o 'appointment'
                ],
                'className' => $className
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($calendarEvents);
    }

    // API para crear evento
    public function addEvent() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $data = [
            'title' => $input['title'],
            'description' => $input['description'] ?? null,
            'start_datetime' => $input['start'],
            'end_datetime' => $input['end'],
            'event_type' => $input['type'] ?? 'other',
            'appointment_id' => $input['appointment_id'] ?? null,
            'patient_id' => $input['patient_id'] ?? null,
            'doctor_id' => $input['doctor_id'] ?? null,
            'reminder_datetime' => $input['reminder_datetime'] ?? null,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->eventModel->create($data);

        if ($result) {
            // ✅ Obtener información del usuario
            $user = [
                'id' => $_SESSION['user']['id'],
                'username' => $_SESSION['user']['username'],
                'email' => $_SESSION['user']['email'],
                'role' => $_SESSION['user']['role']
            ];

            // ✅ Enviar webhook con datos completos y usuario
            $this->webhookService->send([
                'action' => 'create_event',
                'event_data' => $data
            ], $user);

            http_response_code(201);
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
        }
    }

    public function updateEvent() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado']);
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID requerido']);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        $data = [
            'id' => $id,
            'title' => $input['title'],
            'description' => $input['description'] ?? null,
            'start_datetime' => $input['start'],
            'end_datetime' => $input['end'],
            'event_type' => $input['type'] ?? 'other',
            'appointment_id' => $input['appointment_id'] ?? null,
            'patient_id' => $input['patient_id'] ?? null,
            'doctor_id' => $input['doctor_id'] ?? null,
            'reminder_datetime' => $input['reminder_datetime'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $result = $this->eventModel->update($id, $data);

        if ($result) {
            // ✅ Obtener información del usuario
            $user = [
                'id' => $_SESSION['user']['id'],
                'username' => $_SESSION['user']['username'],
                'email' => $_SESSION['user']['email'],
                'role' => $_SESSION['user']['role']
            ];

            // ✅ Enviar webhook con datos completos y usuario
            $this->webhookService->send([
                'action' => 'update_event',
                'event_data' => $data
            ], $user);

            http_response_code(200);
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
        }
    }

    public function deleteEvent() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado']);
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID requerido']);
            exit;
        }

        $result = $this->eventModel->delete($id);

        if ($result) {
            // ✅ Obtener información del usuario
            $user = [
                'id' => $_SESSION['user']['id'],
                'username' => $_SESSION['user']['username'],
                'email' => $_SESSION['user']['email'],
                'role' => $_SESSION['user']['role']
            ];

            // ✅ Enviar webhook con ID del evento eliminado y usuario
            $this->webhookService->send([
                'action' => 'delete_event',
                'event_id' => $id,
                'deleted_at' => date('Y-m-d H:i:s')
            ], $user);

            http_response_code(200);
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
        }
    }
}