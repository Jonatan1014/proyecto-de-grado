<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/Service.php';
require_once __DIR__ . '/../Models/ServiceCategory.php'; // ✅ Añadido

class ServiceController {

    public function readService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $services = Service::read();
        include __DIR__ . '/../Views/admin/pages-get-service.php';
    }

    public function addService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ✅ Obtener category_id desde el formulario
            $categoryId = $_POST['category_id'] ?? null;

            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? null,
                'duration_minutes' => $_POST['duration_minutes'] ?? null,
                'price' => $_POST['price'] ?? null,
                'category_id' => $categoryId, // ✅ Usar category_id
                'icon' => $_POST['icon'] ?? 'fas fa-tooth',
                'features' => $_POST['features'] ?? null,
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'status' => 'active'
            ];

            if (empty($data['name'])) {
                $_SESSION['error'] = 'El nombre del servicio es obligatorio.';
                header("Location: pages-add-service");
                exit;
            }

            // ✅ Validar que se haya seleccionado una categoría
            if (empty($data['category_id'])) {
                $_SESSION['error'] = 'Debe seleccionar una categoría.';
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
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            
            // ✅ Obtener category_id desde el formulario
            $categoryId = $_POST['category_id'] ?? null;

            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? null,
                'duration_minutes' => $_POST['duration_minutes'] ?? null,
                'price' => $_POST['price'] ?? null,
                'category_id' => $categoryId, // ✅ Usar category_id
                'icon' => $_POST['icon'] ?? 'fas fa-tooth',
                'features' => $_POST['features'] ?? null,
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'status' => $_POST['status'] ?? 'active'
            ];

            if (!$id) {
                $_SESSION['error'] = 'ID de servicio no válido.';
                header("Location: pages-get-service");
                exit;
            }

            if (empty($data['name'])) {
                $_SESSION['error'] = 'El nombre del servicio es obligatorio.';
                header("Location: pages-upd-service?id=" . $id);
                exit;
            }

            // ✅ Validar que se haya seleccionado una categoría
            if (empty($data['category_id'])) {
                $_SESSION['error'] = 'Debe seleccionar una categoría.';
                header("Location: pages-upd-service?id=" . $id);
                exit;
            }

            $success = Service::update($id, $data);

            if ($success) {
                $_SESSION['exito'] = 'Servicio actualizado correctamente.';
                header("Location: pages-get-service");
            } else {
                $_SESSION['error'] = 'No se pudo actualizar el servicio. Intente nuevamente.';
                header("Location: pages-upd-service?id=" . $id);
            }
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
                header("Location: pages-get-service");
                exit;
            }

            $success = Service::delete($id);

            if ($success) {
                $_SESSION['exito'] = 'Servicio eliminado correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar el servicio. Intente nuevamente.';
            }

            header("Location: pages-get-service");
            exit;
        }
    }

    public function pagesAddService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        // ✅ Obtener categorías para el formulario
        $categories = ServiceCategory::getAllAsArray();
        include __DIR__ . '/../Views/admin/pages-add-service.php';
    }

    public function pagesGetServices() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $services = Service::read();
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
            header("Location: pages-get-service");
            exit;
        }

        $service = Service::findById($serviceId);

        if (!$service) {
            $_SESSION['error'] = 'Servicio no encontrado.';
            header("Location: pages-get-service");
            exit;
        }

        // ✅ Obtener categorías para el formulario
        $categories = ServiceCategory::getAll();
        include __DIR__ . '/../Views/admin/pages-upd-service.php';
    }

    public function showServices() {
        $services = Service::getActiveServices();
        include __DIR__ . '/../Views/services.php';
    }
    
    public function showServiceDetails() {
        $serviceId = $_GET['id'] ?? null;
        
        if (!$serviceId) {
            header("Location: services");
            exit;
        }
        
        $service = Service::findById($serviceId);
        
        if (!$service || $service->status !== 'active') {
            header("Location: services");
            exit;
        }
        
        include __DIR__ . '/../Views/service-details.php';
    }

    public function editService() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $serviceId = $_GET['id'] ?? null;

        if (!$serviceId) {
            header("Location: pages-get-service");
            exit;
        }

        $service = Service::findById($serviceId);
        $categories = ServiceCategory::getAllAsArray();

        if (!$service) {
            header("Location: pages-upd-service");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-upd-service.php';
    }
}