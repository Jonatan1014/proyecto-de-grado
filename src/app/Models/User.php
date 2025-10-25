<?php
// src/app/Models/User.php

require_once __DIR__ . '/../../config/database.php';

class User {
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $rol;
    public $estado;
    public $telefono;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'] ?? '';
        $this->apellido = $data['apellido'] ?? '';
        $this->email = $data['email'];
        $this->rol = $data['rol'] ?? 'cliente';
        $this->estado = $data['estado'] ?? 'activo';
        $this->telefono = $data['telefono'] ?? '';
    }

    /**
     * Autenticar usuario por email y contraseña
     */
    public static function authenticate($email, $password) {
        $db = Database::getConnection();

        $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ? AND estado = 'activo'");
        $stmt->execute([$email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            return new User($userData);
        }

        return false;
    }

    /**
     * Obtener usuario por ID
     */
    public static function obtenerPorId($id) {
        $db = Database::getConnection();
        
        $stmt = $db->prepare("
            SELECT id, nombre, apellido, email, telefono, rol, estado, fecha_registro
            FROM usuarios
            WHERE id = ? AND estado = 'activo'
        ");
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener direcciones de un usuario
     */
    public static function obtenerDirecciones($usuarioId) {
        $db = Database::getConnection();
        
        $stmt = $db->prepare("
            SELECT id, direccion, ciudad, departamento, codigo_postal, pais, es_principal
            FROM direcciones
            WHERE usuario_id = ?
            ORDER BY es_principal DESC, id DESC
        ");
        $stmt->execute([$usuarioId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Guardar nueva dirección
     */
    public static function guardarDireccion($usuarioId, $datos) {
        $db = Database::getConnection();
        
        try {
            $db->beginTransaction();
            
            // Si es dirección principal, desmarcar las demás
            if (!empty($datos['es_principal'])) {
                $stmt = $db->prepare("UPDATE direcciones SET es_principal = 0 WHERE usuario_id = ?");
                $stmt->execute([$usuarioId]);
            }
            
            $stmt = $db->prepare("
                INSERT INTO direcciones (usuario_id, direccion, ciudad, departamento, codigo_postal, pais, es_principal)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $usuarioId,
                $datos['direccion'],
                $datos['ciudad'],
                $datos['departamento'],
                $datos['codigo_postal'] ?? '',
                $datos['pais'] ?? 'Colombia',
                $datos['es_principal'] ?? 0
            ]);
            
            $db->commit();
            return $db->lastInsertId();
            
        } catch (Exception $e) {
            $db->rollBack();
            error_log("Error al guardar dirección: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verificar si un email ya existe en la base de datos
     */
    public static function existeEmail($email) {
        $db = Database::getConnection();
        
        $stmt = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Crear un nuevo usuario
     */
    public static function crear($datos) {
        $db = Database::getConnection();
        
        try {
            // Hash de la contraseña
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
            
            $stmt = $db->prepare("
                INSERT INTO usuarios (nombre, apellido, email, password, telefono, rol, estado)
                VALUES (?, ?, ?, ?, ?, ?, 'activo')
            ");
            
            $resultado = $stmt->execute([
                $datos['nombre'],
                $datos['apellido'],
                $datos['email'],
                $passwordHash,
                $datos['telefono'] ?? '',
                $datos['rol'] ?? 'cliente'
            ]);
            
            return $resultado;
            
        } catch (Exception $e) {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }
}