<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/admin/assets/images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="assets/admin/assets/js/hyper-config.js"></script>

    <!-- Vendor css -->
    <link href="assets/admin/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="assets/admin/assets/css/unicons/css/unicons.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/remixicon/remixicon.css" rel="stylesheet" type="text/css" />
    <link href="assets/admin/assets/css/mdi/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />

    <!-- Apex Charts css -->
    <link href="assets/admin/assets/vendor/apexcharts/apexcharts.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ========== Topbar Start ========== -->
        <?php include 'includes/navbar.php'; ?>
        <!-- ========== Topbar End ========== -->

        <?php include 'includes/sidebar.php'; ?>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- start stats -->
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-primary-light">
                                                <i class="mdi mdi-account-multiple font-22 text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $stats['totalPacientes']; ?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Pacientes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-info-light">
                                                <i class="mdi mdi-calendar-check font-22 text-info"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $stats['totalCitas']; ?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Citas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-success-light">
                                                <i class="mdi mdi-check-circle font-22 text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $stats['citasCompletadas']; ?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Completadas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="widget-rounded-circle card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-warning-light">
                                                <i class="mdi mdi-currency-usd font-22 text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-end">
                                                <h3 class="text-dark mt-1">$<span data-plugin="counterup"><?php echo number_format($stats['ingresosCompletados'], 0, ',', '.'); ?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Ingresos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                    <!-- start charts -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Citas por Estado</h4>
                                    <div id="citas_estado_chart" class="apex-charts" data-colors="#727cf5,#0acf97,#fa5c7c"></div>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Pacientes por Género</h4>
                                    <div id="pacientes_genero_chart" class="apex-charts" data-colors="#ffbc00,#39afd1"></div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <!-- start tables -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Servicios Más Solicitados</h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Servicio</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stats['serviciosPopulares'] as $servicio): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($servicio['name']); ?></td>
                                                    <td><?php echo $servicio['count']; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Doctores con Más Citas</h4>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-nowrap table-hover mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Doctor</th>
                                                    <th>Citas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stats['doctoresConMasCitas'] as $doctor): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                                                    <td><?php echo $doctor['count']; ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include 'includes/footer.php'; ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <?php include 'includes/theme.php'; ?>

    <!-- Vendor js -->
    <script src="assets/admin/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/admin/assets/js/app.js"></script>

    <!-- Apex Charts js -->
    <script src="assets/admin/assets/vendor/apexcharts/apexcharts.min.js"></script>

    <!-- Dashboard Init js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Datos para el gráfico de citas por estado
            var citasEstadoData = {
                chart: {
                    height: 350,
                    type: 'pie',
                },
                series: [
                    <?php
                    $completadas = $stats['citasCompletadas'];
                    $pendientes = $stats['citasPendientes'];
                    $canceladas = $stats['citasCanceladas'];
                    echo "$completadas, $pendientes, $canceladas";
                    ?>
                ],
                labels: ['Completadas', 'Pendientes', 'Canceladas'],
                colors: ["#0acf97", "#ffbc00", "#fa5c7c"],
                legend: {
                    show: true,
                    position: 'bottom'
                }
            };

            var citasEstadoChart = new ApexCharts(
                document.querySelector("#citas_estado_chart"),
                citasEstadoData
            );
            citasEstadoChart.render();

            // Datos para el gráfico de pacientes por género
            var pacientesGeneroData = {
                chart: {
                    height: 350,
                    type: 'donut',
                },
                series: [
                    <?php
                    $masculino = 0;
                    $femenino = 0;
                    $otro = 0;
                    foreach ($stats['pacientesPorGenero'] as $item) {
                        if ($item['gender'] === 'M') $masculino = $item['count'];
                        if ($item['gender'] === 'F') $femenino = $item['count'];
                        if ($item['gender'] === 'Otro') $otro = $item['count'];
                    }
                    echo "$masculino, $femenino, $otro";
                    ?>
                ],
                labels: ['Masculino', 'Femenino', 'Otro'],
                colors: ["#39afd1", "#ffbc00", "#727cf5"],
                legend: {
                    show: true,
                    position: 'bottom'
                }
            };

            var pacientesGeneroChart = new ApexCharts(
                document.querySelector("#pacientes_genero_chart"),
                pacientesGeneroData
            );
            pacientesGeneroChart.render();
        });
    </script>
</body>
</html>