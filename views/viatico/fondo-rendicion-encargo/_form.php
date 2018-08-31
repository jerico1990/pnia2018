<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionEncargo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-rendicion-encargo-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'fondo_fondo_id')->dropDownList($array_fondos_disponibles, array('prompt'=>'Ninguno'))->label('Fondo de Encargo') ?>

    <?= $form->field($model, 'correlativo')->textInput() ?>

    <?= $form->field($model, 'total')->textInput(['readonly' => true]) ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento')->fileInput(
            ['multiple' => false, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Resolución Directoral (Obligatorio)') ?>

    <?= $form->field($model, 'informe_actividades_logros')->widget(\yii\redactor\widgets\Redactor::className())->label('Informe de Actividades') ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


<?php
$this->registerJs("
    $('#fondorendicionencargo-fondo_fondo_id').on('change',function(){
        if($(this).val()==''){
            $('#fondorendicionencargo-total').val('');
        }
        else {
             $.ajax({
                    url: '".yii\helpers\Url::toRoute("Viatico/fondo-rendicion-viatico/llenar-monto-predeterminado")."',
                    dataType: 'json',
                    method: 'GET',
                    data: {
                        //id: $(this).val()
                        id_fondo: $('#fondorendicionencargo-fondo_fondo_id').val(),
                    },
                    success: function (data, textStatus, jqXHR) {
                        // $('#patrimonioitem-descripcion').val(data.descripcion);
                        // $('#patrimonioitem-marca').val(data.marca);
                        // $('#patrimonioitem-modelo').val(data.modelo);
                        // $('#patrimonioitem-serie').val(data.serie);

                        $('#fondorendicionencargo-total').val(data.monto_de_fondo);
                    },
                    beforeSend: function (xhr) {
                        //alert('loading!');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log('Algo salió mal');
                        alert('Error in ajax request');
                    }
                });
        }
    });"
); 

?>