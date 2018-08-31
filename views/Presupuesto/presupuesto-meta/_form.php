<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoMeta */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    function cargarPeriodosDisponibles() {
        $.ajax({
            url: "<?= \yii\helpers\Url::base() ?>/Viatico/flujo-requerimiento/cargar-periodos",
            method: 'POST',
            data: {
                codigo_arbol: $('#combo_box_cabeceras').val()
            },
            success:function(data){
                $('#combo_box_periodos').html("");
                $.each(JSON.parse(data), function (index, item) {
                    $('#combo_box_periodos').append(
                        $('<option></option>').val(index).html(item)
                    );
                });
            }
        });
    }

</script>

<div class="presupuesto-meta-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--
    <?= $form->field($model, 'presupuesto_id')->textInput() ?>

    <?= $form->field($model, 'meta_fisica_id')->textInput() ?>

    <?= $form->field($model, 'meta_financiera_id')->textInput() ?>
    -->

    <?= $form->field($model,'presupuesto_cabecera_id')->dropDownList(
            \app\models\Presupuesto\PresupuestoCabecera::getComboBoxItemsConMetas(),
        ['prompt'=>'Ninguno','onChange'=>'cargarPeriodosDisponibles()','id' => 'combo_box_cabeceras']
    )?>

    <div id="periodo_id">
        <?= $form->field($model,'periodo_id')->dropDownList($periodos,['id'=>'combo_box_periodos'])?>
    </div>

    <?= $form->field($model, 'unidad_fisica_consumida_temp')->textInput() ?>

    <?= $form->field($model, 'unidad_financiera_consumida_temp')->textInput() ?>
    <!--
    <?= $form->field($model, 'unidad_fisica_consumida_final')->textInput() ?>

    <?= $form->field($model, 'unidad_financiera_consumida_final')->textInput() ?>

    <?= $form->field($model, 'estado_financiero')->textInput() ?> -->

    <?php
        if ($is_update){
            echo $form->field($model, 'estado_meta')->textInput();
            echo $form->field($model, 'estado_regitro')->textInput();
            //echo $form->field($model, 'estado_financiero')->textInput();
        }
    ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
