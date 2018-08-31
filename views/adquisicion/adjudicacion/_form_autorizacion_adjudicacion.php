<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use johnitvn\ajaxcrud\BulkButtonWidget;
CrudAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Adjudicacion */
/* @var $form yii\widgets\ActiveForm */
?>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<div class="adjudicacion-form">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li class="active"><a href="#cabecera" role="tab" data-toggle="tab">Cabecera</a></li>
      <?php if($model->situacion_adjudicacion_id>5){ ?>
      <li><a href="#postor" role="tab" data-toggle="tab">Registro de postores</a></li>
      <?php } ?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane active" id="cabecera">
        <br>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'requerimiento_detalle_id')->textInput() ?>

        <?= $form->field($model, 'requerimiento_id')->textInput() ?>

        <?= $form->field($model, 'situacion_adjudicacion_id')->textInput() ?>

        <?= $form->field($model, 'actualizado_en')->textInput() ?>

        <?= $form->field($model, 'actualizado_por')->textInput() ?>

        <?= $form->field($model, 'creado_en')->textInput() ?>

        <?= $form->field($model, 'creado_por')->textInput() ?>
        <?php ActiveForm::end(); ?>
      </div>
      <div class="tab-pane " id="postor">
        <br>
        <div class="postores-index">
            <div id="ajaxCrudDatatable">
                <?=GridView::widget([
                    'id'=>'crud-datatable',
                    'dataProvider' => $dataProviderPostor,
                    'filterModel' => $searchModelPostor,
                    'pjax'=>true,
                    'columns' => require(__DIR__.'./../../general/postores/_columns_autorizacion_adjudicacion.php'),
                    'toolbar'=> [
                        ['content'=>
                            ($model->situacion_adjudicacion_id==6)?Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/General/postores/create','adjudicacion_id'=>$model->adjudicacion_id],
                            ['role'=>'modal-remote','title'=> 'Create new Postores','class'=>'btn btn-default']).'{export}':''.
                            '{export}'
                        ],
                    ],
                    'striped' => true,
                    'condensed' => true,
                    'responsive' => true,
                    'panel' => [
                        'type' => 'primary',
                        'heading' => '<i class="glyphicon glyphicon-list"></i> Postores listing',
                        'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                    ]
                ])?>
            </div>
        </div>

      </div>
    </div>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?php //= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>

<script type="text/javascript">
$('body').on('click', '.btn-ganador', function (e) {
    e.preventDefault();
    var postor_id = $(this).attr('data-id');
    var msg = confirm("¿Esta seguro de registrar como ganador al participante?");
    if (msg == true) {
      $.ajax({
          url:'<?= \Yii::$app->request->BaseUrl ?>/General/postores/ganador-postor',
          async:false,
          data:{postor_id:postor_id},
          method: 'POST',
          beforeSend:function()
          {

          },
          success:function(result)
          {
            if(result==0){
              alert('Error al registrar al ganador.');
            }else if(result==1){
              alert('Se registro al ganador.');
            }
            $.pjax.reload({container:'#crud-datatable-container'});//actualizar datagrid
          },
          error:function(){
              alert('Error al registrar al ganador.');
          }
      });
      return true;
    } else {
      return false;
    }
});
</script>
