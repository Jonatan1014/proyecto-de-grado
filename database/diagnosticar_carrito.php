<?php
/**
 * Script de diagnóstico y migración del carrito
 * Este script verifica y corrige la estructura de la tabla carrito
 */

require_once __DIR__ . '/../src/config/database.php';

echo "=== DIAGNÓSTICO DE LA TABLA CARRITO ===\n\n";

try {
    $db = Database::getConnection();
    
    // 1. Verificar estructura actual de la tabla carrito
    echo "1. Verificando estructura actual de la tabla carrito...\n";
    $stmt = $db->query("DESCRIBE carrito");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nEstructura actual:\n";
    foreach ($columns as $col) {
        echo "  - {$col['Field']}: {$col['Type']} {$col['Null']} {$col['Key']}\n";
    }
    
    // 2. Verificar si usuario_id es VARCHAR o INT
    $usuarioIdColumn = null;
    foreach ($columns as $col) {
        if ($col['Field'] === 'usuario_id') {
            $usuarioIdColumn = $col;
            break;
        }
    }
    
    if (!$usuarioIdColumn) {
        echo "\n❌ ERROR: No se encontró la columna usuario_id\n";
        exit(1);
    }
    
    echo "\n2. Estado de la columna usuario_id:\n";
    echo "   Tipo: {$usuarioIdColumn['Type']}\n";
    
    $esVarchar = stripos($usuarioIdColumn['Type'], 'varchar') !== false;
    
    if ($esVarchar) {
        echo "   ✓ La columna ya es VARCHAR - NO se requiere migración\n\n";
    } else {
        echo "   ✗ La columna es {$usuarioIdColumn['Type']} - SE REQUIERE migración\n\n";
        
        // 3. Realizar migración
        echo "3. Iniciando migración...\n";
        
        // Verificar si hay datos en la tabla
        $stmt = $db->query("SELECT COUNT(*) as total FROM carrito");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        echo "   Registros existentes: $count\n";
        
        if ($count > 0) {
            echo "   ⚠ ADVERTENCIA: Hay $count registros en el carrito\n";
            echo "   La migración podría afectar datos existentes\n\n";
            
            // Mostrar datos actuales
            $stmt = $db->query("SELECT id, usuario_id, producto_id, cantidad FROM carrito LIMIT 5");
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "   Datos actuales (primeros 5):\n";
            foreach ($items as $item) {
                echo "     - ID: {$item['id']}, Usuario: {$item['usuario_id']}, Producto: {$item['producto_id']}, Cantidad: {$item['cantidad']}\n";
            }
            echo "\n";
        }
        
        echo "   Ejecutando ALTER TABLE...\n";
        
        try {
            $db->exec("ALTER TABLE carrito MODIFY COLUMN usuario_id VARCHAR(100) NOT NULL");
            echo "   ✓ Migración completada exitosamente\n\n";
            
            // Verificar cambio
            $stmt = $db->query("DESCRIBE carrito");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($columns as $col) {
                if ($col['Field'] === 'usuario_id') {
                    echo "   Nueva estructura: {$col['Field']} - {$col['Type']}\n";
                    break;
                }
            }
        } catch (PDOException $e) {
            echo "   ❌ Error en la migración: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    // 4. Prueba de inserción
    echo "\n4. Probando funcionalidad del carrito...\n";
    
    // Crear ID temporal de prueba
    $tempId = 'temp_' . uniqid() . '_' . time();
    echo "   ID temporal de prueba: $tempId\n";
    
    // Obtener un producto para probar
    $stmt = $db->query("SELECT id, precio FROM productos WHERE estado = 'activo' LIMIT 1");
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$producto) {
        echo "   ⚠ No hay productos disponibles para probar\n";
    } else {
        echo "   Producto de prueba: ID {$producto['id']}\n";
        
        // Intentar insertar
        try {
            $stmt = $db->prepare("INSERT INTO carrito (usuario_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$tempId, $producto['id'], 1, $producto['precio']]);
            $insertId = $db->lastInsertId();
            echo "   ✓ Inserción exitosa con ID temporal (registro #$insertId)\n";
            
            // Limpiar prueba
            $stmt = $db->prepare("DELETE FROM carrito WHERE id = ?");
            $stmt->execute([$insertId]);
            echo "   ✓ Registro de prueba eliminado\n";
            
        } catch (PDOException $e) {
            echo "   ❌ Error al insertar: " . $e->getMessage() . "\n";
            exit(1);
        }
    }
    
    echo "\n=== DIAGNÓSTICO COMPLETADO ===\n";
    echo "✓ La tabla carrito está lista para usar\n";
    echo "✓ Puede agregar productos al carrito sin problemas\n\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR GENERAL: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
