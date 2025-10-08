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
    '/citas' => '../app/Views/citas.php',
    '/pacientes' => '../app/Views/pacientes.php',
    '/historial' => '../app/Views/historial.php',
    '/404' => '../app/Views/404.php',
    
    
    // rutas de admin    
    '/apps-calendar' => ['controller' => 'AdminController', 'action' => 'appsCalendar'],
    '/apps-tasks' => ['controller' => 'AdminController', 'action' => 'appsTasks'],
    '/pages-profile' => ['controller' => 'AdminController', 'action' => 'pagesProfile'],

    // rutas de medico
    '/pages-add-medico' => ['controller' => 'MedicoController', 'action' => 'pagesAddMedico'],
    '/add-medico' => ['controller' => 'MedicoController', 'action' => 'addMedico'],
    '/pages-get-medico' => ['controller' => 'MedicoController', 'action' => 'readMedico'],
    '/pages-upd-medico' => ['controller' => 'MedicoController', 'action' => 'editMedico'],
    '/update-medico' => ['controller' => 'MedicoController', 'action' => 'updateMedico'],
    '/delete-medico' => ['controller' => 'MedicoController', 'action' => 'deleteMedico'], 
    
    // rutas de servicio
    '/pages-add-service' => ['controller' => 'ServiceController', 'action' => 'pagesAddService'],
    '/add-service' => ['controller' => 'ServiceController', 'action' => 'addService'],
    '/pages-get-service' => ['controller' => 'ServiceController', 'action' => 'readService'],
    '/pages-upd-service' => ['controller' => 'ServiceController', 'action' => 'editService'],
    '/update-service' => ['controller' => 'ServiceController', 'action' => 'updateService'],
    '/delete-service' => ['controller' => 'ServiceController', 'action' => 'deleteService'],
    '/services' => ['controller' => 'ServiceController', 'action' => 'showServices'],


    // rutas de paciente
    '/pages-add-paciente' => ['controller' => 'PacienteController', 'action' => 'pagesAddPaciente'],
    '/add-paciente' => ['controller' => 'PacienteController', 'action' => 'addPaciente'],
    '/pages-get-paciente' => ['controller' => 'PacienteController', 'action' => 'readPaciente'],
    '/pages-upd-paciente' => ['controller' => 'PacienteController', 'action' => 'editPaciente'],
    '/update-paciente' => ['controller' => 'PacienteController', 'action' => 'updatePaciente'],
    '/delete-paciente' => ['controller' => 'PacienteController', 'action' => 'deletePaciente'],
    
    // rutas de cita
    '/pages-add-cita' => ['controller' => 'CitaController', 'action' => 'pagesAddCita'],
    '/add-cita' => ['controller' => 'CitaController', 'action' => 'addCita'],
    '/pages-get-cita' => ['controller' => 'CitaController', 'action' => 'readCita'],
    '/pages-upd-cita' => ['controller' => 'CitaController', 'action' => 'editCita'],
    '/update-cita' => ['controller' => 'CitaController', 'action' => 'updateCita'],
    '/delete-cita' => ['controller' => 'CitaController', 'action' => 'deleteCita'],


    // Agrega más rutas aquí según necesites
    // Rutas dinámicas (controladores)
    '/login' => ['controller' => 'AuthController', 'action' => 'handleLogin'],
    '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '/index' => ['controller' => 'AdminController', 'action' => 'index'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
];