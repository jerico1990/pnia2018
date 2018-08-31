<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model app\models\rrhh\StaffPersona */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="staff-persona-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombres')->textInput() ?>

    <?= $form->field($model, 'apellido_paterno')->textInput() ?>
    
    <?= $form->field($model, 'apellido_materno')->textInput() ?>
    
    <?= $form->field($model, 'fecha_nacimiento')->widget(DatePicker::classname(),[
            'name' => 'fecha_nacimiento_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'cargo')->textInput() ?>
    
    <?= $form->field($model, 'poliza_seguro')->textInput() ?>
    
    <?= $form->field($model, 'staff_area_id')->dropDownList($array_staff_areas,['prompt'=>'Ninguna']) ?>

    <?= $form->field($model, 'nivel')->dropDownList([1 => '1er Nivel', 2 => '2do Nivel', 3 => '3er Nivel']) ?>

    <?= $form->field($model, 'codigo_pnia')->textInput() ?>
    
    <?= $form->field($model, 'dni')->textInput() ?>
    
    <?= $form->field($model, 'ruc')->textInput() ?>
    
    <?= $form->field($model, 'email')->textInput() ?>

    <?= $form->field($model, 'pnia_ent_financiera_id')->dropDownList($array_entidades_financieras,['prompt'=>'Ninguna']) ?>

    <?= $form->field($model, 'cuenta_bancaria')->textInput() ?>


    <!-- <?= $form->field($model, 'nombres')->widget(Typeahead::classname(), [
            'options' => ['placeholder' => 'Filtrar'],
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
    ?> -->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
