<?php
use yii\helpers\Url;
?>
<script type="text/javascript">
    function cargarDocumentosContrato(patrimonio_item_id){
        $.ajax({
            url: "<?= Url::base() ?>/Patrimonio/patrimonio-item/enviar-codigo-interno",
            method: 'POST',
            data: {
                patrimonio_item_id : patrimonio_item_id,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('lista-documentos-patrimonio-item');
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
    /*
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'patrimonio_item_id',
    ],// */

    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Código',
        'attribute'=>'itemCodigo', 
        'value' => 'codigo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'marca',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'modelo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'serie',
    ],
    
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'patrimonio_clase_id',
//    ],
     [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Clase',
        'width' => '80px',
        'attribute'=>'patrimonioClaseDescripcion', 
        'value' => 'patrimonioClase.nombre',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'metacodigo_id',
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Condición',
        'width' => '60px',
        'attribute'=>'metacodigoDescripcion', 
        'value' => 'metacodigo.descripcion',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'documento_pnia_id',
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
//        //'attribute'=>'documentoPniaNombreDocumento', //deshabilitado, quita el search y el filtro por detrás
//        //'value' => 'documentoPnia.nombre_documento',
//         
//        'format' => 'raw',
//        //'data-pjax' => '0',  //no funciona
//        'value' => function($data){
//            if ($data->documento_pnia_id){
//                return Html::a('Descargar Archivo', ['Patrimonio/patrimonio-item/descargar-doc', 'doc_id' => $data->documento_pnia_id],['class' => 'btn btn-primary', 'data-pjax' => 0]);
//            }
//            else 
//                return 'No existe documento asociado';
//        }
//
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label'=>'Descripción',
        'attribute'=>'itemDescripcion', 
        'value' => 'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechaAlta',
        'format' => ['date', 'php:Y-m-d'],
        'value' => 'fecha_alta',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fechaBaja',
        'format' => ['date', 'php:Y-m-d'],
        'value' => 'fecha_baja',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'valor_historico',
    ],
    [
        'header' => 'Archivos',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Archivos',
                array(
                    'id'=>'buttonDocumentos'.$model->patrimonio_item_id,
                    'onclick'=>'cargarDocumentosContrato("'.$model->patrimonio_item_id.'")',
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