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
                          'columns' => require(__DIR__.'/../requerimiento-detalle/_columns_autorizacion_jefe_requerimiento.php'),
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
