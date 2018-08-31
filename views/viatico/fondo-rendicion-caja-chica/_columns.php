<?php
use yii\helpers\Url;
use app\controllers\Viatico\FondoRendicionCajaChicaController;
use app\models\Viatico\FondoRendicionCajaChica;
use kartik\grid\GridView;

?>
<script type="text/javascript">

    function cargarRendicionGenerica(fondo_rendicion_caja_chica_id){
        $.ajax({
            url: "<?= Url::base() ?>/Viatico/gestion-rendicion-caja-chica/enviar-codigo-rendicion",
            method: 'POST',
            data: {
                fondo_rendicion_caja_chica_id : fondo_rendicion_caja_chica_id,
                //codigo_requerimiento : codigo_requerimiento,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('detalle-rendicion-generica-caja-chica');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-rendicion-caja-chica-pjax',
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
//    [
//        'class' => 'kartik\grid\CheckboxColumn',
//        'width' => '20px',
//    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
//        [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'fondo_rendicion_caja_chica_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Fondo',
        'width' => '300px',
        'attribute'=>'fondoDescripcion', 
        'value' => 'fondoFondo.motivo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Requerimiento',
        'width' => '300px',
        'attribute'=>'rendicionRequerimiento', 
        'value' => 'flujoRequerimiento.descripcion',
    ],
    [
        'header' => 'Detalle',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Detalle',
                array(
                    'id'=>'buttonDetalleRendicion'.$model->fondo_rendicion_caja_chica_id,
                    'onclick'=>'cargarRendicionGenerica("'.$model->fondo_rendicion_caja_chica_id.'")',
                    //'onclick'=>'cargarCodigoInterno("'.$model->contrato_contrato_id.'","'.$model->codigo_interno.'")',
                )
            );
        },
        'width' => '20px'
    ],

    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'responsable_persona_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'total_rendicion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'documento_pnia',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_rendicion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'correlativo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'actualizado_en',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'actualizado_por',
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
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Ver','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip', 'hidden' => true],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   