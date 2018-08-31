<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Adquisicion\RequerimientoDetalleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Requerimiento Detalles';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<div class="requerimiento-detalle-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns_autorizacion_contabilidad_requerimiento_detalle.php'),
            'toolbar'=> [
                ['content'=>

                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Requerimiento Detalles listing - contabilidad',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<script type="text/javascript">
$('body').on('click', '.btn-aprobar-compromiso-siaf', function (e) {
    e.preventDefault();
    var requerimiento_detalle_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de aprobar el compromiso SIAF?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento-detalle/aprobar-compromiso-siaf',
          async:false,
          data:{requerimiento_detalle_id:requerimiento_detalle_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de aprobación del compromiso SIAF.');
            }else if(result==1){
              alert('Se registro el compromiso SIAF.');
            }
            //$.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){

              alert('Error al realizar el proceso de aprobación del compromiso SIAF.');
          }
      });
      return true;
    } else {
      return false;
    }
});

$('body').on('click', '.btn-desaprobar-compromiso-siaf', function (e) {
    e.preventDefault();
    var requerimiento_detalle_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de desaprobar el compromiso SIAF?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento-detalle/desaprobar-compromiso-siaf',
          async:false,
          data:{requerimiento_detalle_id:requerimiento_detalle_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de desaprobación del compromiso SIAF.');
            }else if(result==1){
              alert('Se registro la desaprobación del compromiso SIAF.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){
              alert('Error al realizar el proceso de desaprobación del compromiso SIAF.');
          }
      });
      return true;
    } else {
      return false;
    }
});

$('body').on('click', '.btn-pedir-compromiso-siaf', function (e) {
    e.preventDefault();
    var requerimiento_detalle_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de pedir el compromiso?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento-detalle/pedido-compromiso-siaf',
          async:false,
          data:{requerimiento_detalle_id:requerimiento_detalle_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al realizar el proceso de pedido de compromiso SIAF.');
            }else if(result==1){
              alert('Se registro el proceso de pedido de compromiso SIAF.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){

              alert('Error al realizar el proceso de pedido de compromiso SIAF.');
          }
      });
      return true;
    } else {
      return false;
    }
});
</script>
