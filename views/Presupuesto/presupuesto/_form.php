<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\presupuesto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presupuesto-form">


    <?php $form = ActiveForm::begin(); ?>

    <table style="width:100%">
        <?php
            //if(!$model->presupuestoCabecera->getEsHoja()){
        ?>
        <tr>
            <td><?= $form->field($model, 'presupuesto_plan_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_plan_rooc')->textInput() ?></td>
        </tr>
        <?php //}else{ ?>
        <tr>
            <td><?= $form->field($model, 'presupuesto_compromiso_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_compromiso_rooc')->textInput() ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'presupuesto_devengado_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_devengado_rooc')->textInput() ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'presupuesto_girado_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_girado_rooc')->textInput() ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'presupuesto_pagado_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_pagado_rooc')->textInput() ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'presupuesto_ejecutado_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_ejecutado_rooc')->textInput() ?></td>
        </tr>
        <!--
        <tr>
            <td><?= $form->field($model, 'presupuesto_saldo_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_saldo_rooc')->textInput() ?></td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'presupuesto_saldo_anual_ro')->textInput() ?></td>
            <td><?= $form->field($model, 'presupuesto_saldo_anual_rooc')->textInput() ?></td>
        </tr>
        -->
        <?php //} ?>
    </table>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
