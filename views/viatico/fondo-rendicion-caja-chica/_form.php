<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionCajaChica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-rendicion-caja-chica-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'fondo_fondo_id')->dropDownList($array_fondos_disponibles, array('prompt'=>'Ninguno'))->label('Fondo de Caja Chica') ?>

    <?= $form->field($model, 'total_rendicion')->textInput(['readonly' => true])->label('Total de Rendición') ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento')->fileInput(
            ['multiple' => false, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Documento (Obligatorio)') ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


<?php
$this->registerJs("
    $('#fondorendicioncajachica-fondo_fondo_id').on('change',function(){
        if($(this).val()==''){
            $('#fondorendicioncajachica-total_rendicion').val(''); 
        }
        else {
             $.ajax({
                    url: '".yii\helpers\Url::toRoute("Viatico/fondo-rendicion-viatico/llenar-monto-predeterminado")."',
                    dataType: 'json',
                    method: 'GET',
                    data: {
                        //id: $(this).val()
                        id_fondo: $('#fondorendicioncajachica-fondo_fondo_id').val(),
                    },
                    success: function (data, textStatus, jqXHR) {
                        // $('#patrimonioitem-descripcion').val(data.descripcion);
                        // $('#patrimonioitem-marca').val(data.marca);
                        // $('#patrimonioitem-modelo').val(data.modelo);
                        // $('#patrimonioitem-serie').val(data.serie);

                        $('#fondorendicioncajachica-total_rendicion').val(data.monto_de_fondo);
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