<?PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once('php/includes/template.php');
?>
<?= verificarSesion() ?>
<?= head('Dashboard') ?>
<?= startBody() ?>

<div class="page-header">
    <div class="row align-items-center">
        <div class="col-8">
            <div class="page-header-title">
                <i class="fas fa-user-friends bg-blue mr-2 float-sm-left float-none"></i>
                <h3 style="line-height:1.5;">DASHBOARD</h3>
            </div>
        </div>
        <div class="col-4" style="text-align:right">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-state card-state-info">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<?= endBody(); ?>
<script src="js/initCalendar.js"></script>