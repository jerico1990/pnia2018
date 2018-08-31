<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="presupuesto-cabecera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partida_id')->dropDownList($array_partidas) ?>

    <?= $form->field($model, 'presupuesto_cabecera_padre_id')->dropDownList($array_padres,['prompt'=>'Ninguno']) ?>

    <?= $form->field($model, 'nombre_linea')->textInput() ?>

    <!-- <?= $form->field($model, 'numeracion_linea')->textInput() ?>  -->

    <?= $form->field($model, 'periodo_inicio')->widget(DatePicker::className(),
        [
            'options' => ['placeholder' => 'Inicio...'],
            'pluginOptions' => [
                'autoclose' => true,
                'startView'=>'year',
                'minViewMode'=>'years',//'months',
                'format' => 'yyyy'//-mm'
            ]
        ]
    )->label('Rango del Periodo')
    ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
