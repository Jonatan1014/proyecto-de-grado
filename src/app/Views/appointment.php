<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Cita</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: MediNest
  * Template URL: https://bootstrapmade.com/medinest-bootstrap-hospital-template/
  * Updated: Aug 11 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="appointment-page">

    <?php include 'includes/header.php'; ?>


    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1 class="heading-title">Agendar Cita</h1>
                            <p class="mb-0">
                Agenda tu cita de manera rápida y sencilla. Selecciona la fecha y hora que más te convenga 
                                        y recibe atención médica y estética personalizada con la Dra. Yohanna.

                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="home">Inicio</a></li>
                        <li class="current">Agendar Cita</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Appointmnet Section -->
        <section id="appointmnet" class="appointmnet section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <!-- Appointment Info -->
                    <div class="col-lg-6">
                        <div class="appointment-info">
                            <h3>Reserva en Línea Rápida y Fácil</h3>
                            <p class="mb-4">Agenda tu cita en solo unos sencillos pasos. Nuestros profesionales de la
                                salud están listos
                                para brindarte la mejor atención médica adaptada a tus necesidades.</p>

                            <div class="info-items">
                                <div class="info-item d-flex align-items-center mb-3" data-aos="fade-up"
                                    data-aos-delay="200">
                                    <div class="icon-wrapper me-3">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div>
                                        <h5>Horarios Flexibles</h5>
                                        <p class="mb-0">Elige entre horarios disponibles que se adapten a tu agenda
                                            ocupada</p>
                                    </div>
                                </div><!-- End Info Item -->

                                <div class="info-item d-flex align-items-center mb-3" data-aos="fade-up"
                                    data-aos-delay="250">
                                    <div class="icon-wrapper me-3">
                                        <i class="bi bi-stopwatch"></i>
                                    </div>
                                    <div>
                                        <h5>Respuesta Rápida</h5>
                                        <p class="mb-0">Recibe confirmación en un máximo de 15 minutos tras enviar tu
                                            solicitud</p>
                                    </div>
                                </div><!-- End Info Item -->

                                <div class="info-item d-flex align-items-center mb-3" data-aos="fade-up"
                                    data-aos-delay="300">
                                    <div class="icon-wrapper me-3">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div>
                                        <h5>Atención Médica Experta</h5>
                                        <p class="mb-0">Médicos y especialistas certificados a tu servicio</p>
                                    </div>
                                </div><!-- End Info Item -->
                            </div>

                       

                        </div>
                    </div><!-- End Appointment Info -->


                    <!-- Formulario de Cita -->
                    <div class="col-lg-6">
                        <div class="appointment-form-wrapper" data-aos="fade-up" data-aos-delay="200">
                            <form action="add-cita-frontend" method="post" class="appointment-form php-email-form">
                                <div class="row gy-3">

                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Tu Nombre Completo" required="">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Tu Correo Electrónico" required="">
                                    </div>

                                    <div class="col-md-6">
                                        <input type="tel" name="phone" class="form-control"
                                            placeholder="Tu Número de Teléfono" required="">
                                    </div>

                                    <div class="col-md-6">
                                        <select name="service" class="form-select" required="">
                                            <option value="">Selecciona un Servicio</option>
                                            <option value="cardiology">Consulta General</option>
                                            <option value="neurology">Liempieza Bucal</option>
                                            <option value="orthopedics">Blanqueamiento</option>
                                            <option value="pediatrics">Implante Dental</option>
                                            <option value="dermatology">brackets dentales</option>
                                            <option value="general">Muelas de Juicio</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <input type="datetime-local" name="date" class="form-control" required="">
                                    </div>

                                    <div class="col-md-6">
                                        <select name="doctor" class="form-select" required="">
                                            <option value="">Selecciona un Doctor</option>
                                            <option value="dr-johnson">Dra. Sarah Johnson</option>
                                            <option value="dr-martinez">Dr. Michael Martinez</option>
                                            <option value="dr-chen">Dra. Lisa Chen</option>
                                            <option value="dr-patel">Dr. Raj Patel</option>
                                            <option value="dr-williams">Dra. Emily Williams</option>
                                            <option value="dr-thompson">Dr. David Thompson</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <textarea class="form-control" name="message" rows="5"
                                            placeholder="Por favor describe tus síntomas o motivo de la visita (opcional)"></textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="loading">Cargando</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Tu solicitud de cita ha sido enviada con éxito.
                                            ¡Nos pondremos en contacto contigo pronto!</div>

                                        <button type="submit" class="btn btn-appointment w-100">
                                            <i class="bi bi-calendar-plus me-2"></i>Reservar Cita
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div><!-- End Appointment Form -->


                </div>

                <!-- Pasos del Proceso -->
<div class="process-steps mt-5" data-aos="fade-up" data-aos-delay="300">
    <div class="row text-center gy-4">
        
        <!-- Paso 1 -->
        <div class="col-lg-3 col-md-6">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-icon">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5>Registra tus Datos</h5>
                <p>Ingresa tu información básica y el motivo de tu consulta para iniciar tu proceso de atención.</p>
            </div>
        </div><!-- End Step -->

        <!-- Paso 2 -->
        <div class="col-lg-3 col-md-6">
            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h5>Elige la Fecha</h5>
                <p>Selecciona el día y la hora que mejor se adapten a tu disponibilidad.</p>
            </div>
        </div><!-- End Step -->

        <!-- Paso 3 -->
        <div class="col-lg-3 col-md-6">
            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <h5>Confirma tu Cita</h5>
                <p>Recibe la confirmación y detalles de tu cita directamente en tu correo o WhatsApp.</p>
            </div>
        </div><!-- End Step -->

        <!-- Paso 4 -->
        <div class="col-lg-3 col-md-6">
            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <h5>Atención Personalizada</h5>
                <p>Acude a tu cita y recibe un servicio médico y estético de calidad, pensado en tu bienestar.</p>
            </div>
        </div><!-- End Step -->

                    </div>
                </div><!-- End Process Steps -->


            </div>

        </section><!-- /Appointmnet Section -->

    </main>

    <?php include 'includes/footer.php'; ?>


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>