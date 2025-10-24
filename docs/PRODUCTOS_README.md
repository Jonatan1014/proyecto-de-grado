# Sistema de Visualización de Productos

## Archivos Creados

### Modelos
1. **Producto.php** - Modelo principal para gestionar productos
   - `obtenerTodos()` - Obtiene todos los productos activos
   - `obtenerDestacados()` - Obtiene productos destacados
   - `obtenerPorId()` - Obtiene un producto específico
   - `obtenerPorCategoria()` - Filtra productos por categoría
   - `obtenerEnOferta()` - Obtiene productos en oferta
   - `buscar()` - Busca productos por término
   - `obtenerImagenes()` - Obtiene imágenes de un producto
   - `verificarStock()` - Verifica disponibilidad
   - `obtenerRelacionados()` - Productos relacionados
   - `obtenerPorFiltros()` - Búsqueda avanzada con filtros

2. **Categoria.php** - Modelo para categorías
   - `obtenerTodas()` - Lista todas las categorías
   - `obtenerPorId()` - Obtiene una categoría específica
   - `contarProductos()` - Cuenta productos por categoría

3. **Marca.php** - Modelo para marcas
   - `obtenerTodas()` - Lista todas las marcas
   - `obtenerPorId()` - Obtiene una marca específica

### Controladores
**ProductoController.php** - Controlador principal de productos
- `index()` - Página principal con productos destacados
- `catalogo()` - Catálogo completo con paginación y filtros
- `detalle()` - Detalle de un producto específico
- `buscar()` - Búsqueda de productos
- `apiObtenerProductos()` - API para obtener productos en JSON
- `apiObtenerProducto()` - API para obtener un producto específico
- `apiVerificarStock()` - API para verificar disponibilidad

### Utilidades
**Helpers.php** - Funciones auxiliares
- `formatearPrecio()` - Formatea precios en pesos colombianos
- `calcularDescuento()` - Calcula el porcentaje de descuento
- `obtenerImagenProducto()` - Obtiene imagen o imagen por defecto
- `truncarTexto()` - Trunca texto largo
- `generarEstrellas()` - Genera HTML de rating
- `tieneDescuento()` - Verifica si hay oferta
- `formatearFecha()` - Formatea fechas
- `generarSlug()` - Genera URLs amigables
- `obtenerTextoStock()` - Texto de disponibilidad
- `urlProducto()` - Genera URL de producto
- `urlCategoria()` - Genera URL de categoría

## Rutas Configuradas

### Vistas
- `/` o `/home` → Página principal con productos destacados
- `/category` → Catálogo de productos
- `/producto` o `/single-product` → Detalle de producto
- `/buscar` → Búsqueda de productos

### API (retorna JSON)
- `/api/productos` → Lista de productos
  - Parámetros: `limite`, `offset`, `destacados`
- `/api/producto?id={id}` → Detalle de un producto
- `/api/verificar-stock` → Verificar disponibilidad (POST)
  - Parámetros: `producto_id`, `cantidad`

## Uso en las Vistas

### 1. Página Principal (home.php)
```php
<?php require_once __DIR__ . '/../Utils/Helpers.php'; ?>

<!-- Mostrar productos destacados -->
<?php if (!empty($productosDestacados)): ?>
    <?php foreach ($productosDestacados as $producto): ?>
        <div class="single-product">
            <img src="<?php echo obtenerImagenProducto($producto['imagen_principal']); ?>" 
                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
            <h6><?php echo truncarTexto($producto['nombre'], 50); ?></h6>
            <div class="price">
                <?php if (tieneDescuento($producto['precio_oferta'])): ?>
                    <h6><?php echo formatearPrecio($producto['precio_oferta']); ?></h6>
                    <h6 class="l-through"><?php echo formatearPrecio($producto['precio']); ?></h6>
                <?php else: ?>
                    <h6><?php echo formatearPrecio($producto['precio']); ?></h6>
                <?php endif; ?>
            </div>
            <a href="<?php echo urlProducto($producto['id'], $producto['nombre']); ?>">
                Ver detalles
            </a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
```

### 2. Catálogo (category.php)
```php
<!-- Mostrar productos con paginación -->
<?php foreach ($productos as $producto): ?>
    <!-- Tarjeta de producto -->
<?php endforeach; ?>

<!-- Paginación -->
<?php if ($totalPaginas > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <a href="?pagina=<?php echo $i; ?>" 
               class="<?php echo $i == $paginaActual ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>
```

### 3. Detalle de Producto (single-product.php)
```php
<?php if (isset($producto)): ?>
    <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
    <div class="price">
        <?php if (tieneDescuento($producto['precio_oferta'])): ?>
            <h3><?php echo formatearPrecio($producto['precio_oferta']); ?></h3>
            <del><?php echo formatearPrecio($producto['precio']); ?></del>
            <span class="discount">
                <?php echo calcularDescuento($producto['precio'], $producto['precio_oferta']); ?>% OFF
            </span>
        <?php else: ?>
            <h3><?php echo formatearPrecio($producto['precio']); ?></h3>
        <?php endif; ?>
    </div>
    
    <p><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></p>
    
    <div class="stock">
        <span class="badge <?php echo obtenerClaseStock($producto['stock'], $producto['stock_minimo']); ?>">
            <?php echo obtenerTextoStock($producto['stock'], $producto['stock_minimo']); ?>
        </span>
    </div>
    
    <!-- Productos relacionados -->
    <?php if (!empty($productosRelacionados)): ?>
        <h3>Productos Relacionados</h3>
        <?php foreach ($productosRelacionados as $relacionado): ?>
            <!-- Mostrar producto relacionado -->
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
```

## Uso de API con JavaScript

### Cargar productos dinámicamente
```javascript
// Obtener productos destacados
fetch('/api/productos?destacados=true&limite=8')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Productos:', data.data);
            // Renderizar productos
        }
    });

// Verificar stock antes de agregar al carrito
fetch('/api/verificar-stock', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: `producto_id=1&cantidad=2`
})
.then(response => response.json())
.then(data => {
    if (data.success && data.disponible) {
        // Agregar al carrito
    } else {
        alert('Sin stock disponible');
    }
});
```

## Parámetros de Búsqueda y Filtrado

### Catálogo con filtros
```
/category?categoria=1&marca=2&genero=1&precio_min=50000&precio_max=200000&orden=precio_asc&pagina=1
```

**Parámetros disponibles:**
- `categoria` - ID de categoría
- `marca` - ID de marca
- `genero` - ID de género
- `precio_min` - Precio mínimo
- `precio_max` - Precio máximo
- `orden` - Ordenamiento: `precio_asc`, `precio_desc`, `nombre`, `reciente`
- `pagina` - Número de página

### Búsqueda
```
/buscar?q=nike&pagina=1
```

## Consideraciones Importantes

1. **Imágenes**: Asegúrate de que las rutas de imágenes en la base de datos sean relativas a la carpeta `public/`
   Ejemplo: `img/product/nike-air-max.jpg`

2. **Seguridad**: Todas las funciones incluyen escape de HTML para prevenir XSS

3. **Performance**: Los métodos incluyen límites y paginación para no sobrecargar la base de datos

4. **Stock**: Siempre verifica disponibilidad antes de procesar una compra

5. **Precios**: Los precios se manejan como DECIMAL en la BD para precisión

## Próximos Pasos

1. Implementar el sistema de carrito de compras
2. Crear el sistema de gestión de pedidos
3. Añadir sistema de reseñas y calificaciones
4. Implementar filtros avanzados en el catálogo
5. Crear panel de administración para productos

## Estructura de Base de Datos Requerida

Las tablas necesarias ya están en tu base de datos:
- `productos`
- `categorias`
- `marcas`
- `tallas`
- `colores`
- `generos`
- `imagenes_productos`

Asegúrate de que están creadas y tienen datos antes de usar el sistema.
