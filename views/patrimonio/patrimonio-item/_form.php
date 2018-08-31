<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patrimonio-item-form">
    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'patrimonio_clase_id')->dropDownList([null => 'Ninguno']+ArrayHelper::map($patrimonios_clases, 'patrimonio_clase_id', 'nombre','codigo'))->label('Clase') ?>

    <?= $form->field($model, 'metacodigo_id')->dropDownList(ArrayHelper::map($array_metacodigo_condicion, 'metacodigo_id', 'descripcion')) ?>

    <!-- <?= $form->field($model, 'documento_pnia_id')->textInput() ?> -->
    
    <?= $form->field($model_documento_pnia, 'ruta_documento[]')->fileInput(
            ['multiple' => true, 
             'value' => null,
             //'accept' => 'image/*'
             ])->label('Subir Documento') ?>

    <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'fecha_alta')->widget(DatePicker::classname(),[
            'name' => 'fecha_alta_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?php echo $form->field($model, 'fecha_baja')->widget(DatePicker::classname(),[
            'name' => 'fecha_baja_widget',
            'removeButton' => false,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd']]);
    ?>

    <?= $form->field($model, 'valor_historico')->textInput() ?>

    <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serie')->textInput(['maxlength' => true]) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
