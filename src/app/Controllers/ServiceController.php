<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Service.php';

class ServiceController {

    public function addService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? null,
                'duration_minutes' => $_POST['duration_minutes'] ?? null,
                'price' => $_POST['price'] ?? null
            ];

            // Validar que el nombre no esté vacío
            if (empty($data['name'])) {
                $_SESSION['error'] = 'El nombre del servicio es obligatorio.';
                header("Location: pages-add-service");
                exit;
            }

            $id = Service::create($data);

            if ($id) {
                $_SESSION['exito'] = 'Servicio registrado correctamente.';
                header("Location: pages-add-service");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo registrar el servicio. Intente nuevamente.';
                header("Location: pages-add-service");
                exit;
            }
        }
    }

    public function updateService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: /login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? null,
                'duration_minutes' => $_POST['duration_minutes'] ?? null,
                'price' => $_POST['price'] ?? null
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de servicio no válido.';
                header("Location: pages-get-services");
                exit;
            }

            if (empty($data['name'])) {
                $_SESSION['error'] = 'El nombre del servicio es obligatorio.';
                header("Location: pages-edit-service?id=" . $id);
                exit;
            }

            $success = Service::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Servicio actualizado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el servicio. Intente nuevamente.';
            }

            header("Location: pages-get-services");
            exit;
        }
    }

    public function deleteService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID de servicio no válido.';
                header("Location: pages-get-services");
                exit;
            }

            $success = Service::delete($id);

            if ($success) {
                $_SESSION['exito'] = 'Servicio eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar el servicio. Intente nuevamente.';
            }

            header("Location: pages-get-services");
            exit;
        }
    }

    public function pagesAddService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-add-service.php';
    }

    public function pagesGetServices() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $services = Service::read(); // Obtiene todos los servicios
        include __DIR__ . '/../Views/admin/pages-get-services.php';
    }

    public function pagesEditService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $serviceId = $_GET['id'] ?? null;

        if (!$serviceId) {
            header("Location: pages-get-services");
            exit;
        }

        $service = Service::findById($serviceId);

        if (!$service) {
            $_SESSION['error'] = 'Servicio no encontrado.';
            header("Location: pages-get-services");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-edit-service.php';
    }
}