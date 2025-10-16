<?php
// src/config/routes.php

return [
    '/' => '../app/Views/home.php',
    '/home' => '../app/Views/home.php',
    '/about' => '../app/Views/about.php',
    '/departments' => '../app/Views/departments.php',
    '/services' => ['controller' => 'ServiceController', 'action' => 'showServices'],
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
    '/apps-calendar' => ['controller' => 'CalendarController', 'action' => 'appsCalendar'],
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

    // rutas de servicio catgoría
    '/pages-add-service-category' => ['controller' => 'ServiceCategoryController', 'action' => 'pagesAddServiceCategory'],
    '/add-service-category' => ['controller' => 'ServiceCategoryController', 'action' => 'addServiceCategory'],
    '/pages-get-service-category' => ['controller' => 'ServiceCategoryController', 'action' => 'readServiceCategory'],
    '/pages-upd-service-category' => ['controller' => 'ServiceCategoryController', 'action' => 'editServiceCategory'],
    '/update-service-category' => ['controller' => 'ServiceCategoryController', 'action' => 'updateServiceCategory'],
    '/delete-service-category' => ['controller' => 'ServiceCategoryController', 'action' => 'deleteServiceCategory'],


    // rutas de paciente
    '/pages-add-paciente' => ['controller' => 'PacienteController', 'action' => 'pagesAddPaciente'],
    '/add-paciente' => ['controller' => 'PacienteController', 'action' => 'addPaciente'],
    '/pages-get-paciente' => ['controller' => 'PacienteController', 'action' => 'readPaciente'],
    '/pages-upd-paciente' => ['controller' => 'PacienteController', 'action' => 'editPaciente'],
    '/update-paciente' => ['controller' => 'PacienteController', 'action' => 'updatePaciente'],
    '/delete-paciente' => ['controller' => 'PacienteController', 'action' => 'deletePaciente'],

    // rutas de historial médico
    '/pages-add-historial-clinico' => ['controller' => 'HistorialClinicoController', 'action' => 'pagesAddHistorial'],
    '/add-historial-clinico' => ['controller' => 'HistorialClinicoController', 'action' => 'addHistorial'],
    '/pages-get-historial-clinico' => ['controller' => 'HistorialClinicoController', 'action' => 'readHistorial'],
    '/pages-upd-historial-clinico' => ['controller' => 'HistorialClinicoController', 'action' => 'editHistorial'],
    '/update-historial-clinico' => ['controller' => 'HistorialClinicoController', 'action' => 'updateHistorial'],
    '/delete-historial-clinico' => ['controller' => 'HistorialClinicoController', 'action' => 'deleteHistorial'],
    // Ruta para descargar historial clínico en PDF
    '/download-historial-pdf' => ['controller' => 'HistorialClinicoController', 'action' => 'downloadPdf'],
    
    // rutas de cita
    '/pages-add-cita' => ['controller' => 'CitaController', 'action' => 'pagesAddCita'],
    '/add-cita' => ['controller' => 'CitaController', 'action' => 'addCita'],
    '/add-contact-frontend' => ['controller' => 'CitaController', 'action' => 'addContactFrontend'],
    '/add-cita-frontend' => ['controller' => 'CitaController', 'action' => 'addCitaFrontend'],
    '/pages-get-cita' => ['controller' => 'CitaController', 'action' => 'readCita'],
    '/pages-upd-cita' => ['controller' => 'CitaController', 'action' => 'editCita'],
    '/update-cita' => ['controller' => 'CitaController', 'action' => 'updateCita'],
    '/delete-cita' => ['controller' => 'CitaController', 'action' => 'deleteCita'],

    // Rutas del calendario
    '/calendar' => ['controller' => 'CalendarController', 'action' => 'appsCalendar'],
    '/events' => ['controller' => 'CalendarController', 'action' => 'getEvents'],
    '/add-event' => ['controller' => 'CalendarController', 'action' => 'addEvent'],
    '/update-event' => ['controller' => 'CalendarController', 'action' => 'updateEvent'],
    '/delete-event' => ['controller' => 'CalendarController', 'action' => 'deleteEvent'],

    // Rutas para cargar pacientes y doctores
    '/patients-list' => ['controller' => 'PacienteController', 'action' => 'getAll'],
    '/doctors-list' => ['controller' => 'MedicoController', 'action' => 'getAll'],




    // Agrega más rutas aquí según necesites
    // Rutas dinámicas (controladores)
    '/login' => ['controller' => 'AuthController', 'action' => 'handleLogin'],
    '/admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '/index' => ['controller' => 'AdminController', 'action' => 'index'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
];