<?php
// src/app/Controllers/AdminController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Doctor.php';


class MedicoController {

    public function pagesAddMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        $isRoot = AuthService::getUserRole() === 'root';


        include __DIR__ . '/../Views/admin/pages-add-medico.php';
    }

    public function pagesGetMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-get-medico.php';
    }

    public function addMedico() {
    AuthService::requireLogin();

    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'idnumber' => $_POST['idnumber'] ?? null,
            'name' => $_POST['name'] ?? '',
            'specialization' => $_POST['specialization'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'email' => $_POST['email'] ?? '',
            'license_number' => $_POST['license_number'] ?? ''
        ];

        // Depuración: Ver qué datos se reciben
        error_log("Datos recibidos: " . print_r($data, true));

        $id = Doctor::create($data);

        if ($id) {
            $_SESSION['exito'] = 'Médico registrado correctamente.';
            header("Location:  pages-add-medico");
            exit;
        } else {
            $_SESSION['error'] = 'No se pudo registrar el médico. Intente nuevamente.';
            header("Location:  pages-add-medico");
            exit;
        }
    }
    }

   public function readMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        $isRoot = AuthService::getUserRole() === 'root';


        $doctors = Doctor::read(); // Llama al método del modelo que creamos antes

        include __DIR__ . '/../Views/admin/pages-get-medico.php';
    }

    public function editMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $doctorId = $_GET['id'] ?? null;

        if (!$doctorId) {
            header("Location: pages-get-medico");
            exit;
        }

        $doctor = Doctor::findById($doctorId);

        if (!$doctor) {
            header("Location: pages-upd-medico");
            exit;
        }
        $isRoot = AuthService::getUserRole() === 'root';


        include __DIR__ . '/../Views/admin/pages-upd-medico.php';
    }

    public function updateMedico() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'] ?? '',
                'specialization' => $_POST['specialization'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'license_number' => $_POST['license_number'] ?? ''
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de médico no válido.';
                header("Location: edit-medico?id=" . $id);
                exit;
            }

            $success = Doctor::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Médico actualizado correctamente.';
                header("Location: pages-upd-medico?id=" . $id);
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el médico. Intente nuevamente.';
                header("Location: pages-upd-medico?id=" . $id);
                exit;
            }
        }
    }
    
    public function deleteMedico() {
    AuthService::requireLogin();

    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            $_SESSION['error'] = 'ID de médico no válido.';
            header("Location: pages-get-medico");
            exit;
        }

        $success = Doctor::delete($id);

        if ($success) {
            $_SESSION['exito'] = 'Médico eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el médico. Intente nuevamente.';
        }

        header("Location: pages-get-medico");
        exit;
    }
    }

    public function getAll() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado']);
            exit;
        }

        $doctors = Doctor::getAll(); // Asegúrate de tener este método en tu modelo
        header('Content-Type: application/json');
        echo json_encode($doctors);
    }

    /**
     * Función de prueba para agregar un médico con datos predeterminados
     *
     * @return int|false ID del médico creado o false si falla
     */
    public function addMedicoTest() {
        // Datos predeterminados del médico de prueba
        $datosPrueba = [
            'cedula' => '1234567890',
            'name' => 'Dr. Juan Pérez',
            'specialization' => 'Odontología General',
            'phone' => '310-1234567',
            'email' => 'juan.perez@clinica.com',
            'license_number' => 'ODO-12345'
        ];
        $id = Doctor::create($datosPrueba);
        if ($id) {
            return $id;
        } else {
            echo "❌ Error al crear el médico de prueba<br>";
            return false;
        }
    }

    /**
     * Función de prueba accesible por URL
     */
    public function crearMedicoPrueba() {
        echo "<h2>Creando Médico de Prueba...</h2>";
        $id = $this->addMedicoTest();

        if ($id) {
            echo "<br><a href='pages-get-medico'>Ver lista de médicos</a>";
        }
    }




}