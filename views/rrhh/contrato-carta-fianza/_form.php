<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoCartaFianza */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrato-carta-fianza-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_interno')->textInput() ?>

    <?= $form->field($model, 'entidad_emisora')->dropDownList($array_entidades_financieras) ?>

    <?= $form->field($model, 'entidad_afianzada')->dropDownList($array_entidades) ?>

    <?= $form->field($model, 'contrato')->dropDownList($array_contratos) ?>

    <?= $form->field($model, 'periodo_inicio')->widget(DatePicker::classname(),[
            'name' => 'periodo_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'periodo_fin')->widget(DatePicker::classname(),[
            'name' => 'periodo_fin_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'monto')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
