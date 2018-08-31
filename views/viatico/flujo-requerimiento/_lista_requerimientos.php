<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Viatico\FlujoRequerimientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flujo requerimiento';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="flujo-requerimiento-lista">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable2',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => [
                //'observacion',
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'label' => 'Flujo paso',
                    'width' => '200px',
                    'attribute'=> 'codigoPaso.nombre_paso'
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'label' => 'Fecha esperada',
                    'width' => '200px',
                    'attribute'=>'fecha_esperada',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'label' => 'Observación',
                    'width' => '200px',
                    'attribute'=>'observacion',
                ],
                [
                    'class'=>'\kartik\grid\DataColumn',
                    'label' => 'Área aprobadora',
                    'width' => '200px',
                    'attribute'=>'codigoPaso.areaResponsable.descripcion',
                ],
            ],
//            'toolbar'=> [
//                ['content'=>
//                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
//                    ['role'=>'modal-remote','title'=> 'Crear nuevo flujo requerimiento','class'=>'btn btn-default']).
//                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
//                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Recargar Grilla']).
//                    '{toggleData}'.
//                    '{export}'
//                ],
//            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'secondary', 
                //'heading' => '<i class="glyphicon glyphicon-list"></i> Bandeja de requerimientos',
                //'before'=>'<em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>',
            ]
        ])?>
    </div>
</div>