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
        'template'=>'{generar-contrato} {iniciar-registro-postores} {ingresar-adjudicacion} {pedido-completo} {pedido-incompleto} {admitir-adjudicacion} {observar-adjudicacion} {update} ',
        'buttons'=>[
          'generar-contrato' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==19){
              return Html::a('<span class="glyphicon glyphicon-download-alt btn-generar-contrato" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Generar contrato'),'aria-label'=>"Generar contrato",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Generar contrato"
              ]);
            }
          },
          'iniciar-registro-postores' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==14){
              return Html::a('<span class="glyphicon glyphicon-play btn-iniciar-registro-postores" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Iniciar registro de postores'),'aria-label'=>"Iniciar registro de postores",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Iniciar registro de postores"
              ]);
            }
          },
          'ingresar-adjudicacion' => function ($url, $model) {
            if($model->getIngresarAdjudicacion()){
              return Html::a('<span class="glyphicon glyphicon-share-alt " data-id="'.$model->requerimiento_detalle_id.'"></span>', ['Adquisicion/adjudicacion/update-autorizacion-adjudicacion','id'=>$model->getAdjudicacionId()], [
                      'title' => Yii::t('yii', 'Ingresar adjudicación'),'aria-label'=>"Ingresar adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Ingresar adjudicación"
              ]);
            }
          },
          'pedido-completo' => function ($url, $model) {
            if($model->get4uitmenor() && $model->situacion_requerimiento_detalle_id==12){
              return Html::a('<span class="glyphicon glyphicon-ok-circle btn-pedido-completo" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['index-autorizacion-adjudicacion-requerimiento'], [
                      'title' => Yii::t('yii', 'Pedido completo'),'aria-label'=>"Pedido completo",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Pedido completo"
              ]);
            }
          },
          'pedido-incompleto' => function ($url, $model) {
            if($model->get4uitmenor() && $model->situacion_requerimiento_detalle_id==12){
              return Html::a('<span class="glyphicon glyphicon-ban-circle btn-pedido-incompleto" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['index-autorizacion-adjudicacion-requerimiento'], [
                      'title' => Yii::t('yii', 'Pedido incompleto'),'aria-label'=>"Pedido incompleto",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Pedido incompleto"
              ]);
            }
          },
          'admitir-adjudicacion' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==11){
              return Html::a('<span class="glyphicon glyphicon-ok-circle btn-admitir-adjudicacion" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Admitir adjudicación'),'aria-label'=>"Admitir adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Admitir adjudicación"
              ]);
            }
          },
          'observar-adjudicacion' => function ($url, $model) {
            if($model->situacion_requerimiento_detalle_id==11){
              return Html::a('<span class="glyphicon glyphicon-ban-circle btn-observar-adjudicacion" data-id="'.$model->requerimiento_detalle_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Observar adjudicación'),'aria-label'=>"Observar adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Observar adjudicación"
              ]);
            }
          },
          'update' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/Adquisicion/requerimiento-detalle/update-autorizacion-adjudicacion-requerimiento','id'=>$model->requerimiento_detalle_id], [
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
