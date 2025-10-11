<?php
// src/app/Models/Service.php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/ServiceCategory.php'; // Para obtener el nombre de la categoría

class Service {
    public $id;
    public $name;
    public $description;
    public $duration_minutes;
    public $price;
    public $category_id;        // ✅ Cambiado de category a category_id
    public $category_name;      // ✅ Nuevo campo para mostrar el nombre de la categoría
    public $icon;           
    public $features;      
    public $is_featured;    
    public $status;         
    public $created_at;
    public $updated_at;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->description = $data['description'] ?? null;
        $this->duration_minutes = $data['duration_minutes'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->category_id = $data['category_id'] ?? null;        // ✅ category_id
        $this->category_name = $data['category_name'] ?? null;  // ✅ category_name (de JOIN)
        $this->icon = $data['icon'] ?? 'fas fa-tooth';      
        $this->features = $data['features'] ?? null;        
        $this->is_featured = $data['is_featured'] ?? 0;     
        $this->status = $data['status'] ?? 'active';        
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    public static function read() {
        $db = Database::getConnection();

        // ✅ Actualizado para JOIN con service_categories
        $stmt = $db->prepare("
            SELECT s.*, sc.name as category_name 
            FROM services s 
            LEFT JOIN service_categories sc ON s.category_id = sc.id 
            ORDER BY s.created_at DESC
        ");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $services = [];
            foreach ($results as $data) {
                // Convertir features JSON a array si existen
                if (isset($data['features']) && $data['features']) {
                    $data['features'] = json_decode($data['features'], true);
                } else {
                    $data['features'] = [];
                }
                $services[] = new Service($data);
            }

            return $services;
        } catch (Exception $e) {
            error_log("Error al consultar servicios: " . $e->getMessage());
            return [];
        }
    }

    public static function getAll() {
        $db = Database::getConnection();
        // ✅ Actualizado para incluir category_id
        $stmt = $db->prepare("SELECT id, name, price, duration_minutes, category_id FROM services ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::getConnection();

        // Convertir features a JSON
        $features = $data['features'] ?? null;
        if ($features && is_string($features)) {
            $features = array_map('trim', explode(',', $features));
            $features = json_encode($features);
        }

        // ✅ Actualizado para usar category_id
        $stmt = $db->prepare("INSERT INTO services (name, description, duration_minutes, price, category_id, icon, features, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['description'] ?? null,
                $data['duration_minutes'] ?? null,
                $data['price'] ?? null,
                $data['category_id'] ?? null, // ✅ category_id
                $data['icon'] ?? 'fas fa-tooth',
                $features,
                $data['is_featured'] ?? 0,
                'active'
            ]);

            return $db->lastInsertId();
        } catch (Exception $e) {
            error_log("Error al insertar servicio: " . $e->getMessage());
            return false;
        }
    }

    public static function update($id, $data) {
        $db = Database::getConnection();

        // Convertir features a JSON
        $features = $data['features'] ?? null;
        if ($features && is_string($features)) {
            $features = array_map('trim', explode(',', $features));
            $features = json_encode($features);
        }

        // ✅ Actualizado para usar category_id
        $stmt = $db->prepare("UPDATE services SET name = ?, description = ?, duration_minutes = ?, price = ?, category_id = ?, icon = ?, features = ?, is_featured = ?, status = ? WHERE id = ?");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['description'] ?? null,
                $data['duration_minutes'] ?? null,
                $data['price'] ?? null,
                $data['category_id'] ?? null, // ✅ category_id
                $data['icon'] ?? 'fas fa-tooth',
                $features,
                $data['is_featured'] ?? 0,
                $data['status'] ?? 'active',
                $id
            ]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al actualizar servicio: " . $e->getMessage());
            return false;
        }
    }

    public static function delete($id) {
        $db = Database::getConnection();

        $stmt = $db->prepare("DELETE FROM services WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Error al eliminar servicio: " . $e->getMessage());
            return false;
        }
    }

    public static function findById($id) {
        $db = Database::getConnection();

        // ✅ Actualizado para JOIN con service_categories
        $stmt = $db->prepare("
            SELECT s.*, sc.name as category_name 
            FROM services s 
            LEFT JOIN service_categories sc ON s.category_id = sc.id 
            WHERE s.id = ?
        ");
        
        try {
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                // Convertir features JSON a array si existen
                if (isset($data['features']) && $data['features']) {
                    $data['features'] = implode(', ',json_decode($data['features'], true));
                } else {
                    $data['features'] = [];
                }
                return new Service($data);
            }

            return null;
        } catch (Exception $e) {
            error_log("Error al consultar servicio por ID: " . $e->getMessage());
            return null;
        }
    }

    public static function getActiveServices() {
        $db = Database::getConnection();
        
        // ✅ Actualizado para JOIN con service_categories
        $stmt = $db->prepare("
            SELECT s.id, s.name, s.description, s.duration_minutes, s.price, s.category_id, s.icon, s.features, s.is_featured, s.created_at, sc.name as category_name
            FROM services s 
            LEFT JOIN service_categories sc ON s.category_id = sc.id 
            WHERE s.status = 'active' 
            ORDER BY s.is_featured DESC, s.name ASC
        ");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Convertir features JSON a array si existen
            foreach ($results as &$service) {
                if (isset($service['features']) && $service['features']) {
                    $service['features'] = json_decode($service['features'], true);
                } else {
                    $service['features'] = [];
                }
            }
            
            return $results;
        } catch (Exception $e) {
            error_log("Error al consultar servicios activos: " . $e->getMessage());
            return [];
        }
    }
}