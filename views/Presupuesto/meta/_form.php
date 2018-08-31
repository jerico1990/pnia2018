<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Meta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'meta_descripcion')->textInput(['maxlength' => true]) ?>

    <!--<?= $form->field($model, 'tipo')->checkbox() ?>-->
    <?= $form->field($model, 'tipo')->widget(
        \kartik\switchinput\SwitchInput::classname(),
        [
            'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'onText'	=>'Financiera',
                'offText'	=>'Fisica',
            ],
        ]
    ); ?>

    <?= $form->field($model, 'unidad_medida_id')->dropDownList($array_unidad_medida) ?>

    <?= $form->field($model, 'avance_total')->textInput() ?>

    <?php
    if ($is_update){
        echo $form->field($model, 'avance_actual')->textInput();
    }
    ?>

    <?= $form->field($model, 'precio_unitario')->textInput() ?>

    <?= $form->field($model, 'monto_total')->textInput() ?>

    <?= $form->field($model, 'presupuesto_afectado')->widget(
        \kartik\switchinput\SwitchInput::classname(),
        [
            'type' => \kartik\switchinput\SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'onText'	=>'Ro',
                'offText'	=>'Rooc',
            ],
        ]
    ); ?>

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
