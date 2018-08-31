<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionGenerico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-rendicion-generico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fondo_rendicion_viatico_id')->textInput() ?>

    <?= $form->field($model, 'fondo_rendicion_caja_chica_id')->textInput() ?>

    <?= $form->field($model, 'fondo_rendicion_encargo_id')->textInput() ?>

    <?= $form->field($model, 'tipo_afecto_igv_metacodigo')->textInput() ?>

    <?= $form->field($model, 'tipo_bien_servicio_metacodigo')->textInput() ?>

    <?= $form->field($model, 'tipo_documento_metacodigo')->textInput() ?>

    <?= $form->field($model, 'proveedor_pnia_entidad_id')->textInput() ?>

    <?= $form->field($model, 'importe')->textInput() ?>

    <?= $form->field($model, 'importe_gravado')->textInput() ?>

    <?= $form->field($model, 'importe_no_gravado')->textInput() ?>

    <?= $form->field($model, 'serie_numero')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ruc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detalle_gasto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_documento')->textInput() ?>

    <?= $form->field($model, 'actualizado_en')->textInput() ?>

    <?= $form->field($model, 'actualizado_por')->textInput() ?>

    <?= $form->field($model, 'creado_en')->textInput() ?>

    <?= $form->field($model, 'creado_por')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
