<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoContrato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presupuesto-contrato-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contrato_descripcion')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'estado_regitro')->widget(
        \kartik\switchinput\SwitchInput::classname(),
        [
            'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'onText'	=>'Activo',
                'offText'	=>'Inactivo',
            ],
        ]
    ); ?>
    <!--
    <?= $form->field($model, 'estado_regitro')->textInput() ?>

    <?= $form->field($model, 'actualizado_en')->textInput() ?>

    <?= $form->field($model, 'actualizado_por')->textInput() ?>

    <?= $form->field($model, 'creado_en')->textInput() ?>

    <?= $form->field($model, 'creado_por')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
