<?php
use yii\helpers\Url;
?>

<script type="text/javascript">

    function cargarFondoViatico(fondo_fondo_id){
        $.ajax({
            url: "<?= Url::base() ?>/Viatico/fondo-viatico/enviar-codigo-interno",
            method: 'POST',
            data: {
                fondo_fondo_id : fondo_fondo_id,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('viatico-detalle');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-viatico-detalle-pjax',
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
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'fondo_fondo_id',
    // ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Código de Viático',
//        'width' => '300px',
//        'attribute'=>'fondoId', 
//        'value' => 'fondo_fondo_id',
//    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'label' => 'Motivo',
         'attribute'=>'motivo',
     ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'requerimiento_flujo_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Requerimiento',
        'width' => '300px',
        'attribute'=>'ReqFlujoDescripcion', 
        'value' => 'requerimientoFlujo.descripcion',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'tipo_flujo_metacodigo',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Descargar Documento',
        'width' => '200px',
        //'attribute'=>'documentoPniaNombreDocumento', //deshabilitado, quita el search y el filtro por detrás
        //'value' => 'documentoPnia.nombre_documento',
         
        'format' => 'raw',
        //'data-pjax' => '0',  //no funciona
        'value' => function($data){
            if ($data->resolucion_directoral_pnia_documento_id){
                return Html::a('Descargar Archivo', ['rrhh/contrato-contrato/descargar-doc', 'doc_id' => $data->resolucion_directoral_pnia_documento_id],['class' => 'btn btn-primary', 'data-pjax' => 0]);
            }
            else 
                return 'No existe documento asociado';
        }
    ],
    [
        'header' => 'Detalle Viático',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Detalle Viático',
                array(
                    'id'=>'buttonViaticoDetalle'.$model->fondo_fondo_id,
                    'onclick'=>'cargarFondoViatico("'.$model->fondo_fondo_id.'")',
                )
            );
        },
        'width' => '20px'
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'banco_entidad_financiera',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'motivo',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'saldo_anterior_bienes',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'saldo_anterior_servicios',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'saldo_actual_bienes',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'saldo_actual_servicios',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_inicio',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_fin',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'total_bienes',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'total_servicios',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'total_entregado',
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
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   