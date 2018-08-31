<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioClase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patrimonio-clase-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patrimonio_clase_padre_id')->dropDownList([null => 'Ninguno']+ArrayHelper::map($patrimonios_clases, 'patrimonio_clase_id', 'nombre','codigo'))->label('Clase padre') ?>
 
    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true])->label('código') ?>

    <?= $form->field($model, 'tasa_depreciacion')->textInput()->label('Tasa de depreciación anual (0.00 - 1.00)') ?>

<!--     <?= $form->field($model, 'actualizado_en')->textInput() ?>

    <?= $form->field($model, 'actualizado_por')->textInput() ?>

    <?= $form->field($model, 'creado_en')->textInput() ?>

    <?= $form->field($model, 'creado_por')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
