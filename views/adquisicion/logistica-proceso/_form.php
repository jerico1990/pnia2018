<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\LogisticaProceso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="logistica-proceso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'logistica_proceso_id')->textInput() ?>

    <?= $form->field($model, 'proyecto_id')->textInput() ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'componente_id')->textInput() ?>

    <?= $form->field($model, 'monto_rooc_bm')->textInput() ?>

    <?= $form->field($model, 'monto_rooc_bid')->textInput() ?>

    <?= $form->field($model, 'monto_ro')->textInput() ?>

    <?= $form->field($model, 'monto_total')->textInput() ?>

    <?= $form->field($model, 'categoria')->textInput() ?>

    <?= $form->field($model, 'tipo')->textInput() ?>

    <?= $form->field($model, 'tdr_plan')->textInput() ?>

    <?= $form->field($model, 'tdr_real')->textInput() ?>

    <?= $form->field($model, 'expresion_plan')->textInput() ?>

    <?= $form->field($model, 'expresion_real')->textInput() ?>

    <?= $form->field($model, 'evaluacion_plan')->textInput() ?>

    <?= $form->field($model, 'evaluacion_real')->textInput() ?>

    <?= $form->field($model, 'notificacion_plan')->textInput() ?>

    <?= $form->field($model, 'notificacion_real')->textInput() ?>

    <?= $form->field($model, 'firma_plan')->textInput() ?>

    <?= $form->field($model, 'firma_real')->textInput() ?>

    <?= $form->field($model, 'adenda_plan')->textInput() ?>

    <?= $form->field($model, 'adenda_real')->textInput() ?>

    <?= $form->field($model, 'termino_plan')->textInput() ?>

    <?= $form->field($model, 'termino_real')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'documento_pnia_id')->textInput() ?>

    <?= $form->field($model, 'actualizado_en')->textInput() ?>

    <?= $form->field($model, 'actualizado_por')->textInput() ?>

    <?= $form->field($model, 'creado_en')->textInput() ?>

    <?= $form->field($model, 'creado_por')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
