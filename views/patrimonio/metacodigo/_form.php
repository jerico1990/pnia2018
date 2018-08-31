<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\Metacodigo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="metacodigo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre_lista')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion2')->textInput(['maxlength' => true]) ?>

    <!-- <?= $form->field($model, 'actualizado_en')->textInput() ?> -->

    <!-- <?= $form->field($model, 'actualizado_por')->textInput() ?> -->

    <!-- <?= $form->field($model, 'creado_en')->textInput() ?> -->

    <!-- <?= $form->field($model, 'creado_por')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
