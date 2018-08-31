<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\Proyecto */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="proyecto-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?=
        Html::buttonInput("Reload time",['id'=>'reload_button','onClick'=>'recargarListaUsuarios()']);
    ?>

    <div id="partial-render-usuarios"></div>

    <?php ActiveForm::end(); ?>
</div>

<script type="text/javascript">

    function recargarListaUsuarios() {
        $("#partial-render-usuarios").load("http://localhost:8888/Pnia/web/Presupuesto/usuarios-agregados/index-parcial");
    }

</script>

