<?php
// src/app/Utils/Helpers.php

/**
 * Formatear precio en moneda colombiana
 */
function formatearPrecio($precio) {
    return '$' . number_format($precio, 0, ',', '.');
}

/**
 * Calcular descuento porcentual
 */
function calcularDescuento($precioOriginal, $precioOferta) {
    if ($precioOriginal <= 0 || $precioOferta >= $precioOriginal) {
        return 0;
    }
    return round((($precioOriginal - $precioOferta) / $precioOriginal) * 100);
}

/**
 * Obtener imagen del producto o imagen por defecto
 */
function obtenerImagenProducto($producto, $porDefecto = 'img/product/default.jpg') {
    // Si es un array de producto
    if (is_array($producto)) {
        $imagen = $producto['imagen_principal'] ?? null;
    } else {
        // Si es solo la ruta de la imagen
        $imagen = $producto;
    }
    
    if (!empty($imagen)) {
        return $imagen;
    }
    return $porDefecto;
}

/**
 * Verificar si un producto tiene descuento
 */
function tieneDescuento($producto) {
    if (is_array($producto)) {
        return !empty($producto['precio_oferta']) && $producto['precio_oferta'] > 0 && $producto['precio_oferta'] < $producto['precio'];
    }
    return false;
}

/**
 * Calcular precio original cuando hay descuento
 */
function calcularPrecioOriginal($producto) {
    if (is_array($producto) && isset($producto['precio'])) {
        return $producto['precio'];
    }
    return 0;
}

/**
 * Truncar texto
 */
function truncarTexto($texto, $limite = 100, $sufijo = '...') {
    if (strlen($texto) <= $limite) {
        return $texto;
    }
    return substr($texto, 0, $limite) . $sufijo;
}

/**
 * Generar estrellas de rating
 */
function generarEstrellas($rating, $maxEstrellas = 5) {
    $html = '';
    $ratingRedondeado = round($rating * 2) / 2; // Redondear a media estrella

    for ($i = 1; $i <= $maxEstrellas; $i++) {
        if ($i <= $ratingRedondeado) {
            $html .= '<i class="fa fa-star"></i>';
        } elseif ($i - 0.5 == $ratingRedondeado) {
            $html .= '<i class="fa fa-star-half-o"></i>';
        } else {
            $html .= '<i class="fa fa-star-o"></i>';
        }
    }

    return $html;
}

/**
 * Formatear fecha
 */
function formatearFecha($fecha, $formato = 'd/m/Y') {
    return date($formato, strtotime($fecha));
}

/**
 * Generar URL amigable
 */
function generarSlug($texto) {
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);
    $texto = trim($texto, '-');
    return $texto;
}

/**
 * Obtener clase de badge de stock
 */
function obtenerClaseStock($stock, $stockMinimo) {
    if ($stock <= 0) {
        return 'badge-danger';
    } elseif ($stock <= $stockMinimo) {
        return 'badge-warning';
    }
    return 'badge-success';
}

/**
 * Obtener texto de stock
 */
function obtenerTextoStock($stock, $stockMinimo) {
    if ($stock <= 0) {
        return 'Agotado';
    } elseif ($stock <= $stockMinimo) {
        return 'Pocas unidades';
    }
    return 'Disponible';
}

/**
 * Limpiar entrada de usuario (seguridad)
 */
function limpiarEntrada($dato) {
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

/**
 * Generar URL de producto
 */
function urlProducto($id, $nombre = '') {
    $slug = !empty($nombre) ? generarSlug($nombre) : '';
    return "/producto?id={$id}" . (!empty($slug) ? "&nombre={$slug}" : '');
}

/**
 * Generar URL de categoría
 */
function urlCategoria($id, $nombre = '') {
    $slug = !empty($nombre) ? generarSlug($nombre) : '';
    return "/category?categoria={$id}" . (!empty($slug) ? "&nombre={$slug}" : '');
}

/**
 * Verificar si la imagen existe
 */
function imagenExiste($ruta) {
    $rutaCompleta = __DIR__ . '/../../public/' . $ruta;
    return file_exists($rutaCompleta);
}

/**
 * Obtener asset URL
 */
function asset($ruta) {
    return '/' . ltrim($ruta, '/');
}
