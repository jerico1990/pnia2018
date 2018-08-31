<?php
use yii\helpers\Url;
?>
<script type="text/javascript">

    function cargarCodigoInterno(codigo_interno_contrato,codigo_visible_contrato){
        $.ajax({
            url: "<?= Url::base() ?>/rrhh/contrato-contrato/enviar-codigo-interno",
            method: 'POST',
            data: {
                codigo_interno_contrato : codigo_interno_contrato,
                codigo_visible_contrato : codigo_visible_contrato
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('tablas_anexas');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-entregable-pjax',
                });
                $.pjax.xhr = null;
                $.pjax.reload({
                    container:'#crud-datatable-penalidad-pjax',
                });
                $.pjax.xhr = null;
            },
            fail:function(text){
                alert('Hubo un error en la conexión, la data es invalida. Recargue la página porfavor.');
            }
        });
    }
    
    function cargarDocumentosContrato(codigo_interno_contrato,codigo_visible_contrato){
        $.ajax({
            url: "<?= Url::base() ?>/rrhh/contrato-contrato/enviar-codigo-interno",
            method: 'POST',
            data: {
                codigo_interno_contrato : codigo_interno_contrato,
                codigo_visible_contrato : codigo_visible_contrato
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('lista-documentos2');
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
//use yii\helpers\Url;
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
    //     'attribute'=>'contrato_contrato_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'codigo_interno',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Entidad contratista',
        'width' => '300px',
        'attribute'=>'pniaEntidadRazonSocial', 
        'value' => 'entidadContratista.razon_social',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'entidad_contratista',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Área contratante',
        'width' => '300px',
        'attribute'=>'staffAreaContratanteDescripcion', 
        'value' => 'areaContratante.descripcion',
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'area_contratante',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Área responsable',
        'width' => '300px',
        'attribute'=>'staffAreaResponsableDescripcion', 
        'value' => 'areaResponsable.descripcion',
    ],
    
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'label' => 'Objetivos',
//        'width' => '300px',
//        'attribute'=>'objetivosRichText', 
//        'value' => 'objetivos',
//        'format' => 'html',
//    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'area_responsable',
    // ],
     [
        'header' => 'Archivos',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Archivos',
                array(
                    'id'=>'buttonDocumentos'.$model->contrato_contrato_id,
                    'onclick'=>'cargarDocumentosContrato("'.$model->contrato_contrato_id.'","'.$model->codigo_interno.'")',
                    //'onclick'=>'cargarCodigoInterno("'.$model->contrato_contrato_id.'","'.$model->codigo_interno.'")',
                )
            );
        },
        'width' => '20px'
    ],
    [
        'header' => 'Documentos Relacionados',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Doc. Relacionados',
                array(
                    'id'=>'buttonContrato'.$model->contrato_contrato_id,
                    'onclick'=>'cargarCodigoInterno("'.$model->contrato_contrato_id.'","'.$model->codigo_interno.'")',
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
        'updateOptions'=>['role'=>'modal-remote','title'=>'Actualizar', 'data-toggle'=>'tooltip','hidden'=>true],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Eliminar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   