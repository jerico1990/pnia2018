<?php
use yii\helpers\Url;
use app\controllers\Viatico\FlujoRequerimientoController;
use app\models\Viatico\FlujoRequerimiento;
use kartik\grid\GridView;

?>

<script type="text/javascript">

    function cargarPasos(flujo_flujo_id){
        $.ajax({
            url: "<?= Url::base() ?>/Viatico/flujo-flujo/enviar-codigo-requerimiento",
            method: 'POST',
            data: {
                flujo_flujo_id : flujo_flujo_id,
                //codigo_requerimiento : codigo_requerimiento,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('lista-pasos');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-flujo-paso-pjax',
                });

                
                //cuando se utilizan vistas adicionales
                // $.pjax.xhr = null;
                // $.pjax.reload({
                //     container:'#crud-datatable-penalidad-pjax',
                // });
                // $.pjax.xhr = null;
            },
            fail:function(text){
                alert('Hubo un error en la conexión, la data es invalida. Recargue la página porfavor.');
            }
        });
    }

</script>


<?php
use yii\helpers\Html;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'flujo_flujo_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nombre_flujo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Flujo',
        'attribute'=>'tipoFlujoMetacodigo',
        'value' => 'tipoFlujoMetacodigo.descripcion'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'tipo_flujo_metacodigo',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'actualizado_en',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'actualizado_por',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'creado_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'creado_por',
    // ],
    
    [
        'header' => 'Pasos',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Pasos',
                array(
                    'id'=>'buttonDocumentos'.$model->flujo_flujo_id,
                    'onclick'=>'cargarPasos("'.$model->flujo_flujo_id.'")',
                    //'onclick'=>'cargarCodigoInterno("'.$model->contrato_contrato_id.'","'.$model->codigo_interno.'")',
                )
            );
        },
        'width' => '20px'
    ],
                
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   