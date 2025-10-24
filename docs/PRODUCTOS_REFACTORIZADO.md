# Sistema de Productos Refactorizado - Guía de Uso

## 🎯 Cambios Implementados

El sistema ha sido refactorizado para usar **PDO** y **métodos estáticos**, siguiendo el patrón de diseño de Active Record simplificado.

### ✨ Principales Mejoras

1. **PDO en lugar de MySQLi**: Mayor seguridad y compatibilidad
2. **Métodos estáticos**: No necesitas instanciar modelos
3. **Prepared Statements**: Todas las consultas usan parámetros nombrados
4. **Sin dependencia de constructor**: Los modelos se usan directamente con `Modelo::metodo()`

---

## 📁 Estructura de Archivos

```
src/
├── app/
│   ├── Models/
│   │   ├── Producto.php      ✅ Refactorizado
│   │   ├── Categoria.php     ✅ Refactorizado
│   │   └── Marca.php          ✅ Refactorizado
│   ├── Controllers/
│   │   └── ProductoController.php  ✅ Refactorizado
│   └── Utils/
│       └── Helpers.php        ✅ Funciones auxiliares
└── config/
    └── database.php           (debe usar PDO)
```

---

## 🔧 Uso de los Modelos

### Modelo Producto

#### Obtener productos
```php
// Obtener todos los productos (con límite opcional)
$productos = Producto::obtenerTodos(10, 0);  // límite 10, offset 0

// Productos destacados
$destacados = Producto::obtenerDestacados(8);

// Productos en oferta
$ofertas = Producto::obtenerEnOferta(6);

// Producto por ID
$producto = Producto::obtenerPorId(5);

// Por categoría
$productos = Producto::obtenerPorCategoria(1, 12, 0);

// Búsqueda
$resultados = Producto::buscar('nike', 12, 0);
```

#### Filtros avanzados
```php
$filtros = [
    'categoria_id' => 1,
    'marca_id' => 2,
    'genero_id' => 1,
    'precio_min' => 50000,
    'precio_max' => 200000,
    'orden' => 'precio_asc'  // precio_asc, precio_desc, nombre, reciente
];

$productos = Producto::obtenerPorFiltros($filtros, 12, 0);
```

#### CRUD de productos
```php
// Crear producto
$nuevoId = Producto::create([
    'nombre' => 'Nike Air Max',
    'descripcion' => 'Zapatillas deportivas',
    'precio' => 150000,
    'precio_oferta' => 120000,
    'categoria_id' => 1,
    'marca_id' => 2,
    'stock' => 50,
    'codigo_sku' => 'NIKE-AIR-001',
    'destacado' => 1
]);

// Actualizar producto
$actualizado = Producto::update(5, [
    'nombre' => 'Nike Air Max 2024',
    'precio' => 180000,
    'stock' => 30
]);

// Eliminar (cambia estado a inactivo)
$eliminado = Producto::delete(5);

// Verificar si SKU existe
$existe = Producto::skuExists('NIKE-AIR-001');

// Actualizar stock
Producto::actualizarStock(5, 10, 'sumar');    // Añadir 10 unidades
Producto::actualizarStock(5, 3, 'restar');    // Quitar 3 unidades
```

#### Utilidades
```php
// Verificar stock disponible
$hayStock = Producto::verificarStock(5, 2);  // ID 5, cantidad 2

// Productos relacionados
$relacionados = Producto::obtenerRelacionados(5, 1, 4);  // producto ID 5, categoría 1, límite 4

// Contar total
$total = Producto::contarTotal(['categoria_id' => 1]);

// Obtener imágenes
$imagenes = Producto::obtenerImagenes(5);
```

---

### Modelo Categoría

```php
// Todas las categorías
$categorias = Categoria::obtenerTodas();

// Una categoría
$categoria = Categoria::obtenerPorId(1);

// Contar productos
$total = Categoria::contarProductos(1);

// CRUD
$id = Categoria::create(['nombre' => 'Deportivo', 'descripcion' => 'Calzado deportivo']);
Categoria::update(1, ['nombre' => 'Deportes']);
Categoria::delete(1);
```

---

### Modelo Marca

```php
// Todas las marcas
$marcas = Marca::obtenerTodas();

// Una marca
$marca = Marca::obtenerPorId(1);

// CRUD
$id = Marca::create(['nombre' => 'Nike', 'descripcion' => 'Just Do It']);
Marca::update(1, ['nombre' => 'Nike Inc.']);
Marca::delete(1);
```

---

## 🎮 Uso del Controlador

### En las vistas

El controlador ya no necesita instanciarse. Los métodos se llaman automáticamente desde las rutas.

#### Página principal (/)
```php
// El controlador pasa estas variables a la vista:
$productosDestacados  // Array de productos destacados
$productosNuevos      // Array de productos nuevos
$productosOferta      // Array de productos en oferta
```

#### Catálogo (/category)
```php
// Variables disponibles:
$productos           // Array de productos filtrados
$paginaActual       // Número de página actual
$totalPaginas       // Total de páginas
$totalProductos     // Total de productos
$filtros            // Filtros aplicados
```

#### Detalle (/producto?id=5)
```php
// Variables disponibles:
$producto                // Datos del producto
$imagenes               // Array de imágenes
$productosRelacionados  // Array de productos similares
```

#### Búsqueda (/buscar?q=nike)
```php
// Variables disponibles:
$productos          // Resultados de búsqueda
$terminoBusqueda   // Término buscado
$paginaActual      // Página actual
$totalPaginas      // Total de páginas
$totalProductos    // Total de resultados
```

---

## 🌐 API REST

### Obtener productos
```javascript
// GET /api/productos?destacados=true&limite=8
fetch('/api/productos?destacados=true&limite=8')
    .then(res => res.json())
    .then(data => {
        console.log(data.data);  // Array de productos
    });
```

### Obtener un producto
```javascript
// GET /api/producto?id=5
fetch('/api/producto?id=5')
    .then(res => res.json())
    .then(data => {
        console.log(data.data);  // Objeto producto
    });
```

### Verificar stock
```javascript
// POST /api/verificar-stock
fetch('/api/verificar-stock', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'producto_id=5&cantidad=2'
})
.then(res => res.json())
.then(data => {
    console.log(data.disponible);  // true/false
});
```

---

## 🛠️ Funciones Helper

```php
// En tus vistas, incluye los helpers
require_once __DIR__ . '/../Utils/Helpers.php';

// Formatear precio
echo formatearPrecio(150000);  // $150.000

// Calcular descuento
$descuento = calcularDescuento(150000, 120000);  // 20

// Verificar descuento
if (tieneDescuento($producto['precio_oferta'])) {
    echo "En oferta!";
}

// Imagen del producto
$img = obtenerImagenProducto($producto['imagen_principal'], 'img/default.jpg');

// Truncar texto
echo truncarTexto($producto['descripcion'], 100);

// URL de producto
$url = urlProducto($producto['id'], $producto['nombre']);
// /producto?id=5&nombre=nike-air-max

// URL de categoría
$url = urlCategoria(1, 'Deportivo');
// /category?categoria=1&nombre=deportivo

// Estado de stock
echo obtenerTextoStock($producto['stock'], $producto['stock_minimo']);
// "Disponible", "Pocas unidades", "Agotado"

$clase = obtenerClaseStock($producto['stock'], $producto['stock_minimo']);
// "badge-success", "badge-warning", "badge-danger"
```

---

## 📝 Ejemplo Completo en Vista

```php
<?php require_once __DIR__ . '/../Utils/Helpers.php'; ?>

<div class="productos">
    <?php if (!empty($productosDestacados)): ?>
        <?php foreach ($productosDestacados as $producto): ?>
            <div class="producto-card">
                <img src="<?php echo obtenerImagenProducto($producto['imagen_principal']); ?>" 
                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                
                <h3><?php echo truncarTexto($producto['nombre'], 50); ?></h3>
                
                <div class="precio">
                    <?php if (tieneDescuento($producto['precio_oferta'])): ?>
                        <span class="oferta"><?php echo formatearPrecio($producto['precio_oferta']); ?></span>
                        <del><?php echo formatearPrecio($producto['precio']); ?></del>
                        <span class="descuento">
                            <?php echo calcularDescuento($producto['precio'], $producto['precio_oferta']); ?>% OFF
                        </span>
                    <?php else: ?>
                        <span><?php echo formatearPrecio($producto['precio']); ?></span>
                    <?php endif; ?>
                </div>
                
                <span class="badge <?php echo obtenerClaseStock($producto['stock'], $producto['stock_minimo']); ?>">
                    <?php echo obtenerTextoStock($producto['stock'], $producto['stock_minimo']); ?>
                </span>
                
                <a href="<?php echo urlProducto($producto['id'], $producto['nombre']); ?>" 
                   class="btn">Ver detalles</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles</p>
    <?php endif; ?>
</div>
```

---

## ⚙️ Configuración Necesaria

### database.php debe usar PDO:

```php
class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $host = DB_HOST;
                $dbname = DB_NAME;
                $username = DB_USER;
                $password = DB_PASS;

                self::$connection = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
```

---

## 🚀 Ventajas de esta Refactorización

✅ **Código más limpio**: Sin constructores ni propiedades de instancia  
✅ **Más fácil de usar**: `Producto::obtenerTodos()` en lugar de `$producto->obtenerTodos()`  
✅ **PDO**: Más seguro y con mejor manejo de errores  
✅ **Prepared Statements**: Protección contra SQL Injection  
✅ **Parámetros nombrados**: Código más legible  
✅ **Métodos CRUD completos**: Create, Read, Update, Delete  
✅ **Validaciones incluidas**: `skuExists()`, `verificarStock()`  
✅ **Compatible con tu estilo actual**: Mismo patrón que UserController  

---

## 📌 Notas Importantes

1. Todos los métodos son **estáticos** - No necesitas `new Producto()`
2. Usa **PDO** - Asegúrate de que `database.php` retorne conexión PDO
3. Los parámetros son **nombrados** - Más seguros y legibles
4. `delete()` es **lógico** - Cambia estado a 'inactivo', no borra registro
5. Todos los métodos incluyen **manejo de excepciones**

---

¡Listo para usar! 🎉
