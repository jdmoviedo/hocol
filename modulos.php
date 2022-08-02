<?PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once('php/includes/template.php');
?>
<?= verificar('Modulos') ?>
<?= head('Modulos') ?>
<?= startBody() ?>
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-lg-8 col-8 text-center text-sm-left">
            <div class="page-header-title">
                <i class="fas fa-cube bg-blue mr-2 float-sm-left float-none"></i>
                <h3 style="line-height:1.5;">MODULOS</h3>
            </div>
        </div>
        <div class="col-lg-4 text-sm-right col-4 text-center">
            <i class="ik ik-plus fa-3x mr-1 cursor-pointer" onclick="showModalRegistro();" data-toggle="tooltip" data-placement="top" title="Crear Modulo"></i>
            <i class="ik ik-refresh-ccw fa-3x cursor-pointer" onclick="buscar_registros();" data-toggle="tooltip" data-placement="top" title="Actualizar Tabla"></i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-state card-state-primary">
            <div class="card-body">
                <table id="dtModulos" class="table w-100 ml-0 table-hover"></table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalRegistro" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <input type="hidden" name="id_modulo" id="id_modulo">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="modulo">Modulo</label>
                                <input type="text" class="form-control requerido maxlength-input" name="modulo" id="modulo" title="Modulo" placeholder="Modulo" minlength="3" maxlength="50" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="icono">Icono</label>
                                <input type="text" class="form-control requerido maxlength-input" name="icono" id="icono" title="Icono" placeholder="Icono" minlength="5" maxlength="100"">
                                <span class=" spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" class="form-control requerido maxlength-input" name="descripcion" id="descripcion" title="Descripcion" placeholder="Descripcion" minlength="5" maxlength="100" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
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

<?= endBody(); ?>
<script src="scripts/modulos.js?v=<?php echo (rand()); ?>"></script>