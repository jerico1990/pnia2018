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
        'attribute'=>'situacion_requerimiento_detalle_id',
        'value' => function ($model, $key, $index, $widget) {
          return $model->getSituacionRequerimientoDetalle();
        }
    ],
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
        'template'=>'{aprobar-certificacion-siaf} {desaprobar-certificacion-siaf}  {pedir-certificacion} {update} ',
        'buttons'=>[
          'aprobar-certificacion-siaf' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==8){
              return Html::a('<span class="glyphicon glyphicon-ok-circle btn-aprobar-certificacion-siaf" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Aprobar certificación SIAF'),'aria-label'=>"Aprobar certificación SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Aprobar certificación SIAF"
              ]);
            }
          },
          'desaprobar-certificacion-siaf' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==8){
              return Html::a('<span class="glyphicon glyphicon-ban-circle btn-desaprobar-certificacion-siaf" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Desaprobar certificación SIAF'),'aria-label'=>"Desaprobar certificación SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Desaprobar certificación SIAF"
              ]);
            }
          },
          'pedir-certificacion' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==6){
              return Html::a('<span class="glyphicon glyphicon-cog btn-pedir-certificacion" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Pedir certificación SIAF'),'aria-label'=>"Pedir certificación SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Pedir certificación SIAF"
              ]);
            }
          },
          'update' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/Adquisicion/requerimiento-detalle/update-autorizacion-requerimiento','id'=>$model->requerimiento_detalle_id], [
                    'title' => Yii::t('yii', 'Ver'),'aria-label'=>"Ver",'data-pjax'=>"0",'role'=>"modal-remote",'data-toggle'=>"tooltip",'data-original-title'=>"Ver"
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
