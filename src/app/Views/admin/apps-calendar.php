<!DOCTYPE html>
<html lang="en">




<head>
    <meta charset="utf-8" />
    <title>Calendar | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
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

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();
    });
    </script>
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
                                        <li class="breadcrumb-item"><a href="index">Home</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Apps</a></li>
                                        <li class="breadcrumb-item active">Calendario</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Calendario</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="d-grid">
                                                <button class="btn btn-lg font-16 btn-danger" id="btn-new-event">
                                                    <i class="mdi mdi-plus-circle-outline"></i> Crear nuevo Evento
                                                </button>
                                            </div>
                                            <div id="external-events" class="mt-3">
                                                <p class="text-muted">Arrastre y suelte su evento o haga clic en el
                                                    calendario
                                                </p>
                                                <div class="external-event bg-success-lighten text-success"
                                                    data-class="bg-success"><i
                                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Cita Pendiente</div>
                                                <div class="external-event badge-secondary-lighten text-secundary"
                                                    data-class="bg-secondary"><i
                                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Cita Realizada</div>

                                                <div class="external-event bg-info-lighten text-info"
                                                    data-class="bg-info"><i
                                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Recordatorio</div>

                                                <div class="external-event bg-warning-lighten text-warning"
                                                    data-class="bg-warning"><i
                                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Otro</div>

                                                <div class="external-event bg-danger-lighten text-danger"
                                                    data-class="bg-danger"><i
                                                        class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Cita Cancelada</div>

                                            </div>

                                          

                                        </div> <!-- end col-->

                                        <div class="col-lg-9">
                                            <div class="mt-4 mt-lg-0">
                                                <div id="calendar"></div>
                                            </div>
                                        </div> <!-- end col -->

                                    </div> <!-- end row -->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->

                            <!-- Add New Event MODAL -->
                            <div class="modal fade" id="event-modal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                            <div class="modal-header py-3 px-4 border-bottom-0">
                                                <h5 class="modal-title" id="modal-title">Event</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4 pb-4 pt-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Nombre Evento</label>
                                                            <input class="form-control" placeholder="Insert Event Name"
                                                                type="text" name="title" id="event-title" required />
                                                            <div class="invalid-feedback">Please provide a valid event
                                                                name</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Categoria</label>
                                                            <select class="form-select" name="category"
                                                                id="event-category" required>
                                                                <option value="bg-danger">Danger</option>
                                                                <option value="bg-success">Success</option>
                                                                <option value="bg-primary">Primary</option>
                                                                <option value="bg-info">Info</option>
                                                                <option value="bg-dark">Dark</option>
                                                                <option value="bg-warning">Warning</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a valid event
                                                                category</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Descripcion</label>
                                                            <textarea class="form-control"
                                                                placeholder="Insert Description" name="description"
                                                                id="event-description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Tipo Eveto</label>
                                                            <select class="form-select" name="type" id="event-type"
                                                                required>
                                                                <option value="appointment">Cita Medica</option>
                                                                <option value="reminder">Recordatorio</option>
                                                                <option value="other">Otro</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a valid event
                                                                type</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Paciente</label>
                                                            <select class="form-select" name="patient_id"
                                                                id="event-patient">
                                                                <option value="">Seleccione Paciente</option>
                                                                <!-- Se llenará dinámicamente -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Doctor</label>
                                                            <select class="form-select" name="doctor_id"
                                                                id="event-doctor">
                                                                <option value="">Seleccione Doctor</option>
                                                                <!-- Se llenará dinámicamente -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Inicio Evento</label>
                                                            <input class="form-control" type="datetime-local"
                                                                name="start" id="event-start" required />
                                                            <div class="invalid-feedback">Please provide a valid start
                                                                date/time</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label class="control-label form-label">Finalizacion Evento</label>
                                                            <input class="form-control" type="datetime-local" name="end"
                                                                id="event-end" required />
                                                            <div class="invalid-feedback">Please provide a valid end
                                                                date/time</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            id="btn-delete-event">Eliminar</button>
                                                    </div>
                                                    <div class="col-6 text-end">
                                                        <button type="button" class="btn btn-light me-1"
                                                            data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-success"
                                                            id="btn-save-event">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div> <!-- end modal-content-->
                                </div> <!-- end modal dialog-->
                            </div>
                            <!-- end modal-->
                            <!-- end modal-->
                        </div>
                        <!-- end col-12 -->
                    </div> <!-- end row -->

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

    <!-- Fullcalendar js -->
    <script src="assets/admin/assets/js/calendar.js"></script>

</body>




</html>