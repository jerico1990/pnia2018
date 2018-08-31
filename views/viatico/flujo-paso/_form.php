<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Viatico\FlujoFlujo;
use app\models\Patrimonio\Metacodigo;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FlujoPaso */
/* @var $form yii\widgets\ActiveForm */
$objeto_flujo_flujo = new FlujoFlujo();
$objeto_flujo_flujo = $objeto_flujo_flujo->find()->where(['flujo_flujo_id'=>$_SESSION['flujo_flujo_id']])->one();
$objeto_metacodigo = new Metacodigo();
$objeto_metacodigo = $objeto_metacodigo->find()->where(['nombre_lista'=>'Tipo_flujo','descripcion'=>'Trámite Documentario'])->one();
$flag_tramite_documentario = false;
if($objeto_flujo_flujo->tipo_flujo_metacodigo==$objeto_metacodigo->metacodigo_id)
    $flag_tramite_documentario = true;
?>

<div class="flujo-paso-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'flujo')->dropDownList(ArrayHelper::map($array_flujo_flujo, 'flujo_flujo_id', 'nombre_flujo')) ?> -->

    <?= $form->field($model, 'nombre_paso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado_paso_metacodigo')->dropDownList($array_metacodigo_estado_paso) ?>

    <?= $form->field($model, 'area_responsable_id')->dropDownList($array_staff_area, ['prompt' => 'Ninguna'])->label('Área de Destino') ?>

    <?= $form->field($model, 'cantidad_dias')->textInput() ?>

    <?= $form->field($model, 'proceso_presupuesto')->dropDownList($array_proceso_presupuesto,['prompt'=>'Ninguno']) ?>

    <?= $form->field($model, 'nivel')->textInput() ?>


    <!-- para trabajar con Paso_previo con ComboBox -->
    <!-- <?= $form->field($model,'paso_previo')
        ->dropDownList(\app\models\Viatico\FlujoPaso::getComboBoxItems_PasosPrevios($_SESSION['flujo_flujo_id']),['prompt'=>'Ninguno'])
        ->label("Paso Previo(solo si es necesario)")?> -->


    <?= $form->field($model,'nivel_siguiente')->textInput()?>

    <!-- para trabajar con nivel siguiente con ComboBox -->
    <!-- <?= $form->field($model,'nivel_siguiente')
        ->dropDownList(\app\models\Viatico\FlujoPaso::getComboBoxItems_NivelesSiguientes($_SESSION['flujo_flujo_id']),['prompt'=>'Ninguno'])
        ->label("Nivel Siguiente(solo si no es secuencial)")?> -->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        if(<?php echo $flag_tramite_documentario;?>!=false){
            $('.field-flujopaso-proceso_presupuesto').hide();
        }
    });

</script>


