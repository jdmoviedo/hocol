<!DOCTYPE html>
<html class="no-js" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="img/favicon.png" type="image/png" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="scripts/plugins/bootstrap/dist/css/bootstrap.min.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="scripts/plugins/fontawesome-free/css/all.min.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="scripts/plugins/ionicons/dist/css/ionicons.min.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="scripts/plugins/icon-kit/dist/css/iconkit.min.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="scripts/plugins/perfect-scrollbar/css/perfect-scrollbar.css?v=<?php echo (rand()); ?>">
    <!-- Toast -->
    <link rel="stylesheet" href="scripts/plugins/jquery-toast-plugin/dist/jquery.toast.min.css?v=<?php echo (rand()); ?>">
    <!-- Animate -->
    <link rel="stylesheet" href="scripts/plugins/animate/animate.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="css/theme.min.css?v=<?php echo (rand()); ?>">
    <script src="js/vendor/modernizr-2.8.3.min.js?v=<?php echo (rand()); ?>"></script>
    <!-- Scripts Customizados -->
    <link rel="stylesheet" href="css/tooltips.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="css/overlay.css?v=<?php echo (rand()); ?>">
    <link rel="stylesheet" href="css/custom.css?v=<?php echo (rand()); ?>">
</head>

<body>
    <!-- Overlay Cargue -->
    <div class="overlayCargue">
        <h3 class="overlayText">
            <img src="img/logo.png" id="logoOverlay" alt="Logo">
            <div class="animated infinite pulse"><span id="overlayText"></span></div>
            <!-- <div class="rotate"><i class="ik ik-refresh-ccw"></i></div> -->
        </h3>
    </div>
    <div class="auth-wrapper">
        <div class="container-fluid h-100">
            <div class="row flex-row h-100 bg-white container-login">
                <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0 container-auth d-flex align-items-center">
                    <div class="authentication-form mx-auto">
                        <div class="logo-centered w-auto">
                            <a href="Login"><img src="img/logo.png" alt="Logo" id="login-logo" class="w-100"></a>
                        </div>
                        <h3 class="text-center mt-50">Iniciar Sesion en Italco</h3>
                        <form id="frmLogin">
                            <div class="form-group">
                                <a class="tooltips">
                                    <input type="text" class="form-control requerido" name="usuarioLogin" id="usuarioLogin" placeholder="Correo del Usuario" title="Correo del usuario" onkeydown="pulsaenter(event,this.id)">
                                    <i class="ik ik-user"></i>
                                    <span class="spanValidacion spanValidacionLogin"></span>
                                </a>
                            </div>
                            <div class="form-group">
                                <a class="tooltips">
                                    <input type="password" class="form-control requerido" name="contraseniaLogin" id="contraseniaLogin" placeholder="Contraseña del Usuario" title="Contraseña del Usuario" onkeydown="pulsaenter(event,this.id)">
                                    <i class="ik ik-lock"></i>
                                    <span class="spanValidacion spanValidacionLogin"></span>
                                </a>
                            </div>
                            <div class="sign-btn text-center">
                                <a class="btn btn-theme-lion" id="btnLoginIngresar" onclick="Login('frmLogin');">Iniciar Sesion</a>
                            </div>
                        </form>
                        <!-- <div class="register">
                                <p>Don't have an account? <a href="register.html">Create an account</a></p>
                            </div> -->
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 p-0 d-md-block d-lg-block">
                    <div class="lavalite-bg" style="background-image: url('img/auth/login-bg.jpg')">
                        <div class="lavalite-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')
    </script>
    <script src="scripts/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="scripts/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- <script src="scripts/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script> -->
    <!-- Toast -->
    <script src="scripts/plugins/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
    <script src="scripts/plugins/screenfull/dist/screenfull.js"></script>
    <!-- Sweet Alert -->
    <script src="scripts/plugins/swalalert/sweetalert2@9.js"></script>
    <script src="js/theme.js"></script>
    <!-- Select 2 -->
    <script src="scripts/plugins/select2/dist/js/select2.full.min.js?v=<?php echo (rand()); ?>"></script>
    <!-- Custom Scripts -->
    <script src="scripts/globales.js?v=<?php echo (rand()); ?>"></script>
    <script src="scripts/utilidades.js?v=<?php echo (rand()); ?>"></script>
    <script src="scripts/conf-notificaciones.js?v=<?php echo (rand()); ?>"></script>
    <script src="scripts/validaciones.js?v=<?php echo (rand()); ?>"></script>
    <script src="scripts/login.js?v=<?php echo (rand()); ?>"></script>
</body>

</html>