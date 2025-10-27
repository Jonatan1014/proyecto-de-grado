# �️ SOLUCIÓN AL ERROR DE CHECKOUT

## ❌ Problema Identificado

**Error:** `SQLSTATE[HY093]: Invalid parameter number`

**Causa:** El código estaba enviando parámetros incorrectos al modelo de Pedido:
- Se enviaba `'estado_id' => 1` pero el modelo esperaba `estado_pedido_id`
- Faltaba el campo `costo_envio` en la base de datos

## ✅ Solución Implementada

### 1. **Base de Datos**
Se agregó el campo `costo_envio` a la tabla `pedidos`:

```sql
ALTER TABLE `pedidos` ADD COLUMN `costo_envio` DECIMAL(10,2) DEFAULT 0.00 AFTER `impuestos`;
```

### 2. **CheckoutController.php**
Se corrigió el array de datos del pedido:

**ANTES:**
```php
$datosPedido = [
    'usuario_id' => $usuarioId,
    'total' => $total,
    'subtotal' => $subtotal,
    'impuestos' => $impuestos,
    'metodo_pago_id' => $metodoPagoId,
    'tipo_pedido' => 'online',
    'observaciones' => $observaciones,
    'items' => $items,
    'estado_id' => 1 // ❌ ERROR: Parámetro incorrecto
];
```

**DESPUÉS:**
```php
$datosPedido = [
    'usuario_id' => $usuarioId,
    'total' => $total,
    'subtotal' => $subtotal,
    'impuestos' => $impuestos,
    'envio' => $envio, // ✅ Se agregó el costo de envío
    'metodo_pago_id' => $metodoPagoId,
    'tipo_pedido' => 'online',
    'observaciones' => $observaciones,
    'items' => $items
];
```

### 3. **Modelo Pedido.php**
Se actualizó el INSERT para incluir el campo `costo_envio`:

```php
$sql = "INSERT INTO pedidos (
    numero_pedido, usuario_id, empleado_id, total, subtotal, 
    descuento, impuestos, costo_envio, metodo_pago_id, estado_pedido_id, 
    tipo_pedido, observaciones
) VALUES (
    :numero_pedido, :usuario_id, :empleado_id, :total, :subtotal,
    :descuento, :impuestos, :costo_envio, :metodo_pago_id, :estado_pedido_id,
    :tipo_pedido, :observaciones
)";

$stmt->execute([
    // ...
    ':costo_envio' => $datos['envio'] ?? 0,
    ':estado_pedido_id' => 1, // PENDIENTE por defecto
    // ...
]);
```

## � Flujo del Proceso de Pedido

### 1. **Cliente hace el pedido en checkout:**
```
Cliente → Selecciona productos → Checkout → Finalizar Pedido
```

### 2. **Sistema crea el pedido:**
- Estado: **PENDIENTE** (estado_pedido_id = 1)
- Se calcula: subtotal + IVA (19%) + envío
- Se genera número de pedido único: `PED-YYYYMMDD-XXXXXX`
- Se vacía el carrito del cliente

### 3. **Redirección a WhatsApp:**
```javascript
// En checkout.php después de crear el pedido
if (data.whatsapp_url) {
    if (confirm('¿Deseas enviar los detalles del pedido por WhatsApp?')) {
        window.open(data.whatsapp_url, '_blank');
    }
}
```

El mensaje de WhatsApp contiene:
- ✅ Número de pedido
- � Datos del cliente (ENCRIPTADOS)
- � Lista de productos con cantidades y precios
- � Dirección de envío (ENCRIPTADA)
- � Método de pago
- � Totales (Subtotal, IVA, Envío, Total)

### 4. **Cliente envía mensaje y realiza el pago:**
- Cliente abre WhatsApp con el mensaje pre-cargado
- Envía el mensaje al negocio
- Realiza el pago según el método seleccionado
- Envía comprobante de pago

### 5. **Empleado/Admin gestiona el pedido:**

#### Acceder a herramienta de desencriptación:
```
URL: http://localhost/mayra/src/public/admin-desencriptar
```

#### Cambiar estado del pedido:
El admin/empleado puede cambiar el estado desde el panel administrativo:

**Estados disponibles:**
1. � **PENDIENTE** - Pedido recién creado, esperando pago
2. � **CONFIRMADO** - Pago verificado
3. � **EN PREPARACIÓN** - Empacando productos
4. � **ENVIADO** - Pedido en camino
5. ✅ **ENTREGADO** - Cliente recibió el pedido
6. � **CANCELADO** - Pedido cancelado

### 6. **Cliente consulta su pedido:**
```
URL: http://localhost/mayra/src/public/pedido-detalle?id={PEDIDO_ID}
```

El cliente puede ver:
- Estado actual del pedido
- Productos ordenados
- Dirección de envío
- Método de pago
- Totales
- Fecha de pedido
- Historial de estados (si se implementa)

## � Configuración de WhatsApp

Edita `src/config/whatsapp.php`:

```php
// Cambiar al número real de WhatsApp Business
define('WHATSAPP_NUMERO', '573XXXXXXXXX'); // Tu número

// Cambiar la clave de encriptación (¡MUY IMPORTANTE!)
$clave = 'TuClaveSecreta123!@#$%^&*'; // Única y segura
```

## � Pruebas Recomendadas

1. ✅ Crear pedido en checkout
2. ✅ Verificar que se guarda en base de datos
3. ✅ Verificar que se abre WhatsApp con mensaje
4. ✅ Copiar datos encriptados del mensaje
5. ✅ Desencriptar en `/admin-desencriptar`
6. ✅ Cambiar estado del pedido desde panel admin
7. ✅ Ver detalle del pedido desde cliente
8. ✅ Verificar que el stock se reduce correctamente

## � Estructura de Base de Datos

### Tabla `pedidos`:
```
id, numero_pedido, usuario_id, empleado_id, 
total, subtotal, descuento, impuestos, costo_envio,
metodo_pago_id, estado_pedido_id, tipo_pedido,
fecha_pedido, fecha_envio, fecha_entrega, observaciones
```

### Tabla `estados_pedido`:
```
1 - Pendiente
2 - Confirmado
3 - En Preparación
4 - Enviado
5 - Entregado
6 - Cancelado
```

## � Resultado

Ahora el sistema:
✅ Crea pedidos correctamente sin errores SQL
✅ Redirige a WhatsApp con datos encriptados
✅ Permite al admin desencriptar y verificar
✅ Permite cambiar estados de pedidos
✅ Permite al cliente ver el estado de su compra
✅ Gestiona el inventario automáticamente

