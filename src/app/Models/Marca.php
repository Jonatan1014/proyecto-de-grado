<?php
// src/app/Models/Marca.php

require_once __DIR__ . '/../../config/database.php';

class Marca {
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
     * Obtener todas las marcas activas
     */
    public static function obtenerTodas() {
        $db = Database::getConnection();

        $sql = "SELECT * FROM marcas WHERE estado = 'activo' ORDER BY nombre ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener una marca por ID
     */
    public static function obtenerPorId($id) {
        $db = Database::getConnection();

        $sql = "SELECT * FROM marcas WHERE id = :id AND estado = 'activo'";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crear una nueva marca
     */
    public static function create($data) {
        $db = Database::getConnection();

        $sql = "INSERT INTO marcas (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);

        return $db->lastInsertId();
    }

    /**
     * Actualizar marca
     */
    public static function update($id, $data) {
        $db = Database::getConnection();

        $sql = "UPDATE marcas SET nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':descripcion' => $data['descripcion'] ?? null,
            ':estado' => $data['estado'] ?? 'activo'
        ]);
    }

    /**
     * Eliminar marca
     */
    public static function delete($id) {
        $db = Database::getConnection();

        $sql = "UPDATE marcas SET estado = 'inactivo' WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

