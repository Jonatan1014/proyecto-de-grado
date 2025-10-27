# 📦 SISTEMA DE SEGUIMIENTO DE PEDIDOS
## Tennis y Zapatos - Documentación Completa

---

## 📋 ÍNDICE
1. [Descripción General](#descripción-general)
2. [Flujo del Sistema](#flujo-del-sistema)
3. [Componentes Creados](#componentes-creados)
4. [Funcionalidades](#funcionalidades)
5. [Uso del Sistema](#uso-del-sistema)
6. [Estados de Pedido](#estados-de-pedido)
7. [Estructura de Archivos](#estructura-de-archivos)

---

## 🎯 DESCRIPCIÓN GENERAL

El Sistema de Seguimiento de Pedidos permite a los clientes ver en tiempo real el estado de sus pedidos, mientras que los administradores y empleados pueden actualizar dichos estados de manera visual e intuitiva.

### **Características Principales:**

✅ **Para Clientes:**
- Vista de seguimiento con timeline visual
- Actualización en tiempo real del estado
- Información detallada del pedido
- Productos ordenados con imágenes
- Resumen de pago y envío

✅ **Para Admin/Empleado:**
- Interfaz para cambiar estados de pedidos
- Modal visual para actualizar estados
- Opción de agregar observaciones
- Vista completa de todos los pedidos
- Filtros por estado y búsqueda

---

## 🔄 FLUJO DEL SISTEMA

```
┌─────────────────────────────────────────────────────────────┐
│                    FLUJO DEL PEDIDO                         │
└─────────────────────────────────────────────────────────────┘

1. CLIENTE REALIZA PEDIDO
   ├── Checkout → Procesa pedido
   ├── Estado inicial: PENDIENTE (ID: 1)
   ├── Genera mensaje WhatsApp encriptado
   └── Redirige a confirmación

2. EMPLEADO/ADMIN RECIBE NOTIFICACIÓN
   ├── Desencripta datos de WhatsApp
   ├── Verifica pago
   └── Accede a panel admin/pedidos

3. ACTUALIZACIÓN DE ESTADOS
   ├── Admin selecciona pedido
   ├── Click en "Cambiar Estado"
   ├── Modal muestra estados disponibles
   ├── Selecciona nuevo estado
   ├── Agrega observaciones (opcional)
   └── Confirma cambio

4. CLIENTE VE SEGUIMIENTO
   ├── Accede desde perfil
   ├── Click en "Seguimiento"
   ├── Ve timeline visual con estado actual
   └── Recibe información detallada

┌─────────────────────────────────────────────────────────────┐
│                    ESTADOS DEL PEDIDO                        │
└─────────────────────────────────────────────────────────────┘

ID  │ Estado           │ Color      │ Descripción
────┼──────────────────┼────────────┼──────────────────────────
 1  │ 🕐 Pendiente      │ #ffc107   │ Esperando confirmación
 2  │ ✅ Confirmado     │ #17a2b8   │ Pedido confirmado
 3  │ 📦 En Preparación │ #fd7e14   │ Preparando el pedido
 4  │ 🚚 Enviado        │ #20c997   │ En camino al cliente
 5  │ ✔️ Entregado      │ #28a745   │ Pedido entregado
 6  │ ❌ Cancelado      │ #dc3545   │ Pedido cancelado
```

---

## 📁 COMPONENTES CREADOS

### **1. Vista de Seguimiento para Clientes**
**Archivo:** `src/app/Views/seguimiento-pedido.php`

**Características:**
- Timeline visual con animaciones
- Iconos por cada estado
- Estados completados, actual y pendientes
- Información del pedido
- Lista de productos ordenados
- Resumen de pago
- Botón "Volver a Mi Cuenta"

**Estilos CSS destacados:**
```css
- .timeline-container: Contenedor principal
- .timeline-item: Cada paso del timeline
- .timeline-icon: Iconos de estado
- .estado-actual: Animación pulse para estado actual
- .estado-completado: Estados ya pasados
- .estado-pendiente-icono: Estados futuros
```

---

### **2. Controlador de Seguimiento**
**Archivo:** `src/app/Controllers/SeguimientoPedidoController.php`

**Métodos:**

```php
index()
├── Verifica autenticación del cliente
├── Obtiene ID del pedido desde URL
├── Valida que el pedido pertenezca al usuario
├── Carga datos del pedido
└── Renderiza vista seguimiento-pedido.php

obtenerEstado() (API)
├── Endpoint: /api/seguimiento/estado?id={pedido_id}
├── Retorna JSON con estado actual
├── Usado para actualizaciones en tiempo real
└── Solo accesible por el dueño del pedido
```

---

### **3. Vista Admin de Pedidos (Mejorada)**
**Archivo:** `src/app/Views/admin/pedidos.php`

**Mejoras implementadas:**

✅ **Modal Cambiar Estado:**
- Muestra datos del pedido
- Select con emojis para estados
- Campo de observaciones
- Botones Cancelar/Actualizar

✅ **Función JavaScript mejorada:**
```javascript
cambiarEstado(pedidoId)
├── Encuentra pedido en datos
├── Llena modal con información
├── Muestra estado actual con badge
└── Abre modal

confirmarCambioEstado()
├── Valida cambio de estado
├── Recoge observaciones
├── Llama a actualizarEstadoPedido()
└── Cierra modal

actualizarEstadoPedido(pedidoId, estadoId, observaciones)
├── Crea FormData con datos
├── POST a /admin-pedidos-api?action=cambiar-estado
├── Muestra mensaje de éxito/error
└── Recarga lista de pedidos
```

---

### **4. Actualización del Perfil del Cliente**
**Archivo:** `src/app/Views/perfil.php`

**Cambios:**
- Botón "Seguimiento" agregado a cada pedido
- Link: `seguimiento-pedido?id={pedido_id}`
- Estilo: `btn-primary-custom`
- Icono: `ti-location-arrow`

---

### **5. Rutas Agregadas**
**Archivo:** `src/config/routes.php`

```php
// Rutas de seguimiento de pedidos
'/seguimiento-pedido' => [
    'controller' => 'SeguimientoPedidoController', 
    'action' => 'index'
],

'/api/seguimiento/estado' => [
    'controller' => 'SeguimientoPedidoController', 
    'action' => 'obtenerEstado'
],
```

---

## 🚀 FUNCIONALIDADES

### **PARA CLIENTES:**

#### **1. Ver Seguimiento del Pedido**
```
1. Cliente inicia sesión
2. Va a "Mi Cuenta" → "Historial de Pedidos"
3. Click en botón "Seguimiento" del pedido
4. Ve timeline visual con:
   - Estado actual destacado (con animación)
   - Estados completados (icono completo)
   - Estados pendientes (icono transparente)
   - Fecha y hora de cada cambio
5. Ve detalles del pedido:
   - Productos ordenados
   - Total a pagar
   - Información de envío
```

#### **2. Actualización Automática**
- El estado se carga desde la base de datos
- Cada vez que admin cambia estado, cliente ve cambio inmediato
- Timeline se ajusta automáticamente

---

### **PARA ADMIN/EMPLEADO:**

#### **1. Cambiar Estado de Pedido**
```
1. Login como administrador o empleado
2. Ir a "Pedidos" en panel admin
3. Buscar pedido (por número o cliente)
4. Click en botón verde "Cambiar Estado"
5. En el modal:
   - Ver datos del pedido
   - Seleccionar nuevo estado del dropdown
   - Agregar observaciones (opcional)
6. Click en "Actualizar Estado"
7. Confirmación visual
8. Lista se actualiza automáticamente
```

#### **2. Estados Disponibles en Modal**
```
🕐 Pendiente       → Pedido recibido, esperando confirmación
✅ Confirmado      → Pago verificado, pedido confirmado
📦 En Preparación  → Empacando productos
🚚 Enviado         → Pedido en camino
✔️ Entregado       → Cliente recibió el pedido
❌ Cancelado       → Pedido cancelado
```

---

## 📊 ESTADOS DE PEDIDO

| ID | Estado | Color | Cuándo Usar | Siguiente Estado |
|----|--------|-------|-------------|------------------|
| 1 | Pendiente | Amarillo | Al crear pedido | Confirmado |
| 2 | Confirmado | Azul claro | Tras verificar pago | En Preparación |
| 3 | En Preparación | Naranja | Empacando productos | Enviado |
| 4 | Enviado | Verde agua | Pedido despachado | Entregado |
| 5 | Entregado | Verde | Cliente recibió | FIN |
| 6 | Cancelado | Rojo | Si se cancela | FIN |

---

## 📂 ESTRUCTURA DE ARCHIVOS

```
src/
├── app/
│   ├── Controllers/
│   │   ├── AdminController.php          (Ya existía - API cambiar-estado)
│   │   └── SeguimientoPedidoController.php  ✅ NUEVO
│   │
│   ├── Models/
│   │   └── Pedido.php                   (Ya existía - Métodos usados)
│   │
│   └── Views/
│       ├── perfil.php                   ✅ MODIFICADO (botón seguimiento)
│       ├── seguimiento-pedido.php       ✅ NUEVO
│       └── admin/
│           └── pedidos.php              ✅ MODIFICADO (modal mejorado)
│
└── config/
    └── routes.php                       ✅ MODIFICADO (rutas agregadas)

docs/
└── SISTEMA_SEGUIMIENTO_PEDIDOS.md       ✅ NUEVO (este archivo)
```

---

## 🎨 DISEÑO VISUAL

### **Timeline del Cliente**
```
        🕐
        │
   ┌────┴────┐
   │ PENDIENTE │  ← Completado (verde)
   └─────────┘
        │
        🔽
        │
   ┌────┴────┐
   │CONFIRMADO│  ← ACTUAL (animación pulse, dorado)
   └─────────┘
        │
        🔽
        │
   ┌────┴────┐
   │EN PREP.  │  ← Pendiente (gris transparente)
   └─────────┘
```

### **Modal Admin**
```
╔═══════════════════════════════════════╗
║  Cambiar Estado del Pedido            ║
╠═══════════════════════════════════════╣
║                                       ║
║  Pedido: PED-20250126-ABC123         ║
║  Cliente: Juan Pérez                  ║
║  Estado Actual: [Pendiente]           ║
║                                       ║
║  Nuevo Estado:                        ║
║  ┌─────────────────────────────┐     ║
║  │ ✅ Confirmado              ▼│     ║
║  └─────────────────────────────┘     ║
║                                       ║
║  Observaciones:                       ║
║  ┌─────────────────────────────┐     ║
║  │ Pago verificado...          │     ║
║  └─────────────────────────────┘     ║
║                                       ║
║      [Cancelar] [✓ Actualizar Estado]║
╚═══════════════════════════════════════╝
```

---

## 🔐 SEGURIDAD

### **Validaciones Implementadas:**

✅ **Cliente:**
- Solo puede ver SUS propios pedidos
- Verificación de usuario_id en base de datos
- Redirección a login si no autenticado

✅ **Admin/Empleado:**
- Verificación de rol (administrador o empleado)
- Token de sesión validado
- Solo puede cambiar estados si está autenticado

✅ **Base de Datos:**
- Consultas con prepared statements
- Validación de IDs
- Transacciones para cambios de estado

---

## 🧪 PRUEBAS

### **Como probar el sistema:**

#### **1. Crear un pedido:**
```
1. Login como cliente
2. Agregar productos al carrito
3. Ir a checkout
4. Completar formulario
5. Finalizar pedido
6. Verificar que estado inicial es "Pendiente"
```

#### **2. Cambiar estado (Admin):**
```
1. Login como admin/empleado
2. Ir a admin-pedidos
3. Buscar el pedido recién creado
4. Click en "Cambiar Estado"
5. Seleccionar "Confirmado"
6. Agregar observación: "Pago verificado"
7. Guardar
```

#### **3. Ver seguimiento (Cliente):**
```
1. Volver a login como cliente
2. Ir a perfil
3. Click en "Seguimiento" del pedido
4. Verificar que muestra:
   - Timeline con "Pendiente" completado
   - "Confirmado" como actual (con animación)
   - "En Preparación" como pendiente
```

---

## 📝 NOTAS TÉCNICAS

### **Base de Datos:**
- Tabla: `pedidos`
- Campo clave: `estado_pedido_id` (FK a `estados_pedido`)
- Campo: `observaciones` (TEXT, opcional)

### **API Endpoints:**

| Método | URL | Descripción | Rol |
|--------|-----|-------------|-----|
| GET | `/seguimiento-pedido?id={id}` | Ver timeline del pedido | Cliente |
| GET | `/api/seguimiento/estado?id={id}` | JSON con estado actual | Cliente |
| POST | `/admin-pedidos-api?action=cambiar-estado` | Cambiar estado | Admin/Empleado |

### **Parámetros POST cambiar-estado:**
```php
pedido_id: int       // ID del pedido
estado_id: int       // Nuevo estado (1-6)
observaciones: text  // Opcional
```

---

## 🎯 PRÓXIMAS MEJORAS SUGERIDAS

1. **Notificaciones Email:**
   - Enviar email al cliente cuando cambia estado
   - Template personalizado por estado

2. **Historial de Cambios:**
   - Tabla `historial_estados_pedido`
   - Registrar quién cambió y cuándo
   - Mostrar timeline con fechas reales

3. **WhatsApp Notifications:**
   - Mensaje automático al cliente
   - Actualización de estado por WhatsApp

4. **Dashboard Analytics:**
   - Gráficas de estados
   - Tiempo promedio por estado
   - Pedidos pendientes alertas

---

## ✅ RESUMEN DE IMPLEMENTACIÓN

### **Archivos Creados:**
1. ✅ `src/app/Views/seguimiento-pedido.php` (543 líneas)
2. ✅ `src/app/Controllers/SeguimientoPedidoController.php` (102 líneas)
3. ✅ `docs/SISTEMA_SEGUIMIENTO_PEDIDOS.md` (este archivo)

### **Archivos Modificados:**
1. ✅ `src/app/Views/perfil.php` (botón seguimiento agregado)
2. ✅ `src/app/Views/admin/pedidos.php` (modal mejorado)
3. ✅ `src/config/routes.php` (2 rutas agregadas)

### **Funcionalidad Existente Utilizada:**
1. ✅ `AdminController::pedidosApi()` (action: cambiar-estado)
2. ✅ `Pedido::obtenerDetalle()` (obtener info pedido)
3. ✅ `Pedido::obtenerItems()` (productos del pedido)
4. ✅ `Pedido::actualizarEstado()` (cambiar estado en BD)

---

## 📞 SOPORTE

Para cualquier duda sobre el sistema:
1. Revisar esta documentación
2. Verificar logs en navegador (Consola F12)
3. Revisar logs PHP del servidor
4. Verificar tabla `estados_pedido` en BD

---

**🎉 Sistema de Seguimiento de Pedidos - Implementado con éxito!**

*Documentación creada: 26 de Octubre 2025*
