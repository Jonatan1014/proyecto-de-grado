<?php
// src/config/routes.php

return [
    '/' => '../app/Views/home.php',
    '/home' => '../app/Views/home.php',
    '/about' => '../app/Views/about.php',
    '/departments' => '../app/Views/departments.php',
    '/services' => '../app/Views/services.php',
    '/doctors' => '../app/Views/doctors.php',
    '/contact' => '../app/Views/contact.php',
    '/appointment' => '../app/Views/appointment.php',
    '/department-details' => '../app/Views/department-details.php',
    '/service-details' => '../app/Views/service-details.php',
    '/testimonials' => '../app/Views/testimonials.php',
    '/faq' => '../app/Views/faq.php',
    '/gallery' => '../app/Views/gallery.php',
    '/terms' => '../app/Views/terms.php',
    '/privacy' => '../app/Views/privacy.php',
    '/404' => '../app/Views/404.php',
    '/login' => '../app/Views/login.php',
    '/citas' => '../app/Views/citas.php',
    '/admin' => '../app/Views/admin.php',
    '/pacientes' => '../app/Views/pacientes.php',
    '/historial' => '../app/Views/historial.php',
    '/404' => '../app/Views/404.php', // Agrega esta línea

    // Agrega más rutas aquí según necesites
    // Rutas dinámicas (controladores)
    '/login' => ['controller' => 'AuthController', 'action' => 'handleLogin'],
    '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
];