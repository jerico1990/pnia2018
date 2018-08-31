<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Mensaje */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mensaje-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    if (Yii::$app->user->isGuest) {
        echo $form->field($model, 'usuario_id_de')->textInput();
    } ?>

    <?= $form->field($model, 'usuario_id_para')->textInput() ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mensaje')->textarea(['rows' => 6]) ?>
    
    <!--     $form->field($model, 'creado_en')->textInput() ?>
        $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    -->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
