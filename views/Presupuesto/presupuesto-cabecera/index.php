<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Presupuesto\PresupuestoCabeceraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if (isset($title) AND $title != null){
    $this->title = $title;
}else{
    $this->title = 'Presupuesto Cabeceras';
}

$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>

<?php Modal::end(); ?>
<div id="tablas_anexas"> <!-- style="display: none"> -->
<?php 
    echo Yii::$app->controller->renderPartial('../presupuesto/index', [
                    'searchModel'   => $searchPresupuesto,
                    'dataProvider'  => $dataPresupuesto
                ]);

?>
</div>
