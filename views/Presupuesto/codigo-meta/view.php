<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Presupuesto\CodigoMeta */
?>
<div class="codigo-meta-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo_meta_id',
            'descripcion',
            'unidad_medida_id',
            'estado_regitro',
            'actualizado_en',
            'actualizado_por',
            'creado_en',
            'creado_por',
        ],
    ]) ?>

</div>
