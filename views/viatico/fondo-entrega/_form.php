<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use kartik\date\DatePicker;
$tipo_flujo_metacodigo = 26;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoFondo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-fondo-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'responsable_persona_id')->textInput() ?> --!>

    <?= $form->field($model, 'requerimiento_flujo_id')->dropDownList($lista_flujo_requerimiento)->label('Requerimientos Aprobados') ?>

    <?= $form->field($model, 'tipo_flujo_metacodigo')->hiddenInput(['value'=> $tipo_flujo_metacodigo])->label(false); ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento')->fileInput(
            ['multiple' => false, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Resolución Directoral') ?>

    <?= $form->field($model, 'banco_entidad_financiera')->dropDownList($array_lista_entidad_financiera) ?>

    <?= $form->field($model, 'motivo')->textInput(['maxlength' => true])->label('Motivo de la entrega') ?>

    <?= $form->field($model, 'fecha_inicio')->widget(DatePicker::classname(),[
            'name' => 'fecha_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'fecha_fin')->widget(DatePicker::classname(),[
            'name' => 'fecha_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'total_bienes')->textInput(['maxlength' => true,'readonly' => true]) ?>

    <?= $form->field($model, 'total_servicios')->textInput(['maxlength' => true,'readonly' => true]) ?>

    <?= $form->field($model, 'total_entregado')->textInput()->label('Total por entregar') ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
