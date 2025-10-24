<?php
// src/app/Models/Categoria.php

require_once __DIR__ . '/../../config/database.php';

class Categoria {
    public $id;
    public $nombre;
    public $descripcion;
    public $estado;

    public function __construct($data) {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
        $this->descripcion = $data['descripcion'] ?? null;
        $this->estado = $data['estado'] ?? 'activo';
    }

    /**
     * Obtener todas las categorías activas
     */
    public static function obtenerTodas() {
        $db = Database::getConnection();

        $sql = "SELECT * FROM categorias WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener una categoría por ID
     */
    public static function obtenerPorId($id) {
        $db = Database::getConnection();

        $sql = "SELECT * FROM categorias WHERE id = :id AND estado = 'activo'";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Contar productos por categoría
     */
    public static function contarProductos($categoriaId) {
        $db = Database::getConnection();

        $sql = "SELECT COUNT(*) as total FROM productos WHERE categoria_id = :categoria_id AND estado = 'activo'";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    /**
     * Crear una nueva categoría
     */
    public static function create($data) {
        $db = Database::getConnection();

        $sql = "INSERT INTO categorias (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);

        return $db->lastInsertId();
    }

    /**
     * Actualizar categoría
     */
    public static function update($id, $data) {
        $db = Database::getConnection();

        $sql = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);
    }

    /**
     * Eliminar categoría
     */
    public static function delete($id) {
        $db = Database::getConnection();

        $sql = "UPDATE categorias SET estado = 'inactivo' WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

