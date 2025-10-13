<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login </title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
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
</head>

<body class="login-page">


    <main class="main">
        <!-- Page Title -->
        <!--
        <div class="page-title">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="heading-title fw-bold">Dra. Yohanna</h1>
                    </div>
                </div>
            </div>
        </div>
-->


<section class="vh-100" style="background-color: #2ea9b4;">
  <div class="container py-3 h-3">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card shadow-lg border-0" style="border-radius: 1rem;">
          <div class="row g-0">
            
            <!-- Imagen lateral -->
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="assets/img/health/login.jpg" 
                   alt="Login Healthcare" 
                   class="img-fluid" 
                   style="border-radius: 1rem 0 0 1rem; height:100%; object-fit:cover;" />
            </div>

            <!-- Formulario -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <!-- Encabezado -->
                <div class="text-center mb-4">
                  <h3 class="card-title mb-0 fw-semibold text-primary">Bienvenido</h3>
                  <p class="text-muted mt-2 mb-0">Ingresa tus credenciales para acceder</p>
                </div>

                <!-- Form -->
                <form method="POST" action="login">
                  
                  <div class="mb-3">
                    <label for="email" class="form-label fw-medium">Correo Electrónico</label>
                    <input type="email" class="form-control rounded-pill" id="email" name="email"
                      placeholder="correo@ejemplo.com" required>
                  </div>

                  <div class="mb-3">
                    <label for="password" class="form-label fw-medium">Contraseña</label>
                    <input type="password" class="form-control rounded-pill" id="password" name="password"
                      placeholder="••••••••" required>
                  </div>

                  <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                  </div>

                  <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary rounded-pill fw-semibold">
                      Iniciar Sesión
                    </button>
                  </div>

                  <!-- Links extras -->
                  <div class="text-center">

                    <a href="#!" class="small text-muted me-2">Términos de uso</a> | 
                    <a href="#!" class="small text-muted ms-2">Política de privacidad</a>
                  </div>
                </form>

                <!-- Error -->
                <?php if (isset($_GET['error'])): ?>
                  <p class="text-danger mt-3 text-center">Credenciales incorrectas.</p>
                <?php endif; ?>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>



   
    </main>


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