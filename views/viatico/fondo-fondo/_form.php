<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoFondo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-fondo-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- <?= $form->field($model, 'responsable_persona_id')->textInput() ?> --!>
    <?= $form->field($model, 'autocomplete_staff_persona')->widget(Typeahead::classname(), [
                'options' => ['placeholder' => 'Buscar ... '],
                'pluginOptions' => ['highlight'=>true],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('nombre_completo')",
                        'display' => 'nombre_completo',
                        'remote' => [
                            'url' => Url::base().'/rrhh/staff-persona/autocompletar-nombre-completo'. '?q=%QUERY',
                            'wildcard' => '%QUERY'
                        ]

                    ]
                ]
            ])->label('Personal Asignado');
    ?>

    <?= $form->field($model, 'requerimiento_flujo_id')->dropDownList($lista_flujo_requerimiento) ?>

    <?= $form->field($model, 'tipo_flujo_metacodigo')->dropDownList($array_metacodigo_tipo_flujo) ?>

    <?= $form->field($model_documento_pnia, 'ruta_documento')->fileInput(
            ['multiple' => false, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Resolución Directoral') ?>

    <?= $form->field($model, 'banco_entidad_financiera')->dropDownList($array_lista_entidad_financiera) ?>

    <?= $form->field($model, 'motivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_anterior_bienes')->textInput() ?>

    <?= $form->field($model, 'saldo_anterior_servicios')->textInput() ?>

    <?= $form->field($model, 'saldo_actual_bienes')->textInput() ?>

    <?= $form->field($model, 'saldo_actual_servicios')->textInput() ?>

    <?= $form->field($model, 'fecha_inicio')->widget(DatePicker::classname(),[
            'name' => 'fecha_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'fecha_fin')->widget(DatePicker::classname(),[
            'name' => 'fecha_inicio_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'total_bienes')->textInput() ?>

    <?= $form->field($model, 'total_servicios')->textInput() ?>

    <?= $form->field($model, 'total_entregado')->textInput() ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
