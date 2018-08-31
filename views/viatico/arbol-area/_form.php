<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\ArbolArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="arbol-area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_area_id')->dropDownList($array_lista_areas, ['prompt' => 'Ninguna'])->label('Área') ?>

    <?= $form->field($model, 'presupuesto_cabecera_id')->dropDownList($array_presupuesto_raiz, ['prompt' => 'Ninguna']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
