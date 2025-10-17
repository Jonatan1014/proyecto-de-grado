<?php
// src/app/Models/Dashboard.php

require_once __DIR__ . '/../../config/database.php';

class Dashboard {

    private static $cacheFile = __DIR__ . '/../../cache/dashboard_stats.json'; // Carpeta cache en la raíz del proyecto
    private static $cacheExpirySeconds = 300; // 5 minutos (300 segundos)

    public static function getStats() {
        // 1. ✅ Verificar si hay datos en caché válidos
        $cachedData = self::getCachedStats();
        if ($cachedData !== false) {
            // Si los datos están en caché y no han expirado, devolverlos
            error_log("Dashboard: Cargando estadísticas desde caché.");
            return $cachedData;
        }

        error_log("Dashboard: Caché vacía o expirada. Ejecutando consultas SQL...");

        // 2. Si no hay caché o está expirada, ejecutar las consultas SQL
        $db = Database::getConnection();

        $stats = []; // Array para almacenar todas las estadísticas

        try {
            // Contar pacientes
            $stmt = $db->query("SELECT COUNT(*) AS total FROM patients");
            $stats['totalPacientes'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar citas
            $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments");
            $stats['totalCitas'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar citas completadas
            $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments WHERE status = 'completed'");
            $stats['citasCompletadas'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar citas pendientes
            $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments WHERE status = 'scheduled'");
            $stats['citasPendientes'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar citas canceladas
            $stmt = $db->query("SELECT COUNT(*) AS total FROM appointments WHERE status = 'cancelled'");
            $stats['citasCanceladas'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar doctores
            $stmt = $db->query("SELECT COUNT(*) AS total FROM doctors");
            $stats['totalDoctores'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar servicios activos
            $stmt = $db->query("SELECT COUNT(*) AS total FROM services WHERE status = 'active'");
            $stats['totalServicios'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Contar historias clínicas
            $stmt = $db->query("SELECT COUNT(*) AS total FROM dental_clinical_records");
            $stats['totalHistoriales'] = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Ingresos estimados (basado en citas completadas y servicios)
            $stmt = $db->query("
                SELECT SUM(s.price) AS total
                FROM appointments a
                JOIN services s ON a.service_id = s.id
                WHERE a.status = 'completed'
            ");
            $stats['ingresosCompletados'] = (float)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

            // Ingresos pendientes (basado en citas programadas y servicios)
            $stmt = $db->query("
                SELECT SUM(s.price) AS total
                FROM appointments a
                JOIN services s ON a.service_id = s.id
                WHERE a.status = 'scheduled'
            ");
            $stats['ingresosPendientes'] = (float)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

            // Servicios más solicitados
            $stmt = $db->query("
                SELECT s.name, COUNT(a.id) AS count
                FROM appointments a
                JOIN services s ON a.service_id = s.id
                GROUP BY s.id
                ORDER BY count DESC
                LIMIT 5
            ");
            $stats['serviciosPopulares'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Doctores con más citas
            $stmt = $db->query("
                SELECT d.name, COUNT(a.id) AS count
                FROM appointments a
                JOIN doctors d ON a.doctor_id = d.id
                GROUP BY d.id
                ORDER BY count DESC
                LIMIT 5
            ");
            $stats['doctoresConMasCitas'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Pacientes por género
            $stmt = $db->query("
                SELECT gender, COUNT(*) AS count
                FROM patients
                GROUP BY gender
            ");
            $stats['pacientesPorGenero'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Citas por estado
            $stmt = $db->query("
                SELECT status, COUNT(*) AS count
                FROM appointments
                GROUP BY status
            ");
            $stats['citasPorEstado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            error_log("Error al obtener estadísticas del dashboard: " . $e->getMessage());
            // Devolver un array vacío o con valores por defecto en caso de error
            return [
                'totalPacientes' => 0,
                'totalCitas' => 0,
                'citasCompletadas' => 0,
                'citasPendientes' => 0,
                'citasCanceladas' => 0,
                'totalDoctores' => 0,
                'totalServicios' => 0,
                'totalHistoriales' => 0,
                'ingresosCompletados' => 0,
                'ingresosPendientes' => 0,
                'serviciosPopulares' => [],
                'doctoresConMasCitas' => [],
                'pacientesPorGenero' => [],
                'citasPorEstado' => []
            ];
        }

        // 3. ✅ Guardar los resultados en caché
        self::cacheStats($stats);

        error_log("Dashboard: Estadísticas calculadas y guardadas en caché.");
        return $stats;
    }

    /**
     * Obtiene las estadísticas desde el archivo de caché si es válido.
     * @return array|false
     */
    private static function getCachedStats() {
        if (!file_exists(self::$cacheFile)) {
            return false; // No existe el archivo de caché
        }

        $cacheTime = filemtime(self::$cacheFile);
        $currentTime = time();

        // Verificar si la caché ha expirado
        if (($currentTime - $cacheTime) > self::$cacheExpirySeconds) {
            error_log("Dashboard: Caché expirada. Tiempo actual: $currentTime, Tiempo caché: $cacheTime, Diferencia: " . ($currentTime - $cacheTime));
            return false; // La caché ha expirado
        }

        $cachedContent = file_get_contents(self::$cacheFile);
        if ($cachedContent === false) {
            return false; // Error al leer el archivo
        }

        $data = json_decode($cachedContent, true);

        // Verificar si json_decode fue exitoso y si los datos tienen la estructura esperada
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            error_log("Dashboard: Error al decodificar caché o datos inválidos.");
            return false;
        }

        return $data; // Devolver datos desde caché
    }

    /**
     * Guarda las estadísticas en un archivo de caché.
     * @param array $data
     */
    private static function cacheStats($data) {
        // Asegurarse de que la carpeta cache exista
        $cacheDir = dirname(self::$cacheFile);
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true); // Crear directorio recursivamente si no existe
        }

        $jsonData = json_encode($data);
        if ($jsonData === false) {
            error_log("Dashboard: Error al codificar datos para caché. JSON Error: " . json_last_error_msg());
            return;
        }

        $result = file_put_contents(self::$cacheFile, $jsonData, LOCK_EX); // LOCK_EX para escritura segura
        if ($result === false) {
            error_log("Dashboard: Error al guardar caché en el archivo: " . self::$cacheFile);
        } else {
            error_log("Dashboard: Caché guardada exitosamente.");
        }
    }

    /**
     * Opcional: Método para limpiar la caché manualmente si es necesario.
     */
    public static function clearCache() {
        if (file_exists(self::$cacheFile)) {
            unlink(self::$cacheFile);
            error_log("Dashboard: Caché eliminada manualmente.");
        }
    }
}