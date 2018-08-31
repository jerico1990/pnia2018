<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [

    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'requerimiento_detalle_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'requerimiento_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'linea_nivel_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'concepto',
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'unidad_medida',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'cantidad',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'costo_unitario',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'monto_total',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'rooc',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'ro',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'especificacion_tecnica',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tiempo_entrega',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'tipo_garantia_id',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'garantia_cantidad',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'lugar_entrega',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'fecha_entrega',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'forma_pago',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'resumen_especificacion_tecnica',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'otras_caractaristicas',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'forma_entrega',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'anio_fabricacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'lugar_fabricacion',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'staff_area_id',
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
        'template'=>'{aprobar-compromiso-siaf} {desaprobar-compromiso-siaf} {pedir-compromiso-siaf} {view} ',
        'buttons'=>[
          'aprobar-compromiso-siaf' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==18){
              return Html::a('<span class="glyphicon glyphicon-ok-circle btn-aprobar-compromiso-siaf" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Aprobar compromiso SIAF'),'aria-label'=>"Aprobar compromiso SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Aprobar compromiso SIAF"
              ]);
            }
          },
          'desaprobar-compromiso-siaf' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==18){
              return Html::a('<span class="glyphicon glyphicon-ban-circle btn-desaprobar-compromiso-siaf" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Desaprobar compromiso SIAF'),'aria-label'=>"Desaprobar compromiso SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Desaprobar compromiso SIAF"
              ]);
            }
          },
          'pedir-compromiso-siaf' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==17){
              return Html::a('<span class="glyphicon glyphicon-play btn-pedir-compromiso-siaf" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Pedir compromiso SIAF'),'aria-label'=>"Pedir compromiso SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Pedir compromiso SIAF"
              ]);
            }
          },
          'view' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/Adquisicion/requerimiento-detalle/update','id'=>$model->requerimiento_detalle_id], [
                    'title' => Yii::t('yii', 'Ver'),'aria-label'=>"Ver",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Ver"
            ]);
          }
        ],
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) {

                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],

];
