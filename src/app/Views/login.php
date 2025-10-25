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
                    <h1>Login/Register</h1>
                    <nav class="d-flex align-items-center">
                        <a href="home">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category">Login/Register</a>
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
                            <h4>New to our website?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of
                                this is the</p>
                            <a class="primary-btn" href="registration">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Inicia sesión</h3>
                        
                        <?php if (isset($_SESSION['error_login'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php 
                                echo htmlspecialchars($_SESSION['error_login']);
                                unset($_SESSION['error_login']); 
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['mensaje_login'])): ?>
                            <div class="alert alert-info" role="alert">
                                <?php 
                                echo htmlspecialchars($_SESSION['mensaje_login']);
                                unset($_SESSION['mensaje_login']); 
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['mensaje'])): ?>
                            <div class="alert alert-info" role="alert">
                                <?php echo htmlspecialchars($_GET['mensaje']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form class="row login_form" action="login" method="post">
                            <div class="col-md-12 form-group">
                                <input type="email" class="form-control" id="email" name="email" 
                                    placeholder="Correo electrónico" required
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Correo electrónico'">
                            </div>
                            <div class="col-md-12 form-group">
                                <input type="password" class="form-control" id="password" name="password" 
                                    placeholder="Contraseña" required
                                    onfocus="this.placeholder = ''" 
                                    onblur="this.placeholder = 'Contraseña'">
                            </div>
                            <div class="col-md-12 form-group">
                                <div class="creat_account">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember">Mantenerme conectado</label>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <button type="submit" class="primary-btn">Iniciar Sesión</button>
                                <a href="#">¿Olvidaste tu contraseña?</a>
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