<?php
use yii\helpers\Url;
use app\controllers\General\TramiteDocumentarioController;
use app\models\Viatico\FlujoRequerimiento;
use kartik\grid\GridView;

?>

<script type="text/javascript">

    function cargarDocumentos(flujo_requerimiento_id, codigo_requerimiento){
        $.ajax({
            url: "<?= Url::base() ?>/Viatico/flujo-requerimiento/enviar-codigo-requerimiento",
            method: 'POST',
            data: {
                flujo_requerimiento_id : flujo_requerimiento_id,
                codigo_requerimiento : codigo_requerimiento,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('lista-documentos');
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
    // [
    //     'class' => 'kartik\grid\SerialColumn',
    //     'width' => '30px',
    // ],
    //     [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'flujo_requerimiento_id',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'descripcion',
    // ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        // es necesario realizar la obtención de datos por medio de la declaración de funciones anonimas como se muestra acontinuación.
        // model corresponde al modelo seleccionado
        // key corresponde al id
        // index es el indice de la fila tabla q vemos (comienza en 0) 
        // column es el indice de la columna tabla
        'detail' => function ($model, $key, $index, $column) {
            //return Yii::$app->controller->renderPartial('detalles',['procesos'=> $model->procesos]);
            //return 'hola';
            return Yii::$app->controller->renderPartial('_lista_requerimientos',['searchModel'=> $model->getSearchListaRequerimientos(), 'dataProvider' => $model->getDataProviderListaRequerimientos($model->codigo_requerimiento)]);
        },
        //'detail' => Yii::$app->controller->renderPartial('_lista_procesos', ['dataProviderProcesos' => $dataProviderProcesos, 'searchModelProcesos' => $searchModelProcesos]),
        // Asi tendria que estar el detail para poder renderizar el gridview en _lista_procesos, las variables de $dataProviderProcesos y $searchModelProcesos deben llegar hasta aqui, por eso
        //una opcion es pasar todo esto adentro del mismo index, para ya no requerir este archivo _columns, pero vean si pueden hacer que lleguen hasta aqui estas variables.
        //las instrucciones de _lista_procesos.php estan en el mismo archivo
        'headerOptions' => ['class' => 'kartik-sheet-style'], 
        'expandOneOnly' => true,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Descripción',
        'width' => '200px',
        'attribute'=>'flujoReqDescripcion',
        'value' => 'descripcion'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'emisor_persona_id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Flujo',
        'width' => '200px',
        'attribute'=>'codigoFlujo',
        'value' => 'codigoFlujo.nombre_flujo'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'codigo_flujo',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Flujo paso',
        'width' => '200px',
        'attribute'=>'codigoPaso',
        'value' => 'codigoPaso.nombre_paso'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Fecha esperada',
        'width' => '200px',
        //'attribute'=>'fechaEsperada',
        'value' => 'fecha_esperada'
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Estado paso',
        'width' => '200px',
        'attribute'=>'estadoPaso.descripcion'
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'codigo_paso',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'aprobador_paso',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'estado_paso',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_instanciacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'codigo_arbol',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'anho_arbol',
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
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //      'label' => 'Documento',
    //      'width' => '200px',
    //     'attribute'=>'documentoPniaNombreDocumento', 
    //     'value' => 'documentoPnia.nombre_documento',
    // ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'label' => 'Descargar Documento',
    //     'width' => '200px',
    //     //'attribute'=>'documentoPniaNombreDocumento', //deshabilitado, quita el search y el filtro por detrás
    //     //'value' => 'documentoPnia.nombre_documento',
         
    //     'format' => 'raw',
    //     //'data-pjax' => '0',  //no funciona
    //     'value' => function($data){
    //         if ($data->documento_pnia_id){
    //             return Html::a('Descargar Archivo', ['Patrimonio/patrimonio-item/descargar-doc', 'doc_id' => $data->documento_pnia_id],['class' => 'btn btn-primary', 'data-pjax' => 0]);
    //         }
    //         else 
    //             return 'No existe documento asociado';
    //     }

    // ],
    [
        'header' => 'Documentos Asociados',
        'content' => function($model,$key,$index,$column){
            return Html::button(
                'Documentos Asociados',
                array(
                    'id'=>'buttonDocumentos'.$model->flujo_requerimiento_id,
                    'onclick'=>'cargarDocumentos("'.$model->flujo_requerimiento_id.'", "'.$model->codigo_requerimiento.'")',
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
        'updateOptions'=>['role'=>'modal-remote','title'=>'Procesar', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Borrar', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=> Yii::$app->params['textoEspañol']['tituloConfirmaciónBorrar'],
                          'data-confirm-message'=>Yii::$app->params['textoEspañol']['mensajeConfirmaciónBorrar']],
    ],

];   