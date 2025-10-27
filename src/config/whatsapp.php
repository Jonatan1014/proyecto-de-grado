<?php
/**
 * =============================================================================
 * CONFIGURACIÓN DE WHATSAPP
 * Ubicación: src/config/whatsapp.php
 * =============================================================================
 */

// Configuración de WhatsApp Business
define('WHATSAPP_NUMERO', '573174466432'); // Cambiar por el número real del negocio
define('WHATSAPP_NOMBRE_NEGOCIO', 'Tennis y Zapatos');
define('WHATSAPP_MENSAJE_BIENVENIDA', '¡Gracias por tu compra! 🛍️');

/**
 * Encriptar datos sensibles
 * Usa AES-256-CBC para mayor seguridad
 */
function encriptarDatos($datos) {
    $clave = 'TennisYZapatos2025!SecretKey'; // Cambiar por una clave segura única
    $metodo = 'AES-256-CBC';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));
    
    $datosEncriptados = openssl_encrypt($datos, $metodo, $clave, 0, $iv);
    
    // Combinar IV con datos encriptados
    return base64_encode($iv . $datosEncriptados);
}

/**
 * Desencriptar datos
 */
function desencriptarDatos($datosEncriptados) {
    $clave = 'TennisYZapatos2025!SecretKey'; // Misma clave usada para encriptar
    $metodo = 'AES-256-CBC';
    
    $datos = base64_decode($datosEncriptados);
    $ivLength = openssl_cipher_iv_length($metodo);
    $iv = substr($datos, 0, $ivLength);
    $datosEncriptados = substr($datos, $ivLength);
    
    return openssl_decrypt($datosEncriptados, $metodo, $clave, 0, $iv);
}

/**
 * Formatear precio para WhatsApp
 */
function formatearPrecioWhatsApp($precio) {
    return '$' . number_format($precio, 0, ',', '.');
}
