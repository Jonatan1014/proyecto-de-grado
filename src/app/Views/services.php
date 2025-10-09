<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Servicios</title>
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

<body class="services-page">

    <?php include 'includes/header.php'; ?>


    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1 class="heading-title">Servicios</h1>
                            <p class="mb-0">
                                La Dra. Yohanna ofrece atención médica integral y especializada,
                                combinando experiencia profesional con un trato cercano y humano.
                                Cada servicio está diseñado para cuidar tu salud y bienestar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="home">Inicio</a></li>
                        <li class="current">Services</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Services Section -->
        <!-- Services Section -->
        <section id="services" class="services section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="services-grid">
                    <div class="row g-4">
                        <?php foreach($services as $service): ?>
                        <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                            <div
                                class="service-card <?php echo strtolower($service['category'] ?? 'general'); ?><?php echo $service['is_featured'] ? ' featured' : ''; ?>">
                                <div class="service-header">
                                    <div class="service-icon">
                                        <i class="<?php echo $service['icon'] ?? 'fas fa-tooth'; ?>"></i>
                                    </div>
                                    <span
                                        class="service-category"><?php echo $service['category_name'] ?? 'General'; ?></span>
                                    <?php if ($service['is_featured']): ?>
                                    <div class="featured-badge">Destacado</div>
                                    <?php endif; ?>
                                </div>
                                <div class="service-body">
                                    <h4><?php echo htmlspecialchars($service['name']); ?></h4>
                                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                                    <?php if (!empty($service['features'])): ?>
                                    <div class="service-features">
                                        <?php foreach($service['features'] as $feature): ?>
                                        <span class="feature-badge"><?php echo htmlspecialchars($feature); ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="service-footer">
                                    <a href="/service-details?id=<?php echo $service['id']; ?>" class="service-btn">
                                        Solicitar Cita
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="appointment-banner" data-aos="fade-up" data-aos-delay="900">
                    <div class="banner-content">
                        <div class="banner-text">
                            <h3>Need Medical Attention?</h3>
                            <p>Book your appointment with our qualified healthcare professionals and get the care you
                                deserve.</p>
                        </div>
                        <div class="banner-actions">
                            <a href="appointment.html" class="btn-primary">Book Appointment</a>
                            <a href="tel:+15551234567" class="btn-secondary">
                                <i class="fas fa-phone"></i>
                                Call Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>


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