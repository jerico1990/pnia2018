<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
CrudAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Requerimiento */
/* @var $form yii\widgets\ActiveForm */
?>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <style media="screen">
  .tab-content {
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 10px;
  }
  </style>
<div class="requerimiento-form">


          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#cabecera" role="tab" data-toggle="tab">Cabecera</a></li>
            <li><a href="#detalle" role="tab" data-toggle="tab">Detalle</a></li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane active" id="cabecera">
              <br>
              <?php $form = ActiveForm::begin(); ?>

                 <?= $form->field($model, 'tipo_requerimiento_id')->dropDownList($array_tipo_requerimiento, ['prompt' => 'Seleccionar','disabled' => true])->label('Tipo de requerimiento') ?>

                 <?= $form->field($model, 'asunto')->textInput(['maxlength' => true,'disabled' => true]) ?>

                 <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true,'disabled' => true]) ?>


                 <?= $form->field($model, 'documento')->fileInput(
                         ['multiple' => false,
                          'value' => null,
                          'disabled' => true
                          //'accept' => 'image/*'
                          ])->label('Subir Documento')->label("Subir documento (Guardar antes de procesar)") ?>

                          <!--
                 <button type="button" name="button" class="btn btn-success">Autorizar requerimiento</button>
                 <button type="button" name="button" class="btn btn-primary">Observado</button>
                 <button type="button" name="button" class="btn btn-danger">Cancelar requerimiento</button>-->

               <?php ActiveForm::end(); ?>

            </div>
            <div class="tab-pane " id="detalle">
              <br>
              <div class="requerimiento-detalle-index">
                  <div id="ajaxCrudDatatable">
                      <?=GridView::widget([
                          'id'=>'crud-datatable',
                          'dataProvider' => $dataProviderRequerimientoDetalle,
                          'filterModel' => $searchModelRequerimientoDetalle,
                          'pjax'=>true,
                          'columns' => require(__DIR__.'/../requerimiento-detalle/_columns_autorizacion_planeacion_requerimiento.php'),
                          'toolbar'=> [
                              ['content'=>
                                ''
                              ],
                          ],
                          'striped' => true,
                          'condensed' => true,
                          'responsive' => true,
                          'panel' => [
                              'type' => 'primary',
                              'heading' => '<i class="glyphicon glyphicon-list"></i> Requerimiento Detalles listing',
                              'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                          ]
                      ])?>
                  </div>
              </div>


            </div>
          </div>





</div>



<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size'=>'modal-lg',
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
<script type="text/javascript">
$('body').on('click', '.btn-aprobar-certificacion-siaf', function (e) {
    e.preventDefault();
    var requerimiento_detalle_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de aprobar la certificación SIAF?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento-detalle/aprobar-certificacion-siaf',
          async:false,
          data:{requerimiento_detalle_id:requerimiento_detalle_id},
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
            //$.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
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
    var requerimiento_detalle_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de desaprobar la certificación SIAF?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/Adquisicion/requerimiento-detalle/desaprobar-certificacion-siaf',
          async:false,
          data:{requerimiento_detalle_id:requerimiento_detalle_id},
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
