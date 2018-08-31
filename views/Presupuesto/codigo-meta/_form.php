<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\CodigoMeta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="codigo-meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidad_medida_id')->dropDownList(\app\models\Presupuesto\UnidadMedida::getComboBoxItems()) ?>

    <?php
    if ($es_update){
        echo $form->field($model, 'estado_regitro')->textInput();
    }
    ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
