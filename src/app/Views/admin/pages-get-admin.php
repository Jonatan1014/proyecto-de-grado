<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Lista de Administradores | Sistema Médico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">
    <link href="assets/admin/assets/vendor/datatables/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/assets/vendor/datatables/select.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/assets/vendor/datatables/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css">
    <link href="assets/admin/assets/vendor/datatables/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css">
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
                                        <li class="breadcrumb-item active">Lista de Administradores</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Lista de Administradores</h4>
                                <?php include 'includes/alertEvent.php'; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="header-title">Usuarios del Sistema</h4>
                                        <a href="pages-add-admin" class="btn btn-success">
                                            <i class="mdi mdi-account-plus me-1"></i> Agregar Administrador
                                        </a>
                                    </div>

                                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Usuario</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Estado</th>
                                                <th>Fecha Creación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                                <td>
                                                    <i class="mdi mdi-account-circle me-1"></i>
                                                    <?php echo htmlspecialchars($user['username']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td>
                                                    <?php if ($user['role'] === 'root'): ?>
                                                        <span class="badge bg-danger">Root</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-primary">Admin</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($user['is_active']): ?>
                                                        <span class="badge bg-success">Activo</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                                <td>
                                                    <a href="pages-upd-admin?id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>

                                                    <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                                    <form action="delete-user" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">
                                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                    <?php else: ?>
                                                    <button class="btn btn-sm btn-secondary" disabled title="No puedes eliminarte a ti mismo">
                                                        <i class="mdi mdi-delete"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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
    <script src="assets/admin/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/admin/assets/vendor/datatables/dataTables.bootstrap5.min.js"></script>
    <script src="assets/admin/assets/vendor/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/admin/assets/vendor/datatables/responsive.bootstrap5.min.js"></script>
    <script src="assets/admin/assets/js/app.js"></script>

    <script>
        $(document).ready(function() {
            $("#basic-datatable").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
                    lengthMenu: "Mostrar _MENU_ usuarios",
                    search: "Buscar:",
                    emptyTable: "No hay usuarios registrados"
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                }
            });
        });
    </script>
</body>

</html>
