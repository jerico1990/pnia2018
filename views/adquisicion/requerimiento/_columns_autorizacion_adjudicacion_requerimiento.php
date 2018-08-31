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
        'template'=>'{iniciar-adjudicacion} {admitir-adjudicacion} {observar-adjudicacion} {update} ',
        'buttons'=>[
          'iniciar-adjudicacion' => function ($url, $model) {
            if($model->situacion_requerimiento_id==9){
              return Html::a('<span class="glyphicon glyphicon-play btn-iniciar-adjudicacion" data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Iniciar adjudicación'),'aria-label'=>"Iniciar adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Iniciar adjudicación"
              ]);
            }
          },
          'admitir-adjudicacion' => function ($url, $model) {
            /*if($model->situacion_requerimiento_id==11){
              return Html::a('<span class="glyphicon glyphicon-ok-circle btn-admitir-adjudicacion" data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Admitir adjudicación'),'aria-label'=>"Admitir adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Admitir adjudicación"
              ]);
            }*/
          },
          'observar-adjudicacion' => function ($url, $model) {
            /*if($model->situacion_requerimiento_id==11){
              return Html::a('<span class="glyphicon glyphicon-ban-circle btn-observar-adjudicacion" data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Observar adjudicación'),'aria-label'=>"Observar adjudicación",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Observar adjudicación"
              ]);
            }*/
          },
          'update' => function ($url, $model) {
              return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['update-autorizacion-adjudicacion-requerimiento','id'=>$model->requerimiento_id], [
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
