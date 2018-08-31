<?php
use yii\helpers\Url;
?>
<script type="text/javascript">
    function cargarDocumentosContrato(patrimonio_inventario_id){
        $.ajax({
            url: "<?= Url::base() ?>/Patrimonio/patrimonio-inventario/enviar-codigo-interno",
            method: 'POST',
            data: {
                patrimonio_inventario_id : patrimonio_inventario_id,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('lista-documentos-patrimonio-inventario');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-documento-pnia-pjax',
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
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Item',
        'width' => '100px',
        //'attribute'=>'patrimonioItem.descripcion',
        'attribute' => 'patrimonioItemDescripcion',
        'value' => 'patrimonioItem.descripcion'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Código Item',
        'width' => '60px',
        'attribute'=>'patrimonioItemCodigo',
        'value'=>'patrimonioItem.codigo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
         'label' => 'Ubicación',
        'width' => '140px',
        'attribute'=>'ubicacionDescripcion', 
        'value' => 'ubicacion.descripcion',
    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
//        [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'patrimonio_inventario_id',
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'patrimonio_item_id',
//        //'attribute' => $model_patrimonio_item->getItemComoArray(intval('patrimonio_item_id'))['descripcion'],
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Condición',
        'width' => '140px',
        //'attribute'=>'metacodigoCondicion.descripcion',
        'attribute'=>'condicionDescripcion', 
        'value' => 'metacodigoCondicion.descripcion',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'metacodigo_condicion_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Estado',
        'width' => '140px',
        'attribute'=>'estadoDescripcion', 
        'value' => 'metacodigoEstado.descripcion',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'metacodigo_estado_id',
//    ],
     [
        'class'=>'\kartik\grid\DataColumn',
         'label' => 'Documento',
         'width' => '200px',
        'attribute'=>'documentoPniaNombreDocumento',
        'value' => 'documentoPnia.nombre_documento',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Descargar Documento',
//        'width' => '200px',
//        //'attribute'=>'documentoPniaNombreDocumento',
//        //'value' => 'documentoPnia.nombre_documento',
//         
//        'format' => 'raw',
//        //'data-pjax' => '0',  //no funciona
//        'value' => function($data){
//            if ($data->documento_pnia_id){
//                return Html::a('Descargar Archivo', ['Patrimonio/patrimonio-inventario/descargar-doc', 'doc_id' => $data->documento_pnia_id],['class' => 'btn btn-primary', 'data-pjax' => 0]);
//            }
//            else 
//                return 'No existe documento asociado';
//        }
//
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'documento_pnia_id',
//    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ubicacion_id',
    // ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'persona_aut',
     ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'persona_inv',
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fecha_inventario',
        'format' => ['date', 'php:Y-m-d'],
    ],
    [
        'header' => 'Archivos',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Archivos',
                array(
                    'id'=>'buttonDocumentos'.$model->patrimonio_inventario_id,
                    'onclick'=>'cargarDocumentosContrato("'.$model->patrimonio_inventario_id.'")',
                    //'onclick'=>'cargarCodigoInterno("'.$model->contrato_contrato_id.'","'.$model->codigo_interno.'")',
                )
            );
        },
        'width' => '20px'
    ],
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
                return Url::to([$action,'id' => $key ]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'Vista','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar',  
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']], 
    ],

];   