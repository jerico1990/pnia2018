<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Utilitario\UtilitarioUbigeo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="utilitario-ubigeo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'utilitario_ubigeo_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubigeo_region_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ubigeo_provincia_id')->textInput(['maxlength' => true]) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
