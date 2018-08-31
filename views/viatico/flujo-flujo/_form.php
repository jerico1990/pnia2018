<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoFlujo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flujo-flujo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_flujo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_flujo_metacodigo')->dropDownList($array_metacodigo_tipo_flujo) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
