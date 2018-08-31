<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoDistribucionMonto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-distribucion-monto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'escala_metacodigo')->dropDownList($array_niveles) ?>

    <?= $form->field($model, 'concepto_metacodigo')->dropDownList($array_metacodigo_concepto) ?>

    <?php // $form->field($model, 'destino_ini_ubigeo')->dropDownList($array_utilitario_ubigeo)->label('Destino Inicial') ?>

    <?php
    if ($model->destino_ini_ubigeo != null){
        $nombre_ubigeo = $model->destinoIniUbigeo->nombre;
    }

    echo $form->field($model, 'destino_ini_ubigeo')->widget(Select2::classname(), [
        //'hashVarLoadPosition' => \yii\web\View::POS_READY,// ::POS_READY
        'initValueText' => isset($nombre_ubigeo) ? $nombre_ubigeo : null,
        'options' => [
            'placeholder' => 'Busqueda Origen',
        ],
        'pluginOptions' => [
            'dropdownParent'     => new JsExpression('$("#ajaxCrudModal")'),
            'allowClear'         => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading'   => new JsExpression("function () { return 'Cargando ...'; }"),
            ],
            'ajax' => [
                'url'       => Url::base().'Utilitario/utilitario-ubigeo/ubigeo-list',
                'dataType'  => 'json',
                'data'      => new JsExpression('function(params) { return {q:params.term}; }'),
                ],
            'escapeMarkup'      => new JsExpression('function (markup) { return markup; }'),
            'templateResult'    => new JsExpression('function (ubigeo) { return ubigeo.text; }'),
            'templateSelection' => new JsExpression('function (ubigeo) { return ubigeo.text; }'),
        ],
    ]);
    ?>

    <?php // $form->field($model, 'destino_fin_ubigeo')->dropDownList($array_utilitario_ubigeo)->label('Destino Final') ?>

    <?php
    if ($model->destino_fin_ubigeo != null){
        $nombre_ubigeo_fin = $model->destinoFinUbigeo->nombre;
    }

    echo $form->field($model, 'destino_fin_ubigeo')->widget(Select2::classname(), [
        //'hashVarLoadPosition' => \yii\web\View::POS_READY,// ::POS_READY
        'initValueText' => isset($nombre_ubigeo_fin) ? $nombre_ubigeo_fin : null,
        'options' => [
            'placeholder' => 'Busqueda Destino',
        ],
        'pluginOptions' => [
            'dropdownParent'     => new JsExpression('$("#ajaxCrudModal")'),
            'allowClear'         => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading'   => new JsExpression("function () { return 'Cargando ...'; }"),
            ],
            'ajax' => [
                'url'       => Url::base().'Utilitario/utilitario-ubigeo/ubigeo-list',
                'dataType'  => 'json',
                'data'      => new JsExpression('function(params) { return {q:params.term}; }'),
            ],
            'escapeMarkup'      => new JsExpression('function (markup) { return markup; }'),
            'templateResult'    => new JsExpression('function (ubigeo) { return ubigeo.text; }'),
            'templateSelection' => new JsExpression('function (ubigeo) { return ubigeo.text; }'),
        ],
    ]);
    ?>

    <?= $form->field($model, 'monto_determinado')->textInput() ?>

    <!-- <?= $form->field($model, 'actualizado_en')->textInput() ?>

    <?= $form->field($model, 'actualizado_por')->textInput() ?>

    <?= $form->field($model, 'creado_en')->textInput() ?>

    <?= $form->field($model, 'creado_por')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
