<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\PresupuestoCabecera */
?>
<div class="presupuesto-cabecera-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            /*[
                    'label' => 'Nombre Linea Padre',
                    'value' => function($model){
                                if($model->presupuesto_cabecera_padre_id != null){
                                    return $model->presupuestoCabeceraPadre->lineaNivel->nombre_linea;
                                }else{
                                    return "No designado";
                                }
                    },
                ],//*/
            'presupuestoCabeceraPadre.nombre_linea',
            'presupuestoVersion.presupuesto_version_id',
            'nombre_linea',
            //'partida_id',
        ],
    ]) ?>

</div>
