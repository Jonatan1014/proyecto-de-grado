# 📊 Sistema de Reportes - Panel Administrativo

## 📋 Índice
1. [Descripción General](#descripción-general)
2. [Tipos de Reportes](#tipos-de-reportes)
3. [Funcionalidades](#funcionalidades)
4. [Guía de Uso](#guía-de-uso)
5. [Exportación de Datos](#exportación-de-datos)
6. [Componentes Técnicos](#componentes-técnicos)

---

## 🎯 Descripción General

El Sistema de Reportes proporciona una herramienta completa para visualizar, analizar y exportar datos del negocio. Está diseñado exclusivamente para **administradores** y **empleados**, ofreciendo insights valiosos sobre ventas, productos, clientes e inventario.

### Características Principales

✅ **5 Tipos de Reportes** - General, Ventas, Productos, Clientes e Inventario  
✅ **Visualización Gráfica** - Gráficos de líneas, barras, torta y dona con Chart.js  
✅ **Filtros Avanzados** - Por período (hoy, semana, mes, trimestre, año, personalizado)  
✅ **Exportación Múltiple** - Excel (CSV), PDF (HTML) e Impresión  
✅ **Estadísticas en Tiempo Real** - Datos actualizados de la base de datos  
✅ **Interfaz Intuitiva** - Diseño moderno y responsive  

---

## 📊 Tipos de Reportes

### 1. 📈 Reporte General

**Descripción**: Vista completa del negocio con métricas clave.

**Estadísticas Mostradas**:
- 💰 Total Ventas (suma de todos los pedidos en el período)
- 📦 Total Pedidos (cantidad de pedidos realizados)
- 🛍️ Productos Activos (productos disponibles en catálogo)
- 👥 Total Clientes (clientes registrados)

**Gráficos Incluidos**:

1. **Ventas Diarias** (Gráfico de Líneas)
   - Muestra la evolución de ventas día a día
   - Permite identificar tendencias y patrones
   - Eje X: Fechas del período
   - Eje Y: Monto en pesos ($)

2. **Productos Más Vendidos** (Gráfico de Barras)
   - Top 10 productos con mayor cantidad vendida
   - Útil para identificar productos estrella
   - Muestra unidades vendidas por producto

3. **Pedidos por Estado** (Gráfico de Dona)
   - Distribución de pedidos según su estado
   - Estados: Pendiente, Confirmado, En Preparación, Enviado, Entregado, Cancelado
   - Colores distintivos para cada estado

**Tabla de Datos**:
- **Últimos 20 Pedidos**
  - Columnas: N° Pedido, Cliente, Fecha, Total, Estado
  - Ordenados por fecha descendente

**Casos de Uso**:
- Revisión diaria del estado del negocio
- Identificación de productos más populares
- Monitoreo de flujo de pedidos

---

### 2. 💰 Reporte de Ventas

**Descripción**: Análisis detallado del desempeño comercial.

**Estadísticas Mostradas**:
- 💵 Total Ventas (suma de ventas confirmadas)
- 📊 Promedio por Venta (ticket promedio)
- 🛒 Total Pedidos (pedidos en estados 2-5)
- 👑 Venta Máxima (pedido de mayor valor)

**Gráficos Incluidos**:

1. **Ventas por Categoría** (Gráfico de Torta)
   - Distribución de ingresos por categoría de producto
   - Permite identificar categorías más rentables
   - Porcentajes sobre el total de ventas

**Tabla de Datos**:
- **Ventas por Categoría**
  - Columnas: Categoría, Pedidos, Unidades, Total
  - Información detallada de performance por categoría

**Casos de Uso**:
- Análisis de rentabilidad por categoría
- Planificación de estrategias de marketing
- Identificación de oportunidades de crecimiento

**Nota**: Solo considera pedidos en estados:
- 2 (Confirmado)
- 3 (En Preparación)
- 4 (Enviado)
- 5 (Entregado)

---

### 3. 🛍️ Reporte de Productos

**Descripción**: Análisis del desempeño de productos individuales.

**Estadísticas Mostradas**:
- 📦 Total Productos (productos activos en catálogo)
- ⚠️ Stock Bajo (productos con menos de 5 unidades)
- ❌ Sin Stock (productos agotados)
- 💰 Valor Inventario (valor total del stock: precio × cantidad)

**Tabla de Datos**:
- **Top 10 Productos Más Vendidos**
  - Columnas: Producto, Stock Actual, Unidades Vendidas, Ingresos
  - Ordenados por unidades vendidas descendente
  - Muestra el stock actual vs lo vendido

**Casos de Uso**:
- Identificación de productos best-sellers
- Planificación de compras y reabastecimiento
- Análisis de rotación de inventario
- Decisiones sobre qué productos promocionar

**Alertas**:
- ⚠️ Productos con stock bajo requieren reorden
- ❌ Productos sin stock pueden generar pérdida de ventas

---

### 4. 👥 Reporte de Clientes

**Descripción**: Análisis del comportamiento y valor de clientes.

**Estadísticas Mostradas**:
- 👤 Total Clientes (clientes registrados en el sistema)
- ✅ Clientes Activos (clientes que compraron en el período)

**Tabla de Datos**:
- **Top 20 Clientes**
  - Columnas: Cliente, Pedidos, Total Gastado
  - Ordenados por total gastado descendente
  - Identifica a los clientes más valiosos (VIP)

**Casos de Uso**:
- Identificación de clientes VIP para programas de fidelización
- Análisis de tasa de conversión
- Segmentación de clientes para marketing dirigido
- Evaluación de retención de clientes

**Métricas Calculadas**:
- Frecuencia de compra por cliente
- Valor promedio de compra
- Clientes más leales

---

### 5. 📦 Reporte de Inventario

**Descripción**: Monitoreo del estado del inventario.

**Estadísticas Mostradas**:
- 🛍️ Total Productos (productos activos)
- ⚠️ Productos con Stock Bajo (< 5 unidades)

**Tabla de Datos**:
- **Productos con Stock Bajo**
  - Columnas: Producto, Categoría, Marca, Stock
  - Ordenados por stock ascendente
  - Incluye solo productos con menos de 5 unidades

**Casos de Uso**:
- Prevención de quiebres de stock
- Planificación de órdenes de compra
- Gestión de inventario mínimo
- Alertas tempranas de reabastecimiento

**Criterio de Alerta**:
- Stock < 5 unidades = Stock Bajo
- Stock = 0 = Sin Stock

---

## 🎨 Funcionalidades

### 1. Filtros de Período

**Opciones Predefinidas**:
```
┌─────────────────────────────────────┐
│ Período                             │
├─────────────────────────────────────┤
│ • Hoy                               │
│ • Esta Semana (últimos 7 días)     │
│ • Este Mes (mes actual)            │
│ • Este Trimestre (3 meses)         │
│ • Este Año (año actual)            │
│ • Personalizado (rango manual)     │
└─────────────────────────────────────┘
```

**Fechas Personalizadas**:
- Fecha Inicio: Selector de fecha
- Fecha Fin: Selector de fecha
- Permite análisis de cualquier rango de tiempo

### 2. Visualización con Chart.js

**Tipos de Gráficos Utilizados**:

1. **Line Chart** (Gráfico de Líneas)
   - Ideal para: Tendencias temporales
   - Usado en: Ventas diarias
   - Permite ver evolución en el tiempo

2. **Bar Chart** (Gráfico de Barras)
   - Ideal para: Comparaciones
   - Usado en: Productos más vendidos
   - Fácil comparación visual

3. **Pie Chart** (Gráfico de Torta)
   - Ideal para: Distribuciones porcentuales
   - Usado en: Ventas por categoría
   - Muestra proporción del total

4. **Doughnut Chart** (Gráfico de Dona)
   - Ideal para: Distribuciones con espacio central
   - Usado en: Pedidos por estado
   - Versión moderna del gráfico de torta

**Características**:
- Responsive (se adaptan al tamaño de pantalla)
- Interactivos (tooltips al pasar el mouse)
- Leyendas automáticas
- Colores distintivos

### 3. Estadísticas en Tiempo Real

**Cards de Estadísticas**:
```
┌─────────────────────────────────────┐
│  💰 Total Ventas                    │
│  $2.500.000                         │
│                              [Icon] │
└─────────────────────────────────────┘
```

**Características**:
- Iconos coloridos según métrica
- Números grandes y legibles
- Animación hover
- Actualización dinámica

### 4. Tablas de Datos Detallados

**Características de las Tablas**:
- Headers con fondo gris
- Filas alternadas para mejor legibilidad
- Hover effect en filas
- Responsive con scroll horizontal
- Hasta 20 registros mostrados

**Formato de Datos**:
- Fechas: DD/MM/YYYY HH:MM
- Montos: $###.### (formato colombiano)
- Estados: Con emoji y nombre

---

## 📖 Guía de Uso

### Paso 1: Acceder al Sistema

1. **Login**:
   ```
   URL: http://localhost/mayra/src/public/admin-reportes
   ```

2. **Verificación**:
   - Usuario debe ser `administrador` o `empleado`
   - Redirige a login si no está autenticado

3. **Navegación**:
   - Desde el menú lateral: Click en "📊 Reportes"

### Paso 2: Seleccionar Tipo de Reporte

```
┌─────────────────────────────────────┐
│ Tipo de Reporte ▼                   │
├─────────────────────────────────────┤
│ 📊 Reporte General                  │
│ 💰 Ventas                           │
│ 🛍️ Productos                        │
│ 👥 Clientes                         │
│ 📦 Inventario                       │
└─────────────────────────────────────┘
```

**Recomendaciones**:
- **General**: Para vista rápida diaria
- **Ventas**: Para análisis de ingresos
- **Productos**: Para gestión de inventario
- **Clientes**: Para estrategias de marketing
- **Inventario**: Para control de stock

### Paso 3: Configurar Período

**Opción A: Período Predefinido**
```
1. Seleccionar "Período" → "Este Mes"
2. Las fechas se actualizan automáticamente
3. Click en "Generar Reporte"
```

**Opción B: Rango Personalizado**
```
1. Seleccionar "Período" → "Personalizado"
2. Elegir "Fecha Inicio"
3. Elegir "Fecha Fin"
4. Click en "Generar Reporte"
```

### Paso 4: Visualizar Resultados

**El sistema mostrará**:

1. **Estadísticas Principales** (cards superiores)
   - 4 métricas clave con iconos
   - Valores numéricos grandes
   - Colores distintivos

2. **Gráficos** (sección media)
   - 1-3 gráficos según tipo de reporte
   - Interactivos con tooltips
   - Leyendas automáticas

3. **Tablas de Datos** (sección inferior)
   - Datos detallados en formato tabla
   - Ordenados por relevancia
   - Scroll horizontal si es necesario

### Paso 5: Analizar Datos

**Interpretación de Gráficos**:

- **Líneas ascendentes** = Crecimiento
- **Líneas descendentes** = Decrecimiento
- **Picos** = Días de alto volumen
- **Valles** = Días de bajo volumen

**Interpretación de Tablas**:

- **Primeras filas** = Productos/Clientes más importantes
- **Stocks bajos** = Requieren atención inmediata
- **Totales altos** = Oportunidades de negocio

---

## 💾 Exportación de Datos

### 1. Exportar a Excel (CSV)

**Proceso**:
```
1. Generar reporte deseado
2. Click en "📥 Exportar Excel"
3. Descarga automática del archivo .csv
```

**Contenido del archivo**:
```csv
REPORTE: VENTAS
Período: 2025-10-01 al 2025-10-27
Generado: 2025-10-27 18:30:45

ESTADÍSTICAS
Total Ventas,$2.500.000
Promedio por Venta,$250.000
Total Pedidos,10
Venta Máxima,$500.000

Ventas por Categoría
Categoría,Pedidos,Unidades,Total
Deportivos,5,15,$1.200.000
Casuales,3,8,$800.000
...
```

**Características**:
- UTF-8 con BOM (correcta visualización de caracteres especiales)
- Compatible con Excel, Google Sheets, LibreOffice
- Formato estándar CSV
- Incluye todas las tablas del reporte

**Usos**:
- Análisis avanzado en Excel
- Creación de dashboards personalizados
- Compartir con equipo
- Archivo histórico

### 2. Exportar a PDF (HTML)

**Proceso**:
```
1. Generar reporte deseado
2. Click en "📄 Exportar PDF"
3. Descarga automática del archivo .html
```

**Contenido del archivo**:
- Encabezado con título y período
- Estadísticas en cards visuales
- Tablas con estilos profesionales
- Footer con fecha de generación

**Características**:
- Formato HTML estilizado
- Fácil conversión a PDF real
- Diseño profesional
- Listo para imprimir

**Conversión a PDF Real**:
```
1. Abrir archivo .html en navegador
2. Ctrl+P (Imprimir)
3. Seleccionar "Guardar como PDF"
4. Ajustar márgenes y orientación
5. Guardar
```

### 3. Imprimir Reporte

**Proceso**:
```
1. Generar reporte deseado
2. Click en "🖨️ Imprimir"
3. Se abre ventana de impresión del navegador
```

**Características de Impresión**:
- Oculta elementos de navegación
- Optimizado para papel A4
- Breaks de página inteligentes
- Colores adaptados para impresión

**Estilos de Impresión**:
```css
@media print {
    .sidebar, .filters-card {
        display: none; /* Oculta menú lateral */
    }
    .stat-card {
        break-inside: avoid; /* No divide cards */
    }
}
```

---

## 🔧 Componentes Técnicos

### Arquitectura

```
┌─────────────────────────────────────────────┐
│           USUARIO (Admin/Empleado)          │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│         reportes.php (Vista)                │
│  • Interfaz de usuario                      │
│  • Filtros de período                       │
│  • Visualización con Chart.js               │
└──────────────────┬──────────────────────────┘
                   │ AJAX Request
                   ▼
┌─────────────────────────────────────────────┐
│    AdminController::reportesApi()           │
│  • Recibe parámetros (tipo, fechas)        │
│  • Enrutamiento a método específico         │
└──────────────────┬──────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────┐
│      Métodos de Generación                  │
│  • reporteGeneral()                         │
│  • reporteVentas()                          │
│  • reporteProductos()                       │
│  • reporteClientes()                        │
│  • reporteInventario()                      │
└──────────────────┬──────────────────────────┘
                   │ SQL Queries
                   ▼
┌─────────────────────────────────────────────┐
│         Base de Datos MySQL                 │
│  • pedidos, detalle_pedidos                 │
│  • productos, categorias, marcas            │
│  • usuarios, estados_pedido                 │
└─────────────────────────────────────────────┘
```

### Rutas Configuradas

**En `routes.php`**:
```php
'/admin-reportes' => [
    'controller' => 'AdminController',
    'action' => 'reportes'
]

'/admin-reportes-api' => [
    'controller' => 'AdminController',
    'action' => 'reportesApi'
]

'/admin-exportar-reporte' => [
    'controller' => 'AdminController',
    'action' => 'exportarReporte'
]
```

### Métodos del Controller

#### 1. `reportes()`
```php
public function reportes()
```
- **Descripción**: Muestra la vista principal
- **Autenticación**: Requerida (admin/empleado)
- **Retorno**: Include de `reportes.php`

#### 2. `reportesApi()`
```php
public function reportesApi()
```
- **Descripción**: API para generar reportes dinámicamente
- **Parámetros**:
  - `action`: 'generar'
  - `tipo`: 'general', 'ventas', 'productos', 'clientes', 'inventario'
  - `inicio`: Fecha inicio (YYYY-MM-DD)
  - `fin`: Fecha fin (YYYY-MM-DD)
- **Retorno**: JSON con estructura de reporte

#### 3. `generarReporte()`
```php
private function generarReporte($tipo, $fechaInicio, $fechaFin)
```
- **Descripción**: Router a métodos específicos
- **Retorno**: Array con ['estadisticas', 'graficos', 'tablas']

#### 4. `exportarReporte()`
```php
public function exportarReporte()
```
- **Descripción**: Maneja exportación a diferentes formatos
- **Parámetros**:
  - `formato`: 'excel' o 'pdf'
  - `tipo`: Tipo de reporte
  - `inicio`, `fin`: Fechas
- **Acción**: Descarga directa del archivo

#### 5. `exportarExcel()`
```php
private function exportarExcel($reporte, $tipo, $fechaInicio, $fechaFin)
```
- **Descripción**: Genera archivo CSV
- **Formato**: UTF-8 con BOM
- **Salida**: Descarga automática

#### 6. `exportarPDF()`
```php
private function exportarPDF($reporte, $tipo, $fechaInicio, $fechaFin)
```
- **Descripción**: Genera archivo HTML estilizado
- **Salida**: Descarga automática

### Estructura de Datos Retornada

**Formato JSON de respuesta**:
```json
{
  "success": true,
  "reporte": {
    "estadisticas": [
      {
        "titulo": "Total Ventas",
        "valor": "$2.500.000",
        "icono": "ti-money",
        "color": "purple"
      }
    ],
    "graficos": [
      {
        "titulo": "Ventas Diarias",
        "tipo": "line",
        "data": {
          "labels": ["01/10", "02/10", "03/10"],
          "datasets": [{
            "label": "Ventas ($)",
            "data": [100000, 150000, 120000],
            "borderColor": "#667eea",
            "backgroundColor": "rgba(102, 126, 234, 0.1)"
          }]
        }
      }
    ],
    "tablas": [
      {
        "titulo": "Últimos Pedidos",
        "columnas": ["N° Pedido", "Cliente", "Fecha", "Total", "Estado"],
        "datos": [
          ["#001234", "Juan Pérez", "27/10/2025", "$250.000", "Entregado"]
        ]
      }
    ]
  }
}
```

### Consultas SQL Principales

#### Estadísticas de Ventas
```sql
SELECT 
    COUNT(*) as total_pedidos,
    COALESCE(SUM(total), 0) as total_ventas,
    COALESCE(AVG(total), 0) as promedio_venta
FROM pedidos 
WHERE DATE(fecha_pedido) BETWEEN :inicio AND :fin
AND estado_pedido_id != 6  -- Excluye cancelados
```

#### Productos Más Vendidos
```sql
SELECT 
    p.nombre,
    SUM(dp.cantidad) as cantidad_vendida
FROM detalle_pedidos dp
INNER JOIN productos p ON dp.producto_id = p.id
INNER JOIN pedidos ped ON dp.pedido_id = ped.id
WHERE DATE(ped.fecha_pedido) BETWEEN :inicio AND :fin
AND ped.estado_pedido_id != 6
GROUP BY p.id, p.nombre
ORDER BY cantidad_vendida DESC
LIMIT 10
```

#### Top Clientes
```sql
SELECT 
    CONCAT(u.nombre, ' ', u.apellido) as cliente,
    COUNT(p.id) as pedidos,
    SUM(p.total) as total_gastado
FROM pedidos p
INNER JOIN usuarios u ON p.usuario_id = u.id
WHERE DATE(p.fecha_pedido) BETWEEN :inicio AND :fin
AND p.estado_pedido_id IN (2,3,4,5)
GROUP BY u.id, u.nombre, u.apellido
ORDER BY total_gastado DESC
LIMIT 20
```

### Tecnologías Frontend

**Chart.js**:
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
```

**Creación de Gráfico**:
```javascript
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mié'],
        datasets: [{
            label: 'Ventas',
            data: [12, 19, 3]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
```

**Destrucción de Gráficos**:
```javascript
// Importante para evitar memory leaks
Object.values(chartInstances).forEach(chart => chart.destroy());
```

---

## ✅ Casos de Uso Prácticos

### Caso 1: Análisis de Ventas Mensuales

**Escenario**: El gerente quiere revisar el desempeño de ventas del mes.

**Pasos**:
1. Acceder a `/admin-reportes`
2. Seleccionar "💰 Ventas"
3. Período: "Este Mes"
4. Click "Generar Reporte"

**Resultados**:
- Total vendido en el mes
- Promedio de venta
- Categorías más rentables
- Exportar a Excel para presentación

### Caso 2: Reabastecimiento de Inventario

**Escenario**: Se necesita saber qué productos reabastecer.

**Pasos**:
1. Acceder a `/admin-reportes`
2. Seleccionar "📦 Inventario"
3. Generar reporte

**Resultados**:
- Lista de productos con stock < 5
- Información de categoría y marca
- Exportar a PDF para orden de compra

### Caso 3: Campaña de Fidelización

**Escenario**: Crear programa VIP para mejores clientes.

**Pasos**:
1. Acceder a `/admin-reportes`
2. Seleccionar "👥 Clientes"
3. Período: "Este Año"
4. Generar reporte

**Resultados**:
- Top 20 clientes por monto gastado
- Frecuencia de compra
- Exportar a Excel para mailchimp

### Caso 4: Evaluación de Productos

**Escenario**: Decidir qué productos descontinuar o promocionar.

**Pasos**:
1. Acceder a `/admin-reportes`
2. Seleccionar "🛍️ Productos"
3. Período: "Este Trimestre"
4. Generar reporte

**Resultados**:
- Productos más vendidos
- Productos con poco movimiento
- Valor de inventario actual

---

## 🚀 Mejoras Futuras Sugeridas

### Versión 2.0
- [ ] Gráficos adicionales (comparativas año vs año)
- [ ] Exportación a PDF real (con librería FPDF o TCPDF)
- [ ] Exportación a Excel real (con PHPSpreadsheet)
- [ ] Reportes programados (emails automáticos)
- [ ] Dashboard con widgets personalizables
- [ ] Filtros avanzados (por marca, categoría)
- [ ] Comparación de períodos
- [ ] Predicciones con IA

### Versión 3.0
- [ ] Reportes en tiempo real (WebSockets)
- [ ] App móvil para reportes
- [ ] Integración con Google Analytics
- [ ] Business Intelligence completo
- [ ] Alertas automáticas
- [ ] Recomendaciones inteligentes

---

## 📞 Soporte

Para consultas sobre el sistema de reportes:
- **Documentación**: Este archivo
- **Código**: `src/app/Views/admin/reportes.php`
- **Controller**: `src/app/Controllers/AdminController.php`

---

**Desarrollado para Tennis y Zapatos - Sistema de Gestión Administrativa**

*Última actualización: 27 de Octubre de 2025*
