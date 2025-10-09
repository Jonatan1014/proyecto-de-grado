<?php 

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Paciente.php'; 


class PacienteController {



    public function pagesAddPaciente() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-add-paciente.php';
    }
    public function readPaciente() {
        AuthService::requireLogin();
        
        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        
        $pacientes = Paciente::read(); // Llama al método del modelo que creamos antes
        
        include __DIR__ . '/../Views/admin/pages-get-paciente.php';
    }

     public function editPaciente() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $pacienteId = $_GET['id'] ?? null;

        if (!$pacienteId) {
            header("Location: pages-get-paciente");
            exit;
        }

        $paciente = Paciente::findById($pacienteId);

        if (!$paciente) {
            header("Location: pages-upd-paciente");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-upd-paciente.php';
    }
    public function addPaciente() {
        AuthService::requireLogin();
        
        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'lastname' => $_POST['lastname'] ?? '',
                'idnumber' => $_POST['idnumber'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? null,
                'gender' => $_POST['gender'] ?? null,
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'address' => $_POST['address'] ?? '',
                'emergency_contact_name' => $_POST['emergency_contact_name'] ?? '',
                'emergency_contact_phone' => $_POST['emergency_contact_phone'] ?? ''
            ];

            // Depuración: Ver qué datos se reciben
            error_log("Datos recibidos: " . print_r($data, true));

            $id = Paciente::create($data);
            
            if ($id) {
                $_SESSION['exito'] = 'Paciente registrado correctamente.';
                header("Location: pages-add-paciente");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo registrar el paciente. Intente nuevamente.';
                header("Location: pages-add-paciente");
                exit;
            }
        }
    }

    public function updatePaciente() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? null,
                'gender' => $_POST['gender'] ?? null,
                'phone' => $_POST['phone'] ?? '',
                'email' => $_POST['email'] ?? '',
                'address' => $_POST['address'] ?? '',
                'emergency_contact_name' => $_POST['emergency_contact_name'] ?? '',
                'emergency_contact_phone' => $_POST['emergency_contact_phone'] ?? ''
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de paciente no válido.';
                header("Location: pages-upd-paciente?id=" . $id);
                exit;
            }

            $success = Paciente::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Paciente actualizado correctamente.';
                header("Location: pages-get-paciente");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el paciente. Intente nuevamente.';
                header("Location: pages-upd-paciente?id=" . $id);
                exit;
            }
        }
    }

    public function deletePaciente() {
    AuthService::requireLogin();
    
    if (!AuthService::isAdminOrRoot()) {
        header("Location: login");
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'] ?? null;
    
        if (!$id) {
            $_SESSION['error'] = 'ID de Paciente no válido.';
            header("Location: pages-get-medico");
            exit;
        }
    
        $success = Paciente::delete($id);
    
        if ($success) {
            $_SESSION['exito'] = 'Paciente eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el Paciente. Intente nuevamente.';
        }
    
        header("Location: pages-get-paciente");
        exit;
    }
    }


}



