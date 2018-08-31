<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\General\RequerimientoDetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requerimiento-detalle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_arbol')->dropDownList($lista_presupuestos_ramas, ['prompt' => 'Seleccionar'])->label('Presupuesto Línea') ?>

    <?= $form->field($model, 'periodo_id')->dropDownList($array_periodo, ['prompt' => 'Seleccionar'])->label('Periodo') ?>

    <?= $form->field($model, 'monto')->textInput() ?>

    <?= $form->field($model, 'ro_rooc')->dropDownList($array_ro_rooc, ['prompt' => 'Seleccionar'])->label('Ro/Rooc') ?>
    
    <?= $form->field($model, 'entregable_id')->textInput() ?>

    <?= $form->field($model, 'penalidad_id')->textInput() ?>

    <?= $form->field($model, 'flujo_requerimiento_id')->dropDownList($array_flujo_requerimiento, ['prompt' => 'Seleccionar'])->label('Requerimiento Asociado') ?>    

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'unidad_medida_cantidad')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'costo_unitario')->textInput() ?>

    <?= $form->field($model, 'staff_area_id')->dropDownList($array_staff_area, ['prompt' => 'Seleccionar'])->label('Área Responsable') ?>

    <?= $form->field($model, 'bien_servicio')->dropDownList($array_tipo_bien_servicio, ['prompt' => 'Seleecionar'])->label('Bien/Servicio') ?>

    <?= $form->field($model, 'descripcion_bien_servicio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'especificacion_tecnica_o_tdr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tiempo_garantia_numero_meses')->textInput() ?>

    <?= $form->field($model, 'lugar_entrega')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'forma_pago')->textInput() ?>

    <?= $form->field($model, 'duracion_servicio')->textInput() ?>

    <?= $form->field($model, 'monto_total_contrato_fake')->textInput() ?>

    <?= $form->field($model, 'staff_persona_id')->textInput() ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
