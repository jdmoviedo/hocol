<?PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once('php/includes/template.php');
?>
<?= verificar('Usuarios') ?>
<?= head('Usuarios') ?>
<?= startBody() ?>
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-lg-8 col-8 text-center text-sm-left">
            <div class="page-header-title">
                <i class="fas fa-user bg-blue mr-2 float-sm-left float-none"></i>
                <h3 style="line-height:1.5;">USUARIOS</h3>
            </div>
        </div>
        <div class="col-lg-4 text-sm-right col-4 text-center">
            <i class="ik ik-plus fa-3x mr-1 cursor-pointer" onclick="showModalRegistro();" data-toggle="tooltip" data-placement="top" title="Crear Trabajador"></i>
            <i class="ik ik-refresh-ccw fa-3x cursor-pointer" onclick="buscar_registros();" data-toggle="tooltip" data-placement="top" title="Actualizar Tabla"></i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-state card-state-primary">
            <div class="card-body">
                <table id="dtUsuarios" class="table ml-0 w-100 table-hover"></table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ModalRegistro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <input type="hidden" name="id_usuario" id="id_usuario">
                    <!-- Primer y Segundo Nombre -->
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="primer_nombre">Primer Nombre</label>
                                <input type="text" class="form-control requerido maxlength-input" name="primer_nombre" id="primer_nombre" title="Primer Nombre" placeholder="Primer Nombre" minlength="3" maxlength="30" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="segundo_nombre">Segundo Nombre</label>
                                <input type="text" class="form-control maxlength-input" placeholder="Segundo Nombre" name="segundo_nombre" id="segundo_nombre" title="Segundo Nombre" minlength="3" maxlength="30" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>

                        <!-- Primer y Segundo Apellido -->
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="primer_apellido">Primer Apellido</label>
                                <input type="text" class="form-control requerido maxlength-input" name="primer_apellido" id="primer_apellido" title="Primer Apellido" placeholder="Primer Apellido" minlength="3" maxlength="30" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="segundo_apellido">Segundo Apellido</label>
                                <input type="text" class="form-control maxlength-input" placeholder="Segundo Apellido" name="segundo_apellido" id="segundo_apellido" title="Segundo Apellido" minlength="3" maxlength="30" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>

                        <!-- Documento y Correo -->
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="documento">Documento</label>
                                <input type="text" class="form-control requerido maxlength-input" name="documento" id="documento" title="Documento" placeholder="Documento" minlength="6" maxlength="10" pattern="^[0-9\s]+$" data-pattern="Solo se permiten numeros" data-pattern-replace="[^0-9\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control requerido maxlength-input" placeholder="Correo" name="correo" id="correo" title="Correo" minlength="3" maxlength="30">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>

                        <!-- Telefono y Cargo -->
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="telefono">Telefono</label>
                                <input type="text" class="form-control requerido maxlength-input" name="telefono" id="telefono" title="Telefono" placeholder="Telefono" minlength="6" maxlength="10" pattern="^[0-9\s]+$" data-pattern="Solo se permiten numero" data-pattern-replace="[^0-9\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                    </div>

                    <!-- Contraseña y Confirmar Contraseña -->
                    <div class="row" id="passwords">
                        <div class="col-md-6 form-group">

                            <a class="tooltips">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control requerido maxlength-input" name="password" id="password" title="Contraseña" placeholder="Contraseña" minlength="6" maxlength="20" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-6 form-group">

                            <a class="tooltips">
                                <label for="password1">Confirmar Contraseña</label>
                                <input type="password" class="form-control requerido maxlength-input" placeholder="Confirmar Contraseña" name="password1" id="password1" title="Confirmar Contraseña" minlength="6" maxlength="20" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset();">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnRegistro"></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAsignarSubmodulo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
            </div>
            <div class="modal-body">
                <form id="frmRegistroAsignarSubmodulo">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <a class="tooltips">
                                <label for="selectHome">Pagina de Inicio</label>
                                <select class="form-control requerido w-100" name="selectHome" id="selectHome" title="Pagina de Inicio">
                                </select>
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                    </div>
                    <div class="row" id="modulos">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_asignar_submodulo();">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnRegistroAsignarSubmodulo"></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalAsignarPermiso" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
            </div>
            <div class="modal-body">
                <form id="frmRegistroAsignarPermiso">
                    <div class="row" id="procesos">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset_asignar_permiso();">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnRegistroAsignarPermiso"></button>
            </div>
        </div>
    </div>
</div>

<?= endBody(); ?>
<script src="scripts/usuarios.js?v=<?php echo (rand()); ?>"></script>