<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Viatico\FondoRendicionViaticoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rendición de Viáticos';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="fondo-rendicion-viatico-index">
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
                    ['role'=>'modal-remote','title'=> 'Crear Nueva Rendición de Viático','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Resetear Grilla']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],        
            'emptyText' => 'Lista vacía.',
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de Rendiciones de Viáticos',
                'before'=>'<em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>',
//                'after'=>BulkButtonWidget::widget([
//                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
//                                ["bulk-delete"] ,
//                                [
//                                    "class"=>"btn btn-danger btn-xs",
//                                    'role'=>'modal-remote-bulk',
//                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
//                                    'data-request-method'=>'post',
//                                    'data-confirm-title'=>'Are you sure?',
//                                    'data-confirm-message'=>'Are you sure want to delete this item'
//                                ]),
//                        ]).                        
//                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>


<div id ="detalle-rendicion-viatico" style="display:none">
    <?php 
    echo Yii::$app->controller->renderPartial('/Viatico/gestion-rendicion-viatico/index', [
                    'searchModel' => $searchModelGestionRendicionViatico,
                    'dataProvider' => $dataProviderGestionRendicionViatico
                ]);

    ?>
</div>