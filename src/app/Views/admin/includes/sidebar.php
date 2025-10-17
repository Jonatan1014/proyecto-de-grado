<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="index" class="logo logo-light">
        <span class="logo-lg">
            <img src="assets/admin/assets/images/logo.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="assets/admin/assets/images/logo-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index" class="logo logo-dark">
        <span class="logo-lg">
            <img src="assets/admin/assets/images/logo-dark.png" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="assets/admin/assets/images/logo-dark-sm.png" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile">
                <img src="assets/admin/assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                    class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Inicio</li>

            <li class="side-nav-item">
                <a href="index" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Gestión de Citas</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCitas" aria-expanded="false"
                    aria-controls="sidebarCitas" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Citas Médicas </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarCitas">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="apps-calendar">Calendario de Citas</a>
                        </li>
                        <li>
                            <a href="pages-add-cita">Programar Nueva Cita</a>
                        </li>
                        <li>
                            <a href="pages-get-cita">Ver Citas Programadas</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Gestión de Pacientes</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarPacientes" aria-expanded="false" aria-controls="sidebarPacientes"
                    class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Pacientes </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarPacientes">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="pages-add-paciente">Registrar Nuevo Paciente</a>
                        </li>
                        <li>
                            <a href="pages-get-paciente">Buscar Paciente</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Gestión de Historiales Clínicos</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarHistoriales" aria-expanded="false" aria-controls="sidebarHistoriales"
                    class="side-nav-link">
                    <i class="uil-file-medical"></i>
                    <span> Historiales Clínicos </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarHistoriales">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="pages-get-historial-clinico">Ver Historial de Paciente</a>
                        </li>
                        <li>
                            <a href="pages-add-historial-clinico">Crear Registro Clinico</a>
                        </li>
                        <!-- Aquí puedes agregar más opciones como "Agregar nuevo registro clínico" -->
                    </ul>
                </div>
            </li>
            <?php if ($isRoot) : ?>

            <li class="side-nav-title">Gestión de Médicos y Servicios</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarAdmin" aria-expanded="false"
                    aria-controls="sidebarAdmin" class="side-nav-link">
                    <i class="uil-medkit"></i>
                    <span> Médicos y Servicios </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarAdmin">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="pages-add-medico">Registrar Médico</a>
                        </li>
                        <li>
                            <a href="pages-get-medico">Buscar Médico</a>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarServicios" aria-expanded="false"
                                aria-controls="sidebarServicios">
                                <span> Servicios </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarServicios">
                                <ul class="side-nav-third-level">
                                    <li>
                                        <a href="pages-add-service">Registrar Servicio</a>
                                    </li>
                                    <li>
                                        <a href="pages-get-service">Buscar Servicio</a>
                                    </li>
                                    <li>
                                        <a href="pages-add-service-category">Registrar Categoría</a>
                                    </li>
                                    <li>
                                        <a href="pages-get-service-category">Buscar Categoría</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
            <?php endif; ?>

            <!-- Opcional: Mantener otras secciones como Tasks -->
            <li class="side-nav-title">Otras Herramientas</li>

            <!-- <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false" aria-controls="sidebarTasks"
                    class="side-nav-link">
                    <i class="uil-clipboard-alt"></i>
                    <span> Tareas </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTasks">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="apps-tasks">Lista de Tareas</a>
                        </li>
                        <li>
                            <a href="apps-tasks-details">Detalles de Tarea</a>
                        </li>
                        <li>
                            <a href="apps-kanban">Tablero Kanban</a>
                        </li>
                    </ul>
                </div>
            </li> -->

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>