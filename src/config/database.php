<?php
// src/config/database.php

require_once __DIR__ . '/config.php';

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (!self::$connection) {
            // Determinar el entorno
            $environment = $_ENV['APP_ENV'] ?? 'local';

            if ($environment === 'production') {
                // Configuración de producción
                $host = $_ENV['DB_HOST_PROD'] ?? 'localhost';
                $db_name = $_ENV['DB_NAME_PROD'] ?? 'clinic_db';
                $username = $_ENV['DB_USER_PROD'] ?? 'root';
                $password = $_ENV['DB_PASS_PROD'] ?? '';
            } else {
                // Configuración de desarrollo/local
                $host = $_ENV['DB_HOST_LOCAL'] ?? 'localhost';
                $db_name = $_ENV['DB_NAME_LOCAL'] ?? 'clinic_db';
                $username = $_ENV['DB_USER_LOCAL'] ?? 'root';
                $password = $_ENV['DB_PASS_LOCAL'] ?? '';
            }

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
                error_log("Error de conexión a la base de datos: " . $e->getMessage());
                die("Error de conexión a la base de datos. Por favor, inténtelo más tarde.");
            }
        }
        return self::$connection;
    }
}