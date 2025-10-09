<?php
// src/app/Controllers/ServiceCategoryController.php

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Models/ServiceCategory.php';

class ServiceCategoryController {

    public function readServiceCategory() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $categories = ServiceCategory::getAll();
        include __DIR__ . '/../Views/admin/pages-get-service-category.php';
    }

    public function addServiceCategory() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');

            if (empty($name)) {
                $_SESSION['error'] = 'El nombre de la categoría es obligatorio.';
                header("Location: pages-add-service-category");
                exit;
            }

            // Verificar si ya existe
            if (ServiceCategory::findByName($name)) {
                $_SESSION['error'] = 'Ya existe una categoría con ese nombre.';
                header("Location: pages-add-service-category");
                exit;
            }

            $id = ServiceCategory::create($name);

            if ($id) {
                $_SESSION['exito'] = 'Categoría creada correctamente.';
                header("Location: pages-add-service-category");
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo crear la categoría. Intente nuevamente.';
                header("Location: pages-add-category");
                exit;
            }
        }
    }

    public function updateServiceCategory() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');

            if (!$id) {
                $_SESSION['error'] = 'ID de categoría no válido.';
                header("Location: pages-get-service-category");
                exit;
            }

            if (empty($name)) {
                $_SESSION['error'] = 'El nombre de la categoría es obligatorio.';
                header("Location: pages-upd-service-category?id=" . $id);
                exit;
            }

            // Verificar si ya existe otra categoría con ese nombre
            $existing = ServiceCategory::findByName($name);
            if ($existing && $existing->id != $id) {
                $_SESSION['error'] = 'Ya existe una categoría con ese nombre.';
                header("Location: pages-get-category?id=" . $id);
                exit;
            }

            $success = ServiceCategory::update($id, $name);

            if ($success) {
                $_SESSION['exito'] = 'Categoría actualizada correctamente.';
                header("Location: pages-upd-service-category?id=" . $id);
                exit;
            } else {
                $_SESSION['error'] = 'No se pudo actualizar la categoría. Intente nuevamente.';
                header("Location: pages-upd-service-category?id=" . $id);
                exit;
            }
        }
    }

    public function deleteServiceCategory() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                $_SESSION['error'] = 'ID de categoría no válido.';
                header("Location: pages-get-service-category");
                exit;
            }

            $success = ServiceCategory::delete($id);

            if ($success) {
                $_SESSION['exito'] = 'Categoría eliminada correctamente.';
            } else {
                $_SESSION['error'] = 'No se pudo eliminar la categoría. Es posible que esté siendo usada por servicios.';
            }

            header("Location: pages-get-service-category");
            exit;
        }
    }

    public function pagesAddServiceCategory() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }
        $categories = ServiceCategory::getAll(); 


        include __DIR__ . '/../Views/admin/pages-add-service-category.php';
    }

    public function editServiceCategory() {
        AuthService::requireLogin();

        if (!AuthService::isAdminOrRoot()) {
            header("Location: login");
            exit;
        }

        $categoryId = $_GET['id'] ?? null;

        if (!$categoryId) {
            header("Location: pages-upd-service-category");
            exit;
        }

        $category = ServiceCategory::findByIdCategeory($categoryId);

        if (!$category) {
            $_SESSION['error'] = 'Categoría no encontrada.';
            header("Location: pages-upd-service-category");
            exit;
        }

        include __DIR__ . '/../Views/admin/pages-upd-service-category.php';
    }
}