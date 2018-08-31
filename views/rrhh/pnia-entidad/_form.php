<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\PniaEntidad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pnia-entidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_entidad')->dropDownList($array_metacodigo_tipo_entidad) ?>

    <?= $form->field($model, 'ruc')->textInput() ?>

    <?= $form->field($model, 'razon_social')->textInput() ?>
    
    

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
