<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'contratoEntregable.descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'contratoEntregable.monto',
    ],
    [
        'label' => 'Conformidad',
        'class'=>'\kartik\grid\DataColumn',
        'value'=>'flagConformidad.descripcion',
    ],
    [
        'label' => 'Observación',
        'class'=>'\kartik\grid\DataColumn',
        'value'=>'observacion',
    ],
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
        'class'=>'\kartik\grid\DataColumn',
        'label' => 'Descargar Documento',
        'width' => '200px',
        //'attribute'=>'documentoPniaNombreDocumento', //deshabilitado, quita el search y el filtro por detrás
        //'value' => 'documentoPnia.nombre_documento',
         
        'format' => 'raw',
        //'data-pjax' => '0',  //no funciona
        'value' => function($data){
            if ($data->documento_pnia_id){
                return Html::a('Descargar Archivo', ['rrhh/conformidad-entregable/descargar-doc', 'doc_id' => $data->documento_pnia_id],['class' => 'btn btn-primary', 'data-pjax' => 0]);
            }
            else 
                return 'No existe documento asociado';
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 'hidden'=>true,
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   