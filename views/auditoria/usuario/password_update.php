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
    $model->password_hash = '';
    $change_password = true;

    if ($change_password) { ?>

        <div class="rol-update-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'password_viejo')->passwordInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'pregunta_secreta_1')->dropDownList($arreglo_de_preguntas, ['prompt' => 'Ninguna']) ?>
            
            <?= $form->field($model, 'respuesta_secreta_1')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'pregunta_secreta_2')->dropDownList($arreglo_de_preguntas, ['prompt' => 'Ninguna']) ?>

            <?= $form->field($model, 'respuesta_secreta_2')->textInput(['maxlength' => true]) ?>
            
            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                            <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                </div>
            <?php } ?>

            <?php ActiveForm::end(); ?>

        </div>

    <?php }else{ ?>

        <div class="rol-update-form">

            <?php $form = ActiveForm::begin(); ?>
            
            <?= $form->field($model, 'pregunta_secreta_1')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'respuesta_secreta_1')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'pregunta_secreta_2')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'respuesta_secreta_2')->textInput(['maxlength' => true]) ?>
            
            <?= $form->field($model, 'pregunta_secreta_3')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'respuesta_secreta_3')->textInput(['maxlength' => true]) ?>

            <?php if (!Yii::$app->request->isAjax){ ?>
                <div class="form-group">
                            <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-success']) ?>
                </div>
            <?php } ?>

            <?php ActiveForm::end(); ?>

        </div>

    <?php } ?>

