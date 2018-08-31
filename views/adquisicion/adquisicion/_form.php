<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Viatico\FlujoRequerimiento;
/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\Adquisicion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adquisicion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flujo_requerimiento_id')->dropDownList($array_flujo_requerimiento) ?>

    <?= $form->field($model, 'codigo_referencia')->textInput() ?>

    <?= $form->field($model, 'referencia_actividad')->textInput() ?>

    <?= $form->field($model, 'monto_adjudicado')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'monto_ejecutado')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'componente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo_revision')->dropDownList($array_tipo_revision) ?>
    
    <?= $form->field($model, 'categoria')->dropDownList($array_categoria_adquisicion) ?>
    
    <?= $form->field($model, 'enfoque_mercado')->dropDownList($array_enfoque_mercado) ?>

    <?= $form->field($model, 'monto_estimado')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'estado_actividad')->dropDownList($array_estado_actividad) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#adquisicion-flujo_requerimiento_id').change();
    });

    $('#adquisicion-flujo_requerimiento_id').change(function(){
        if($('#adquisicion-flujo_requerimiento_id').val()!='')
        $.ajax({
            url: "<?= Url::base() ?>/Adquisicion/adquisicion/monto-estimado",
            method: 'POST',
            data: {
                flujo_requerimiento_id: $('#adquisicion-flujo_requerimiento_id').val()
            },
            success:function(data){
                if(data>=0)
                    $('#adquisicion-monto_estimado').val(data);
            }
        });
    });
</script>
