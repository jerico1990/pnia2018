<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Patrimonio\PatrimonioItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$title = 'Lista de Items';
$this->title = Yii::t('app', $title);
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="patrimonio-item-index">
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
                    ['role'=>'modal-remote','title'=> 'Registrar Nuevo Item','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reiniciar Grilla']).
                    '{toggleData}'.
                    '{export}'
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> '.$title,
                'before'=>'
                <em>'.Yii::$app->params['textoEspañol']['mensajeCabecera'].'</em>'
                
            ]
        ])?>
        
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<div id ="lista-documentos-patrimonio-item" style="display:none">
    <?php 
    echo Yii::$app->controller->renderPartial('/Patrimonio/documento-pnia/index', [
                    'searchModel' => $searchModelDocumentoPnia,
                    'dataProvider' => $dataProviderDocumentoPnia
                ]);

    ?>
</div>
