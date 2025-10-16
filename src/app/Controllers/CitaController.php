<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Cita.php';
require_once __DIR__ . '/../Models/Paciente.php';
require_once __DIR__ . '/../Models/Doctor.php';
require_once __DIR__ . '/../Models/Service.php';
require_once __DIR__ . '/../Services/WebhookService.php';


class CitaController {
    private $webhookService;

    
    public function __construct() {
        $this->webhookService = new WebhookService($_ENV['WEBHOOK_URL'] ?? null);
    }

    public function addCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'doctor_id' => $_POST['doctor_id'] ?? null,
                'service_id' => $_POST['service_id'] ?? null,
                'appointment_date' => $_POST['appointment_date'] ?? null,
                'status' => $_POST['status'] ?? 'scheduled',
                'notes' => $_POST['notes'] ?? null
            ];

            // Validar que todos los campos requeridos estén presentes
            if (!$data['patient_id'] || !$data['doctor_id'] || !$data['service_id'] || !$data['appointment_date']) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header("Location: pages-add-cita");
                exit;
            }

            $id = Cita::create($data);

            if ($id) {
                $_SESSION['exito'] = 'Cita registrada correctamente.';
                header("Location: pages-add-cita");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo registrar la cita. Intente nuevamente.';
                header("Location: pages-add-cita");
                exit;
            }
        }
    }

    public function addContactFrontend() {
        // REMOVIDO: AuthService::requireLogin(); y verificación de rol
        // porque este formulario es público

        // ✅ Asegurarse de que sea una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo "Method Not Allowed";
            exit;
        }

        $data = [
            'name' => $_POST['name'] ?? null,
            'email' => $_POST['email'] ?? null,
            'subject' => $_POST['subject'] ?? null,
            'message' => $_POST['message'] ?? null,
            // Añade aquí otros campos si los tienes en el formulario, como 'phone'
            // 'phone' => $_POST['phone'] ?? null,
        ];

        // ✅ Validar campos requeridos del formulario de contacto
        if (empty($data['name']) || empty($data['email']) || empty($data['subject']) || empty($data['message'])) {
            // ✅ Devolver mensaje de error directamente
            echo "Todos los campos son obligatorios.";
            exit; // Detener la ejecución aquí
        }

        // ✅ Opcional: Validar formato de email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Por favor, ingrese un correo electrónico válido.";
            exit;
        }

        // ✅ Enviar webhook con los datos del formulario de contacto
        $user_info = null; // No hay usuario logueado en este formulario
        $webhook_response = $this->webhookService->send([
            'action' => 'contact_frontend', // Cambia la acción para identificarla
            'contact_data' => $data, // Envía los datos del formulario
            'submitted_at' => date('Y-m-d H:i:s')
        ], $user_info);

        // Puedes verificar la respuesta del webhook si es necesario
        // if ($webhook_response === false) {
        //     echo "Error al procesar su solicitud. Intente nuevamente.";
        //     exit;
        // }

        // ✅ Si todo es correcto, devolver 'OK' para que php-email-form.js lo entienda
        echo "OK";
        exit; // Detener la ejecución aquí también
    }
    public function addCitaFrontend() {
        // REMOVIDO: AuthService::requireLogin(); y verificación de rol
        // porque este formulario es público

        // ✅ Asegurarse de que sea una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo "Method Not Allowed";
            exit;
        }

        $data = [
            'name' => $_POST['name'] ?? null,
            'email' => $_POST['email'] ?? null,
            'phone' => $_POST['phone'] ?? null,
            'service' => $_POST['service'] ?? null,
            'doctor' => $_POST['doctor'] ?? null,
            'message' => $_POST['message'] ?? null,
            // Añade aquí otros campos si los tienes en el formulario, como 'phone'
            // 'phone' => $_POST['phone'] ?? null,
        ];

        // ✅ Validar campos requeridos del formulario de contacto
        if (empty($data['name']) || empty($data['email']) || empty($data['service']) || empty($data['message']) || empty($data['phone'])) {
            // ✅ Devolver mensaje de error directamente
            echo "Todos los campos son obligatorios.";
            exit; // Detener la ejecución aquí
        }

        // ✅ Opcional: Validar formato de email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Por favor, ingrese un correo electrónico válido.";
            exit;
        }

        // ✅ Enviar webhook con los datos del formulario de contacto
        $user_info = null; // No hay usuario logueado en este formulario
        $webhook_response = $this->webhookService->send([
            'action' => 'cita_frontend', // Cambia la acción para identificarla
            'contact_data' => $data, // Envía los datos del formulario
            'submitted_at' => date('Y-m-d H:i:s')
        ], $user_info);

        // Puedes verificar la respuesta del webhook si es necesario
        // if ($webhook_response === false) {
        //     echo "Error al procesar su solicitud. Intente nuevamente.";
        //     exit;
        // }

        // ✅ Si todo es correcto, devolver 'OK' para que php-email-form.js lo entienda
        echo "OK";
        exit; // Detener la ejecución aquí también
    }

    public function pagesAddCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $pacientes = Paciente::getAll();
        $servicios = Service::getAll();
        $doctores = Doctor::getAll();

        include __DIR__ . '/../Views/admin/pages-add-cita.php';
    }


    public function readCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $appointments = Cita::read();

        include __DIR__ . '/../Views/admin/pages-get-cita.php';
    }
    public function editCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $citaId = $_GET['id'] ?? null;

        if (!$citaId) {
            $_SESSION['error'] = 'ID de cita no válido.';
            header("Location: pages-get-cita");
            exit;
        }

        // Obtener la cita específica
        $cita = Cita::findById($citaId);

        if (!$cita) {
            $_SESSION['error'] = 'Cita no encontrada.';
            header("Location: pages-get-cita");
            exit;
        }

        // Obtener TODAS las opciones disponibles para los selects
        $pacientes = Paciente::getAll();
        $servicios = Service::getAll();
        $doctores = Doctor::getAll();

        include __DIR__ . '/../Views/admin/pages-upd-cita.php';
    }

    public function updateCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'patient_id' => $_POST['patient_id'] ?? null,
                'doctor_id' => $_POST['doctor_id'] ?? null,
                'service_id' => $_POST['service_id'] ?? null,
                'appointment_date' => $_POST['appointment_date'] ?? null,
                'status' => $_POST['status'] ?? 'scheduled',
                'notes' => $_POST['notes'] ?? null
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de cita no válido.';
                header("Location: pages-get-citas");
                exit;
            }

            // Validar que todos los campos requeridos estén presentes
            if (!$data['patient_id'] || !$data['doctor_id'] || !$data['service_id'] || !$data['appointment_date']) {
                $_SESSION['error'] = 'Todos los campos son obligatorios.';
                header("Location: pages-edit-cita?id=" . $id);
                exit;
            }

            $success = Cita::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Cita actualizada correctamente.';
                header("Location: pages-get-citas");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar la cita. Intente nuevamente.';
                header("Location: pages-edit-cita?id=" . $id);
                exit;
            }
        }
    }

    public function deleteCita() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID de cita no válido.';
                header("Location: pages-get-citas");
                exit;
            }

            $success = Cita::delete($id);

            if ($success) {
                $_SESSION['exito'] = 'Cita eliminada correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar la cita. Intente nuevamente.';
            }

            header("Location: pages-get-citas");
            exit;
        }
    }

    public function calendar() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        include __DIR__ . '/../Views/admin/calendar.php';
    }

    public function getEvents() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("HTTP/1.1 403 Forbidden");
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode(Cita::getForCalendar());
    }
}