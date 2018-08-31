<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ContratoEntregable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contrato-entregable-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codigo_contrato')->dropDownList($array_lista_codigos_contrato) ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'estado')->dropDownList($array_estado_de_entregables) ?>

    <?= $form->field($model, 'porcentaje')->textInput()->label('Porcentaje del total del contrato (%)') ?>

    <?= $form->field($model, 'staff_area_id')->dropDownList($array_staff_area) ?>

    <?php echo $form->field($model, 'fecha')->widget(DatePicker::classname(),[
            'name' => 'fecha_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'periodo_id')->dropDownList($array_periodo) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#contratoentregable-codigo_contrato').change();
    });

    $('#contratoentregable-codigo_contrato').change(function(){
        $.ajax({
            url: "<?= Url::base() ?>/rrhh/contrato-entregable/analiza-contrato-adquisicion",
            method: 'POST',
            data: {
                codigo_contrato: $('#contratoentregable-codigo_contrato').val()
            },
            success:function(data){
                if(data==0){
                    $('.field-contratoentregable-periodo_id').hide();
                }
                else{
                    $.ajax({
            url: "<?= Url::base() ?>/rrhh/contrato-contrato/cargar-periodos",
            method: 'POST',
            data: {
                codigo_contrato: $('#contratoentregable-codigo_contrato').val()
            },
            success:function(data){
                $('#contratoentregable-periodo_id').html("");
                $.each(JSON.parse(data), function (index, item) {
                    $('#contratoentregable-periodo_id').append(
                        $('<option></option>').val(index).html(item)
                    );   
                });
            }
        });
                }
            }
        });

        
    });
</script>