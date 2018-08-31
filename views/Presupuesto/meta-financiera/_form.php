<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\MetaFinanciera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-financiera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avance_total')->textInput() ?>

    <?= $form->field($model, 'avance_actual')->textInput() ?>

    <?= $form->field($model, 'unidad_medida_id')->textInput() ?>

    <?= $form->field($model, 'precio_unitario_ro')->textInput() ?>

    <?= $form->field($model, 'precio_unitario_rooc')->textInput() ?>

    <?= $form->field($model, 'monto_total_ro')->textInput() ?>

    <?= $form->field($model, 'monto_total_rooc')->textInput() ?>

    <?= $form->field($model, 'presupuesto_cabecera_id')->textInput() ?>

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
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
