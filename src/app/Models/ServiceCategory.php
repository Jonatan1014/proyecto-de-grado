<?php
// src/app/Models/ServiceCategory.php

require_once __DIR__ . '/../../config/database.php';

class ServiceCategory {
    public $id;
    public $name;
    public $created_at;
    public $updated_at;
    public $service = []; 

    

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    public static function getAll() {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM service_categories ORDER BY name ASC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $categories = [];
        foreach ($results as $data) {
            $categories[] = new ServiceCategory($data);
        }
        return $categories;
    }

    public static function findById($id): ServiceCategory|null {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM service_categories WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new ServiceCategory($data) : null;
    }

    public static function findByIdCategeory($id): ?ServiceCategory {
        $db = Database::getConnection();
        $stmt = $db->prepare("
            SELECT 
                sc.*, 
                s.id AS service_id,
                s.name AS service_name,
                s.description AS service_description,
                s.price AS service_price,
                s.duration_minutes AS service_duration,
                s.icon AS service_icon,
                s.features AS service_features,
                s.status AS service_status
            FROM service_categories sc
            LEFT JOIN services s ON s.category_id = sc.id
            WHERE sc.id = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) return null;

        $category = new ServiceCategory($data);

        // Opcional: añade los servicios asociados como propiedad
        $category->service = [
            'id' => $data['service_id'],
            'name' => $data['service_name'],
            'description' => $data['service_description'],
            'price' => $data['service_price'],
            'duration' => $data['service_duration'],
            'icon' => $data['service_icon'],
            'features' => json_decode($data['service_features'], true),
            'status' => $data['service_status']
        ];

        return $category;
    }


    public static function findByName($name) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM service_categories WHERE name = ?");
        $stmt->execute([$name]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new ServiceCategory($data) : null;
    }

    public static function create($name) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO service_categories (name) VALUES (?)");
        try {
            $stmt->execute([$name]);
            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al crear categoría: " . $e->getMessage());
            return false;
        }
    }

    public static function update($id, $name) {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE service_categories SET name = ? WHERE id = ?");
        try {
            $stmt->execute([$name, $id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al actualizar categoría: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id) {
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM service_categories WHERE id = ?");
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            // Manejar restricción de clave foránea
            if ($e->getCode() == 23000) { // SQLSTATE[23000]: Integrity constraint violation
                error_log("No se puede eliminar la categoría porque está siendo usada por servicios.");
                return false;
            }
            error_log("Error al eliminar categoría: " . $e->getMessage());
            return false;
        }
    }

    // ✅ Nuevo método para obtener todas como array asociativo (para selects)
    public static function getAllAsArray() {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id, name FROM service_categories ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}