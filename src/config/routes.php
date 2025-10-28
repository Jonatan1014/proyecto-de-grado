<?php
// src/config/routes.php

return [
    // Rutas principales con controladores
    '/' => ['controller' => 'ProductoController', 'action' => 'index'],
    '/home' => ['controller' => 'ProductoController', 'action' => 'index'],
    '/contact' => '../app/Views/contact.php',
    '/404' => '../app/Views/404.php',

    // Rutas de productos con controladores
    '/productos' => ['controller' => 'ProductoController', 'action' => 'catalogo'],
    '/catalogo' => ['controller' => 'ProductoController', 'action' => 'catalogo'],
    '/category' => ['controller' => 'ProductoController', 'action' => 'catalogo'],
    '/producto-detalle' => ['controller' => 'ProductoController', 'action' => 'detalle'],
    '/buscar' => ['controller' => 'ProductoController', 'action' => 'buscar'],

    // API de productos
    '/api/productos' => ['controller' => 'ProductoController', 'action' => 'apiObtenerProductos'],
    '/api/producto' => ['controller' => 'ProductoController', 'action' => 'apiObtenerProducto'],
    '/api/verificar-stock' => ['controller' => 'ProductoController', 'action' => 'apiVerificarStock'],

    // Rutas de tienda/ecommerce
    '/blog' => '../app/Views/blog.php',
    '/blog-details' => '../app/Views/blog-details.php',
    '/cart' => ['controller' => 'CarritoController', 'action' => 'ver'],
    '/checkout' => ['controller' => 'CheckoutController', 'action' => 'index'],
    '/confirmation' => ['controller' => 'CheckoutController', 'action' => 'confirmacion'],
    '/elements' => '../app/Views/elements.php',
    '/tracking' => '../app/Views/tracking.php',

    // API de carrito
    '/api/carrito/agregar' => ['controller' => 'CarritoController', 'action' => 'agregar'],
    '/api/carrito/actualizar' => ['controller' => 'CarritoController', 'action' => 'actualizar'],
    '/api/carrito/eliminar' => ['controller' => 'CarritoController', 'action' => 'eliminar'],
    '/api/carrito/vaciar' => ['controller' => 'CarritoController', 'action' => 'vaciar'],
    '/api/carrito/contar' => ['controller' => 'CarritoController', 'action' => 'contarItems'],

    // API de checkout y pedidos
    '/api/actualizar-cantidad' => ['controller' => 'CheckoutController', 'action' => 'actualizarCantidad'],
    '/api/eliminar-item' => ['controller' => 'CheckoutController', 'action' => 'eliminarItem'],
    '/api/procesar-pedido' => ['controller' => 'CheckoutController', 'action' => 'procesarPedido'],
    '/api/guardar-direccion' => ['controller' => 'CheckoutController', 'action' => 'guardarDireccion'],

    // Rutas de autenticación
    '/login' => ['controller' => 'AuthController', 'action' => 'handleLogin'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    '/registration' => '../app/Views/registration.php',
    '/registro' => ['controller' => 'RegistroController', 'action' => 'index'],

    // Rutas de perfil de usuario
    '/perfil' => ['controller' => 'PerfilController', 'action' => 'index'],
    '/perfil/actualizar-informacion' => ['controller' => 'PerfilController', 'action' => 'actualizarInformacion'],
    '/perfil/cambiar-password' => ['controller' => 'PerfilController', 'action' => 'cambiarPassword'],
    '/perfil/agregar-direccion' => ['controller' => 'PerfilController', 'action' => 'agregarDireccion'],
    '/perfil/actualizar-direccion' => ['controller' => 'PerfilController', 'action' => 'actualizarDireccion'],
    '/perfil/eliminar-direccion' => ['controller' => 'PerfilController', 'action' => 'eliminarDireccion'],
    '/perfil/establecer-principal' => ['controller' => 'PerfilController', 'action' => 'establecerPrincipal'],

    // Rutas de pedidos
    '/detalle-pedido' => ['controller' => 'PedidoController', 'action' => 'detalle'],
    '/pedido/cancelar' => ['controller' => 'PedidoController', 'action' => 'cancelar'],
    
    // Rutas de seguimiento de pedidos
    '/seguimiento-pedido' => ['controller' => 'SeguimientoPedidoController', 'action' => 'index'],
    '/api/seguimiento/estado' => ['controller' => 'SeguimientoPedidoController', 'action' => 'obtenerEstado'],


    // Rutas panel administrativo
    '/admin-dashboard' => ['controller' => 'AdminController', 'action' => 'index'],
    '/admin-productos' => ['controller' => 'AdminController', 'action' => 'productos'],
    '/admin-productos-api' => ['controller' => 'AdminController', 'action' => 'productosApi'],
    '/admin-categorias' => ['controller' => 'AdminController', 'action' => 'categorias'],
    '/admin-categorias-api' => ['controller' => 'AdminController', 'action' => 'categoriasApi'],
    '/admin-marcas' => ['controller' => 'AdminController', 'action' => 'marcas'],
    '/admin-marcas-api' => ['controller' => 'AdminController', 'action' => 'marcasApi'],
    '/admin-pedidos' => ['controller' => 'AdminController', 'action' => 'pedidos'],
    '/admin-pedidos-api' => ['controller' => 'AdminController', 'action' => 'pedidosApi'],
    '/admin-clientes' => ['controller' => 'AdminController', 'action' => 'clientes'],
    '/admin-clientes-api' => ['controller' => 'AdminController', 'action' => 'clientesApi'],
    '/admin-usuarios' => ['controller' => 'AdminController', 'action' => 'usuarios'],
    '/admin-usuarios-api' => ['controller' => 'AdminController', 'action' => 'usuariosApi'],
    '/admin-reportes' => ['controller' => 'AdminController', 'action' => 'reportes'],
    '/admin-reportes-api' => ['controller' => 'AdminController', 'action' => 'reportesApi'],
    '/admin-exportar-reporte' => ['controller' => 'AdminController', 'action' => 'exportarReporte'],
    '/admin-desencriptar' => ['controller' => 'AdminController', 'action' => 'desencriptar'],
    '/api/desencriptar-datos' => ['controller' => 'AdminController', 'action' => 'desencriptarApi'],

    // Rutas dinámicas con controladores
    '/auth/login' => ['controller' => 'AuthController', 'action' => 'handleLogin'],
    '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '/index' => ['controller' => 'AdminController', 'action' => 'index']
];