 <?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use app\models\Viatico\FlujoPaso;
use app\models\Patrimonio\Metacodigo;
use app\models\rrhh\StaffArea;
use \yii2mod\alert\Alert;
use kartik\switchinput\SwitchInput;

// echo \yii2mod\alert\Alert::widget([
//     'useSessionFlash' => false,
//     'options' => [
//         'type' => 'info',
//         'title' => 'Atención!',
//         'text' => "
//         - Si inserta un documento, debe guardar antes de procesar
//         ",
//         'closeOnConfirm' => true,
//         'animation' => "slide-from-top",
//     ]
// ]);
/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoRequerimiento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tramite-documentario1-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'codigo_flujo')->dropDownList($array_flujo_flujo) ?>
    
    <?= $form->field($model, 'observacion')->textInput() ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
            ['multiple' => true, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Documento')->label("Subir documento (Guardar antes de procesar)") ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>

<select id="select_opciones"></select>

<input type="button" id="btn_avanza_paso" value="Procesar">
    <script type="text/javascript">
    $(document).ready(function(){
        <?php
        $flag = false;
        $objeto_flujo_paso = new FlujoPaso();
        if($model->flujo_requerimiento_id>0){
            $objeto_metacodigo = new Metacodigo();
            $objeto_flujo_paso = $objeto_flujo_paso->findById($model->codigo_paso);
            $objeto_metacodigo = $objeto_metacodigo->findById($objeto_flujo_paso->estado_paso_metacodigo);
            $estado_actual = $objeto_metacodigo->descripcion;
            $objeto_area = StaffArea::find()->where(['responsable'=> Yii::$app->user->identity->persona_id])->one();
            if($objeto_area->staff_area_id != $model->area_aprobadora_id){
                $flag=true;
            }
            
        }
        else
            $estado_actual="";
        ?>
        
        if("<?php echo $estado_actual ?>" == "En Digitación" || "<?php echo $estado_actual ?>" == ""){
            $('.field-flujorequerimiento-observacion').hide();
            if("<?php echo $estado_actual ?>" == ""){
                $('.field-flujorequerimiento-observacion').hide();

                $('#select_opciones').hide();
                $('#btn_avanza_paso').hide();
            }
        }
        else{
            $('.field-flujorequerimiento-observacion').show();
            $('#flujorequerimiento-descripcion').prop('disabled', 'disabled');
            $('#flujorequerimiento-codigo_flujo').prop('disabled', 'disabled');
            $('#flujorequerimiento-codigo_arbol').prop('disabled', 'disabled');
            $('#flujorequerimiento-periodo_id').prop('disabled', 'disabled');
            $('#flujorequerimiento-monto').prop('disabled', 'disabled');
            $('#flujorequerimiento-ro_rooc').prop('disabled', 'disabled');
            if("<?php echo $model->emisor_persona_id ?>" && '<?php echo $flag ?>' ){
                $('#select_opciones').hide();
                $('#btn_avanza_paso').hide();
                $('#flujorequerimiento-observacion').prop('disabled','disabled');
            }
            else{
                $('#select_opciones').show();
                $('#btn_avanza_paso').show();
            }  
            if("<?php echo $estado_actual ?>" == "Contrato"){
                alert("VERIFICAR PROCESAMIENTO DE CONTRATO PARA PODER PROCESAR");
            }
            if("<?php echo $estado_actual ?>" == "Desembolso"){
                alert("VERIFICAR PROCESAMIENTO DE DESEMBOLSO PARA PODER PROCESAR");
            }

        }

        if("<?php echo $model->flag_procesado ?>" == '1'){
            $('#select_opciones').hide();
            $('#btn_avanza_paso').hide();
            $('#flujorequerimiento-descripcion').prop('disabled', 'disabled');
            $('#flujorequerimiento-codigo_flujo').prop('disabled', 'disabled');
            $('#flujorequerimiento-codigo_arbol').prop('disabled', 'disabled');
            $('#flujorequerimiento-periodo_id').prop('disabled', 'disabled');
            $('#flujorequerimiento-monto').prop('disabled', 'disabled');
            $('#flujorequerimiento-ro_rooc').prop('disabled', 'disabled');
        }

        if("<?php echo $estado_actual ?>" != "" ){
            $.ajax({
            url: "<?= Url::base() ?>/Viatico/flujo-requerimiento/llenar-opciones",
            method: 'POST',
            data: {
                flujo_requerimiento_id: "<?php echo $model->flujo_requerimiento_id; ?>"
            },
            success:function(data){
                    $('#select_opciones').html("");
                    $.each(JSON.parse(data), function (index, item) {

                        $('#select_opciones').append(
                            $('<option></option>').val(index).html(item)
                        );
                        
                    });
                //alert(data);
            }
        });
        }

        
    });

    $('#btn_avanza_paso').click(function(){
        //alert(<?php echo $model->codigo_paso; ?>);
        $.ajax({
            url: "<?= Url::base() ?>/Viatico/flujo-requerimiento/avanzar-paso",
            method: 'POST',
            data: {
                flujo_requerimiento_id: "<?php echo $model->flujo_requerimiento_id; ?>" ,
                siguiente_paso : $('#select_opciones').val(),
                observacion : $('#flujorequerimiento-observacion').val()
            },
            success:function(data){
                if(data!=null){
                    alert("se procesó");
                }
                //alert("Se procesó");
                $('#ajaxCrudModal').modal('toggle');
                $.pjax.reload({container:"#crud-datatable-pjax"});
            }
        });
    });
    $(document).ready(function(){
    });
    </script>
</div>
