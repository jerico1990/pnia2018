<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Adquisicion\RequerimientoDetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="requerimiento-detalle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'requerimiento_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'linea_nivel_id')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'concepto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unidad_medida')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cantidad')->textInput() ?>

    <?= $form->field($model, 'costo_unitario')->textInput() ?>

    <?= $form->field($model, 'monto_total')->textInput() ?>

    <?= $form->field($model, 'rooc')->textInput() ?>

    <?= $form->field($model, 'ro')->textInput() ?>

    <?= $form->field($model, 'especificacion_tecnica')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tiempo_entrega')->textInput() ?>

    <?= $form->field($model, 'tipo_garantia_id')->textInput() ?>

    <?= $form->field($model, 'garantia_cantidad')->textInput() ?>

    <?= $form->field($model, 'lugar_entrega')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fecha_entrega')->textInput() ?>

    <?= $form->field($model, 'forma_pago')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'resumen_especificacion_tecnica')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'otras_caractaristicas')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'forma_entrega')->textInput() ?>

    <?= $form->field($model, 'anio_fabricacion')->textInput() ?>

    <?= $form->field($model, 'lugar_fabricacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_area_id')->textarea(['rows' => 6]) ?>




    <?php ActiveForm::end(); ?>

</div>
