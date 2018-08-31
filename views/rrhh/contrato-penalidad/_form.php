<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoPenalidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrato-penalidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_contrato')->dropDownList($array_lista_codigos_contrato) ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'monto_penalidad')->textInput() ?>

    <!-- <?= $form->field($model, 'staff_area_id')->dropDownList($array_staff_area) ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
