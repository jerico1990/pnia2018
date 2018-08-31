<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\typeahead\Typeahead;


/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioInventario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patrimonio-inventario-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'patrimonio_item_id')->dropDownList($items) ?>

    <?= $form->field($model, 'metacodigo_condicion_id')->dropDownList($metacodigo_condicion) ?>

    <?= $form->field($model, 'metacodigo_estado_id')->dropDownList($metacodigo_estado) ?>

    <!-- <?= $form->field($model, 'documento_pnia_id')->textInput() ?> -->
    
    <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
            ['multiple' => true, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Documento') ?>

    

    <?= $form->field($model, 'ubicacion_id')->dropDownList($ubicaciones,array('prompt'=>'Ninguno')) ?>

    <!-- <?= $form->field($model, 'persona_aut')->dropDownList($user,array('prompt'=>'Ninguno')) ?> -->
    <?= $form->field($model, 'autocomplete_staff_persona_aut')->widget(Typeahead::classname(), [
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
            ]);
    ?>

    <!-- <?= $form->field($model, 'persona_inv')->dropDownList($user,array('prompt'=>'Ninguno')) ?> -->
    <?= $form->field($model, 'autocomplete_staff_persona_inv')->widget(Typeahead::classname(), [
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
            ]);
    ?>

    <?php echo $form->field($model, 'fecha_inventario')->widget(DatePicker::classname(),[
            'name' => 'fecha_salida_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
