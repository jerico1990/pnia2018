<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\PniaEntFinanciera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pnia-ent-financiera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_entidad')->dropDownList($array_lista_tipo_entidad_financiera) ?>

    <?= $form->field($model, 'razon_social')->textInput() ?>

    <?= $form->field($model, 'cuenta_bancaria')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
