<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use kartik\date\DatePicker;

$fecha_actual = date('Y-m-d H:i:s');
$tipo_flujo_metacodigo = 23;


/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoFondo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-caja-chica">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'requerimiento_flujo_id')->dropDownList($lista_flujo_requerimiento)->label('Requerimientos Aprobados') ?>

    <?= $form->field($model, 'tipo_flujo_metacodigo')->hiddenInput(['value'=> $tipo_flujo_metacodigo])->label(false); ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento')->fileInput(
            ['multiple' => false, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Resolución Directoral') ?>

    <?= $form->field($model, 'motivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_entregado')->textInput(['maxlength' => true,'readonly' => true]) ?>


    <?= $form->field($model, 'fecha_inicio')->hiddenInput(['value'=> $fecha_actual])->label(false); ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
