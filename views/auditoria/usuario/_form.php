<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>

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
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
