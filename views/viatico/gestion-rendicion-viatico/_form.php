<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoRendicionGenerico */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-rendicion-generico-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_afecto_igv_metacodigo')->dropDownList($array_tipo_afecto)->label('¿Afecto a IGV?') ?>

    <?= $form->field($model, 'tipo_bien_servicio_metacodigo')->dropDownList($array_metacodigo_tipo_bien_servicio)->label('Tipo de Servicio') ?>

    <?= $form->field($model, 'tipo_documento_metacodigo')->dropDownList($array_metacodigo_documento_rendicion)->label('Tipo de Documento') ?>

    <?= $form->field($model, 'proveedor_pnia_entidad_id')->dropDownList($array_pnia_entidades)->label('Entidad Proveedora') ?>

    <?= $form->field($model, 'importe_viatico')->textInput() ?>

    <?= $form->field($model, 'importe_gravado')->textInput(['maxlength' => true,'readonly' => true]) ?>

    <?= $form->field($model, 'serie_numero')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'fecha_documento')->widget(DatePicker::classname(),[
            'name' => 'fecha_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'ruc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detalle_gasto')->textInput(['maxlength' => true]) ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>

<?php
$this->registerJs("
    $('#fondorendiciongenerico-importe_viatico').on('change',function(){
        if($(this).val()==''){
            $('#fondorendiciongenerico-importe_gravado').val('');
        }
        else {
             $.ajax({
                    url: '".yii\helpers\Url::toRoute("Viatico/gestion-rendicion-encargo/llenar-importe-gravado")."',
                    dataType: 'json',
                    method: 'GET',
                    data: {
                        //id: $(this).val()
                        importe: $('#fondorendiciongenerico-importe_viatico').val(),
                    },
                    success: function (data, textStatus, jqXHR) {
                        // $('#patrimonioitem-descripcion').val(data.descripcion);
                        // $('#patrimonioitem-marca').val(data.marca);
                        // $('#patrimonioitem-modelo').val(data.modelo);
                        // $('#patrimonioitem-serie').val(data.serie);

                        $('#fondorendiciongenerico-importe_gravado').val(data.importe_gravado);
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