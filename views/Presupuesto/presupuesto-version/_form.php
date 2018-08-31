<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    function alertaVacio() {
        var comboBox = document.getElementById('presupuestoversion-version_previa_id');
        if (comboBox.selectedIndex == 0){
            alert("Al seleccionar un origen vacio, la copia estara vacia.");
        }
    }
</script>

<div class="presupuesto-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'version_previa_id')->dropDownList(
            $array_versiones_previas,['prompt'=>'Ninguno','onchange'=>'alertaVacio()']) ?>

    <?= $form->field($model, 'nro_version')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'detalle')->textInput() ?>

    <?= $form->field($model, 'fecha')->textInput() ?>

    <?= $form->field($model, 'estatus')->widget(
        SwitchInput::classname(),
        [
            'type' => SwitchInput::CHECKBOX,
            'pluginOptions' => [
                'onText'	=>'Activo',
                'offText'	=>'Inactivo',
            ],
        ]
    ); ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
