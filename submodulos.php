<?PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once('php/includes/template.php');
?>
<?= verificar('Submodulos') ?>
<?= head('Submodulos') ?>
<?= startBody() ?>
<div class="page-header">
    <div class="row align-items-center">
        <div class="col-lg-8 col-8 text-center text-sm-left">
            <div class="page-header-title">
                <i class="fas fa-cubes bg-blue mr-2 float-sm-left float-none"></i>
                <h3 style="line-height:1.5;">SUBMODULOS</h3>
            </div>
        </div>
        <div class="col-lg-4 text-sm-right col-4 text-center">
            <i class="ik ik-plus fa-3x mr-1 cursor-pointer" onclick="showModalRegistro();" data-toggle="tooltip" data-placement="top" title="Crear Submodulo"></i>
            <i class="ik ik-refresh-ccw fa-3x cursor-pointer" onclick="buscar_registros();" data-toggle="tooltip" data-placement="top" title="Actualizar Tabla"></i>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-state card-state-primary">
            <div class="card-body">
                <table id="dtSubmodulos" class="table ml-0 w-100 table-hover"></table>
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
                    <input type="hidden" name="id_submodulo" id="id_submodulo">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="selectModulo">Modulo</label>
                                <select class="form-control requerido w-100" name="selectModulo" id="selectModulo" title="Modulo">
                                </select>
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="submodulo">Submodulo</label>
                                <input type="text" class="form-control requerido maxlength-input" name="submodulo" id="submodulo" title="Submodulo" placeholder="Submodulo" minlength="2" maxlength="50" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" class="form-control requerido maxlength-input" name="descripcion" id="descripcion" title="Descripcion" placeholder="Descripcion" minlength="2" maxlength="100" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
                                <span class="spanValidacion"></span>
                            </a>
                        </div>
                        <div class="col-md-12 form-group">
                            <a class="tooltips">
                                <label for="url">Url sin Extensión</label>
                                <input type="text" class="form-control requerido maxlength-input" name="url" id="url" title="Url" placeholder="Url" minlength="2" maxlength="100" pattern="^[a-zA-Z\s]+$" data-pattern="Solo se permiten letras" data-pattern-replace="[^a-zA-Z\s]" oninput="limitecaracteres(this);">
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
<script src="scripts/submodulos.js?v=<?php echo (rand()); ?>"></script>