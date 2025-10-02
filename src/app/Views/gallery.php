<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Gallery - MediNest Bootstrap Template</title>
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

<body class="gallery-page">

    <?php include 'includes/header.php'; ?>


    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1 class="heading-title">Gallery</h1>
                            <p class="mb-0">
                                Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo
                                odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum
                                debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat
                                ipsum dolorem.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="home">Home</a></li>
                        <li class="current">Gallery</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Gallery Section -->
        <section id="gallery" class="gallery section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
                    <ul class="gallery-filters isotope-filters" data-aos="fade-up" data-aos-delay="200">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-nature">Nature</li>
                        <li data-filter=".filter-architecture">Architecture</li>
                        <li data-filter=".filter-people">People</li>
                    </ul>

                    <div class="row gallery-grid isotope-container" data-aos="fade-up" data-aos-delay="300">

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-nature">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-1.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Natural Beauty</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-1.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-architecture">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-2.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Urban Landscape</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-2.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-people">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-3.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Candid Moments</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-3.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-nature">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-4.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Wilderness</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-4.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-architecture">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-5.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Modern Design</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-5.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-people">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-6.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Portrait Studies</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-6.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-nature">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-7.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Serene Waters</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-7.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                        <div class="col-xl-3 col-md-4 col-sm-6 gallery-item isotope-item filter-architecture">
                            <div class="gallery-card">
                                <div class="gallery-image">
                                    <img src="assets/img/gallery/gallery-8.webp" class="img-fluid" alt="">
                                </div>
                                <div class="gallery-overlay">
                                    <h4>Historical Places</h4>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                    <div class="gallery-actions">
                                        <a href="assets/img/gallery/gallery-8.webp" title="View Image"
                                            class="glightbox"><i class="bi bi-eye"></i></a>
                                        <a href="gallery-details"><i class="bi bi-info-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Gallery Item -->

                    </div>
                </div>

            </div>

        </section><!-- /Gallery Section -->

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