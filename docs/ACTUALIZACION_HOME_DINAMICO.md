# Actualización Home Dinámico

## Resumen de Cambios

Se ha actualizado la vista `home.php` para mostrar productos dinámicos desde la base de datos en lugar de contenido estático HTML.

## Archivos Modificados

### 1. `src/app/Views/home.php`
- **Agregado**: Inclusión del archivo de helpers al inicio del archivo
- **Actualizado**: Sección "Latest Products" - Ahora muestra productos nuevos desde `$productosNuevos`
- **Actualizado**: Sección "Coming Products" - Ahora muestra productos destacados desde `$productosDestacados`
- **Actualizado**: Sección "Exclusive Hot Deal" - Carrusel lateral ahora muestra los primeros 3 productos en oferta
- **Actualizado**: Sección "Deals of the Week" - Ahora muestra productos en oferta desde `$productosOferta`

### 2. `src/app/Utils/Helpers.php`
Funciones actualizadas y agregadas:

#### Funciones Modificadas:
- `obtenerImagenProducto($producto, $porDefecto)`: Ahora acepta un array de producto o una ruta de imagen
- `tieneDescuento($producto)`: Ahora verifica si un producto (array) tiene descuento activo

#### Funciones Agregadas:
- `calcularPrecioOriginal($producto)`: Obtiene el precio original del producto cuando hay descuento

### 3. `database/add_imagen_productos.sql`
- **Creado**: Script SQL para agregar el campo `imagen_principal` a la tabla `productos`
- **Ejecutado**: El script se ejecutó exitosamente en la base de datos
- El campo almacena la ruta de la imagen (VARCHAR(255))
- Se actualizaron productos existentes con imágenes de ejemplo (p1.jpg a p8.jpg)

## Características Implementadas

### Visualización Dinámica de Productos

1. **Latest Products (Productos Más Recientes)**
   - Muestra hasta 8 productos nuevos
   - Utiliza la variable `$productosNuevos` del controlador
   - Cada tarjeta muestra: imagen, nombre truncado, precio, descuento (si aplica)

2. **Coming Products (Productos Destacados)**
   - Muestra hasta 8 productos destacados
   - Utiliza la variable `$productosDestacados` del controlador
   - Mismo formato de tarjeta que Latest Products

3. **Exclusive Hot Deal (Oferta Exclusiva)**
   - Carrusel lateral con hasta 3 productos en oferta
   - Utiliza `array_slice($productosOferta, 0, 3)`
   - Muestra imagen grande, precio original y precio de oferta

4. **Deals of the Week (Ofertas de la Semana)**
   - Lista de productos en oferta en formato compacto
   - Utiliza la variable `$productosOferta` del controlador
   - Formato horizontal con imagen pequeña y detalles

### Funcionalidades de las Tarjetas de Producto

Cada tarjeta de producto incluye:
- **Imagen**: Obtenida dinámicamente o imagen por defecto
- **Nombre**: Truncado a 50 caracteres con `truncarTexto()`
- **Precio**: Formateado con `formatearPrecio()`
- **Precio Original**: Mostrado con línea atravesada si hay descuento
- **Acciones**:
  - Agregar a bolsa
  - Agregar a wishlist
  - Comparar
  - Ver más (enlace a detalle del producto)

### Estados Vacíos

Se implementaron mensajes cuando no hay productos disponibles:
```php
<?php if (!empty($productos)): ?>
    <!-- Mostrar productos -->
<?php else: ?>
    <div class="col-12 text-center">
        <p>No hay productos disponibles en este momento.</p>
    </div>
<?php endif; ?>
```

## Datos Pasados desde el Controlador

El `ProductoController::index()` pasa las siguientes variables a la vista:

```php
$data = [
    'productosDestacados' => $productosDestacados,  // 8 productos
    'productosNuevos' => $productosNuevos,          // 8 productos
    'productosOferta' => $productosOferta            // 4 productos
];
```

## Funciones Helper Utilizadas

```php
// Formateo
formatearPrecio($precio)                    // Formato moneda colombiana: $123.456
truncarTexto($texto, $limite, $sufijo)      // Limita texto a X caracteres

// Producto
obtenerImagenProducto($producto)            // Obtiene ruta de imagen o default
tieneDescuento($producto)                   // Verifica si hay descuento
calcularPrecioOriginal($producto)           // Obtiene precio sin descuento

// URLs
urlProducto($id)                            // Genera URL: /producto?id=X
urlCategoria($id)                           // Genera URL: /category?categoria=X

// Seguridad
htmlspecialchars($texto)                    // Escapa HTML para seguridad
```

## Base de Datos

### Campo Agregado a la Tabla `productos`

```sql
ALTER TABLE productos 
ADD COLUMN imagen_principal VARCHAR(255) NULL 
AFTER descripcion;
```

### Datos de Ejemplo

Los productos existentes fueron actualizados con rutas de imagen:
- `img/product/p1.jpg`
- `img/product/p2.jpg`
- ... hasta `img/product/p8.jpg`

Las rutas se asignan cíclicamente usando: `((id - 1) % 8) + 1`

## Compatibilidad con el Diseño Original

✅ **Preservado**:
- Estructura HTML completa
- Clases CSS (Bootstrap + personalizadas)
- Layout responsive (col-lg-3, col-md-6)
- Carruseles owl-carousel
- Iconos (Themify, Linearicons)
- Espaciados y márgenes

✅ **Mejorado**:
- Contenido dinámico desde base de datos
- Manejo de estados vacíos
- Seguridad con htmlspecialchars()
- Enlaces funcionales a detalle de producto
- Precios formateados correctamente

## Pruebas Recomendadas

1. **Visualización**:
   - [ ] Verificar que las imágenes se cargan correctamente
   - [ ] Comprobar formato de precios
   - [ ] Verificar que los descuentos se muestran correctamente

2. **Enlaces**:
   - [ ] Click en "view more" redirige a detalle del producto
   - [ ] URLs se generan correctamente

3. **Estados**:
   - [ ] Mensajes apropiados cuando no hay productos
   - [ ] Carruseles funcionan con productos dinámicos

4. **Responsive**:
   - [ ] Layout se mantiene en móvil
   - [ ] Imágenes responsive

## Próximos Pasos Sugeridos

1. Implementar funcionalidad "Agregar a Bolsa" con JavaScript/AJAX
2. Implementar sistema de Wishlist
3. Implementar comparación de productos
4. Agregar paginación en secciones si hay muchos productos
5. Implementar filtros dinámicos
6. Optimizar carga de imágenes (lazy loading)
7. Agregar caché para mejorar rendimiento

## Notas Técnicas

- **Patrón MVC**: Se mantiene separación de lógica (Controlador), datos (Modelo) y presentación (Vista)
- **PDO**: Todas las consultas usan PDO con prepared statements
- **Seguridad**: htmlspecialchars() previene XSS
- **Helpers**: Funciones reutilizables simplifican la vista
- **Arrays**: Se usa array_slice() para limitar productos en carrusel

## Comandos Ejecutados

```bash
# Ejecutar migración de base de datos
mysql -u root -p tennisyzapatos_db < database/add_imagen_productos.sql
```

---

**Fecha de actualización**: 2025
**Desarrollador**: Sistema de productos dinámicos
