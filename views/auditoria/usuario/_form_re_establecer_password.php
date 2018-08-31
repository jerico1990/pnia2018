<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\helpers\Url;
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Rol */
/* @var $form yii\widgets\ActiveForm */

	$url_base = Url::base();

?>

<div class="pregunta-secreta-form">

    <?php $form = ActiveForm::begin(); ?>

	<!-- pregunta 1 -->

    <?= $form->field($model, 'respuesta_random_1')->textInput(['maxlength' => true])->label($arreglo_de_preguntas[$model->pregunta_secreta_1]) ?>

    <!-- pregunta 2 -->

    <?= $form->field($model, 'respuesta_random_2')->textInput(['maxlength' => true])->label($arreglo_de_preguntas[$model->pregunta_secreta_2]) ?>
    

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
                    <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-success']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>

