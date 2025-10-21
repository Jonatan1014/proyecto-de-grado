<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Editar Administrador | Sistema Médico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">
    <script src="assets/admin/assets/js/hyper-config.js"></script>
    <link href="assets/admin/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <link href="assets/admin/assets/css/unicons/css/unicons.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard">Inicio</a></li>
                                        <li class="breadcrumb-item"><a href="pages-get-admin">Administradores</a></li>
                                        <li class="breadcrumb-item active">Editar</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Editar Administrador</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Actualizar Información</h4>
                                    <p class="text-muted font-14 mb-3">
                                        Modifique los datos del usuario. Deje la contraseña en blanco si no desea cambiarla.
                                    </p>

                                    <?php include 'includes/alertEvent.php'; ?>

                                    <form action="update-user" method="POST" id="userForm">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Nombre de Usuario <span class="text-danger">*</span></label>
                                                    <input type="text" id="username" name="username" class="form-control" required minlength="3" maxlength="100" value="<?php echo htmlspecialchars($user['username']); ?>">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                                                    <input type="email" id="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($user['email']); ?>">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="role" class="form-label">Rol <span class="text-danger">*</span></label>
                                                    <select id="role" name="role" class="form-control" required>
                                                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
                                                        <option value="root" <?php echo $user['role'] === 'root' ? 'selected' : ''; ?>>Root (Super Admin)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Nueva Contraseña</label>
                                                    <input type="password" id="password" name="password" class="form-control" minlength="6" placeholder="Dejar en blanco para mantener la actual">
                                                    <small class="text-muted">Solo complete si desea cambiar la contraseña</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="password_confirm" class="form-label">Confirmar Nueva Contraseña</label>
                                                    <input type="password" id="password_confirm" name="password_confirm" class="form-control" minlength="6" placeholder="Repetir nueva contraseña">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="is_active">
                                                            Usuario Activo
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <a href="pages-get-admin" class="btn btn-secondary me-2">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="mdi mdi-content-save me-1"></i> Actualizar Usuario
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'includes/theme.php'; ?>
        </div>
    </div>

    <script src="assets/admin/assets/js/vendor.min.js"></script>
    <script src="assets/admin/assets/js/app.js"></script>
    <script>
    document.getElementById('userForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirm = document.getElementById('password_confirm').value;

        if (password !== '' || passwordConfirm !== '') {
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }

            if (password.length > 0 && password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return false;
            }
        }
    });
    </script>
</body>

</html>
