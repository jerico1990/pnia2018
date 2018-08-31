<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\rrhh\ContratoContratoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Lista de Contratos');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="contrato-contrato-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Registrar Nuevo Contrato','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de Contratos',
                'before'=>'<em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>',/*
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item'
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',// */
            ]
        ])?>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<div id="tablas_anexas" style="display: none">
<?php 
    echo Yii::$app->controller->renderPartial('../contrato-entregable/index', [
                    'searchModel' => $searchModelEntregable,
                    'dataProvider' => $dataProviderEntregable
                ]);

?>

<?php 
    echo Yii::$app->controller->renderPartial('../contrato-penalidad/index', [
                    'searchModel' => $searchModelPenalidad,
                    'dataProvider' => $dataProviderPenalidad
                ]);

?>
</div>

<div id ="lista-documentos1" style="display:none">
    <?php 
    echo Yii::$app->controller->renderPartial('/Patrimonio/documento-pnia/index', [
                    'searchModel' => $searchModelDocumentoPnia,
                    'dataProvider' => $dataProviderDocumentoPnia
                ]);

    ?>
</div>

