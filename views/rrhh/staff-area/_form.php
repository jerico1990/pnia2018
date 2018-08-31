<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\rrhh\StaffArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-area-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'area_superior')->dropDownList($array_lista_areas, ['prompt' => 'Ninguno'])->label('Área Superior') ?>
    
    <?= $form->field($model, 'codigo')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput() ?>

    <?= $form->field($model, 'cargo')->textInput() ?>

    <!-- <?= $form->field($model, 'responsable')->dropDownList($array_personas, ['prompt' => 'Ninguno'])->label('Responsable') ?> -->

    <?= $form->field($model, 'autocomplete_staff_persona')->widget(Typeahead::classname(), [
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
    ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
