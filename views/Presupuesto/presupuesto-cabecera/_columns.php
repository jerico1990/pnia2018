<?php
use yii\helpers\Url;
//use yii\helpers\Web;
?>
<!--
<script type="text/javascript">

    function cargarId(id,key){
        $.ajax({
            url: "<?= Url::base() ?>/behavior-controller/enviar-session",
            method: 'POST',
            data: {
                key : id,
            },
            success:function(text){
                //alert(codigo_interno_contrato_visible);
                var tablas_anexas = document.getElementById('tablas_anexas');
                tablas_anexas.style.display = 'block';
                $.pjax.reload({
                    container:'#crud-datatable-presupuesto',
                });
                $.pjax.xhr = null;
            },
            fail:function(text){
                alert('Hubo un error en la conexión, la data es invalida. Recargue la página porfavor.');
            }
        });
    }
</script>
-->
<?php
return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_cabecera_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_version_id',
    ],/*
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'linea_id',
    ], // */
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'partida_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'presupuesto_cabecera_padre_id',
    ],
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
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
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