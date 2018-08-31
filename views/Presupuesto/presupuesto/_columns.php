<?php
use yii\helpers\Url;
use app\models\Presupuesto\Periodo;

return [
    [
         'class' => 'kartik\grid\CheckboxColumn',
         'width' => '20px',
    ],
    /*
    [
        'attribute' => 'linea_id_fk',
        'value' => 'presupuestoCabecera.lineaNivel.nombre_linea',
        'headerOptions' => ['style'=>'text-align:center'],
        'contentOptions' => function ($model, $key, $index, $column) {
            return ['style' => 'background-color:'
                . (!empty($model->coefTK_se) && $model->coefTK / $model->coefTK_se < 2
                    ? 'red' : 'blue')];
        },
    ],// */
    [
        'attribute' => 'linea_id_fk',// 'presupuestoCabecera.lineaNivel.linea_id',
        'vAlign' => 'middle',
        //'width' => '180px',
        'text-align' => 'center',
        //'contentOptions' => ['style'=>'text-align:center'],
        //'headerOptions' =>  ['style'=>'text-align:center'],
        //'contentOptions' => ['style' => 'width:1010px;'],
        'value' => 'presupuestoCabecera.lineaNivel.nombre_linea',
        'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
        'filter' => \app\models\Presupuesto\Linea::getComboBoxItems(),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Presupuestos'],
        'format' => 'raw',
        'label' => 'Linea Presupuestal',
    ],
    [
        'attribute' => 'periodo_id',
        'vAlign' => 'middle',
        'width' => '180px',
        //'contentOptions' => ['style' => 'width:1010px;'],
        'value' => function ($model, $key, $index, $widget) {
            return $periodo_actl = $model->getPeriodo()->one()->getDisplayText();
        },
        'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
        'filter' => Periodo::getComboBoxItems(),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Periodos'],
        'format' => 'raw',
        'label' => 'Periodo (mes-año)',
    ],
    [
        'attribute' => 'estado',
        'vAlign' => 'middle',
        'width' => '180px',
        //'contentOptions' => ['style' => 'width:1010px;'],
        'value' => function ($model, $key, $index, $widget) {
            return $periodo_actl = $model->estadoActual->descripcion;
        },
        'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
        'filter' => \app\models\Patrimonio\Metacodigo::getComboBoxItems(Yii::$app->params['metacodigoFlags']['Estado_Presupuesto']),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Estado'],
        'format' => 'raw'
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                        return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_plan_ro',
        //'inputType'=>\kartik\editable\Editable::INPUT_TEXTAREA,

        //'options'   => ['style'=>'color:'.'white'.'; background-color:'.'rgb(146,166,196)'.';'],
            //['style'=>'color:'.'black'.'; background-color:'.'rgb(146,166,196)'.';']
            //['style'=>'color:'.'white'.'; background-color:'.'rgb(146,0,196)'.';'],

            /*[
            'background-color' => 'black',

        ],// */
        /*
        'columnOptions' => function ($model){
            if ($model->linea->nivel == 0 ){
                return ['style'=>'color:'.'black'.'; background-color:'.'rgb(242,227,224)'.';'];
            }else{
                return ['style'=>'color:'.'black'.'; background-color:'.'rgb(146,166,196)'.';'];
            }
            // 146 166 196 azul // RGB
            // 216 230 237
            // 230 244 251
            // 160 187 168 green
            // 232 244 232
            //247 214 248 Golden
            // 250 241 218
            // 242 227 224 pink
            // 175 176 179 gray
            // 213 214 229
            // 224 226 225

            //return ['style'=>'color:'.'red;  background-color:'.'red'.';'];
            //return ['class' => 'danger'];
        },// */
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_plan_rooc',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_compromiso_ro',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_compromiso_rooc',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_devengado_ro',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_devengado_rooc',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_girado_ro',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_girado_rooc',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_pagado_ro',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura();
                        },
        'attribute'=>'presupuesto_pagado_rooc',
    ],

    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_ejecutado_ro',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_ejecutado_rooc',
    ],

    [
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_saldo_ro',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_saldo_rooc',
    ],

    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_saldo_anual_ro',
    ],
    [
        'class' => '\kartik\grid\EditableColumn',
        'readonly' => function($model,$key,$index,$widget){
                            return $model->esDeSoloLectura(); 
                        },
        'attribute'=>'presupuesto_saldo_anual_rooc',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                //return Url::to([$action,'id'=>$key]);
            $base = Url::base();
            $text = $base."/Presupuesto/presupuesto/".$action."?id=".$key;
            return $text; 
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