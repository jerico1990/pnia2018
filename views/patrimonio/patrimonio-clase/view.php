<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Patrimonio\PatrimonioClase */
?>
<div class="patrimonio-clase-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'patrimonio_clase_id',
            //'patrimonio_clase_padre_id',
            [
                'label' => 'Clase Padre',
                'attribute' => 'patrimonioClasePadre.nombre',
            ],
            'nombre',
            'codigo',
            'tasa_depreciacion',
            // 'actualizado_en',
            // 'actualizado_por',
            // 'creado_en',
            // 'creado_por',
        ],
    ]) ?>

</div>
