<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Presupuesto\PresupuestoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presupuestos';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>

<style>
    kv-editable {
        color: white;
    }
</style>
<?php
$es_factibilidad = true;
if ($es_factibilidad){
?>
<div class="presupuesto-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable-presupuesto',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'rowOptions' => function ($model){
                if ($model->linea->nivel == 0 ){
                    return ['style'=>'color:'.'white'.'; background-color:'.'rgb(146,166,196)'.';'];
                }else{
                    return ['style'=>'color:'.'black'.'; background-color:'.'rgb(242,227,224)'.';'];
                }
                // 146 166 196 azul // RGB
                    // 216 230 237
                    // 230 244 251
                // 160 187 168 green
                    // 232 244 232
                //247 214 248 Golden
                    // 250 241 218
                // 242 227 224 pink
                // 175 176 179 gray
                    // 213 214 229
                    // 224 226 225

                },// */
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns_factibilidad.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Presupuestos','class'=>'btn btn-default']).
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> 
                        '.$this->title,
                'before'=>'<em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>',
                /*'after'=>BulkButtonWidget::widget([
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


<?php
}else{
?>
<div class="presupuesto-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable-presupuesto',
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Presupuestos','class'=>'btn btn-default']).
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> 
                        '.$this->title,
                'before'=>'<em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>',
                /*'after'=>BulkButtonWidget::widget([
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

<?php
}
 ?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
