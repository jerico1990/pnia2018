<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoContrato */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrato-contrato-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'adquisicion_id')->dropDownList($array_adquisicion) ?>

    <?= $form->field($model, 'codigo_arbol')->dropDownList($lista_presupuestos_ramas) ?>

    <?= $form->field($model, 'entidad_contratista')->dropDownList($array_entidades) ?>

    <?= $form->field($model, 'area_contratante')->dropDownList($array_areas) ?>

    <?= $form->field($model, 'area_responsable')->dropDownList($array_areas) ?>

    <?= $form->field($model, 'monto')->textInput() ?>

    <?= $form->field($model, 'fecha_inicio')->widget(DatePicker::classname(),[
            'name' => 'fecha_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'fecha_fin')->widget(DatePicker::classname(),[
            'name' => 'fecha_fin_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'objetivos')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'contrato_origen')->dropDownList($array_contratos,['prompt'=>'Ninguno']) ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
            ['multiple' => true, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Documento') ?>
    

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    $('#contrato_origen').change(function(){
        alert("asasas");
    });
</script>