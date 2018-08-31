<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcesoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* Este archivo crea un gridView con una busqueda funcional dentro del contenedor expandible que agregue, tener cuidado con Ajax/Pjax*/
?>

<div class="lista-procesos">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProviderProcesos,
            'filterModel' => $searchModelProcesos,
            //'pjax'=>true, hace que se recargue todo el contenor, lo cual esta mal
            'columns' => [
                //descomentar este campo si se necesitan checkbox
//                [
//                    'class' => 'kartik\grid\CheckboxColumn',
//                    'width' => '20px',
//                ],
              
                'nombre',
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
        ])?>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>