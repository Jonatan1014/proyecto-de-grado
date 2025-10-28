# SISTEMA DE SELECCIÓN DE TALLAS - DOCUMENTACIÓN TÉCNICA

## 📋 RESUMEN

Sistema completo que permite a los clientes seleccionar la talla de un producto antes de agregarlo al carrito de compras.

---

## 🗂️ ESTRUCTURA DE LA BASE DE DATOS

### Tablas Principales:

#### 1. **tallas**
- Tabla de catálogo con todas las tallas disponibles
- Incluye tallas numéricas (35-45) y alfabéticas (XS-XXL)
- 17 tallas predefinidas

```sql
CREATE TABLE tallas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(10) NOT NULL,
    tipo ENUM('numerica', 'alfabetica'),
    orden INT,
    estado ENUM('activo', 'inactivo')
);
```

#### 2. **producto_tallas**
- Relación many-to-many entre productos y tallas
- Gestiona stock individual por combinación producto-talla

```sql
CREATE TABLE producto_tallas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    producto_id INT NOT NULL,
    talla_id INT NOT NULL,
    stock INT DEFAULT 0,
    stock_minimo INT DEFAULT 0,
    estado ENUM('activo', 'inactivo'),
    UNIQUE KEY unique_producto_talla (producto_id, talla_id)
);
```

#### 3. **productos**
- Campo agregado: `requiere_talla` (BOOLEAN)
- Indica si el producto necesita selección de talla

#### 4. **carrito**
- Campo agregado: `talla_id` (INT NULL)
- Almacena la talla seleccionada al agregar al carrito

#### 5. **detalle_pedidos**
- Campo agregado: `talla_id` (INT NULL)
- Registra la talla comprada en cada pedido

---

## 📁 ARCHIVOS DEL SISTEMA

### Backend

#### 1. **ProductoTalla.php** (Model)
Ubicación: `src/app/Models/ProductoTalla.php`

**Métodos principales:**
```php
// Obtener tallas disponibles de un producto
ProductoTalla::obtenerPorProducto($productoId)

// Verificar stock de una talla específica
ProductoTalla::verificarStock($productoId, $tallaId, $cantidad)

// Reducir stock al completar venta
ProductoTalla::reducirStock($productoId, $tallaId, $cantidad)

// Agregar nueva talla a producto
ProductoTalla::agregar($productoId, $tallaId, $stock, $stockMinimo)

// Actualizar stock de una talla
ProductoTalla::actualizarStock($productoTallaId, $nuevoStock)

// Eliminar talla de producto
ProductoTalla::eliminar($productoTallaId)
```

**Retorno típico de obtenerPorProducto():**
```php
[
    [
        'id' => 1,                    // ID de producto_tallas
        'talla_id' => 5,              // ID de la talla
        'nombre' => '38',             // Nombre de la talla
        'tipo' => 'numerica',         // Tipo de talla
        'stock' => 15,                // Stock disponible
        'stock_minimo' => 3,          // Stock mínimo
        'estado' => 'activo'
    ],
    // ... más tallas
]
```

#### 2. **ProductoController.php** (Controller)
Modificaciones en el método `detalle()`:

```php
public function detalle($id) {
    // ... código existente ...
    
    // Cargar tallas disponibles del producto
    require_once __DIR__ . '/../Models/ProductoTalla.php';
    $tallasDisponibles = ProductoTalla::obtenerPorProducto($id);
    
    $data = [
        'producto' => $producto,
        'imagenes' => $imagenes,
        'productosRelacionados' => $productosRelacionados,
        'tallasDisponibles' => $tallasDisponibles  // ← NUEVO
    ];
    
    // ... renderizar vista ...
}
```

#### 3. **CarritoController.php** (Controller)
Modificaciones en el método `agregar()`:

```php
public function agregar() {
    // Capturar talla_id del request
    $tallaId = $data['talla_id'] ?? null;
    
    // Validar stock de talla específica
    if ($tallaId) {
        ProductoTalla::verificarStock($productoId, $tallaId, $cantidad);
    }
    
    // Agregar al carrito con talla
    Carrito::agregar($carritoId, $productoId, $cantidad, $precio, $tallaId);
}
```

#### 4. **Carrito.php** (Model)
Modificación del método `agregar()`:

```php
public static function agregar($carritoId, $productoId, $cantidad, $precio, $tallaId = null) {
    // Verificar si ya existe (producto + talla)
    // Si existe: actualizar cantidad
    // Si no existe: insertar nuevo item
    
    // IMPORTANTE: La clave única es ahora (usuario_id, producto_id, talla_id)
    // Esto permite tener el mismo producto con diferentes tallas
}
```

---

### Frontend

#### 1. **producto-detalle.php** (View)
Ubicación: `src/app/Views/producto-detalle.php`

**HTML del Selector de Tallas:**
```html
<?php if (!empty($tallasDisponibles)): ?>
<div class="size-selector">
    <span class="size-label">Selecciona tu talla:</span>
    <div class="size-options">
        <?php foreach ($tallasDisponibles as $talla): ?>
        <button type="button"
                class="size-option <?= $talla['stock'] > 0 ? '' : 'disabled' ?>"
                data-talla-id="<?= $talla['talla_id'] ?>"
                data-talla-nombre="<?= $talla['nombre'] ?>"
                data-stock="<?= $talla['stock'] ?>">
            <?= htmlspecialchars($talla['nombre']) ?>
            
            <?php if ($talla['stock'] == 0): ?>
            <span class="sold-out-badge">Agotado</span>
            <?php elseif ($talla['stock'] < 5): ?>
            <span class="low-stock-badge"><?= $talla['stock'] ?> disponibles</span>
            <?php endif; ?>
        </button>
        <?php endforeach; ?>
    </div>
    <div id="talla-error" class="error-message" style="display:none;">
        <i class="fa fa-exclamation-circle"></i>
        Por favor, selecciona una talla
    </div>
</div>
<?php endif; ?>
```

**CSS del Selector:**
```css
.size-selector {
    margin: 30px 0;
}

.size-option {
    min-width: 60px;
    height: 50px;
    border: 2px solid #e0e0e0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
}

.size-option:hover:not(.disabled) {
    border-color: #ffba00;
    background: #fff8e6;
    transform: translateY(-2px);
}

.size-option.selected {
    border-color: #ffba00;
    background: #ffba00;
    color: white;
}

.size-option.disabled {
    background: #f5f5f5;
    color: #999;
    cursor: not-allowed;
    opacity: 0.6;
}

.sold-out-badge {
    background: #dc3545;
    color: white;
    font-size: 9px;
    padding: 2px 6px;
    border-radius: 10px;
}

.low-stock-badge {
    background: #ff9800;
    color: white;
    font-size: 9px;
    padding: 2px 6px;
    border-radius: 10px;
}
```

**JavaScript del Selector:**
```javascript
// Variables globales
let tallaSeleccionada = null;
let stockTallaSeleccionada = 0;

// Click en talla
$('.size-option').on('click', function() {
    if ($(this).hasClass('disabled')) return;
    
    // Remover selección previa
    $('.size-option').removeClass('selected');
    
    // Marcar como seleccionada
    $(this).addClass('selected');
    
    // Guardar datos
    tallaSeleccionada = $(this).data('talla-id');
    stockTallaSeleccionada = parseInt($(this).data('stock'));
    
    // Ocultar error
    $('#talla-error').hide();
    
    // Actualizar max cantidad
    $('#qty').attr('max', stockTallaSeleccionada);
    
    // Ajustar cantidad si excede
    if (parseInt($('#qty').val()) > stockTallaSeleccionada) {
        $('#qty').val(stockTallaSeleccionada > 0 ? 1 : 0);
    }
});

// Validación al agregar al carrito
$('#btn-add-to-cart').on('click', function(e) {
    e.preventDefault();
    
    // Verificar si hay selector de tallas
    const haySelectorTallas = $('.size-selector').length > 0;
    
    // Si hay selector y no se seleccionó talla
    if (haySelectorTallas && !tallaSeleccionada) {
        $('#talla-error').show();
        $('html, body').animate({
            scrollTop: $('.size-selector').offset().top - 100
        }, 500);
        return;
    }
    
    // Agregar al carrito con talla
    agregarAlCarrito(productoId, cantidad, callback, tallaSeleccionada);
});
```

#### 2. **carrito.js**
Ubicación: `src/public/js/carrito.js`

**Función modificada:**
```javascript
function agregarAlCarrito(productoId, cantidad = 1, callback = null, tallaId = null) {
    const data = {
        producto_id: productoId,
        cantidad: cantidad
    };
    
    // Agregar talla_id si está presente
    if (tallaId) {
        data.talla_id = tallaId;
    }
    
    fetch('api/carrito/agregar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            mostrarNotificacion('✓ Producto agregado al carrito', 'success');
            actualizarContadorCarrito(result.total_items);
            
            if (typeof callback === 'function') {
                callback(true);
            }
        } else {
            mostrarNotificacion('✗ ' + result.message, 'error');
            
            if (typeof callback === 'function') {
                callback(false);
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarNotificacion('✗ Error al agregar al carrito', 'error');
        
        if (typeof callback === 'function') {
            callback(false);
        }
    });
}
```

---

## 🔄 FLUJO DE DATOS

### 1. **Carga de Producto**
```
Usuario → producto-detalle?id=X
    ↓
ProductoController::detalle($id)
    ↓
ProductoTalla::obtenerPorProducto($id)
    ↓
SELECT tallas disponibles con stock
    ↓
Renderizar selector de tallas en vista
```

### 2. **Selección de Talla**
```
Usuario hace click en talla
    ↓
JavaScript: $('.size-option').click()
    ↓
- Marcar botón como .selected
- Guardar tallaSeleccionada
- Actualizar max cantidad
- Validar stock
```

### 3. **Agregar al Carrito**
```
Usuario hace click "Agregar al Carrito"
    ↓
Validar talla seleccionada (JS)
    ↓
agregarAlCarrito(productoId, cantidad, callback, tallaId)
    ↓
POST /api/carrito/agregar
    {
        producto_id: 123,
        cantidad: 2,
        talla_id: 5  ← NUEVO
    }
    ↓
CarritoController::agregar()
    ↓
ProductoTalla::verificarStock($productoId, $tallaId, $cantidad)
    ↓
Carrito::agregar($carritoId, $productoId, $cantidad, $precio, $tallaId)
    ↓
INSERT INTO carrito (..., talla_id)
    ↓
Respuesta JSON: { success: true, total_items: 3 }
```

### 4. **Completar Pedido**
```
Usuario finaliza compra
    ↓
Crear pedido en tabla pedidos
    ↓
Para cada item del carrito:
    - Insertar en detalle_pedidos (con talla_id)
    - ProductoTalla::reducirStock($productoId, $tallaId, $cantidad)
    ↓
Vaciar carrito
```

---

## ⚙️ CASOS DE USO

### Caso 1: Producto con Tallas
**Ejemplo:** Zapatillas deportivas

1. Campo `requiere_talla = 1`
2. Registros en `producto_tallas`:
   - Talla 38: stock = 10
   - Talla 39: stock = 15
   - Talla 40: stock = 5
3. Vista muestra selector de tallas
4. Usuario DEBE seleccionar talla antes de agregar al carrito
5. Stock se valida por talla específica

### Caso 2: Producto sin Tallas
**Ejemplo:** Cordones para zapatos

1. Campo `requiere_talla = 0` o NULL
2. Sin registros en `producto_tallas`
3. Vista NO muestra selector de tallas
4. `talla_id = NULL` al agregar al carrito
5. Stock se valida del campo general `productos.stock`

### Caso 3: Mismo Producto, Diferentes Tallas en Carrito
**Ejemplo:** Usuario compra talla 38 y 40 del mismo zapato

1. Primer agregado: producto_id=123, talla_id=5 (38)
2. Segundo agregado: producto_id=123, talla_id=7 (40)
3. Carrito contiene 2 items diferentes:
   ```
   | id | producto_id | talla_id | cantidad |
   |----|-------------|----------|----------|
   | 1  | 123         | 5        | 1        |
   | 2  | 123         | 7        | 1        |
   ```

---

## 🔍 CONSULTAS SQL ÚTILES

### Ver tallas de un producto
```sql
SELECT 
    pt.id,
    t.nombre as talla,
    pt.stock,
    pt.stock_minimo,
    pt.estado
FROM producto_tallas pt
INNER JOIN tallas t ON pt.talla_id = t.id
WHERE pt.producto_id = 123
  AND pt.estado = 'activo'
ORDER BY t.orden;
```

### Ver carrito con tallas
```sql
SELECT 
    c.id,
    p.nombre as producto,
    t.nombre as talla,
    c.cantidad,
    c.precio,
    (c.cantidad * c.precio) as subtotal
FROM carrito c
INNER JOIN productos p ON c.producto_id = p.id
LEFT JOIN tallas t ON c.talla_id = t.id
WHERE c.usuario_id = 'user123'
ORDER BY c.fecha_agregado DESC;
```

### Ver stock total de un producto (todas las tallas)
```sql
SELECT 
    p.nombre,
    SUM(pt.stock) as stock_total_tallas,
    p.stock as stock_general
FROM productos p
LEFT JOIN producto_tallas pt ON p.id = pt.producto_id
WHERE p.id = 123
GROUP BY p.id;
```

### Productos con stock bajo por talla
```sql
SELECT 
    p.nombre,
    t.nombre as talla,
    pt.stock,
    pt.stock_minimo
FROM producto_tallas pt
INNER JOIN productos p ON pt.producto_id = p.id
INNER JOIN tallas t ON pt.talla_id = t.id
WHERE pt.stock < pt.stock_minimo
  AND pt.estado = 'activo'
ORDER BY p.nombre, t.orden;
```

---

## 🧪 TESTING

### 1. Test: Selección de Talla
- [ ] Verificar que se muestren todas las tallas disponibles
- [ ] Verificar que tallas agotadas aparezcan deshabilitadas
- [ ] Verificar badge "Agotado" en tallas sin stock
- [ ] Verificar badge "X disponibles" en tallas con stock < 5
- [ ] Verificar que solo una talla se pueda seleccionar a la vez
- [ ] Verificar efecto visual al seleccionar (.selected class)

### 2. Test: Validación
- [ ] Intentar agregar al carrito sin seleccionar talla
- [ ] Verificar que aparezca mensaje de error
- [ ] Verificar scroll automático al selector de tallas
- [ ] Verificar que error desaparezca al seleccionar talla

### 3. Test: Stock por Talla
- [ ] Seleccionar talla con stock = 10
- [ ] Verificar que cantidad máxima sea 10
- [ ] Intentar ingresar cantidad > 10
- [ ] Verificar rechazo del sistema
- [ ] Cambiar a otra talla con stock diferente
- [ ] Verificar actualización del máximo

### 4. Test: Agregar al Carrito
- [ ] Seleccionar talla 38
- [ ] Agregar 2 unidades al carrito
- [ ] Verificar que se guarde talla_id = X
- [ ] Seleccionar talla 40 del mismo producto
- [ ] Agregar 1 unidad al carrito
- [ ] Verificar que se cree item separado en carrito

### 5. Test: Completar Pedido
- [ ] Finalizar compra con productos con talla
- [ ] Verificar que detalle_pedidos tenga talla_id
- [ ] Verificar reducción de stock por talla
- [ ] Verificar que stock general NO cambie
- [ ] Verificar que se vacíe el carrito

---

## 🐛 TROUBLESHOOTING

### Problema: No aparece selector de tallas
**Solución:**
1. Verificar que `$tallasDisponibles` llegue a la vista
2. Verificar registros en `producto_tallas` para ese producto
3. Verificar que estado = 'activo'

### Problema: Error al agregar al carrito
**Solución:**
1. Verificar console.log para ver si `tallaSeleccionada` tiene valor
2. Verificar network tab para ver request POST
3. Verificar que campo `talla_id` exista en tabla `carrito`

### Problema: Stock no se reduce
**Solución:**
1. Verificar llamada a `ProductoTalla::reducirStock()`
2. Verificar que talla_id se esté pasando correctamente
3. Revisar logs de base de datos

### Problema: Mismo producto con talla diferente no se agrega
**Solución:**
1. Verificar consulta SQL en `Carrito::agregar()`
2. Debe comparar `producto_id AND talla_id`
3. No solo `producto_id`

---

## 📊 ESTADÍSTICAS Y REPORTES

### Productos más vendidos por talla
```sql
SELECT 
    p.nombre as producto,
    t.nombre as talla,
    SUM(dp.cantidad) as total_vendido
FROM detalle_pedidos dp
INNER JOIN productos p ON dp.producto_id = p.id
LEFT JOIN tallas t ON dp.talla_id = t.id
WHERE dp.talla_id IS NOT NULL
GROUP BY dp.producto_id, dp.talla_id
ORDER BY total_vendido DESC
LIMIT 20;
```

### Tallas más populares (general)
```sql
SELECT 
    t.nombre as talla,
    COUNT(*) as veces_vendida,
    SUM(dp.cantidad) as unidades_vendidas
FROM detalle_pedidos dp
INNER JOIN tallas t ON dp.talla_id = t.id
WHERE dp.talla_id IS NOT NULL
GROUP BY dp.talla_id
ORDER BY unidades_vendidas DESC;
```

---

## 📝 NOTAS FINALES

1. **Compatibilidad hacia atrás:** El sistema es compatible con productos que no requieren talla (`talla_id = NULL`)

2. **Escalabilidad:** Fácilmente extensible para agregar:
   - Colores (crear tabla `producto_colores`)
   - Medidas personalizadas
   - Variantes múltiples (color + talla)

3. **Performance:** 
   - Índices optimizados en `producto_tallas`
   - Consultas JOIN eficientes
   - Caché de tallas disponibles en frontend

4. **UX:** 
   - Validación en tiempo real
   - Feedback visual inmediato
   - Mensajes de error claros

5. **Seguridad:**
   - Validación de stock en backend
   - Prepared statements en todas las consultas
   - Sanitización de inputs

---

**Última actualización:** 2024
**Versión:** 1.0
**Desarrollado para:** Tennis y Zapatos E-commerce
