<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Adquisicion\RequerimientoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requerimientos';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<div class="requerimiento-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns_autorizacion_operaciones_requerimiento.php'),
            'toolbar'=> [
                ['content'=>
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Requerimientos listing - operaciones',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    'size'=>'modal-lg',
])?>
<?php Modal::end(); ?>

<script type="text/javascript">



$('body').on('click', '.btn-aprobar-operaciones-requerimiento', function (e) {
    e.preventDefault();
    var requerimiento_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de procesar la aprobación del requerimiento?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento/aprobar-operaciones-requerimiento',
          async:false,
          data:{requerimiento_id:requerimiento_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de aprobación del requerimiento.');
            }else if(result==1){
              alert('Se registro la aprobación del requerimiento.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){

              alert('Error al realizar el proceso de aprobación del requerimiento.');
          }
      });
      return true;
    } else {
      return false;
    }
});

$('body').on('click', '.btn-desaprobar-operaciones-requerimiento', function (e) {
    e.preventDefault();
    var requerimiento_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de procesar la desaprobación del requerimiento?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento/desaprobar-operaciones-requerimiento',
          async:false,
          data:{requerimiento_id:requerimiento_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de desaprobación del requerimiento.');
            }else if(result==1){
              alert('Se registro la desaprobación del requerimiento.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){

              alert('Error al realizar el proceso de desaprobación del requerimiento.');
          }
      });
      return true;
    } else {
      return false;
    }
});
</script>
