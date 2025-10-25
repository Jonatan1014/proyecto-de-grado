<!DOCTYPE html>
<html lang="zxx" class="no-js">


<!-- Mirrored from themewagon.github.io/karma/login by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Oct 2025 15:43:58 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Karma Shop</title>

    <!--
		CSS
		============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Crear Cuenta</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Inicio<span class="lnr lnr-arrow-right"></span></a>
                        <a href="registration">Registro</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Login Box Area =================-->
    <section class="login_box_area section_gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <img class="img-fluid" src="img/login.jpg" alt="">
                        <div class="hover">
                            <h4>¿Ya tienes cuenta?</h4>
                            <p>Si ya estás registrado, inicia sesión para acceder a tu cuenta y realizar tus compras.</p>
                            <a class="primary-btn" href="login">Iniciar Sesión</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Crear nueva cuenta</h3>
                        
                        <?php if (isset($_SESSION['error_registro'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php 
                                echo htmlspecialchars($_SESSION['error_registro']);
                                unset($_SESSION['error_registro']); 
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['mensaje_registro'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?php 
                                echo htmlspecialchars($_SESSION['mensaje_registro']);
                                unset($_SESSION['mensaje_registro']); 
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <form class="row login_form" action="registro" method="post" id="registrationForm">
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                    placeholder="Nombre" required
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Nombre'">
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                    placeholder="Apellido" required
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Apellido'">
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" 
                                    placeholder="Correo electrónico" required
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Correo electrónico'">
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                    placeholder="Teléfono (opcional)"
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Teléfono (opcional)'">
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password" name="password" 
                                    placeholder="Contraseña" required minlength="6"
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Contraseña'">
                                <small class="form-text text-muted">Mínimo 6 caracteres</small>
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" 
                                    placeholder="Confirmar contraseña" required
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Confirmar contraseña'">
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="terminos" name="terminos" required>
                                    <label for="terminos">Acepto los términos y condiciones</label>
                                </div>
                            </div>
                            
                            <div class="col-md-12 form-group">
                                <button type="submit" class="primary-btn">Crear Cuenta</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Login Box Area =================-->

    <!-- start footer Area -->
    <?php include 'includes/footer.php'; ?>
    <!-- End footer Area -->


    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../../cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/main.js"></script>
</body>


<!-- Mirrored from themewagon.github.io/karma/login by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Oct 2025 15:43:59 GMT -->

</html>