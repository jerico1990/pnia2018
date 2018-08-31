<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Viatico\FondoViaticoDetalle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fondo-viatico-detalle-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'destino_inicial_ubigeo')->dropDownList($array_utilitario_ubigeo, array('prompt'=>'Ninguno'))->label('Destino Inicial') ?>

    <?php
    if ($model->destino_inicial_ubigeo != null){
        $nombre_ubigeo_inicial = $model->destinoInicialUbigeo->nombre;
    }

    echo $form->field($model, 'destino_inicial_ubigeo')->widget(Select2::classname(), [
        //'hashVarLoadPosition' => \yii\web\View::POS_READY,// ::POS_READY
        'initValueText' => isset($nombre_ubigeo_inicial) ? $nombre_ubigeo_inicial : null,
        'options' => [
            'placeholder' => 'Busqueda Destino Inicial',
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

    <?php // $form->field($model, 'destino_final_ubigeo')->dropDownList($array_utilitario_ubigeo, array('prompt'=>'Ninguno'))->label('Destino Inicial') ?>

    <?php
    if ($model->destino_final_ubigeo != null){
        $nombre_ubigeo_final = $model->destinoFinalUbigeo->nombre;
    }

    echo $form->field($model, 'destino_final_ubigeo')->widget(Select2::classname(), [
        //'hashVarLoadPosition' => \yii\web\View::POS_READY,// ::POS_READY
        'initValueText' => isset($nombre_ubigeo_final) ? $nombre_ubigeo_final : null,
        'options' => [
            'placeholder' => 'Busqueda Destino Inicial',
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

    <?= $form->field($model, 'numero_dias')->textInput()->label('Número de Días') ?>

    <?= $form->field($model, 'monto')->textInput(['maxlength' => true,'readonly' => true]) ?>
    <!-- <?= $form->field($model, 'monto')->textInput() ?> -->

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>


<?php
$this->registerJs("
    $('#fondoviaticodetalle-destino_inicial_ubigeo').change(function(){
        calcularMonto();
    });
    $('#fondoviaticodetalle-destino_final_ubigeo').change(function(){
        calcularMonto();
    });

    $('#fondoviaticodetalle-numero_dias').on('change',function(){
        calcularMonto();
                
    });

    function calcularMonto(){
        if($('#fondoviaticodetalle-numero_dias').val()!=''){
                    $.ajax({
                        url: '".yii\helpers\Url::toRoute("Viatico/fondo-viatico/calcular-monto")."',
                        dataType: 'json',
                        method: 'GET',
                        data: {
                            //id: $(this).val()
                            ubicacionInicial: $('#fondoviaticodetalle-destino_inicial_ubigeo').val(),
                            ubicacionFinal: $('#fondoviaticodetalle-destino_final_ubigeo').val(),
                            nroDias: $('#fondoviaticodetalle-numero_dias').val(), //es el numero de días del if donde se encuentra
                        },
                        success: function (data, textStatus, jqXHR) {
                            // $('#patrimonioitem-descripcion').val(data.descripcion);
                            // $('#patrimonioitem-marca').val(data.marca);
                            // $('#patrimonioitem-modelo').val(data.modelo);
                            // $('#patrimonioitem-serie').val(data.serie);

                            $('#fondoviaticodetalle-monto').val(data.monto_total);
                        },
                        beforeSend: function (xhr) {
                            //alert('loading!');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Algo salió mal');
                            alert('Error in ajax request');
                        }
                    });
        }
        else{
            $.ajax({
                        url: '".yii\helpers\Url::toRoute("Viatico/fondo-viatico/calcular-monto")."',
                        dataType: 'json',
                        method: 'GET',
                        data: {
                            //id: $(this).val()
                            ubicacionInicial: $('#fondoviaticodetalle-destino_inicial_ubigeo').val(),
                            ubicacionFinal: $('#fondoviaticodetalle-destino_final_ubigeo').val(),
                            nroDias: 0
                        },
                        success: function (data, textStatus, jqXHR) {
                            // $('#patrimonioitem-descripcion').val(data.descripcion);
                            // $('#patrimonioitem-marca').val(data.marca);
                            // $('#patrimonioitem-modelo').val(data.modelo);
                            // $('#patrimonioitem-serie').val(data.serie);

                            $('#fondoviaticodetalle-monto').val(data.monto_total);
                        },
                        beforeSend: function (xhr) {
                            //alert('loading!');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log('Algo salió mal');
                            alert('Error in ajax request');
                        }
                    });
        }
    };



    
    "
); 

?>