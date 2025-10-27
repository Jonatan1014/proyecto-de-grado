# 🛒 Sistema E-Commerce de Tenis y Zapatos

## 📋 Índice
1. [Descripción General](#descripción-general)
2. [Arquitectura del Sistema](#arquitectura-del-sistema)
3. [Flujo Completo del Cliente](#flujo-completo-del-cliente)
4. [Sistema de Gestión Administrativa](#sistema-de-gestión-administrativa)
5. [Seguimiento de Pedidos](#seguimiento-de-pedidos)
6. [Integración con WhatsApp](#integración-con-whatsapp)
7. [Tecnologías Utilizadas](#tecnologías-utilizadas)
8. [Instalación y Configuración](#instalación-y-configuración)

---

## 🎯 Descripción General

Sistema completo de comercio electrónico desarrollado con arquitectura MVC en PHP para la venta de tenis y zapatos. El sistema permite a los clientes navegar por productos, realizar compras mediante WhatsApp, y hacer seguimiento en tiempo real del estado de sus pedidos. Los administradores y empleados pueden gestionar todo el inventario, pedidos, clientes, marcas y categorías desde un panel administrativo completo.

---

## 🏗️ Arquitectura del Sistema

### Estructura MVC (Model-View-Controller)

```
src/
├── app/
│   ├── Controllers/        # Lógica de negocio
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── SeguimientoPedidoController.php
│   │   └── ...
│   ├── Models/            # Interacción con base de datos
│   │   ├── User.php
│   │   ├── Producto.php
│   │   ├── Pedido.php
│   │   └── ...
│   ├── Services/          # Servicios auxiliares
│   │   └── AuthService.php
│   ├── Utils/             # Utilidades
│   │   ├── Conexion.php
│   │   └── Validador.php
│   └── Views/             # Interfaces de usuario
│       ├── home.php
│       ├── cart.php
│       ├── checkout.php
│       ├── seguimiento-pedido.php
│       └── admin/         # Panel administrativo
├── config/                # Configuraciones
│   ├── config.php
│   ├── database.php
│   └── routes.php
└── public/                # Punto de entrada
    ├── index.php
    └── assets/           # Recursos estáticos
```

### Base de Datos

- **Motor**: MySQL
- **Base de datos**: `tennisyzapatos_db`
- **Tablas principales**:
  - `usuarios` - Clientes, empleados y administradores
  - `productos` - Catálogo de productos
  - `categorias` - Categorías de productos
  - `marcas` - Marcas de productos
  - `pedidos` - Órdenes de compra
  - `detalle_pedidos` - Items de cada pedido
  - `estados_pedido` - Estados del flujo de pedidos

---

## 🛍️ Flujo Completo del Cliente

### 1. **Navegación y Exploración de Productos**

#### 1.1 Página de Inicio (Home)
Cuando el cliente ingresa al sitio, se encuentra con:

```
┌─────────────────────────────────────────────────────┐
│  🏠 INICIO                                          │
├─────────────────────────────────────────────────────┤
│  📸 Banner Principal con Promociones                │
│  ⭐ Productos Destacados                            │
│  🔥 Ofertas Especiales                              │
│  🏷️ Categorías Principales                          │
└─────────────────────────────────────────────────────┘
```

**Funcionalidades**:
- Visualización de productos destacados con imágenes
- Filtros rápidos por categoría
- Búsqueda de productos
- Banner de promociones

**Código Backend** (`home.php`):
```php
// Obtiene productos activos del catálogo
$productos = Producto::obtenerTodos(null, 'activo');
// Muestra cards con imagen, nombre, precio y botón "Añadir al carrito"
```

#### 1.2 Catálogo de Productos
El cliente puede navegar por el catálogo completo:

**Filtros disponibles**:
- 🔍 Búsqueda por nombre
- 📂 Categoría (Deportivos, Casuales, Formales, etc.)
- 🏷️ Marca (Nike, Adidas, Puma, etc.)
- 💰 Rango de precios
- ⭐ Disponibilidad

**Visualización**:
```
┌──────────────┬──────────────┬──────────────┐
│  🖼️ Producto  │  🖼️ Producto  │  🖼️ Producto  │
│  Nike Air    │  Adidas Run  │  Puma Speed  │
│  $350.000    │  $280.000    │  $420.000    │
│  [🛒 Añadir] │  [🛒 Añadir] │  [🛒 Añadir] │
└──────────────┴──────────────┴──────────────┘
```

#### 1.3 Detalle del Producto
Al hacer clic en un producto, el cliente ve:

```
┌─────────────────────────────────────────────────────┐
│  📸 Galería de Imágenes (Principal + Miniaturas)    │
├─────────────────────────────────────────────────────┤
│  Nombre: Nike Air Max 2024                         │
│  Precio: $350.000                                  │
│  Descripción: Zapatillas deportivas...            │
│  Stock: 15 unidades disponibles                   │
│                                                     │
│  Cantidad: [1] [-] [+]                            │
│  [🛒 Añadir al Carrito]                           │
└─────────────────────────────────────────────────────┘
```

**Backend** (`single-product.php`):
```php
// Obtiene detalles completos del producto
$producto = Producto::obtenerPorId($id);
// Muestra información detallada con galería de imágenes
```

### 2. **Carrito de Compras**

#### 2.1 Añadir Productos
El cliente puede añadir productos de dos formas:
- Desde el catálogo (cantidad por defecto: 1)
- Desde detalle del producto (cantidad personalizada)

**JavaScript** (Sistema de carrito con LocalStorage):
```javascript
// Almacenamiento local del navegador
function agregarAlCarrito(productoId, cantidad) {
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito.push({
        id: productoId,
        cantidad: cantidad,
        fecha: new Date()
    });
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarIconoCarrito(); // Badge con cantidad
}
```

#### 2.2 Página del Carrito (`cart.php`)
Visualización completa del carrito:

```
┌─────────────────────────────────────────────────────┐
│  🛒 CARRITO DE COMPRAS                              │
├──────────┬──────────┬──────────┬──────────┬─────────┤
│ Producto │ Precio   │ Cantidad │ Subtotal │ Acción  │
├──────────┼──────────┼──────────┼──────────┼─────────┤
│ Nike Air │ $350.000 │ [2][-][+]│ $700.000 │ [🗑️]   │
│ Adidas R │ $280.000 │ [1][-][+]│ $280.000 │ [🗑️]   │
├──────────┴──────────┴──────────┴──────────┴─────────┤
│                         Subtotal: $980.000          │
│                         Envío:    $15.000           │
│                         ──────────────────          │
│                         TOTAL:    $995.000          │
├─────────────────────────────────────────────────────┤
│  [← Continuar Comprando]  [Proceder al Pago →]    │
└─────────────────────────────────────────────────────┘
```

**Funcionalidades**:
- ✏️ Modificar cantidad de cada producto
- 🗑️ Eliminar productos del carrito
- 💰 Cálculo automático de subtotales y total
- 🚚 Cálculo de envío
- 📱 Botón para proceder al checkout

### 3. **Proceso de Checkout**

#### 3.1 Registro/Login
Si el cliente no está registrado:

```
┌─────────────────────────────────────────────────────┐
│  👤 CREAR CUENTA o INICIAR SESIÓN                   │
├─────────────────────────────────────────────────────┤
│  Registro Nuevo:                                    │
│  - Nombre y Apellido                               │
│  - Email                                           │
│  - Teléfono                                        │
│  - Dirección                                       │
│  - Contraseña                                      │
│                                                     │
│  Ya tengo cuenta: [Iniciar Sesión]                │
└─────────────────────────────────────────────────────┘
```

**Backend** (`AuthController.php`):
```php
public function register() {
    // Valida datos del formulario
    $validator = new Validador();
    $validator->validarEmail($email);
    
    // Hash de contraseña con bcrypt
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    // Crea usuario en BD
    User::crear($datos);
    
    // Inicia sesión automáticamente
    $_SESSION['user_id'] = $userId;
}
```

#### 3.2 Información de Envío (`checkout.php`)
El cliente completa los datos de envío:

```
┌─────────────────────────────────────────────────────┐
│  📦 FINALIZAR PEDIDO                                │
├─────────────────────────────────────────────────────┤
│  📋 Resumen del Pedido:                             │
│  ├─ 2 productos                                     │
│  └─ Total: $995.000                                 │
│                                                     │
│  🏠 Información de Envío:                           │
│  ├─ Dirección: [Calle 123 #45-67]                 │
│  ├─ Ciudad: [Bogotá]                               │
│  ├─ Teléfono: [300 123 4567]                       │
│  └─ Observaciones: [Dejar en portería]            │
│                                                     │
│  💰 Método de Pago:                                 │
│  ☑️ Pago por WhatsApp (Con envío a domicilio)      │
│                                                     │
│  [📱 Enviar Pedido por WhatsApp]                   │
└─────────────────────────────────────────────────────┘
```

**Proceso Backend**:
```php
// 1. Validar datos de envío
if (empty($direccion) || empty($telefono)) {
    // Mostrar error
}

// 2. Crear pedido en BD
$pedidoId = Pedido::crear([
    'usuario_id' => $_SESSION['user_id'],
    'total' => $total,
    'direccion_envio' => $direccion,
    'telefono' => $telefono,
    'estado_pedido_id' => 1, // Pendiente
    'tipo_pedido' => 'whatsapp',
    'envio' => $costoEnvio
]);

// 3. Guardar items del pedido
foreach ($items_carrito as $item) {
    DetallePedido::crear([
        'pedido_id' => $pedidoId,
        'producto_id' => $item['id'],
        'cantidad' => $item['cantidad'],
        'precio_unitario' => $item['precio']
    ]);
}

// 4. Generar mensaje encriptado para WhatsApp
```

### 4. **Integración con WhatsApp**

#### 4.1 Encriptación del Pedido
El sistema encripta los datos del pedido usando **AES-256-CBC**:

```php
// WhatsAppService.php
public static function encriptarDatos($datos) {
    $key = hash('sha256', WHATSAPP_SECRET_KEY);
    $iv = openssl_random_pseudo_bytes(16);
    
    $encrypted = openssl_encrypt(
        json_encode($datos),
        'AES-256-CBC',
        $key,
        0,
        $iv
    );
    
    return base64_encode($encrypted . '::' . $iv);
}
```

**Datos encriptados**:
- 🆔 ID del pedido
- 👤 Nombre del cliente
- 📱 Teléfono
- 🏠 Dirección de envío
- 🛍️ Lista de productos
- 💰 Total del pedido

#### 4.2 Envío por WhatsApp
Al hacer clic en "Enviar Pedido por WhatsApp":

```
┌─────────────────────────────────────────────────────┐
│  WhatsApp se abre automáticamente con:              │
├─────────────────────────────────────────────────────┤
│  Hola! 👋                                           │
│                                                     │
│  Quiero realizar el siguiente pedido:              │
│                                                     │
│  📦 Pedido #001234                                  │
│                                                     │
│  🛍️ Productos:                                      │
│  • Nike Air Max 2024 (x2) - $700.000              │
│  • Adidas Running Pro (x1) - $280.000             │
│                                                     │
│  💰 Total: $995.000                                 │
│  🚚 Envío: $15.000                                  │
│                                                     │
│  🏠 Dirección: Calle 123 #45-67, Bogotá            │
│  📱 Teléfono: 300 123 4567                          │
│                                                     │
│  [Datos encriptados]: eyJpZCI6MTIzNC...           │
└─────────────────────────────────────────────────────┘
```

**Flujo técnico**:
```javascript
function enviarWhatsApp(pedidoId) {
    // Generar link de WhatsApp
    const telefono = "573001234567"; // Número de la tienda
    const mensaje = encodeURIComponent(mensajeFormateado);
    const url = `https://wa.me/${telefono}?text=${mensaje}`;
    
    // Abrir WhatsApp
    window.open(url, '_blank');
    
    // Redirigir a página de confirmación
    window.location.href = 'confirmation.php?pedido=' + pedidoId;
}
```

#### 4.3 Página de Confirmación
```
┌─────────────────────────────────────────────────────┐
│  ✅ PEDIDO ENVIADO EXITOSAMENTE                     │
├─────────────────────────────────────────────────────┤
│  Tu pedido #001234 ha sido registrado              │
│                                                     │
│  📱 Hemos abierto WhatsApp para que confirmes      │
│     tu pedido con nosotros                         │
│                                                     │
│  ⏰ En breve recibirás confirmación                 │
│                                                     │
│  🔍 Puedes hacer seguimiento de tu pedido en:      │
│     [Ver Seguimiento del Pedido]                   │
│                                                     │
│  📧 O desde tu perfil: [Ir a Mi Perfil]           │
└─────────────────────────────────────────────────────┘
```

---

## 👔 Sistema de Gestión Administrativa

### 1. **Acceso al Panel de Administración**

#### 1.1 Login Administrativo
```
┌─────────────────────────────────────────────────────┐
│  🔐 PANEL DE ADMINISTRACIÓN                         │
├─────────────────────────────────────────────────────┤
│  Email: [admin@tienda.com]                         │
│  Contraseña: [••••••••]                            │
│                                                     │
│  [Iniciar Sesión]                                  │
└─────────────────────────────────────────────────────┘
```

**Roles del sistema**:
- 👑 **Administrador**: Acceso completo a todas las funciones
- 👨‍💼 **Empleado**: Gestión de pedidos y consultas
- 👤 **Cliente**: Solo área de cliente

**Validación Backend**:
```php
// AuthService.php
public static function verificarRol($rolesPermitidos) {
    $rol = $_SESSION['user_rol'] ?? null;
    
    if (!in_array($rol, $rolesPermitidos)) {
        header('Location: /login');
        exit;
    }
}
```

#### 1.2 Dashboard Principal
```
┌─────────────────────────────────────────────────────────────────┐
│  📊 DASHBOARD - PANEL DE ADMINISTRACIÓN                         │
├──────────────────┬──────────────────┬──────────────────────────┤
│  📦 Pedidos      │  🛍️ Productos     │  👥 Clientes             │
│  Total: 156      │  Total: 89       │  Total: 234              │
│  Pendientes: 12  │  Stock bajo: 5   │  Nuevos hoy: 3          │
├──────────────────┼──────────────────┼──────────────────────────┤
│  💰 Ventas       │  📈 Estadísticas │  ⚙️ Configuración       │
│  Hoy: $2.5M      │  Ver reportes    │  Ajustes del sistema    │
└──────────────────┴──────────────────┴──────────────────────────┘
```

**Módulos disponibles**:
1. 📦 Gestión de Pedidos
2. 🛍️ Gestión de Productos
3. 📂 Gestión de Categorías
4. 🏷️ Gestión de Marcas
5. 👥 Gestión de Clientes
6. 📊 Reportes y Estadísticas

### 2. **Gestión de Productos**

#### 2.1 Lista de Productos
```
┌─────────────────────────────────────────────────────────────────┐
│  🛍️ GESTIÓN DE PRODUCTOS                    [+ Nuevo Producto] │
├─────────────────────────────────────────────────────────────────┤
│  🔍 Buscar: [_______]  📂 Categoría: [Todas ▼]  Estado: [Activo]│
├─────┬──────────────┬──────────┬─────────┬────────┬─────────────┤
│ ID  │ Producto     │ Categoría│ Precio  │ Stock  │ Acciones    │
├─────┼──────────────┼──────────┼─────────┼────────┼─────────────┤
│ 001 │ Nike Air Max │ Deport.  │$350.000 │ 15 ✅  │ [✏️] [🗑️]  │
│ 002 │ Adidas Run   │ Deport.  │$280.000 │ 3  ⚠️  │ [✏️] [🗑️]  │
│ 003 │ Puma Speed   │ Casual   │$420.000 │ 0  ❌  │ [✏️] [🗑️]  │
└─────┴──────────────┴──────────┴─────────┴────────┴─────────────┘
```

**Funcionalidades**:
- ✅ Ver lista completa de productos
- 🔍 Buscar por nombre o código
- 📂 Filtrar por categoría, marca, estado
- ⚠️ Alertas de stock bajo (< 5 unidades)
- ✏️ Editar información del producto
- 🗑️ Eliminar productos (soft delete)

#### 2.2 Crear/Editar Producto
```
┌─────────────────────────────────────────────────────┐
│  ✏️ EDITAR PRODUCTO                                 │
├─────────────────────────────────────────────────────┤
│  Información Básica:                                │
│  ├─ Nombre: [Nike Air Max 2024]                    │
│  ├─ Código: [NK-AM-2024]                           │
│  ├─ Descripción: [Zapatillas deportivas...]       │
│  └─ Precio: [$350.000]                             │
│                                                     │
│  Clasificación:                                     │
│  ├─ Categoría: [Deportivos ▼]                     │
│  ├─ Marca: [Nike ▼]                                │
│  └─ Estado: [● Activo ○ Inactivo]                 │
│                                                     │
│  Inventario:                                        │
│  ├─ Stock Actual: [15]                             │
│  └─ Stock Mínimo: [5]                              │
│                                                     │
│  Imágenes:                                          │
│  ├─ Principal: [📸 Subir imagen]                   │
│  └─ Galería: [📸] [📸] [📸]                        │
│                                                     │
│  [Cancelar]  [💾 Guardar Cambios]                  │
└─────────────────────────────────────────────────────┘
```

**Backend** (`AdminController.php`):
```php
public function guardarProducto() {
    // 1. Validar datos
    $validator = new Validador();
    $validator->requerido($nombre, 'nombre');
    $validator->numero($precio, 'precio');
    
    // 2. Procesar imágenes
    $imagen_principal = $this->subirImagen($_FILES['imagen']);
    
    // 3. Guardar en BD
    if ($productoId) {
        // Actualizar
        Producto::actualizar($productoId, $datos);
    } else {
        // Crear nuevo
        Producto::crear($datos);
    }
    
    // 4. Actualizar stock
    Stock::registrarMovimiento([
        'producto_id' => $productoId,
        'cantidad' => $stock,
        'tipo' => 'entrada',
        'usuario_id' => $_SESSION['user_id']
    ]);
}
```

### 3. **Gestión de Pedidos**

#### 3.1 Lista de Pedidos
```
┌──────────────────────────────────────────────────────────────────────────────┐
│  📦 GESTIÓN DE PEDIDOS                                                       │
├──────────────────────────────────────────────────────────────────────────────┤
│  🔍 Buscar: [_______]  📅 Fecha: [Hoy ▼]  Estado: [Todos ▼]                │
├─────────┬────────────────┬────────────┬────────────┬─────────────┬──────────┤
│ N° Ped. │ Cliente        │ Fecha      │ Total      │ Estado      │ Acciones │
├─────────┼────────────────┼────────────┼────────────┼─────────────┼──────────┤
│ #001234 │ Juan Pérez     │ 27/10/2025 │ $995.000   │🕐 Pendiente │[👁️][🔄] │
│ #001235 │ María García   │ 27/10/2025 │ $1.2M      │✅ Confirmado│[👁️][🔄] │
│ #001236 │ Carlos López   │ 26/10/2025 │ $580.000   │📦 En Prep. │[👁️][🔄] │
│ #001237 │ Ana Martínez   │ 26/10/2025 │ $750.000   │🚚 Enviado   │[👁️][🔄] │
│ #001238 │ Luis Rodríguez │ 25/10/2025 │ $1.5M      │✅ Entregado │[👁️]     │
└─────────┴────────────────┴────────────┴────────────┴─────────────┴──────────┘
```

**Estados de pedido**:
1. 🕐 **Pendiente** - Pedido creado, esperando confirmación
2. ✅ **Confirmado** - Pago verificado, procesando pedido
3. 📦 **En Preparación** - Empacando productos
4. 🚚 **Enviado** - En camino al cliente
5. ✅ **Entregado** - Pedido completado
6. ❌ **Cancelado** - Pedido cancelado

**Funcionalidades AJAX**:
```javascript
// Cargar pedidos dinámicamente
function cargarPedidos() {
    fetch('admin-pedidos-api?action=listar')
        .then(response => response.json())
        .then(data => {
            mostrarPedidos(data.pedidos);
            actualizarEstadisticas(data.pedidos);
        });
}

// Actualizar cada 30 segundos
setInterval(cargarPedidos, 30000);
```

#### 3.2 Ver Detalle del Pedido
```
┌─────────────────────────────────────────────────────┐
│  📋 DETALLE DEL PEDIDO #001234                      │
├─────────────────────────────────────────────────────┤
│  👤 Cliente: Juan Pérez                             │
│  📧 Email: juan@email.com                           │
│  📱 Teléfono: 300 123 4567                          │
│                                                     │
│  🏠 Dirección de Envío:                             │
│  Calle 123 #45-67, Bogotá                          │
│                                                     │
│  📅 Fecha: 27 de Octubre, 2025 - 10:30 AM         │
│  💰 Estado: 🕐 Pendiente                            │
│                                                     │
│  🛍️ Productos:                                      │
│  ┌──────────────┬──────┬────────┬──────────┐       │
│  │ Producto     │ Cant │ Precio │ Subtotal │       │
│  ├──────────────┼──────┼────────┼──────────┤       │
│  │ Nike Air Max │  2   │$350.000│ $700.000 │       │
│  │ Adidas Run   │  1   │$280.000│ $280.000 │       │
│  └──────────────┴──────┴────────┴──────────┘       │
│                                                     │
│  Subtotal:    $980.000                             │
│  Envío:       $ 15.000                             │
│  ─────────────────────                             │
│  TOTAL:       $995.000                             │
│                                                     │
│  📝 Observaciones:                                  │
│  "Dejar en portería si no hay nadie"              │
│                                                     │
│  [🔄 Cambiar Estado]  [📄 Imprimir]  [Cerrar]     │
└─────────────────────────────────────────────────────┘
```

#### 3.3 Cambiar Estado del Pedido
Al hacer clic en el botón amarillo **"🔄 Editar Estado"**:

```
┌─────────────────────────────────────────────────────┐
│  🔄 CAMBIAR ESTADO DEL PEDIDO #001234              │
├─────────────────────────────────────────────────────┤
│  Estado Actual: 🕐 Pendiente                        │
│                                                     │
│  Nuevo Estado:                                      │
│  ┌───────────────────────────────────────┐         │
│  │ Seleccionar estado ▼                  │         │
│  ├───────────────────────────────────────┤         │
│  │ 🕐 Pendiente                           │         │
│  │ ✅ Confirmado                          │         │
│  │ 📦 En Preparación                      │         │
│  │ 🚚 Enviado                             │         │
│  │ ✅ Entregado                           │         │
│  │ ❌ Cancelado                           │         │
│  └───────────────────────────────────────┘         │
│                                                     │
│  Observaciones (Opcional):                         │
│  ┌───────────────────────────────────────┐         │
│  │ Pago confirmado vía WhatsApp         │         │
│  │                                       │         │
│  │                                       │         │
│  └───────────────────────────────────────┘         │
│                                                     │
│  [Cancelar]  [✅ Actualizar Estado]                │
└─────────────────────────────────────────────────────┘
```

**Proceso Backend**:
```php
// AdminController.php
public function cambiarEstadoPedido() {
    $pedidoId = $_POST['pedido_id'];
    $nuevoEstado = $_POST['estado_id'];
    $observaciones = $_POST['observaciones'] ?? null;
    
    // Actualizar estado en BD
    $resultado = Pedido::actualizarEstado(
        $pedidoId, 
        $nuevoEstado, 
        $observaciones
    );
    
    if ($resultado) {
        // Notificar al cliente (opcional)
        // EmailService::notificarCambioEstado($pedidoId);
        
        return json_encode([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }
}
```

**SQL ejecutado**:
```sql
UPDATE pedidos 
SET estado_pedido_id = :nuevo_estado,
    observaciones = :observaciones,
    fecha_actualizacion = NOW()
WHERE id = :pedido_id
```

### 4. **Gestión de Categorías**

```
┌─────────────────────────────────────────────────────┐
│  📂 GESTIÓN DE CATEGORÍAS        [+ Nueva Categoría]│
├──────┬────────────────┬──────────┬─────────────────┤
│ ID   │ Nombre         │ Estado   │ Acciones        │
├──────┼────────────────┼──────────┼─────────────────┤
│ 1    │ Deportivos     │ ✅ Activo│ [✏️] [🗑️]      │
│ 2    │ Casuales       │ ✅ Activo│ [✏️] [🗑️]      │
│ 3    │ Formales       │ ✅ Activo│ [✏️] [🗑️]      │
│ 4    │ Niños          │ ✅ Activo│ [✏️] [🗑️]      │
└──────┴────────────────┴──────────┴─────────────────┘
```

### 5. **Gestión de Marcas**

```
┌─────────────────────────────────────────────────────┐
│  🏷️ GESTIÓN DE MARCAS              [+ Nueva Marca] │
├──────┬────────────────┬──────────┬─────────────────┤
│ ID   │ Nombre         │ Estado   │ Acciones        │
├──────┼────────────────┼──────────┼─────────────────┤
│ 1    │ Nike           │ ✅ Activo│ [✏️] [🗑️]      │
│ 2    │ Adidas         │ ✅ Activo│ [✏️] [🗑️]      │
│ 3    │ Puma           │ ✅ Activo│ [✏️] [🗑️]      │
│ 4    │ Reebok         │ ✅ Activo│ [✏️] [🗑️]      │
└──────┴────────────────┴──────────┴─────────────────┘
```

### 6. **Gestión de Clientes**

```
┌─────────────────────────────────────────────────────────────────┐
│  👥 GESTIÓN DE CLIENTES                                         │
├──────┬─────────────────┬──────────────────┬─────────┬──────────┤
│ ID   │ Nombre          │ Email            │ Pedidos │ Acciones │
├──────┼─────────────────┼──────────────────┼─────────┼──────────┤
│ 101  │ Juan Pérez      │ juan@email.com   │ 5       │ [👁️]    │
│ 102  │ María García    │ maria@email.com  │ 12      │ [👁️]    │
│ 103  │ Carlos López    │ carlos@email.com │ 3       │ [👁️]    │
└──────┴─────────────────┴──────────────────┴─────────┴──────────┘
```

---

## 🔍 Seguimiento de Pedidos

### 1. **Vista del Cliente**

#### 1.1 Desde el Perfil
El cliente puede ver sus pedidos desde su perfil:

```
┌─────────────────────────────────────────────────────┐
│  👤 MI PERFIL                                       │
├─────────────────────────────────────────────────────┤
│  📦 MIS PEDIDOS                                     │
├─────────────────────────────────────────────────────┤
│  Pedido #001234                 27/10/2025         │
│  Total: $995.000               🕐 Pendiente        │
│  [👁️ Ver Detalles] [📍 Seguimiento]               │
├─────────────────────────────────────────────────────┤
│  Pedido #001180                 20/10/2025         │
│  Total: $450.000               ✅ Entregado        │
│  [👁️ Ver Detalles] [📍 Seguimiento]               │
└─────────────────────────────────────────────────────┘
```

#### 1.2 Página de Seguimiento (`seguimiento-pedido.php`)
Al hacer clic en "📍 Seguimiento":

```
┌─────────────────────────────────────────────────────────────────┐
│  📦 SEGUIMIENTO DEL PEDIDO #001234                              │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌─────────────────── LÍNEA DE TIEMPO ──────────────────────┐  │
│  │                                                           │  │
│  │    ✅ ────────── ✅ ────────── 🔵 ─ ─ ─ ─ ─ ○ ─ ─ ─ ─ ○  │  │
│  │    │            │            │            │            │  │  │
│  │  Pedido      Confirmado   En Prep.    Enviado    Entregado │
│  │  Realizado                                                │  │
│  │                                                           │  │
│  │  27/10 10:30   27/10 11:15   27/10 14:00     ---         --- │
│  │                                                           │  │
│  │            💬 "Pago confirmado vía WhatsApp"             │  │
│  └───────────────────────────────────────────────────────────┘  │
│                                                                 │
│  📝 DETALLES DEL PEDIDO                                         │
│  ├─ Estado Actual: 📦 En Preparación                           │
│  ├─ Fecha de Pedido: 27 de Octubre, 2025                       │
│  └─ Última Actualización: 27 de Octubre, 2025 - 14:00         │
│                                                                 │
│  🛍️ PRODUCTOS                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ 📸 Nike Air Max 2024      x2      $350.000   $700.000   │  │
│  │ 📸 Adidas Running Pro     x1      $280.000   $280.000   │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                 │
│  💰 RESUMEN                                                     │
│  ├─ Subtotal:     $980.000                                     │
│  ├─ Envío:        $ 15.000                                     │
│  └─ TOTAL:        $995.000                                     │
│                                                                 │
│  🏠 INFORMACIÓN DE ENVÍO                                        │
│  ├─ Dirección: Calle 123 #45-67, Bogotá                       │
│  ├─ Teléfono: 300 123 4567                                    │
│  └─ Observaciones: "Dejar en portería si no hay nadie"       │
│                                                                 │
│  [← Volver al Perfil]                                          │
└─────────────────────────────────────────────────────────────────┘
```

**Características del seguimiento**:
- 🎨 **Línea de tiempo visual** con colores:
  - ✅ Verde: Estados completados
  - 🔵 Azul (pulsando): Estado actual
  - ⚪ Gris: Estados pendientes

- 💬 **Observaciones del empleado** visibles para el cliente
- 🔄 **Actualización en tiempo real** (puede refrescar la página)
- 📱 **Diseño responsive** para móviles

**Backend** (`SeguimientoPedidoController.php`):
```php
public function index() {
    $pedidoId = $_GET['id'] ?? null;
    $usuarioId = $_SESSION['user_id'] ?? null;
    
    // Obtener datos del pedido
    $pedido = Pedido::obtenerDetalle($pedidoId);
    
    // Verificar que el pedido pertenece al usuario
    if ($pedido['usuario_id'] !== $usuarioId) {
        header('Location: /perfil');
        exit;
    }
    
    // Obtener items del pedido
    $items = Pedido::obtenerItems($pedidoId);
    
    // Renderizar vista
    require_once 'Views/seguimiento-pedido.php';
}
```

**API para actualización en tiempo real**:
```javascript
// Actualizar estado cada 60 segundos
setInterval(function() {
    fetch(`/api/seguimiento/estado?id=${pedidoId}`)
        .then(response => response.json())
        .then(data => {
            actualizarTimeline(data.estado_id);
            if (data.observaciones) {
                mostrarObservaciones(data.observaciones);
            }
        });
}, 60000);
```

---

## 📱 Integración con WhatsApp

### Arquitectura de Seguridad

#### 1. **Encriptación AES-256-CBC**
```php
class WhatsAppService {
    private const CIPHER = 'AES-256-CBC';
    
    public static function encriptarDatos($datos) {
        // Generar clave de 32 bytes desde secret
        $key = hash('sha256', WHATSAPP_SECRET_KEY);
        
        // Vector de inicialización aleatorio (16 bytes)
        $iv = openssl_random_pseudo_bytes(16);
        
        // Encriptar datos
        $encrypted = openssl_encrypt(
            json_encode($datos),
            self::CIPHER,
            $key,
            0,
            $iv
        );
        
        // Retornar: encrypted::iv en base64
        return base64_encode($encrypted . '::' . $iv);
    }
    
    public static function desencriptarDatos($encryptedData) {
        $key = hash('sha256', WHATSAPP_SECRET_KEY);
        $decoded = base64_decode($encryptedData);
        
        list($encrypted, $iv) = explode('::', $decoded, 2);
        
        $decrypted = openssl_decrypt(
            $encrypted,
            self::CIPHER,
            $key,
            0,
            $iv
        );
        
        return json_decode($decrypted, true);
    }
}
```

#### 2. **Generación del Mensaje**
```php
public static function generarMensajePedido($pedido) {
    // Datos a encriptar
    $datosEncriptar = [
        'pedido_id' => $pedido['id'],
        'usuario_id' => $pedido['usuario_id'],
        'total' => $pedido['total'],
        'fecha' => $pedido['fecha_pedido']
    ];
    
    $encrypted = self::encriptarDatos($datosEncriptar);
    
    // Formato del mensaje
    $mensaje = "🛒 *Nuevo Pedido*\n\n";
    $mensaje .= "📦 *Pedido:* #{$pedido['numero_pedido']}\n";
    $mensaje .= "👤 *Cliente:* {$pedido['nombre_completo']}\n";
    $mensaje .= "📱 *Teléfono:* {$pedido['telefono']}\n\n";
    
    $mensaje .= "🛍️ *Productos:*\n";
    foreach ($pedido['items'] as $item) {
        $mensaje .= "• {$item['nombre']} x{$item['cantidad']} - \${$item['subtotal']}\n";
    }
    
    $mensaje .= "\n💰 *Total:* \${$pedido['total']}\n";
    $mensaje .= "🚚 *Envío:* \${$pedido['envio']}\n\n";
    
    $mensaje .= "🏠 *Dirección:*\n{$pedido['direccion_envio']}\n\n";
    
    $mensaje .= "🔐 *Código de verificación:*\n";
    $mensaje .= "`{$encrypted}`\n";
    
    return $mensaje;
}
```

#### 3. **Flujo Completo**
```
Cliente                    Sistema                WhatsApp               Empleado
  │                          │                        │                      │
  │ 1. Finaliza checkout     │                        │                      │
  ├─────────────────────────>│                        │                      │
  │                          │                        │                      │
  │                          │ 2. Crea pedido en BD   │                      │
  │                          │    (estado: Pendiente) │                      │
  │                          │                        │                      │
  │                          │ 3. Encripta datos      │                      │
  │                          │    AES-256-CBC         │                      │
  │                          │                        │                      │
  │ 4. Abre WhatsApp         │                        │                      │
  │<─────────────────────────│                        │                      │
  │                          │                        │                      │
  │ 5. Envía mensaje         │                        │                      │
  ├──────────────────────────┼───────────────────────>│                      │
  │                          │                        │                      │
  │                          │                        │ 6. Notifica llegada  │
  │                          │                        │─────────────────────>│
  │                          │                        │                      │
  │                          │                        │ 7. Verifica pedido   │
  │                          │                        │<─────────────────────│
  │                          │                        │                      │
  │                          │                        │ 8. Confirma pago     │
  │                          │ 9. Actualiza estado    │<─────────────────────│
  │                          │<───────────────────────┼──────────────────────│
  │                          │    (Confirmado)        │                      │
  │                          │                        │                      │
  │ 10. Ve en seguimiento    │                        │                      │
  │<─────────────────────────│                        │                      │
  │     (Timeline actualiza) │                        │                      │
```

---

## 🔧 Tecnologías Utilizadas

### Backend
- **PHP 8.2.12**: Lenguaje principal
- **MySQL 8.0**: Base de datos relacional
- **PDO**: Abstracción de base de datos con prepared statements
- **OpenSSL**: Encriptación AES-256-CBC
- **Sessions**: Manejo de autenticación

### Frontend
- **HTML5**: Estructura semántica
- **CSS3**: Estilos y animaciones
- **Bootstrap 4**: Framework CSS responsive
- **JavaScript ES6**: Interactividad
- **jQuery 2.2.4**: Manipulación DOM y AJAX
- **Font Awesome**: Iconografía
- **Themify Icons**: Iconos adicionales

### Arquitectura
- **MVC (Model-View-Controller)**: Separación de responsabilidades
- **RESTful API**: Endpoints JSON para AJAX
- **SPA parcial**: Carga dinámica de contenido
- **Responsive Design**: Adaptable a todos los dispositivos

### Seguridad
- **Password Hashing**: bcrypt para contraseñas
- **Prepared Statements**: Prevención de SQL Injection
- **CSRF Protection**: Tokens en formularios
- **XSS Prevention**: Sanitización de inputs
- **Encriptación**: AES-256-CBC para datos sensibles
- **Session Security**: HttpOnly y Secure cookies

---

## 📦 Instalación y Configuración

### Requisitos Previos
- XAMPP 8.2.12 o superior
- PHP 8.2+
- MySQL 8.0+
- Composer (opcional)

### Paso 1: Clonar el Repositorio
```bash
git clone https://github.com/Jonatan1014/proyecto-de-grado.git
cd proyecto-de-grado
```

### Paso 2: Configurar Base de Datos

#### 2.1 Crear Base de Datos
```bash
# Iniciar MySQL
c:/xampp/mysql/bin/mysql.exe -u root

# Crear base de datos
CREATE DATABASE tennisyzapatos_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tennisyzapatos_db;
```

#### 2.2 Importar Estructura
```bash
# Desde la terminal de MySQL
source database/structure.sql;

# O desde línea de comandos
c:/xampp/mysql/bin/mysql.exe -u root tennisyzapatos_db < database/structure.sql
```

#### 2.3 Importar Datos de Prueba (Opcional)
```bash
c:/xampp/mysql/bin/mysql.exe -u root tennisyzapatos_db < database/dump.sql
```

#### 2.4 Ejecutar Migración de Envío
```bash
c:/xampp/mysql/bin/mysql.exe -u root tennisyzapatos_db < database/migrations/add_envio_to_pedidos.sql
```

### Paso 3: Configurar Aplicación

#### 3.1 Archivo de Configuración (`src/config/database.php`)
```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'tennisyzapatos_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
```

#### 3.2 Configuración de WhatsApp (`src/config/config.php`)
```php
<?php
// Número de WhatsApp de la tienda (formato internacional sin +)
define('WHATSAPP_NUMERO', '573001234567'); // ⚠️ CAMBIAR

// Clave secreta para encriptación (32 caracteres mínimo)
define('WHATSAPP_SECRET_KEY', 'tu-clave-super-secreta-de-32-caracteres-minimo'); // ⚠️ CAMBIAR

// Configuración de sesión
define('SESSION_LIFETIME', 3600); // 1 hora
```

### Paso 4: Configurar Permisos
```bash
# En Linux/Mac
chmod -R 755 src/
chmod -R 777 src/public/assets/img/product/

# En Windows (desde PowerShell como Admin)
icacls "c:\xampp\htdocs\mayra\src\public\assets\img\product" /grant Users:F /t
```

### Paso 5: Iniciar Servidor

#### Opción 1: XAMPP
1. Abrir XAMPP Control Panel
2. Iniciar Apache y MySQL
3. Acceder a: `http://localhost/mayra/src/public/`

#### Opción 2: PHP Built-in Server
```bash
cd src/public
php -S localhost:8000
# Acceder a: http://localhost:8000
```

### Paso 6: Crear Usuario Administrador

```bash
# Conectar a MySQL
c:/xampp/mysql/bin/mysql.exe -u root tennisyzapatos_db

# Ejecutar SQL
INSERT INTO usuarios (nombre, apellido, email, password, telefono, direccion, rol, estado) 
VALUES (
    'Admin',
    'Sistema',
    'admin@tienda.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: password
    '3001234567',
    'Calle Principal #123',
    'admin',
    'activo'
);
```

**Credenciales por defecto**:
- Email: `admin@tienda.com`
- Password: `password`

⚠️ **IMPORTANTE**: Cambiar la contraseña después del primer login.

### Paso 7: Verificar Instalación

#### 7.1 Comprobar Base de Datos
```bash
c:/xampp/mysql/bin/mysql.exe -u root -e "USE tennisyzapatos_db; SHOW TABLES;"
```

Deberías ver:
```
+-------------------------------+
| Tables_in_tennisyzapatos_db   |
+-------------------------------+
| categorias                     |
| detalle_pedidos                |
| estados_pedido                 |
| marcas                         |
| pedidos                        |
| productos                      |
| usuarios                       |
+-------------------------------+
```

#### 7.2 Verificar Estados de Pedido
```bash
c:/xampp/mysql/bin/mysql.exe -u root -e "USE tennisyzapatos_db; SELECT * FROM estados_pedido;"
```

Deberías ver:
```
+----+----------------+
| id | nombre         |
+----+----------------+
|  1 | Pendiente      |
|  2 | Confirmado     |
|  3 | En Preparación |
|  4 | Enviado        |
|  5 | Entregado      |
|  6 | Cancelado      |
+----+----------------+
```

#### 7.3 Probar Login
1. Ir a: `http://localhost/mayra/src/public/login`
2. Ingresar credenciales de admin
3. Deberías ver el dashboard administrativo

---

## 🚀 Uso del Sistema

### Para Clientes

1. **Registrarse**: `/registration`
2. **Explorar productos**: `/` o `/category`
3. **Añadir al carrito**: Click en "🛒 Añadir"
4. **Ver carrito**: `/cart`
5. **Finalizar compra**: `/checkout`
6. **Enviar por WhatsApp**: Click en botón verde
7. **Ver seguimiento**: `/perfil` → "📍 Seguimiento"

### Para Administradores/Empleados

1. **Login**: `/admin` o `/login`
2. **Dashboard**: `/admin-dashboard`
3. **Gestionar productos**: `/admin-productos`
4. **Gestionar pedidos**: `/admin-pedidos`
5. **Cambiar estado**: Click en "🔄 Editar Estado"
6. **Ver clientes**: `/admin-clientes`
7. **Gestionar categorías**: `/admin-categorias`
8. **Gestionar marcas**: `/admin-marcas`

---

## 📊 Estructura de la Base de Datos

### Tabla: `usuarios`
```sql
+----------------+--------------+
| Campo          | Tipo         |
+----------------+--------------+
| id             | INT (PK)     |
| nombre         | VARCHAR(100) |
| apellido       | VARCHAR(100) |
| email          | VARCHAR(100) |
| password       | VARCHAR(255) |
| telefono       | VARCHAR(20)  |
| direccion      | TEXT         |
| rol            | ENUM         | -- 'cliente', 'empleado', 'admin'
| estado         | ENUM         | -- 'activo', 'inactivo'
| fecha_registro | TIMESTAMP    |
+----------------+--------------+
```

### Tabla: `productos`
```sql
+----------------+--------------+
| Campo          | Tipo         |
+----------------+--------------+
| id             | INT (PK)     |
| nombre         | VARCHAR(200) |
| descripcion    | TEXT         |
| precio         | DECIMAL(10,2)|
| stock          | INT          |
| imagen         | VARCHAR(255) |
| categoria_id   | INT (FK)     |
| marca_id       | INT (FK)     |
| estado         | ENUM         | -- 'activo', 'inactivo'
| fecha_creacion | TIMESTAMP    |
+----------------+--------------+
```

### Tabla: `pedidos`
```sql
+-------------------+--------------+
| Campo             | Tipo         |
+-------------------+--------------+
| id                | INT (PK)     |
| numero_pedido     | VARCHAR(20)  |
| usuario_id        | INT (FK)     |
| total             | DECIMAL(10,2)|
| estado_pedido_id  | INT (FK)     |
| direccion_envio   | TEXT         |
| telefono          | VARCHAR(20)  |
| tipo_pedido       | VARCHAR(50)  |
| envio             | DECIMAL(10,2)|
| observaciones     | TEXT         |
| fecha_pedido      | TIMESTAMP    |
+-------------------+--------------+
```

### Tabla: `detalle_pedidos`
```sql
+-----------------+--------------+
| Campo           | Tipo         |
+-----------------+--------------+
| id              | INT (PK)     |
| pedido_id       | INT (FK)     |
| producto_id     | INT (FK)     |
| cantidad        | INT          |
| precio_unitario | DECIMAL(10,2)|
| subtotal        | DECIMAL(10,2)|
+-----------------+--------------+
```

### Tabla: `estados_pedido`
```sql
+--------+--------------+
| Campo  | Tipo         |
+--------+--------------+
| id     | INT (PK)     |
| nombre | VARCHAR(50)  |
+--------+--------------+
```

---

## 🔐 Seguridad

### Medidas Implementadas

1. **Autenticación**
   - Password hashing con bcrypt (cost 10)
   - Sesiones con tiempo de expiración
   - Regeneración de session ID tras login

2. **Autorización**
   - Control de acceso basado en roles
   - Verificación de permisos en cada request
   - Middleware de autenticación

3. **Prevención de Ataques**
   - SQL Injection: Prepared statements con PDO
   - XSS: Sanitización con `htmlspecialchars()`
   - CSRF: Tokens en formularios críticos
   - Path Traversal: Validación de rutas

4. **Encriptación**
   - Contraseñas: bcrypt
   - Datos WhatsApp: AES-256-CBC
   - Comunicación: HTTPS recomendado en producción

5. **Validación**
   - Lado servidor: Clase `Validador`
   - Lado cliente: HTML5 + JavaScript
   - Sanitización de inputs

---

## 📝 Documentación Adicional

- **Sistema de Seguimiento**: `docs/SISTEMA_SEGUIMIENTO_PEDIDOS.md`
- **Guía Rápida**: `SEGUIMIENTO_PEDIDOS_GUIA_RAPIDA.txt`
- **Edición de Estados**: `EDICION_ESTADOS_PEDIDOS.txt`

---

## 👥 Equipo de Desarrollo

- **Desarrollador Principal**: Jonatan
- **Proyecto**: Sistema de E-Commerce - Proyecto de Grado
- **Universidad**: [Tu Universidad]
- **Año**: 2025

---

## 📞 Soporte

Para soporte o consultas:
- **Email**: soporte@tienda.com
- **WhatsApp**: +57 300 123 4567
- **GitHub**: [https://github.com/Jonatan1014/proyecto-de-grado](https://github.com/Jonatan1014/proyecto-de-grado)

---

## 📄 Licencia

Este proyecto es privado y de uso académico.

---

## 🎓 Notas del Proyecto

Este sistema fue desarrollado como **proyecto de grado** y demuestra:

✅ **Arquitectura MVC** completa en PHP  
✅ **Gestión de base de datos** con MySQL  
✅ **Integración con APIs externas** (WhatsApp)  
✅ **Seguridad robusta** con encriptación  
✅ **Diseño responsive** con Bootstrap  
✅ **AJAX y JavaScript** para UX moderna  
✅ **Sistema de autenticación** completo  
✅ **Panel administrativo** funcional  
✅ **Seguimiento en tiempo real** de pedidos  

---

**¡Gracias por usar nuestro sistema! 🚀**