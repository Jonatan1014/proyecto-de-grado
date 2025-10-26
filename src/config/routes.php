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

    // Rutas de admin con controladores
    '/apps-calendar' => ['controller' => 'AdminController', 'action' => 'appsCalendar'],
    '/apps-tasks' => ['controller' => 'AdminController', 'action' => 'appsTasks'],
    '/pages-profile' => ['controller' => 'AdminController', 'action' => 'pagesProfile'],
    '/pages-add-medico' => ['controller' => 'AdminController', 'action' => 'pagesAddMedico'],
    '/add-medico' => ['controller' => 'AdminController', 'action' => 'addMedico'],
    '/pages-get-medico' => ['controller' => 'AdminController', 'action' => 'readMedico'],
    '/pages-upd-medico' => ['controller' => 'AdminController', 'action' => 'editMedico'],
    '/update-medico' => ['controller' => 'AdminController', 'action' => 'updateMedico'],

    // Rutas dinámicas con controladores
    '/auth/login' => ['controller' => 'AuthController', 'action' => 'handleLogin'],
    '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '/index' => ['controller' => 'AdminController', 'action' => 'index']
];