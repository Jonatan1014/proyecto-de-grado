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

            <li class="side-nav-title">Gestion Administrativa</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                    aria-controls="sidebarDashboards" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span class="badge bg-success float-end">5</span>
                    <span> Administrativo </span>
                </a>
                <div class="collapse" id="sidebarDashboards">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="index">Inicio</a>
                        </li>
                        <li>
                            <a href="pages-add-medico">Registrar Medico</a>
                        </li>
                        <li>
                            <a href="pages-get-medico">Consulta de Medico</a>
                        </li>
                        <li>
                            <a href="pages-upd-medico">Actualizacion de Datos</a>
                        </li>
                        <li>
                            <a href="pages-add-cita">Agenda Medica</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-title">Gestion Pacientes</li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarCrm" aria-expanded="false" aria-controls="sidebarCrm"
                    class="side-nav-link">
                    <i class="uil uil-tachometer-fast"></i>
                    <span class="badge bg-danger text-white float-end">New</span>
                    <span> Pacientes </span>
                </a>
                <div class="collapse" id="sidebarCrm">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="crm-projects.html">Registro de Pacientes</a>
                        </li>
                        <li>
                            <a href="crm-orders-list.html">Consulta de Pacientes</a>
                        </li>
                        <li>
                            <a href="crm-clients.html">Programar Cita</a>
                        </li>
                        <li>
                            <a href="crm-management.html">Actualizacion de Datos</a>
                        </li>
                        <li>
                            <a href="crm-management.html">Consuslta de Cita</a>
                        </li>
                        
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="apps-calendar" class="side-nav-link">
                    <i class="uil-calender"></i>
                    <span> Calendar </span>
                </a>
            </li>






            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false" aria-controls="sidebarTasks"
                    class="side-nav-link">
                    <i class="uil-clipboard-alt"></i>
                    <span> Tasks </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarTasks">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="apps-tasks">List</a>
                        </li>
                        <li>
                            <a href="apps-tasks-details">Details</a>
                        </li>
                        <li>
                            <a href="apps-kanban">Kanban Board</a>
                        </li>
                    </ul>
                </div>
            </li>



            <li class="side-nav-title">Custom</li>


            <li class="side-nav-title">Components</li>




            <!-- Help Box -->

            <!-- end Help Box -->


        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>