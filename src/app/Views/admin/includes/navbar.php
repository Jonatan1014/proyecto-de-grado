<!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->

<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                <!-- Logo light -->
                <a href="admin" class="logo-light">
                    <span class="logo-lg">
                        <img src="assets/admin/assets/images/logo.png" alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="assets/admin/assets/images/logo-sm.png" alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="admin" class="logo-dark">
                    <span class="logo-lg">
                        <img src="assets/admin/assets/images/logo-dark.png" alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="assets/admin/assets/images/logo-dark-sm.png" alt="small logo">
                    </span>
                </a>
            </div>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="ri-menu-5-line"></i>
            </button>

            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu" onclick="goBack()">
                <i class="ri-reply-line"></i>
            </button>

            <script>
            function goBack() {
                // Opción 1: Volver a la página anterior
                history.back();

                // Opción 2: Alternativamente, puedes usar:
                // window.history.go(-1);

                // Opción 3: Si quieres ir a una página específica:
                // window.location.href = '/admin';
            }
            </script>

            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Topbar Search Form -->

        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">




            




            <li class="d-none d-sm-inline-block">
                <div class="nav-link" id="light-dark-mode">
                    <i class="ri-moon-line font-22"></i>
                </div>
            </li>


            <li class="d-none d-md-inline-block">
                <a class="nav-link" href="#" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line font-22"></i>
                </a>
            </li>

            <li class="dropdown">
                <?php
                    // Obtener información del usuario de la sesión
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $username = $_SESSION['user']['username'] ?? 'Usuario';
                    $role = $_SESSION['user']['role'] ?? 'user';
                    
                    // Extraer iniciales del nombre
                    $nameParts = explode(' ', $username);
                    $initials = '';
                    
                    if (count($nameParts) >= 2) {
                        // Si tiene al menos 2 partes (nombre y apellido)
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                    } else {
                        // Si solo tiene una palabra, tomar las 2 primeras letras
                        $initials = strtoupper(substr($username, 0, 2));
                    }
                    
                    // Definir color según el rol
                    $bgColor = 'bg-primary';
                    $roleName = 'Usuario';
                    if ($role === 'root') {
                        $bgColor = 'bg-danger';
                        $roleName = 'Root';
                    } elseif ($role === 'admin') {
                        $bgColor = 'bg-success';
                        $roleName = 'Administrador';
                    }
                ?>
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <div class="avatar-sm">
                            <span class="avatar-title <?php echo $bgColor; ?> rounded-circle">
                                <?php echo $initials; ?>
                            </span>
                        </div>
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0"><?php echo htmlspecialchars($username); ?></h5>
                        <h6 class="my-0 fw-normal"><?php echo $roleName; ?></h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">¡Bienvenido!</h6>
                    </div>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ri-user-smile-line font-16 me-1"></i>
                        <span>Mi Cuenta</span>
                    </a>

                    <!-- item-->
                    <a href="logout" class="dropdown-item">
                        <i class="ri-login-circle-line font-16 me-1"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>