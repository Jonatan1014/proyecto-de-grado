# 📱 Sistema de Pedidos por WhatsApp - Tennis y Zapatos

## 🔒 Seguridad y Encriptación

### Descripción del Sistema

Este sistema implementa un flujo de pedidos seguro que integra WhatsApp para la confirmación de pagos:

1. **Cliente realiza el pedido** en la página web
2. **Sistema registra el pedido** con estado "PENDIENTE"
3. **Se genera mensaje de WhatsApp** con datos encriptados
4. **Cliente envía mensaje** con detalles del pedido
5. **Empleado/Admin confirma pago** y cambia estado del pedido

---

## 🔐 Encriptación de Datos

### ¿Qué datos se encriptan?

- **Datos del Cliente**: Nombre, email, teléfono
- **Dirección de Envío**: Dirección completa, ciudad, departamento, código postal

### Algoritmo de Encriptación

- **Método**: AES-256-CBC
- **Seguridad**: Alta
- **Reversible**: Sí (solo con la clave correcta)

---

## 📋 Flujo del Proceso

### 1. Cliente Finaliza Compra

```
checkout.php → Formulario de pago → Botón "Finalizar Pedido"
```

**Acciones:**
- Valida dirección de envío
- Valida método de pago
- Crea pedido en base de datos con estado "PENDIENTE"
- Genera URL de WhatsApp con mensaje encriptado
- Abre WhatsApp automáticamente

### 2. Mensaje de WhatsApp

El mensaje incluye:

```
🛍️ TENNIS Y ZAPATOS
¡Gracias por tu compra! 🛍️

━━━━━━━━━━━━━━━━
📋 PEDIDO: PED-20251026-ABC123
━━━━━━━━━━━━━━━━

👤 DATOS DEL CLIENTE
(Datos encriptados por seguridad)
```U2FsdGVkX1...```

📦 PRODUCTOS SOLICITADOS
1. Nike Air Max 270
   • Cantidad: 2 unidad(es)
   • Precio unitario: $329.000
   • Subtotal: $658.000

📍 DIRECCIÓN DE ENVÍO
(Datos encriptados por seguridad)
```U2FsdGVkX1...```

💳 MÉTODO DE PAGO
Transferencia Bancaria

💰 RESUMEN DE PAGO
Subtotal: $658.000
IVA (19%): $125.020
Envío: GRATIS ✅
━━━━━━━━━━━━━━━━
🏷️ TOTAL A PAGAR
*$783.020*

⏳ Estado: PENDIENTE
```

### 3. Cliente Envía Comprobante

El cliente:
1. Recibe el mensaje automáticamente
2. Realiza el pago
3. Responde en WhatsApp con el comprobante
4. Espera confirmación

### 4. Empleado Procesa el Pedido

**Acceso al Panel Admin:**
```
/admin-pedidos
```

**Acciones disponibles:**
- Ver todos los pedidos pendientes
- Desencriptar datos del cliente
- Verificar comprobante de pago
- Cambiar estado del pedido a "CONFIRMADO"
- Procesar envío

---

## 🔓 Desencriptar Datos

### Opción 1: Herramienta Web (Recomendado)

**URL:** `/admin-desencriptar`

**Pasos:**
1. Abre WhatsApp y encuentra el mensaje del pedido
2. Copia el texto entre ``` (backticks)
3. Pega en la herramienta de desencriptación
4. Haz clic en "Desencriptar Datos"
5. Ver información en texto plano

### Opción 2: Manual (PHP)

```php
<?php
require_once 'config/whatsapp.php';

$datosEncriptados = "U2FsdGVkX1..."; // Texto copiado de WhatsApp
$datosDesencriptados = desencriptarDatos($datosEncriptados);

echo $datosDesencriptados;
?>
```

---

## 🔧 Configuración

### Archivo: `src/config/whatsapp.php`

```php
// Número de WhatsApp Business (cambiar por el real)
define('WHATSAPP_NUMERO', '573001234567');

// Nombre del negocio
define('WHATSAPP_NOMBRE_NEGOCIO', 'Tennis y Zapatos');

// Clave de encriptación (CAMBIAR POR UNA ÚNICA Y SEGURA)
$clave = 'TennisYZapatos2025!SecretKey';
```

⚠️ **IMPORTANTE**: Cambia la clave de encriptación a una única para tu aplicación.

---

## 📊 Estados de Pedido

| ID | Estado | Descripción | Color |
|----|--------|-------------|-------|
| 1 | Pendiente | Esperando confirmación de pago | 🟡 Amarillo |
| 2 | Confirmado | Pago verificado | 🔵 Azul |
| 3 | En Preparación | Preparando el pedido | 🟠 Naranja |
| 4 | Enviado | Pedido en camino | 🟢 Verde claro |
| 5 | Entregado | Pedido completado | ✅ Verde |
| 6 | Cancelado | Pedido cancelado | 🔴 Rojo |

---

## 🛡️ Seguridad

### Medidas Implementadas

1. **Encriptación AES-256-CBC**: Máxima seguridad para datos sensibles
2. **HTTPS Recomendado**: Para transmisión segura
3. **Sesiones PHP**: Autenticación de usuarios
4. **Validación de Roles**: Solo admin/empleado puede desencriptar
5. **Logs de Errores**: Registro de actividad sospechosa
6. **Sanitización de Datos**: Prevención de inyección SQL/XSS

### Mejores Prácticas

- ✅ Cambia la clave de encriptación regularmente
- ✅ No compartas la clave con terceros
- ✅ Usa HTTPS en producción
- ✅ Mantén actualizadas las dependencias
- ✅ Realiza backups regulares de la base de datos
- ✅ Implementa rate limiting en endpoints críticos

---

## 🚀 Instalación

### Paso 1: Configurar WhatsApp

1. Abre `src/config/whatsapp.php`
2. Cambia `WHATSAPP_NUMERO` por tu número real
3. Formato: Código país + número (sin espacios, guiones ni +)
   - Ejemplo: `573001234567` para Colombia

### Paso 2: Cambiar Clave de Encriptación

```php
// En whatsapp.php, línea 12
$clave = 'TuClaveSeguraUnica123!@#$%';
```

⚠️ **La misma clave debe usarse para encriptar y desencriptar**

### Paso 3: Configurar Rutas

Las rutas ya están configuradas en `src/config/routes.php`:
- `/admin-desencriptar` → Herramienta de desencriptación
- `/api/desencriptar-datos` → API para desencriptar

### Paso 4: Permisos

Asegúrate de que el panel admin sea accesible solo para:
- Administradores
- Empleados

---

## 📝 Uso para Empleados

### Ver Pedidos Pendientes

1. Accede a `/admin-pedidos`
2. Filtra por estado "Pendiente"
3. Verás lista de pedidos esperando confirmación

### Desencriptar Información del Cliente

**Método A: Herramienta Web**
1. Ve a `/admin-desencriptar`
2. Copia el texto encriptado de WhatsApp
3. Pega y desencripta

**Método B: Vista de Pedido**
1. Abre el detalle del pedido
2. Clic en "Ver datos del cliente"
3. Se desencripta automáticamente

### Confirmar Pago

1. Verifica el comprobante de pago en WhatsApp
2. Confirma el monto
3. Cambia estado del pedido a "CONFIRMADO"
4. El cliente recibe notificación

---

## 🐛 Solución de Problemas

### El mensaje de WhatsApp no se abre

**Posibles causas:**
- Número de WhatsApp mal configurado
- Navegador bloqueó popup
- WhatsApp no instalado en dispositivo móvil

**Solución:**
1. Verifica `WHATSAPP_NUMERO` en `whatsapp.php`
2. Permite popups en el navegador
3. Usa WhatsApp Web como alternativa

### No se puede desencriptar

**Posibles causas:**
- Clave de encriptación cambiada
- Datos copiados incorrectamente
- Caracteres especiales perdidos

**Solución:**
1. Verifica que la clave no haya cambiado
2. Copia todo el texto entre ```
3. No modifiques el texto copiado

### Pedido no se crea

**Posibles causas:**
- Carrito vacío
- Stock insuficiente
- Error en base de datos

**Solución:**
1. Revisa logs de error
2. Verifica stock de productos
3. Comprueba conexión a BD

---

## 📞 Soporte

Para más ayuda:
- Email: soporte@tennisyzapatos.com
- WhatsApp: +57 300 123 4567
- Panel Admin: /admin-dashboard

---

**Versión:** 1.0.0  
**Última actualización:** 26 de octubre de 2025  
**Desarrollado por:** Tennis y Zapatos Dev Team
