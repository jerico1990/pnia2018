<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Proceso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proceso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'modulo_id')->dropDownList(ArrayHelper::map($modulos, 'modulo_id', 'nombre')); ?>


    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url_accion')->textInput(['maxlength' => true]) ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>


    
</div>
