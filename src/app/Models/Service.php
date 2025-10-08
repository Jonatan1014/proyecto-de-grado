<?php
// src/app/Models/Service.php

require_once __DIR__ . '/../../config/database.php';

class Service {
    public $id;
    public $name;
    public $description;
    public $duration_minutes;
    public $price;
    public $category;        
    public $icon;           
    public $features;      
    public $is_featured;    
    public $status;         
    public $created_at;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->description = $data['description'] ?? null;
        $this->duration_minutes = $data['duration_minutes'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->category = $data['category'] ?? null;        
        $this->icon = $data['icon'] ?? 'fas fa-tooth';      
        $this->features = $data['features'] ?? null;        
        $this->is_featured = $data['is_featured'] ?? 0;     
        $this->status = $data['status'] ?? 'active';        
        $this->created_at = $data['created_at'] ?? null;
    }

    public static function read() {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM services ORDER BY created_at DESC");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Convertir cada resultado en objeto Service
            $services = [];
            foreach ($results as $data) {
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
        $stmt = $db->prepare("SELECT id, name, duration_minutes FROM services ORDER BY name ASC");
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

        $stmt = $db->prepare("INSERT INTO services (name, description, duration_minutes, price, category, icon, features, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['description'] ?? null,
                $data['duration_minutes'] ?? null,
                $data['price'] ?? null,
                $data['category'] ?? null,
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

        $stmt = $db->prepare("UPDATE services SET name = ?, description = ?, duration_minutes = ?, price = ?, category = ?, icon = ?, features = ?, is_featured = ?, status = ? WHERE id = ?");
        
        try {
            $stmt->execute([
                $data['name'],
                $data['description'] ?? null,
                $data['duration_minutes'] ?? null,
                $data['price'] ?? null,
                $data['category'] ?? null,
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

        $stmt = $db->prepare("SELECT * FROM services WHERE id = ?");
        
        try {
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $data ? new Service($data) : null;
        } catch (Exception $e) {
            error_log("Error al consultar servicio por ID: " . $e->getMessage());
            return null;
        }
    }

   

    public static function getActiveServices() {
        $db = Database::getConnection();
        
        $stmt = $db->prepare("
            SELECT id, name, description, duration_minutes, price, category, icon, features, is_featured, created_at 
            FROM services 
            WHERE status = 'active' 
            ORDER BY is_featured DESC, name ASC
        ");
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Convertir features JSON a array si existen
            foreach ($results as &$service) {
                if ($service['features']) {
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