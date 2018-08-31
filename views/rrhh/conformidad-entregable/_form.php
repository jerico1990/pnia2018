<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use app\models\Patrimonio\Metacodigo;
/* @var $this yii\web\View */
/* @var $model app\models\rrhh\ConformidadEntregable */
/* @var $form yii\widgets\ActiveForm */
$objeto_metacodigo = Metacodigo::find()->where(['nombre_lista'=>'Tipo_conformidad','descripcion'=>'Conforme'])->one();
?>

<div class="conformidad-entregable-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'flag_conformidad')->dropDownList($array_tipo_conformidad) ?>
    
    <?= $form->field($model_documento_pnia, 'ruta_documento')->fileInput(
            ['multiple' => true, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Documento') ?>
    
    <?= $form->field($model, 'observacion')->textInput() ?>
    
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        if(<?= $model->flag_conformidad==$objeto_metacodigo->metacodigo_id?true:false?>){
            alert('Ya se dio conformidad positiva a este entregable');
            $('#ajaxCrudModal').modal('toggle');

        }
    });

</script>
