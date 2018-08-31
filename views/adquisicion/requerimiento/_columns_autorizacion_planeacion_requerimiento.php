<?php
use yii\helpers\Url;
use yii\helpers\Html;
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    /*[
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'requerimiento_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'descripcion',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'asunto',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'documento',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'situacion_requerimiento_id',
        'value' => function ($model, $key, $index, $widget) {
          return $model->getSituacionRequerimiento();
       }
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
        'class' => 'kartik\grid\ActionColumn',
        'template'=>'{enviar-adjudicacion} {aprobar-certificacion-siaf} {desaprobar-certificacion-siaf} {pedir-certificacion-siaf} {update} ',
        'buttons'=>[
          'enviar-adjudicacion' => function ($url, $model) {
            /*
              if($model->getRequerimientoDetalleEnviarAdjudicacion()==0){
                return Html::a('<span class="glyphicon glyphicon-hand-right btn-enviar-adjudicacion"></span>', ['update-certificar-requerimiento','id'=>$model->requerimiento_id], [
                        'title' => Yii::t('yii', 'Ver'),'aria-label'=>"Ver",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Ver"
                ]);
              }
              */
          },
          'aprobar-certificacion-siaf' => function ($url, $model) {
            if($model->getRequerimientoDetalleAprobarCertificacionSIAF()>0){
              return Html::a('<span class="glyphicon glyphicon-ok-circle btn-aprobar-certificacion-siaf" data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Aprobar certificación SIAF'),'aria-label'=>"Aprobar certificación SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Aprobar certificación SIAF"
              ]);
            }
          },
          'desaprobar-certificacion-siaf' => function ($url, $model) {
            if($model->getRequerimientoDetalleAprobarCertificacionSIAF()>0){
              return Html::a('<span class="glyphicon glyphicon-ban-circle btn-desaprobar-certificacion-siaf" data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Desaprobar certificación SIAF'),'aria-label'=>"Desaprobar certificación SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Desaprobar certificación SIAF"
              ]);
            }
          },
          'pedir-certificacion-siaf' => function ($url, $model) {
            if($model->getRequerimientoDetallePedirCertificacionSIAF()>0){
              return Html::a('<span class="glyphicon glyphicon-hand-up btn-pedir-certificacion-siaf" data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Pedir certificación SIAF'),'aria-label'=>"Pedir certificación SIAF",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Pedir certificación SIAF"
              ]);
            }
          },
          'update' => function ($url, $model) {
              return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['update-autorizacion-planeacion-requerimiento','id'=>$model->requerimiento_id], [
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
        'updateOptions'=>['title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete',
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
    ],



];
