<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */
/* @var $form yii\widgets\ActiveForm */
?>

<script>
    function ocultarNumeracion() {
        var cabecera_padre = document.getElementById('presupuestocabecera-presupuesto_cabecera_padre_id');
        var campo_numeracion = document.getElementById("segmento_numeracion");

        if (cabecera_padre.selectedIndex == 0){
            campo_numeracion.style.display = "block";
        }else{
            campo_numeracion.style.display = "none";
        }
    }
</script>
<div class="presupuesto-cabecera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partida_id')->dropDownList($array_partidas,['prompt'=>'Ninguno']) ?>

    <?= $form->field($model, 'presupuesto_cabecera_padre_id')->dropDownList($array_padres,['prompt'=>'Ninguno','onchange'=>'ocultarNumeracion()']) ?>

    <?= $form->field($model, 'nombre_linea')->textInput() ?>

    <div id="segmento_numeracion" style="display: block" >
        <?= $form->field($model, 'numeracion_linea')->textInput() ?>
    </div>

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

