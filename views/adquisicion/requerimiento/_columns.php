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
        'attribute'=>'requerimiento_id',
    ],*/
    [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'Tipo de requerimiento',
        'attribute'=>'tipo_requerimiento_id',
        'value' => function ($model, $key, $index, $widget) {
          return $model->getMetaCodigo()->descripcion;
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'Asunto',
        'attribute'=>'asunto',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'Descripción',
        'attribute'=>'descripcion',
    ],

    [
        'class'=>'\kartik\grid\DataColumn',
        'header'=>'Documento',
        //'attribute'=>'documento',
        'format'=>'html',
        'value' => function ($model, $key, $index, $widget) {
          //Html::a('<span class="glyphicon glyphicon-download-alt"></span>',['/documentos/requerimientos/'.$model->getDocumentos()->documento.'']);
          if($model->getDocumentos()){
              return '<a data-pjax=true  href="'.\Yii::$app->request->BaseUrl.'/documentos/requerimientos/'.$model->getDocumentos()->documento.'"> <span class="glyphicon glyphicon-download-alt"></span></a>' ;
          }          
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'situacion_requerimiento_id',
        'header'=>'Situación del registro',
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
        'template'=>'{enviar-jefe-requerimiento} {enviar-operaciones-requerimiento} {update} {delete}',
        'buttons'=>[
          'enviar-jefe-requerimiento' => function ($url, $model) {
            if($model->situacion_requerimiento_id==1 && $model->getRequerimientoDetalleEnviarAdjudicacion()>0){
              return Html::a('<span class="glyphicon glyphicon-hand-right btn-enviar-jefe-requerimiento "  data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Enviar a Jefe'),'aria-label'=>"Enviar a Jefe",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Enviar a Jefe"
              ]);
            }
          },
          'enviar-operaciones-requerimiento' => function ($url, $model) {
            if($model->situacion_requerimiento_id==3){
              return Html::a('<span class="glyphicon glyphicon-hand-right btn-enviar-operaciones-requerimiento "  data-id="'.$model->requerimiento_id.'"></span>', ['#'], [
                      'title' => Yii::t('yii', 'Enviar a D.O.'),'aria-label'=>"Enviar a D.O.",'data-pjax'=>"0",'data-toggle'=>"tooltip",'data-original-title'=>"Enviar a D.O."
              ]);
            }
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
