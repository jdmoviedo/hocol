<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once('php/controller/controller_login.php');
require_once('php/libraries/sesion.php');

function verificar($submodulo)
{
    $respuesta = controller_login::verificarLogin($submodulo);
    if (!$respuesta) {
        header('Location: Login.php', true);
        exit();
    }
}

function verificarSesion()
{
    $respuesta = controller_login::verificarSesion();
    if (!$respuesta) {
        header('Location: Login.php', true);
        exit();
    }
}

function Head($title)
{
    ob_start();
?>
    <!DOCTYPE html>
    <html class="no-js" lang="es">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="img/favicon.png" type="image/png" />
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="scripts/plugins/bootstrap/dist/css/bootstrap.min.css">
        <!-- FontAwesome -->
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css' integrity='sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==' crossorigin='anonymous' />
        <!-- <link rel="stylesheet" href="scripts/plugins/fontawesome-free/css/all.min.css"> -->
        <link rel="stylesheet" href="scripts/plugins/ionicons/dist/css/ionicons.min.css">
        <link rel="stylesheet" href="scripts/plugins/icon-kit/dist/css/iconkit.min.css">
        <!-- Animate -->
        <link rel="stylesheet" href="scripts/plugins/animate/animate.css">
        <!-- datatable  -->
        <link rel="stylesheet" href="scripts/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="scripts/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
        <!-- bootstrap-daterangepicker -->
        <link rel="stylesheet" href="scripts/plugins/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <!-- <link rel="stylesheet" href="scripts/plugins/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css"> -->
        <!-- FullCalendar -->
        <link rel='stylesheet' href='scripts/plugins/fullcalendar-4.3.1/packages/core/main.min.css'>
        <link rel='stylesheet' href='scripts/plugins/fullcalendar-4.3.1/packages/daygrid/main.css'>
        <link rel='stylesheet' href='scripts/plugins/fullcalendar-4.3.1/packages/timegrid/main.css'>
        <link rel='stylesheet' href='scripts/plugins/fullcalendar-4.3.1/packages/list/main.css'>
        <!-- SWITCHERY -->
        <link rel="stylesheet" href="scripts/plugins/mohithg-switchery/dist/switchery.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="scripts/plugins/select2/dist/css/select2.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="scripts/plugins/iCheck/skins/all.css">
        <!-- Select 2 -->
        <link rel="stylesheet" href="scripts/plugins/select2/dist/css/select2.min.css">
        <!-- Toast -->
        <link rel="stylesheet" href="scripts/plugins/jquery-toast-plugin/dist/jquery.toast.min.css">
        <link rel="stylesheet" href="css/custom-datepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="scripts/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
        <!-- DateDropper -->
        <link rel="stylesheet" href="scripts/plugins/datedropper/datedropper.min.css">

        <!-- <link rel="stylesheet" href="scripts/plugins/perfect-scrollbar/css/perfect-scrollbar.css"> -->
        <link rel="stylesheet" href="scripts/plugins/jvectormap/jquery-jvectormap.css">
        <!-- <link rel="stylesheet" href="scripts/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css"> -->
        <link rel="stylesheet" href="scripts/plugins/weather-icons/css/weather-icons.min.css">
        <link rel="stylesheet" href="scripts/plugins/c3/c3.min.css">

        <link rel="stylesheet" href="css/theme.min.css?v=<?php echo (rand()); ?>">
        <script src="js/vendor/modernizr-2.8.3.min.js?v=<?php echo (rand()); ?>"></script>

        <!-- Scripts Customizados -->
        <link rel="stylesheet" href="css/custom-datepicker.css?v=<?php echo (rand()); ?>">
        <link rel="stylesheet" href="css/tooltips.css?v=<?php echo (rand()); ?>">
        <link rel="stylesheet" href="css/overlay.css?v=<?php echo (rand()); ?>">
        <link rel="stylesheet" href="css/custom.css?v=<?php echo (rand()); ?>">

        <style>
            .swal2-input[type="number"] {
                max-width: 100% !important;
            }
        </style>

    </head>

    <body>
    <?php
    return ob_get_clean();
}
function startBody()
{
    ob_start();
    ?>
        <!-- Overlay Cargue -->
        <div class="overlayCargue">
            <h3 class="overlayText">
                <img src="img/logo.png" id="logoOverlay" alt="Logo">
                <div class="animated infinite pulse"><span id="overlayText"></span></div>
                <!-- <div class="rotate"><i class="ik ik-refresh-ccw"></i></div> -->
            </h3>
        </div>

        <div class="wrapper">

            <header class="header-top" header-theme="utitalco">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between">
                        <div class="top-menu d-flex align-items-center">
                            <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                            <!-- <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> -->
                        </div>
                        <div class="top-menu d-flex align-items-center horaactual">
                            <div id="fechaHora" class="text-center text-white mb-0"></div>
                        </div>
                        <div class="top-menu d-flex align-items-center">
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-center name-user"><?php echo Sesion::GetParametro('usuario'); ?></span>
                                    <img class="avatar" src="<?php $foto = Sesion::GetParametro('foto');
                                                                if ($foto == "") {
                                                                    echo 'img/favicon.png';
                                                                } else {
                                                                    echo 'data:image/jpeg;base64,' . $foto;
                                                                }
                                                                ?>" alt="" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="javascript:;" onclick="cambiarContrasenia();"><i class="ik ik-lock dropdown-icon"></i> Cambiar contraseña</a>
                                    <a class="dropdown-item" href="javascript:;" onclick="cerrarSesion();"><i class="ik ik-power dropdown-icon"></i> Cerrar Sesion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="page-wrap">
                <div class="app-sidebar colored">
                    <div class="sidebar-header">
                        <a class="header-brand" href="index">
                            <div class="logo-img">
                                <img class="header-brand-img" src="img/favicon.png" alt="" />
                            </div>
                            <span class="text">UT ITALCO</span>
                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>

                    <div class="sidebar-content">
                        <div class="nav-container">
                            <nav id="main-menu-navigation" class="navigation-main">
                                <div class="nav-item has-sub text-capitalize">
                                    <a class="cursor-pointer"><i class="fa-solid fa-gauge"></i><span>Dashboard</span></a>
                                    <div class="submenu-content">
                                        <a href="Inicio" class="menu-item"><i class="ik ik-corner-down-right nav-icon"></i>Inicio</a>
                                    </div>
                                </div>
                                <?PHP
                                echo controller_login::menunav();
                                ?>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="main-content">
                    <div class="container-fluid">
                    <?php
                    return ob_get_clean();
                }
                function endBody()
                {
                    ob_start();
                    ?>
                    </div>
                </div>
                <footer class="footer">
                    <div class="w-100 clearfix">
                        <span class="text-center text-sm-left d-md-inline-block">Copyright © 2022 UT ITALCO, todos los derechos reservados. Diseñado por 19D S.A.S </span>
                        <span class="float-none float-sm-right mt-1 mt-sm-0 text-center">Desarrollado <i class="ik ik-terminal"></i> por <a href="https://www.linkedin.com/in/juan-david-mendoza-oviedo-82b789180/" class="font-weight-bold" target="_blank">Jdmoviedo <i class="ik ik-linkedin text-primary"></i></a></span>
                    </div>
                </footer>
            </div>
        </div>

        <!-- MODAL MOSTRAR PDF -->
        <div class="modal fade" id="ModalPdfGenerado" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                    </div>
                    <div class="modal-body">
                        <iframe src="" id="ifmPDF" style="width:100%; height:500px;" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL MOSTRAR PDF -->

        <script src="https://code.jquery.com/jquery-3.3.1.min.js?v=<?php echo (rand()); ?>"></script>
        <script>
            window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')
        </script>
        <script src="scripts/plugins/popper.js/dist/umd/popper.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/bootstrap/dist/js/bootstrap.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- <script src="scripts/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js?v=<?php echo (rand()); ?>"></script> -->
        <script src="scripts/plugins/screenfull/dist/screenfull.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/jvectormap/jquery-jvectormap.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/jvectormap/jquery-jvectormap-world-mill-en.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/jquery-toast-plugin/dist/jquery.toast.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- Moment -->
        <script src="scripts/plugins/moment/moment_v2.17.js?v=<?php echo (rand()); ?>"></script>
        <!-- <script src="scripts/plugins/moment/min/moment.min.js?v=<?php echo (rand()); ?>"></script> -->
        <script src="scripts/plugins/moment/locale/es.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/bootstrap-daterangepicker/daterangepicker.js?v=<?php echo (rand()); ?>"></script>
        <!--bootstrap datepícker-->
        <script src="scripts/plugins/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/bootstrap-datepicker-master/dist/locales/bootstrap-datepicker.es.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- datatable -->
        <script src="scripts/plugins/datatables.net/js/jquery.dataTables.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/datatables.net-responsive/js/dataTables.responsive.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- DateDropper -->
        <script src="scripts/plugins/datedropper/datedropper.pro.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- FullCalendar -->
        <script src="scripts/plugins/fullcalendar-4.3.1/packages/core/main.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/fullcalendar-4.3.1/packages/core/locales-all.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/fullcalendar-4.3.1/packages/interaction/main.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/fullcalendar-4.3.1/packages/daygrid/main.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/fullcalendar-4.3.1/packages/timegrid/main.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/fullcalendar-4.3.1/packages/list/main.js?v=<?php echo (rand()); ?>"></script>
        <!-- Sweet Alert -->
        <script src="scripts/plugins/swalalert/sweetalert2@9.js?v=<?php echo (rand()); ?>"></script>
        <!-- MaxLenght -->
        <script src="scripts/plugins/bootstrap-maxlength/bootstrap-maxlength.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/timedropper/timedropper.js?v=<?php echo (rand()); ?>"></script>
        <!-- switchery -->
        <script src="scripts/plugins/mohithg-switchery/dist/switchery.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
        <!-- Autocomplete Email -->
        <script src="scripts/plugins/email-autocomplete-master/jquery.email-autocomplete.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/d3/dist/d3.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/c3/c3.min.js?v=<?php echo (rand()); ?>"></script>
        <script src="js/theme.js?v=<?php echo (rand()); ?>"></script>
        <!-- iCheck -->
        <script src="scripts/plugins/iCheck/icheck.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- Select 2 -->
        <script src="scripts/plugins/select2/dist/js/select2.full.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- Toast -->
        <script src="scripts/plugins/jquery-toast-plugin/dist/jquery.toast.min.js?v=<?php echo (rand()); ?>"></script>
        <!-- input-mask -->
        <script src="scripts/plugins/input-mask/dist/jquery.inputmask.bundle.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/plugins/jQuery-Mask-Plugin-master/src/jquery.mask.js?v=<?php echo (rand()); ?>"></script>
        <!-- Custom Scripts -->
        <script src="scripts/globales.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/utilidades.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-notificaciones.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/enter.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/login.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/inicio.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-datedropper.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-datepicker.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-timedropper.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-input-mask.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-mask.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/init-select.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/validaciones.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-bootstrapmaxlenght.js?v=<?php echo (rand()); ?>"></script>
        <script src="scripts/conf-emailautocomplete.js?v=<?php echo (rand()); ?>"></script>
    </body>

    </html>
<?php
                    return ob_get_clean();
                }
?>