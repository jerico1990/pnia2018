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


        <?php if($flag_action=='create'){ ?>

          <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'tipo_requerimiento_id')->dropDownList($array_tipo_requerimiento, ['prompt' => 'Seleccionar'])->label('Tipo de Requerimiento') ?>

            <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true]) ?>


            <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
            ['multiple' => false,
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir documento (Guardar antes de procesar)') ?>



        	   <?php if (!Yii::$app->request->isAjax){ ?>
          	  	<div class="form-group">
          	        <?= Html::submitButton($model->isNewRecord ? 'Grabar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
          	    </div>
      	     <?php } ?>
          <?php ActiveForm::end(); ?>

        <?php } elseif($flag_action=='update') { ?>
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

                 <?= $form->field($model, 'tipo_requerimiento_id')->dropDownList($array_tipo_requerimiento, ['prompt' => 'Seleccionar','disabled'=>true])->label('Requerimiento Asociado') ?>

                 <?= $form->field($model, 'asunto')->textInput(['maxlength' => true]) ?>

                 <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true]) ?>


                 <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
                    ['multiple' => false,
                     'value' => null,
                     //'accept' => 'image/*'
                     ])->label('Subir documento (Guardar antes de procesar)') ?>
                 <?php if($model->getDocumentos()){ ?>
                   <a data-pjax=true target="_blank"  href="<?= \Yii::$app->request->BaseUrl.'/documentos/requerimientos/'.$model->getDocumentos()->documento ?>"> <span class="glyphicon glyphicon-download-alt"></span> descargar</a>
                 <?php } ?>
                 <br><br>
                 <?php if (!Yii::$app->request->isAjax){ ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Grabar' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                 <?php } ?>

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
                          'columns' => require(__DIR__.'/../requerimiento-detalle/_columns_creacion_requerimiento.php'),
                          'toolbar'=> [
                              ['content'=>
                                  Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/Adquisicion/requerimiento-detalle/create','requerimiento_id'=>$model->requerimiento_id],
                                  ['role'=>'modal-remote','title'=> 'Create new Requerimiento Detalles','class'=>'btn btn-default']).
                                  '{export}'
                              ],
                          ],
                          'striped' => true,
                          'condensed' => true,
                          'responsive' => true,
                          'panel' => [
                              'type' => 'primary',
                              'heading' => '<i class="glyphicon glyphicon-list"></i> Lista de items adjuntos',
                              'before'=>'<em>* </em>',
                          ]
                      ])?>
                  </div>
              </div>


            </div>
          </div>


        <?php } elseif($flag_action=='disabled') { ?>
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

                 <?= $form->field($model, 'tipo_requerimiento_id')->dropDownList($array_tipo_requerimiento, ['prompt' => 'Seleccionar','disabled'=>true])->label('Requerimiento Asociado') ?>

                 <?= $form->field($model, 'asunto')->textInput(['maxlength' => true,'disabled'=>true]) ?>

                 <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true,'disabled'=>true]) ?>


                 <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
                    ['multiple' => true,
                     'value' => null,

                     //'accept' => 'image/*'
                     ])->label('Subir documento (Guardar antes de procesar)') ?>



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
                          'columns' => require(__DIR__.'/../requerimiento-detalle/_columns_creacion_requerimiento.php'),
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
                              'heading' => '<i class="glyphicon glyphicon-list"></i> Requerimiento Detalles listing',
                              'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                          ]
                      ])?>
                  </div>
              </div>


            </div>
          </div>
        <?php } ?>


</div>



<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    'size'=>'modal-lg',
    "footer"=>"",// always need it for jquery plugin
    'clientOptions' => [
      'backdrop' => 'static', 'keyboard' => true
    ]
])?>
<?php Modal::end(); ?>

<script type="text/javascript">
  $('body').on('click', '.btn-grabar-detalle', function () {

      $( "#detalle" ).submit();
      var required = [];
      var error = '';
      required.push('requerimientodetalle-descripcion');
      $.each(required, function( index, value ) {
        if(jQuery.trim( $('#'+value+'').val() ) == ''){
          $('#'+value+'').parent().addClass('has-error');
          error = error + 'No debe esta vacio';
        }
      });

      if(error != ''){
        return false;
      }else{

        return true;
      }
  });
</script>
