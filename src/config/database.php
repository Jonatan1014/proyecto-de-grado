<?php
// src/config/database.php

require_once __DIR__ . '/config.php';

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (!self::$connection) {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $db_name = $_ENV['DB_NAME'] ?? 'clinic_db';
            $username = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASS'] ?? '';

            try {
                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$db_name;charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}