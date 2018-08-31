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
            'columns' => require(__DIR__.'/_columns_autorizacion_planeacion_requerimiento.php'),
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
                'heading' => '<i class="glyphicon glyphicon-list"></i> Requerimientos listing - planeacion',
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


$('body').on('click', '.btn-pedir-certificacion-siaf', function (e) {
    e.preventDefault();
    var requerimiento_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de pedir la certificación del requerimiento?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento/pedido-certificacion-siaf',
          async:false,
          data:{requerimiento_id:requerimiento_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de pedido de certificación SIAF.');
            }else if(result==1){
              alert('Se registro el proceso de pedido de certificación SIAF.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){

              alert('Error al realizar el proceso de pedido de certificación SIAF.');
          }
      });
      return true;
    } else {
      return false;
    }
});

$('body').on('click', '.btn-aprobar-certificacion-siaf', function (e) {
    e.preventDefault();
    var requerimiento_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de aprobar la certificación SIAF?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento/aprobar-certificacion-siaf',
          async:false,
          data:{requerimiento_id:requerimiento_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de aprobación de certificación SIAF.');
            }else if(result==1){
              alert('Se registro la aprobación de certificación SIAF.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){

              alert('Error al realizar el proceso de aprobación de certificación SIAF.');
          }
      });
      return true;
    } else {
      return false;
    }
});

$('body').on('click', '.btn-desaprobar-certificacion-siaf', function (e) {
    e.preventDefault();
    var requerimiento_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de desaprobar la certificación SIAF?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento/desaprobar-certificacion-siaf',
          async:false,
          data:{requerimiento_id:requerimiento_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de desaprobación de certificación SIAF.');
            }else if(result==1){
              alert('Se registro la desaprobación de certificación SIAF.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){
              alert('Error al realizar el proceso de desaprobación de certificación SIAF.');
          }
      });
      return true;
    } else {
      return false;
    }
});

</script>
