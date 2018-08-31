<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */
/* @var $form yii\widgets\ActiveForm */

if (isset($_SESSION['anho_busqueda']) AND $_SESSION['anho_busqueda'] != null){
    $model->periodo_inicio = $_SESSION['anho_busqueda'];
}


?>

<div class="presupuesto-cabecera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'linea_elegida')->dropDownList(\app\models\Presupuesto\PresupuestoCabecera::getComboBoxItemsVerdaderoId(false)) ?>

    <?= $form->field($model, 'periodo_inicio')->widget(DatePicker::className(),
        [
            'options' => ['placeholder' => 'Inicio...'],
            'pluginOptions' => [
                'autoclose' => true,
                'startView'=>'year',
                'minViewMode'=>'years',//'months',
                'format' => 'yyyy',//-mm'
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

